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

</script>

<script src="<?php echo base_url(); ?>../asstes/general.js"></script>

<?php
include("asstes/pos_funciones.php");
include("asstes/pos_orden.php");
?>
<script src="<?php echo base_url(); ?>../asstes/js/generalAlert.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/pos.css" />

<style>
    .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
        padding-left: 10%;
    }

    .modal-content {
        height: auto;
        min-height: 100%;
        border-radius: 5;
    }

    i{
        color:grey;
    }
    .format-label{
        width: 100%;
        height:30px;
        background:none;
        color: black;
        padding:0px;
        margin-bottom:-5px;
        text-align:right;
        padding-right:10px;
    }

    .icono-1{
        display:inline-block;
    }
    .control-style{
        float:right;
        display:inline-block;width:80%;
    }

    .myTableFormat > tbody > tr > td {
        border-top: 0px solid #eee;
    }

    .bg-green{
        color:white;
    }

    .panel {
        margin-bottom:0px;
    }

</style>

<!-- Main section-->
<section>
    <!-- Page content-->


    <div class="row">
        <div class="col-lg-12 col-md-12">
            <!-- Team Panel-->
            <div class="">

                <!-- START panel-->
                <form name="encabezado_form" id="encabezado_form" method="post" action="">

                    <!-- Campos de la terminal -->
                    <input type="hidden" name="terminal_id" value="<?php echo $terminal[0]->id_terminal; ?>" />
                    <input type="hidden" name="terminal_numero" value="<?php echo $terminal[0]->numero; ?>" />
                    <input type="hidden" name="caja_id" value="<?php echo $terminal[0]->id_caja; ?>" />
                    <input type="hidden" name="caja_numero" value="<?php echo $terminal[0]->cod_interno_caja; ?>" />
                    <input type="hidden" name="vista_id" value="<?php echo $vista_id; ?>" />
                    <!-- Fin Campos de la terminal -->

                    <!-- Campos del cliente -->
                    <input type="hidden" name="impuesto" value="" id="impuesto" />
                    <!-- Fin Campos del cliente -->


                    <div id="panelDemo1" class="panel" style="margin-top: 60px;">

                        <a href="index" style="top: 0px;position: relative; text-decoration: none; float: left;">
                            <button type="button" class="mb-sm btn btn-info"> Lista Ordenes </button>
                        </a>

                        <span style="text-align: left; font-size: 20px;overflow: hidden;margin-left:20px;">

                        </span>

                        <div class="panel-heading" style="text-align: right; font-size: 20px;">

                            <?php
                            if ($empleado[0]) {
                                //echo $empleado[0]->nombre_sucursal . " [ " . $terminal[0]->nombre . " ]";
                            } else {
                                echo " No hay Sucursal";
                            }
                            ?>

                            <a href="#" data-tool="panel-collapse" id="information" data-toggle="tooltip" title="Collapse Panel" class="pull-right bg-green">
                                <em class="fa fa-expand"></em> [ ? ]
                            </a>
                        </div>

                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3">
                                            
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-file-o sz" style="font-size:20px; float:left;padding:5px;"></i>Tipo Documento
                                                </label> 
                                                <select class="form-control" name="id_tipo_documento" id="id_tipo_documento" class="id_tipo_documento">
                                                    <?php
                                                    if ($tipoDocumento) {
                                                        foreach ($tipoDocumento as $documento) {
                                                            $doc = strtoupper($documento->nombre);
                                                            //if (strpos($doc, 'ORDEN') !== FALSE) {
                                                    ?>
                                                                <option value="<?php echo $documento->id_tipo_documento; ?>"><?php echo $documento->nombre; ?></option>
                                                        <?php
                                                            //}
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value="">No Hay Documento</option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-building sz" style="font-size:20px; float:left;padding:5px;"></i>Sucursal Destino
                                                </label>
                                                <select class="form-control" name="sucursal_destino" id="sucursal_id">
                                                    <?php
                                                    $id_sucursal = 0;
                                                    $id_sucursal2 = $empleado[0]->id_sucursal;
                                                    foreach ($empleado as $sucursal) {
                                                        $id_sucursal = $sucursal->id_sucursal;
                                                    ?>
                                                        <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                        <?php
                                                    }

                                                    foreach ($sucursales as $sucursal) {
                                                        if ($sucursal->id_sucursal != $id_sucursal) {
                                                            $id_sucursal = $sucursal->id_sucursal;
                                                        ?>
                                                            <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-home sz" style="font-size:20px; float:left;padding:5px;"></i>Bodega
                                                </label>
                                                <select class="form-control" name="bodega" id="bodega_select">
                                                    <?php
                                                    if (isset($bodega[0]->nombre_bodega)) {
                                                        foreach ($bodega as $b) {
                                                            if ($b->Sucursal == $id_sucursal2) {
                                                    ?>
                                                                <option value="<?php echo $b->id_bodega; ?>"><?php echo $b->nombre_bodega; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value="">No hay Bodega</option>
                                                    <?php
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="btn-group col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style" >
                                                <label class="format-label">
                                                    <i class="fa fa-arrow-down sz" style="font-size:20px; float:left;padding:5px;"></i>Estado Orden
                                                </label>
                                                <select name="orden_estado" id="orden_estado" class="form-control">
                                                    <?php
                                                    foreach($estados as $e){
                                                        
                                                        ?>
                                                        <option value="<?php echo $e->id_orden_estado ?>"><?php echo $e->orden_estado_nombre ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-user sz" style="font-size:20px; float:left;padding:5px;"></i>Cliente Codigo
                                                </label>
                                                <?php
                                                if (isset($cliente[0]->id_cliente)) {
                                                ?>
                                                    <input type="text" name="cliente_codigo" class="form-control cliente_codigo" id="cliente_codigo" value="<?php echo $cliente[0]->id_cliente ?>">
                                                    <select multiple="" class="form-control cliente_codigo2" id="cliente_codigo2" name="abc"></select>
                                                <?php
                                                } else {
                                                    echo "No Hay Cliente";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-user sz" style="font-size:20px; float:left;padding:5px;"></i>
                                                    <?php 
                                                        $saldo = $cliente[0]->saldos ? $cliente[0]->saldos : 0.00;
                                                    ?>
                                                    <span class="saldo"><?php echo " Saldo $ ". $saldo ." - "; ?> </span>
                                                    Cliente Nombre
                                                </label>
                                                <?php
                                                if (isset($cliente[0]->id_cliente)) {
                                                ?>
                                                    <input type="text" name="cliente_nombre" class="form-control cliente_nombre" id="cliente_nombre" value="<?php echo $cliente[0]->nombre_empresa_o_compania; ?>">
                                                <?php
                                                } else {
                                                    echo "No Hay Cliente";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-user sz" style="font-size:20px; float:left;padding:5px;"></i>Cliente Direccion
                                                </label>
                                                <?php
                                                if (isset($cliente[0]->id_cliente)) {
                                                ?>
                                                    <input type="text" name="cliente_direccion" class="form-control direccion_cliente" id="direccion_cliente" value="<?php echo $cliente[0]->direccion_cliente ?>">
                                                <?php
                                                } else {
                                                    echo "No Hay Cliente";
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-money sz" style="font-size:20px; float:left;padding:5px;"></i>Forma Pago
                                                </label>
                                                <select class="form-control" id="modo_pago_id" name="modo_pago_id">
                                                    <?php
                                                    if ($modo_pago) {
                                                        foreach ($modo_pago as $value) {
                                                        ?><option value="<?php echo $value->id_modo_pago; ?>">
                                                        <?php echo $value->nombre_modo_pago; ?></option>
                                                        <?php
                                                            }
                                                        } else {
                                                        ?>
                                                        <option value=""><?php echo "No Hay Pagos"; ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-comment sz" style="font-size:20px; float:left;padding:5px;"></i>Comentarios
                                                </label>
                                                <input type="text" name="comentarios" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-clock-o sz" style="font-size:20px; float:left;padding:5px;"></i>Fecha
                                                </label>
                                                <input type="date" name="fecha" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                            <label class="format-label">
                                                <i class="fa fa-building sz" style="font-size:20px; float:left;padding:5px;"></i>Sucursal Origen
                                            </label>
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

                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group has-success control-style">
                                                <label class="format-label">
                                                    <i class="fa fa-user sz" style="font-size:20px; float:left;padding:5px;"></i>Vendedor
                                                </label>
                                                <div class="" style="border:1px solid grey;height:35px;">
                                                    <input type="hidden" name="vendedor" id="vendedor1" value="<?php echo @$empleado[0]->id_empleado; ?>">
                                                    <a href="#" class="vendedores_lista1" id="<?php echo @$empleado[0]->id_sucursal; ?>"><?php echo @$empleado[0]->primer_nombre_persona . " " . @$empleado[0]->primer_apellido_persona; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END panel-->

                <!-- START table-responsive-->
                <div class="row" style="padding:0px;">
                    <div class="col-md-10">
                        <table class="table table-sm table-hover" style="margin-bottom: 0px;">

                            <div class="row" style="background:#2D3B48;">
                                <div class="col-md-5">
                                    <div class="" id="" style="margin-left:10px;">
                                        <input type="text" placeholder="Buscar Producto" autocomplete="off" width="100px" name="producto_buscar" class="form-control producto_buscar " style="width:100%;border:0px white;font-size:20px;">
                                    </div>

                                    <select multiple="" class="form-control dataSelect" id="dataSelect" style="height: 300px; width: 800px; font-size: 22px; font-family: monospace; display: block;"></select>

                                    <select multiple="" class="form-control dataSelect2" id="dataSelect2" style="height: 300px; width: 800px; font-size: 22px; font-family: monospace; display: block;border:3px solid #badae;"></select>

                                </div>
                                <div class="col-md-7">
                                <?php
                                    if (isset($tipoDocumento) && isset($sucursales) && isset($bodega) && isset($cliente)) {
                                    ?>
                                        <button type="button" class="btn btn-labeled bg-green" style="font-size: 20px;" name="guardar_orden" id="guardar_orden"><i class='fa fa-save' style="color:white;"></i> </button>
                                    <?php
                                    } else {
                                    ?>
                                        <button type="button" class="btn btn-labeled" style="font-size: 20px;" name="" id=""><i class='fa fa-save' style="color:white;"></i></button>
                                    <?php
                                    }
                                    ?>

                                    <span class="btn bg-green" id="btn_existencias" data-toggle='modal' style="font-size: 20px;" data-target='#existencias'><i class="fa fa-dropbox" style="color:white;"></i> <span style="font-size:18;">[ 6 ]</span></span>
                                    <span class="btn bg-green" id="btn_discount" style="font-size: 20px;"><i class="fa fa-percent" aria-hidden="true" style="color:white;"></i> <span style="font-size:18;color:white;">[ 7 ]</span></span>
                                    <span>
                                        ?<input type="number" class="form-control border-input" id="cantidad" name="cantidad" size="1px" value="1" min="1" max="1000" style="width: 80px;height:50px;display:inline-block;">
                                        <input type="text" class="form-control border-input" placeholder="Des. *" id="descuento" name="descuento" size="2px" style="width: 80px;height:50px;display:inline-block;">
                                        <input type="text" class="form-control border-input" placeholder="Orden -" id="buscar_orden" name="buscar_orden" style="width: 100px;height:50px;display:inline-block;">
                                    </span>
                                </div>
                            </div>                         
                        </table>
                        <div class="lista_productos" style="height:600px;">                           
                            <table class="table table-sm table-hover myTableFormat" id="lista_productos">   
                                <thead class="bg-info-dark" style="background: #cfdbe2;">
                                    <tr>
                                        <th style="color: black;">#</th>
                                        <th style="color: black;">Producto</th>
                                        <th style="color: black;">Descripción</th>
                                        <th style="color: black;">Cantidad</th>
                                        <th style="color: black;">Presentación</th>
                                        <th style="color: black;">Factor</th>
                                        <th style="color: black;">Precio Unidad</th>
                                        <th style="color: black;">Descuento</th>
                                        <th style="color: black;">Total</th>
                                        <th style="color: black;">Bodega</th>
                                        <th style="color: black;">
                                            <span style="background:black;" class="badge badge-success cantidad_tabla"></span>
                                        </th>
                                    </tr>
                                </thead>                        
                                <tbody class="producto_agregados" style="border-top:  0px solid black" id="prod_list">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="row" style="background:#2D3B48;">
                            <div class="col-md-12" style="width: 100%; background: #2D3B48/*#0f4871*/;text-align: left;color: white;">
                                <span style="font-size: 30px;"><?php echo $moneda[0]->moneda_simbolo; ?> <span class="total_msg">0.00</span></span>
                            </div>
                        </div>

                        <div class="row">
                            
                                <table class="table table-sm table-hover myTableFormat" style="font-size: 16px;">
                                    <tr>
                                        <td style="color:#0f4871;"><b>Gravado</b></td>
                                        <td><?php echo $moneda[0]->moneda_simbolo; ?> <span class="sub_total_tabla"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Iva</b></td>
                                        <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="iva_valor"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Exento</b></td>
                                        <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="exento_valor"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Descuento</b></td>
                                        <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="descuento_tabla"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:16px;"><span class="impuestos_nombre"></span></td>
                                        <td><span class="impuestos_total"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="color:#0f4871"><b>Total</b></td>
                                        <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="total_tabla"></span></td>
                                    </tr>
                                </table>
                                <table class="table myTableFormat">
                                    Acceso de Teclado
                                    <tr>
                                        <td>
                                            <span class="btn btn-info" 
                                                  style="background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;" >2
                                                <i class="icon-grid" style="color:white;"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <span class="btn btn-info" 
                                                style="background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;"> 3
                                            <i class="icon-trash" style="color:white;"></i>
                                        </span>
                                        </td>
                                    </tr>
                                    <!--<tr>
                                        <td>
                                            <span class="btn btn-info guardar" id="../venta/guardar_venta" style="background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">4
                                                <i class="fa fa-credit-card" style="color:white;"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <span class="btn btn-info devolucion" data-toggle="modal" data-target="#devolucion" id="../venta/guardar_venta" style="background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">5
                                            <i class="fa fa-refresh" style="color:white;"></i>
                                        </span>
                                    </td>
                                    </tr>-->
                                </table>
                            

                        </div>
                    </div>
                </div>

                <div class="row" style="border-top: 1px dashed grey;">

                </div>

                <div class="col-lg-12 col-md-12 paper_cut1">
                </div>
                <!-- END table-responsive-->
            </div>
            <!-- end Team Panel-->
        </div>
    </div>

    <div class="row bg-red" style="position: fixed;bottom: 0px; width: 100%;">
        <div class="col-lg-12 col-md-12 abajo" style="height: 50px;">

        </div>
    </div>

</section>

<!-- Modal Large CLIENTES MODAL-->
<div id="vendedor_modal" tabindex="-1" role="dialog" aria-labelledby="vendedor_modal" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel-header" style="background: #535D67; color: white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title">Buscar Vendedor</h4>
            </div>
            <div class="modal-body">
                <p class="vendedor_lista_datos">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-info">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->

<!-- Modal Large CLIENTES MODAL-->
<div id="cliente_modal" tabindex="-1" role="dialog" aria-labelledby="cliente_modal" class="modal fade fade-scale">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel-header" style="background: #535D67; color: white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title">Buscar Cliente</h4>
            </div>
            <div class="modal-body">
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
<div id="existencias" tabindex="-1" role="dialog" aria-labelledby="existencias" class="modal fade fade-scale">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="input-group m-b" id="headerInputs">
                    <span class="input-group-addon bg-green"><i class="fa fa-search"></i></span>
                    <input type="text" placeholder="Buscar Exsitencia" name="existencia_buscar" class="form-control existencia_buscar">
                </div>

                <select multiple="" class="form-control 1dataSelect" id="1dataSelect"></select>

                <select multiple="" class="form-control 1dataSelect2" style="display: inline-block;"></select>

            </div>
            <div class="modal-body">
                <table class="table table-sm table-hover">
                    <thead class="linea_superior">
                        <tr class="linea_superior">
                            <th style="color: black;">#</th>
                            <th style="color: black;">Sucursal</th>
                            <th style="color: black;">Bodega</th>
                            <th style="color: black;">Existencia</th>
                            <th style="color: black;">Precio</th>
                            <th style="color: black;">Presentacion</th>
                            <th style="color: black;">Codigo</th>
                        </tr>
                    </thead>
                    <tbody class="dos" style="border-bottom: 3px solid grey"></tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default bg-green">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->
<div id="autorizacion_descuento_div"></div>
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
                <button type="button" data-dismiss="modal" class="btn btn-success guardar bg-green" name="5">Si</button>
                <button type="button" data-dismiss="modal" class="btn btn-warning">No</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->

<!-- Modal Large PRODUCTOS MODAL-->
<div id="en_reserva" tabindex="-1" role="dialog" aria-labelledby="en_reserva" class="modal fade fade-scale">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Notificación
            </div>
            <div class="modal-body">
                Cambiar Orden a Reservado ?
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-success guardar bg-green" name="2">Si</button>
                <button type="button" data-dismiss="modal" class="btn btn-warning">No</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->

<!-- METODO DE PAGOS MODAL-->
<!--
<div id="procesar_venta" tabindex="-1" role="dialog" aria-labelledby="procesar_venta" class="modal flip">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header" style="background: #dde6e9">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; ">[ Proceso Pago ]</span>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-9 col-md-9" style="border-right: 1px solid #e5e5e5; height: 50%;">

                        <div class="row">
                            <div class="col-lg-3 col-md-3">
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
                            <div class="col-lg-3 col-md-3">
                                <a href="#" class="btn bg-green addMetodoPago"><i class="fa fa-plus-circle"></i> Agregar</a>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <input type="text" class="form-control has-success" name="cliente" placeholder="Nombre Cliente">
                            </div>

                        </div>

                        <div class="row" id="metodos_pagos">

                            <br>
                            <?php

                            if (isset($modo_pago)) {
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
                        </div>
                    </div>

                </div>
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6" id="metodo_pago_lista">

                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" data-dismiss="modal" id="procesar_btn2" class="mb-sm btn-lg btn btn-purple btn-outline guardar" name="2">PROCESAR</button>
                    <button type="button" data-dismiss="modal" class="mb-sm btn-lg btn btn-danger btn-outline">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<!-- Modal Small-->

<!-- METODO DE PAGOS MODAL-->
<div id="autorizacion_descuento" tabindex="-1" role="dialog" aria-labelledby="autorizacion_descuento" class="modal flip fade-scale">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: #dde6e9">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; ">[ Autorizacion - Descuento ]</span>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                        <p class="msg_error"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6" style="border-right:1px solid grey;text-align:center;">
                        <br/><br/><img src="/asstes/img/user_autorization.png" width="20%" /><br/><br/><br/>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="row">

                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                Ingresar Credenciales
                            </div>
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:left;margin-top:0px;">
                                Usuario
                                <input type="text" class="form-control has-success" name="input_autorizacion_descuento" id="input_autorizacion_descuento">
                            </div>

                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:left;margin-top:0px;">
                                Password
                                <input type="password" class="form-control has-success" name="input_autorizacion_passwd" id="input_autorizacion_passwd">
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-success bg-green btn_aut_desc" name="5">Autorizar</button>
                <button type="button" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->

<!-- METODO DE PAGOS MODAL-->
<div id="procesar_venta" tabindex="-1" role="dialog" aria-labelledby="procesar_venta" class="modal flip fade-scale">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header" style="background: #dde6e9; color:black;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; ">[ Proceso de Pago ]</span>
            </div>
            <div class="modal-body">
                <div class="row" style="background:#f7f7f7;">
                    <div class="col-lg-9 col-md-9" style="border-right: 1px solid #e5e5e5; height: 50%;">
                        <div class="row">
                            <div class="col-lg-2 col-md-2">
                                <span>TIPO PAGO </span> [ N°8 ]
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
                            <div class="col-lg-1 col-md-1"><br>
                                <a href="#" class="btn bg-green addMetodoPago"><i class="fa fa-plus-circle"></i> Agregar</a>
                            </div>
                            <div class="col-lg-2 col-md-2">Correlativo
                                <input type="text" class="form-control has-success" name="correlativo_documento" id="correlativo_documento" placeholder="">
                            </div>

                            <div class="col-lg-2 col-md-2">
                                <spam>Nombre Cliente</spam>
                                <input type="text" class="form-control has-success" name="cliente" placeholder="">
                            </div>

                            <div class="col-lg-2 col-md-1">D. Identificacion
                                <input type="text" class="form-control has-success" name="correlativo_documento" id="correlativo_documento" placeholder="">
                            </div>

                            <div class="col-lg-2 col-md-2">Estado
                                <select name="orden_estado" id="orden_estado" class="form-control">
                                    <?php
                                    foreach($estados as $e){
                                        
                                        ?>
                                        <option value="<?php echo $e->id_orden_estado ?>"><?php echo $e->orden_estado_nombre ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><br>
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
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="panel widget bg-success" style="height: 90px;">
                                    <div class="row row-table">
                                        <div class="col-xs-4 text-center bg-success-dark pv-lg">
                                            <div class="text-uppercase">PAGAR</div>
                                            <em class="fa-3x"><?php echo $moneda[0]->moneda_simbolo; ?></em>
                                        </div>
                                        <div class="col-xs-8 pv-lg">
                                            <div class="h1 m0 text-bold"><span id="compra_venta">0.00</span></div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="panel widget bg-green" style="height: 90px;">
                                    <div class="row row-table">
                                        <div class="col-xs-4 text-center bg-green-dark pv-lg">
                                            <div class="text-uppercase">RESTANTE</div>
                                            <em class="fa-3x"><?php echo $moneda[0]->moneda_simbolo; ?></em>
                                        </div>
                                        <div class="col-xs-8 pv-lg">
                                            <div class="h1 m0 text-bold"><span id="restante_venta">0.00</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="panel widget bg-warning" style="height: 90px;">
                                    <div class="row row-table">
                                        <div class="col-xs-4 text-center bg-warning-dark pv-lg">
                                            <div class="text-uppercase">CAMBIO</div>
                                            <em class="fa-3x"><?php echo $moneda[0]->moneda_simbolo; ?></em>
                                        </div>
                                        <div class="col-xs-8 pv-lg">
                                            <div class="h1 m0 text-bold"><span id="cambio_venta">0.00</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12" style="text-align:center">
                                <a href="#" class="printer">
                                    <h1><i class="fa fa-print"></i></h1>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>                
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
<div id="devolucion" tabindex="-1" role="dialog" aria-labelledby="devolucion" class="modal flip fade-scale">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: #dde6e9">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; ">[ Devolcion ]</span>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                        <p class="msg_error"></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6" style="border-right:1px solid grey;text-align:center;">
                        <br/><br/><img src="/asstes/img/download.png" width="" /><br/><br/><br/>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="row">

                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <span class="inline checkbox c-checkbox">
                                    <label>
                                    <input type="checkbox" id="check_devolucion" name="check_devolucion" class="">
                                    <span class="fa fa-check check_devolucion"></span> Aplicar Devolucion ?
                                    </label>
                                </span>
                            </div>
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <input type="text" class="form-control has-success input_devolucion" placeholder="Documento Referencia" name="input_devolucion" id="input_devolucion" value=""><br>
                            </div>

                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <input type="text" class="form-control has-success" placeholder="Cliente Nombre" name="input_devolucion_nombre" id="input_devolucion_nombre" value=""><br>
                            </div>

                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <input type="text" class="form-control has-success" placeholder="Cliente DUI" name="input_devolucion_dui" id="input_devolucion_dui" value=""><br>
                            </div>

                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <input type="text" class="form-control has-success" placeholder="Cliente NIT" name="input_devolucion_nit" id="input_devolucion_nit" value=""><br>
                            </div>
                        </div>
                    </div>
                </div>                       
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success bg-green btn_aut_desc input_devolucion_btn" name="5">Aceptar Devolución</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->