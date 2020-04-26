<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script type="text/javascript">
    var path = "";

    var _orden = [];
    var _productos = {};
    var _productos_precio = [];
    var _productos_lista;
    var contador_productos = 0;
    var contador_tabla = 1;
    var total_msg = 0.00;
    var factor_precio = 0;
    var factor_total = 0;
    var producto_cantidad_linea = 1;
    var sucursal = 0;
    var interno_sucursal = 0;
    var interno_bodega = 0;
    var producto_escala;
    var clientes_lista;
    var combo_total = 0.00;
    var combo_descuento = 0.00;
    var _conf = [];
    var _impuestos = [];

    window.onload = function(event) {

        var terminal = $("#terminal_id").val();

        setAction(terminal, 1);

    };

    /*window.onbeforeunload = function(event) {

        var message = '';
        var terminal = $("#terminal_id").val();

        setAction(terminal, 0);

        return message;
    };*/

    function setAction(terminal, action) {

        $.ajax({
            type: "POST",
            url: "unload",
            datatype: 'json',
            cache: false,
            data: {
                terminal: terminal,
                estado: action
            },

            success: function(data) {

            },
            error: function() {}
        });

    }
</script>
<script src="<?php echo base_url(); ?>../asstes/general.js"></script>

<?php

include("asstes/pos_funciones.php");
include("asstes/pos_orden.php");

?>
<script src="<?php echo base_url(); ?>../asstes/js/generalAlert.js"></script>

<?php $this->load->view('styles_files.php'); ?>
<title><?php echo $title; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/pos.css" />

<script>
    $(document).ready(function() {
        $(".print_venta").click(function() {
            location.reload();
        });

        registro_editado = 0;
    });
</script>

<!-- Main section-->

<style>
    .modal-header {
        background:#fff;
        color: black;
        border-top: 2px solid white;
        border-bottom: 2px solid #27c24c;
        font-size:22px;
    }
</style>


<section onunload="con();">

    <div class="row">
        <div class="col-lg-9 col-md-9">

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- Team Panel-->
                    <div class="" style="width: 100%; background: white;text-align: center;color: white;font-size: 30px;">
                        <div class="panel-heading" style="background: #2D3B48; color: white;">
                            <div class="row">

                                <div class="col-lg-4">

                                    <div class="input-group m-b" id="headerInputs">
                                        <span class="input-group-addon bg-green">[ <i class="fa fa-arrow-left"></i> ] <i class="fa fa-search"></i></span>
                                        <input type="text" placeholder="Buscar Producto" autocomplete="off" name="[producto_buscar]" class="form-control producto_buscar">
                                    </div>

                                    <select multiple="" class="form-control dataSelect form-control note-editor" id="dataSelect" style="height: 200px;">

                                    </select>

                                    <select multiple="" class="form-control dataSelect2 note-editor" id="dataSelect2" style="display: inline-block;height: 200px;">

                                    </select>
                                </div>

                                <div class="col-lg-8" style="text-align: left;" id="headerInputs">
                                    <!--
                                    <button class="btn bg-green" id="grabar" style="font-size: 25px;" data-toggle="tooltip" data-placement="bottom" title="Agregar"><i class='fa fa-shopping-cart'></i></button>
-->
                                    <span class='btn bg-green guardar' name="1" id="../venta/guardar_venta" style="font-size: 25px;" data-toggle="tooltip" data-placement="bottom" title="Procesar"><i class='fa fa-money'></i> <span style="font-size:18;">[ F4 ]</span></span>

                                    <span class="btn bg-green" id="btn_existencias" data-toggle="tooltip" data-placement="bottom" title="Existencias" style="font-size: 25px;"><i class="fa fa-dropbox"></i> <span style="font-size:18;">[ F8 ]</span> </span>
                                    <span class="btn bg-green" id="btn_discount" style="font-size: 25px;"><i class="fa fa-percent" aria-hidden="true"></i> <span style="font-size:18;">[ F9 ]</span></span>

                                    <div class="btn-group">
                                        <button type="button" class="btn bg-green"><i class="fa fa-plus" style="font-size: 25px;"></i></button>
                                        <button type="button" data-toggle="dropdown" class="btn dropdown-toggle bg-green" style="font-size: 17px;">
                                            <span class="caret"></span>
                                            <span class="sr-only">default</span>
                                        </button>
                                        <ul role="menu" class="dropdown-menu">
                                            <li><a href="#" class="btn btn-warning" id="btn_impuestos" data-toggle='modal'><i class="fa fa-money"></i> Impuestos</a></li>

                                            <li><a href="#" class="btn btn-warning" id="btn_en_proceso" data-toggle='modal' data-target='#en_proceso'><i class="fa fa-key"></i> En Espera</a></li>

                                            <li class="divider"></li>

                                            <li><a href="#" class="btn btn-warning" id="btn_en_reserva" data-toggle='modal' data-target='#en_reserva'><i class="icon-cursor"></i> En Reserva</a></li>
                                        </ul>
                                    </div>

                                    <input type="text" name="orden_numero" id="orden_numero" placeholder="Orden [ * ]" value="" class="form-control" style="width:100px; display: inline-block;" />
                                    Can[=]<input type="number" class="form-control border-input" id="cantidad" name="cantidad" size="1px" value="1" min="1" max="1000" style="width: 80px;display: inline-block;">
                                    Des[-]<input type="text" class="form-control border-input" id="descuento" name="descuento" size="2px" style="width: 80px;display: inline-block;">
                                </div>
                            </div>
                        </div>

                        <!-- START table-responsive-->
                        <div class="table-responsive" style="width: 100%;">  
                            <div class="lista_productos">                                
                                <table class="table table-sm table-hover">  
                                <thead class="bg-info-dark" style="background: #cfdbe2;">
                                    <tr>
                                        <th style="color: black;">#</th>
                                        <th style="color: black;">Producto</th>
                                        <th style="color: black;">Descripción</th>
                                        <th style="color: black;">Cantidad</th>
                                        <th style="color: black;">Presentación</th>
                                        <th style="color: black;">Factor</th>
                                        <th style="color: black;">Unidad</th>
                                        <th style="color: black;">Descuento</th>
                                        <th style="color: black;">Total</th>
                                        <th style="color: black;">Bodega</th>   
                                        <th style="color: black;"></th>                                        
                                    </tr>
                                </thead>                              
                                    <tbody class="producto_agregados" style="border-top:  0px solid black; color: black; background: white; overflow: scroll;">
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-12 col-md-12 paper_cut">
                            </div>
                        </div>
                        <!-- END table-responsive-->

                    </div>
                    <!-- end Team Panel-->
                </div>
            </div>

        </div>
        <div class="col-lg-3 col-md-3">
            <div style="border:0px solid black">
                <form name="encabezado_form" id="encabezado_form" method="post" action="">

                    <!-- Campos de la terminal -->
                    <input type="hidden" name="terminal_id" value="<?php echo $terminal[0]->id_terminal; ?>" />
                    <input type="hidden" name="terminal_numero" value="<?php echo $terminal[0]->numero; ?>" />
                    <input type="hidden" name="caja_id" value="<?php echo $terminal[0]->id_caja; ?>" />
                    <input type="hidden" name="caja_numero" value="<?php echo $terminal[0]->cod_interno_caja; ?>" />
                    <!-- Fin Campos de la terminal -->

                    <!-- Campos del cliente -->
                    <input type="hidden" name="impuesto" value="" id="impuesto" />
                    <!-- Fin Campos del cliente -->



                    <div class="row">
                        <div class="col-lg-12 col-md-12" style="width: 100%; background: #2D3B48/*#0f4871*/;text-align: center;color: white;">

                            <span style="font-size: 50px;">
                                <?php echo $moneda[0]->moneda_simbolo; ?> <span class="total_msg">0.00</span>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12" style="width: 100%; background: white;">

                            <table class="table table-sm table-hover" style="font-size: 22px;">
                                <tr>
                                    <td style="color:#0f4871;"><b>Sub total</b></td>
                                    <td><?php echo $moneda[0]->moneda_simbolo; ?> <span class="sub_total_tabla"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Iva</b></td>
                                    <td><span class="iva_valor"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Desc</b></td>
                                    <td><span class="descuento_tabla"></span></td>
                                </tr>
                                <tr>
                                    <td><span class="impuestos_nombre"></span></td>
                                    <td><span class="impuestos_total"></span></td>
                                </tr>
                                <tr>
                                    <td style="color:#0f4871"><b>Total</b></td>
                                    <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="total_tabla"></span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-lg-12 col-md-12 paper_cut">
                        </div>
                    </div><br>

                    <!--
                <div class="row">
                    <div class="col-lg-12 col-md-12" style="width: 100%; background: white;">
                        Imagen
                      <div class="panel b m0">
                       
                         <div class="panel-body">
                            <p>
                               <a href="#">
                                  <span class="producto_imagen"></span>
                               </a>
                            </p>
                            
                         </div>
                      </div>
                    </div>
                </div>
                -->

            </div>

            <!-- Modal Large Documenos -->
            <div id="documentoModel" tabindex="-1" role="dialog" aria-labelledby="documentoModel" class="modal fade">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i class="icon-docs"></i> > FACTURACION
                        </div>
                        <div class="modal-body">

                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <label> <span class="fa fa-edit"></span> Tipo Documento [ 1 ] <?php //echo $terminal[0]->pred_id_tpdoc; 
                                                                                                            ?></label>
                                            <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">

                                                <?php
                                                foreach ($tipoDocumento as $d) {

                                                    $doc = strtoupper($d->nombre);

                                                    if ($d->id_temp_suc == $terminal[0]->pred_id_tpdoc) {

                                                        if (strpos($doc, 'ORDEN') === false) {
                                                ?>
                                                            <option value="<?php echo $d->id_tipo_documento; ?>"><?php echo $d->nombre . ' - ' . $d->factura_nombre; ?></option>
                                                        <?php
                                                        }
                                                    }
                                                }

                                                foreach ($tipoDocumento as $documento) {

                                                    $doc = strtoupper($documento->nombre);

                                                    if (strpos($doc, 'ORDEN') === FALSE) {

                                                        if ($documento->id_temp_suc != $terminal[0]->pred_id_tpdoc) {
                                                        ?>
                                                            <option value="<?php echo $documento->id_tipo_documento; ?>"><?php echo $documento->nombre . ' - ' . $documento->factura_nombre; ?></option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">

                                        <div class="form-group has-success">
                                            <span class="fa fa-user"></span> <label>Cliente Codigo [ 2 ]</label> 

                                            <input type="text" name="cliente_codigo" class="form-control cliente_codigo" id="cliente_codigo" value="<?php echo $cliente[0]->id_cliente ?>">

                                            <select multiple="" class="form-control cliente_codigo2" id="cliente_codigo2" name="abc"></select>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-money"></span> <label>Forma Pago [ 3 ]</label>
                                            <select class="form-control" id="modo_pago_id" name="modo_pago_id">
                                                <?php
                                                foreach ($modo_pago as $value) {
                                                ?><option value="<?php echo $value->id_modo_pago; ?>"><?php echo $value->nombre_modo_pago; ?></option><?php
                                                                                                                                                    }
                                                                                                                                                        ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-user"></span>
                                            <label>Cliente Nombre [ 4 ]</label>
                                            <input type="text" name="cliente_nombre" class="form-control cliente_nombre" id="cliente_nombre" value="<?php echo $cliente[0]->nombre_empresa_o_compania ?>">
                                            <input type="hidden" name="cliente_direccion" class="form-control direccion_cliente" id="direccion_cliente" value="<?php echo $cliente[0]->direccion_cliente ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-home"></span>
                                            <label>Sucursal Destino [ 5 ]</label>
                                            <select class="form-control" name="sucursal_destino" id="sucursal_id">
                                                <?php
                                                $id_sucursal = 0;

                                                foreach ($empleado as $sucursal) {
                                                    $id_sucursal = $sucursal->id_sucursal;
                                                ?>
                                                    <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                    <?php
                                                }

                                                foreach ($sucursales as $sucursal) {
                                                    if ($sucursal->id_sucursal != $id_sucursal) {
                                                    ?>
                                                        <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-building"></span>
                                            <label>Bodega [ 6 ]</label>
                                            <select class="form-control" name="bodega" id="bodega_select">
                                                <?php
                                                foreach ($bodega as $b) {
                                                    if ($b->Sucursal == $id_sucursal) {
                                                ?>
                                                        <option value="<?php echo $b->id_bodega; ?>"><?php echo $b->nombre_bodega; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-home"></span>
                                            <label>Sucursal Origin [ 7 ]</label>
                                            <select class="form-control" name="sucursal_origin" id="sucursal_id2">
                                                <?php
                                                $id_sucursal = 0;
                                                $id_sucursal = $empleado[0]->id_sucursal;
                                                foreach ($empleado as $sucursal) {

                                                ?>
                                                    <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                    <?php
                                                }

                                                foreach ($sucursales as $sucursal) {
                                                    if ($sucursal->id_sucursal != $id_sucursal) {
                                                    ?>
                                                        <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-clock-o"></span>
                                            <label>Fecha [ 8 ]</label>
                                            <input type="date" name="fecha" id="fecha_factura" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="vendedor" id="vendedor1" value="<?php echo @$empleado[0]->id_empleado; ?>">
                                <div class="label bg-gray">

                                    <?php
                                    if (isset($empleado[0]->id_sucursal)) {

                                    ?>
                                        <a href="#" class="vendedores_lista1" id="<?php echo $empleado[0]->id_sucursal; ?>"><?php echo $empleado[0]->primer_nombre_persona . " " . $empleado[0]->primer_apellido_persona; ?>
                                        </a>
                                    <?php

                                    } else {
                                        echo "No hay Vendedor";
                                    }
                                    ?>

                                </div>

                            </div>

                        </div>
                        <div class="modal-footer" style="border-top:2px solid #0f4871"></div>
                    </div>
                </div>
            </div>
            <!-- Modal Small-->


            </form>
        </div>
    </div>

    <div class="row bg-red" style="position: fixed;bottom: 0px; width: 100%;">
        <div class="col-lg-12 col-md-12 abajo" style="height: 50px;">
            <span class="btn btn-info" data-toggle="modal" data-target="#documentoModel" style="background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">F1
                <i class="icon-settings"></i>
            </span>

            <span class="btn btn-info" style="background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">F2
                <i class="icon-grid"></i>
            </span>

            <span class="btn btn-info" style="background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">F3
                <i class="icon-trash"></i>
            </span>

            <span class="btn btn-info guardar" id="../venta/guardar_venta" style="background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">F4
                <i class="fa fa-credit-card"></i>
            </span>
            <span class="btn btn-info guardar" id="../venta/guardar_venta" style="background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">
                
                    <input type="hidden" name="terminal" id="terminal_id" value="<?php echo $terminal[0]->id_terminal ?>" />
                    <div class="" style="font-size: 30px;overflow: hidden;">
                        <?php
                        if (isset($empleado[0]->nombre_sucursal)) {
                            echo $empleado[0]->nombre_sucursal . " [ " . $terminal[0]->nombre . " ]";
                        } else {
                            echo "Sin Sucursal";
                        }

                        ?>

                        <span class="label label-warning">
                            <?php echo Date("d/M/y"); ?>
                        </span>
                    </div>

                
            </span>
        </div>
    </div>
</section>



<!-- Modal Large CLIENTES MODAL-->
<div id="cliente_modal" tabindex="-1" role="dialog" aria-labelledby="cliente_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel-header" style="background: #535D67; color: white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title">Buscar Cliente</h4>
            </div>
            <div class="modal-body">
                <tr>
                    <td colspan='9'><input type='text' placeholder='Buscar Cliente' class='form-control buscar_cliente' name='buscar_cliente' id='buscar_producto' /> </td>
                </tr>
                <p class="cliente_lista_datos">

                </p>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->

<!-- Modal Large PRODUCTOS MODAL-->
<div id="existencias" tabindex="-1" role="dialog" aria-labelledby="existencias" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="input-group m-b">
                    <span class="input-group-addon bg-green"><i class="fa fa-search"></i></span>
                    <input type="text" placeholder="Buscar Exsitencia" name="existencia_buscar" autocomplete="no" class="form-control existencia_buscar">
                </div>

                <select multiple="" class="form-control 1dataSelect" id="1dataSelect">

                </select>

                <select multiple="" class="form-control 1dataSelect2" style="display: inline-block;">

                </select>

            </div>
            <div class="modal-body">
                <table class="table table-sm table-hover">
                    <thead class="linea_superior">
                        <tr style="linea_superior">
                            <th style="color: black;">#</th>
                            <th style="color: black;">Sucursal</th>
                            <th style="color: black;">Bodega</th>
                            <th style="color: black;">Existencia</th>
                            <th style="color: black;">Costo</th>
                            <th style="color: black;">Costo Anterior</th>
                            <th style="color: black;">Costo utilidad</th>
                            <th style="color: black;">Cod ubicacion</th>
                        </tr>
                    </thead>
                    <tbody class="dos" style="border-bottom: 3px solid grey">

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default bg-green">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->

<!-- Modal Large PRODUCTOS MODAL-->
<div id="en_proceso" tabindex="-1" role="dialog" aria-labelledby="en_proceso" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Notificacion
            </div>
            <div class="modal-body">
                Cambiar Orden a Espera ?
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-success guardar btn-pre" name="5">Si</button>
                <button type="button" data-dismiss="modal" class="btn btn-warning">No</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->

<!-- Modal Large PRODUCTOS MODAL-->
<div id="en_reserva" tabindex="-1" role="dialog" aria-labelledby="en_reserva" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Notificacion
            </div>
            <div class="modal-body">
                Cambiar Orden a Reservado ?
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-success guardar btn-pre" name="2">Si</button>
                <button type="button" data-dismiss="modal" class="btn btn-warning">No</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->

<!-- METODO DE PAGOS MODAL-->
<div id="procesar_venta" tabindex="-1" role="dialog" aria-labelledby="procesar_venta" class="modal flip">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header" style="background: #2D3B48; color:white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; ">[ Proceso Pago ]</span>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-9 col-md-9" style="border-right: 1px solid #e5e5e5; height: 50%;">

                        <div class="row">
                            <div class="col-lg-2 col-md-2">
                                <select class="form-control" name="extraMetodoPago" id="extraMetodoPago" class="extraMetodoPago">
                                    <?php
                                    foreach ($modo_pago as $mp) {
                                    ?>
                                        <option value="<?php echo $mp->id_modo_pago; ?>"><?php echo $mp->nombre_modo_pago; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-1 col-md-1">
                                <a href="#" class="btn bg-green addMetodoPago"><i class="fa fa-plus-circle"></i> Agregar</a>
                            </div>

                            <div class="col-lg-2 col-md-2">

                                <select name="orden_estado" id="orden_estado" class="form-control">
                                    <option value="6">Cancelado</option>
                                    <option value="1">En proceso</option>
                                    <option value="2">En Reservaa</option>
                                    <option value="3">Procesadaa</option>
                                    <option value="4">Facturada</option>
                                    <option value="5">En Espera</option>
                                </select>

                            </div>

                            <div class="col-lg-3 col-md-3">
                                <input type="text" class="form-control has-success" name="cliente" placeholder="Nombre Cliente">
                            </div>

                            <div class="col-lg-2 col-md-2">
                                <input type="text" class="form-control has-success" name="correlativo_documento" id="correlativo_documento" placeholder="">
                            </div>

                        </div>

                        <div class="row" id="metodos_pagos">

                            <br>
                            <?php

                            $a = 1;
                            $count = count($modo_pago);
                            foreach ($modo_pago as $value) {
                            ?>
                                <div class="col-lg-4 col-md-4">
                                    <?php echo $value->nombre_modo_pago; ?>
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <input type='text' count='<?php echo $count; ?>' name='pagoInput<?php echo $a; ?>' id='<?php echo $value->nombre_modo_pago; ?>' class='form-control metodo_pago_input'>
                                </div>
                            <?php
                                $a++;
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">

                        <div class="row" style="">
                            <div class="col-lg-12 col-md-12">
                                <div class="panel widget bg-success" style="height: 80px;">
                                    <div class="row row-table">
                                        <div class="col-xs-4 text-center bg-success-dark pv-lg">

                                            <em class="fa-1x">
                                                <div class="text-uppercase">PAGAR</div>
                                            </em>

                                        </div>
                                        <div class="col-xs-8 pv-lg">

                                            <div class="h1 m0 text-bold currency_procesar_pago">
                                                <?php echo $moneda[0]->moneda_simbolo; ?>
                                                <span id="compra_venta">0.00</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="panel widget bg-green" style="height: 80px;">
                                    <div class="row row-table">
                                        <div class="col-xs-4 text-center bg-green-dark pv-lg">
                                            <em class="fa-1x">
                                                <div class="text-uppercase">RESTANTE</div>
                                            </em>
                                        </div>
                                        <div class="col-xs-8 pv-lg">

                                            <div class="h1 m0 text-bold currency_procesar_pago">
                                                <?php echo $moneda[0]->moneda_simbolo; ?>
                                                <span id="restante_venta">0.00</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="panel widget bg-warning" style="height: 80px;">
                                    <div class="row row-table">
                                        <div class="col-xs-4 text-center bg-warning-dark pv-lg">
                                            <em class="fa-1x">
                                                <div class="text-uppercase">CAMBIO</div>
                                            </em>
                                        </div>
                                        <div class="col-xs-8 pv-lg">

                                            <div class="h1 m0 text-bold currency_procesar_pago">
                                                <?php echo $moneda[0]->moneda_simbolo; ?>
                                                <span id="cambio_venta">0.00</span>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <a href="" target="_blank" class="print_venta">
                                    <h1><i class="fa fa-print"></i></h1>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6" id="metodo_pago_lista">

                    </div>
                    <h2><span class="transacion"></span></h2>
                </div>

                <div class="modal-footer">

                    <button type="button" data-dismiss="modal" id="procesar_btn" class="mb-sm btn-lg btn btn-purple btn-outline guardar" name="../venta/guardar_venta">PROCESAR</button>
                    <button type="button" data-dismiss="modal" class="mb-sm btn-lg btn btn-danger btn-outline">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Small-->


    <!-- METODO DE PAGOS MODAL-->
    <div id="autorizacion_descuento" tabindex="-1" role="dialog" aria-labelledby="autorizacion_descuento" class="modal flip">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="background: #dde6e9">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span style="font-size: 20px; ">[ Autorizacion - Descuento ]</span>

                </div>
                <div class="modal-body">
                    Usuario
                    <input type="text" class="form-control has-success" name="input_autorizacion_descuento" id="input_autorizacion_descuento">
                    Password
                    <input type="password" class="form-control has-success" name="input_autorizacion_passwd" id="input_autorizacion_passwd">
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-success bg-green btn_aut_desc" name="5">Autorizar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Small-->

    <?php $this->load->view('scripts_files.php'); ?>