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
    var cantidad_por_documento = 0;

    window.onload = function(event) {

        var terminal = $("#terminal_id").val();

        setAction(terminal, 1);

    };

    window.onbeforeunload = function(event) {

        var message = '';
        var terminal = $("#terminal_id").val();

        setAction(terminal, 0);

        return message;
    };

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
        setTimeout(function() {
            //$("#m_orden_creada").modal();
            //$("#imprimir").modal(); 
        }, 1000);

        $(".printer").click(function() {

            $("#m_orden_creada").modal();

        });

        registro_editado = 0;
    });
</script>

<!-- Main section-->

<style>
    .modal-header {
        background: #fff;
        color: black;
        border-top: 2px solid white;
        border-bottom: 2px solid #4974a7;
        font-size: 22px;
    }

    .pantalla-info {
        display: inline-block;
        font-size: 20px;
        overflow: hidden;
        float: right;
        margin-top: 10px;
    }

    .pantalla-detalle {
        color: white;
    }

    .pantalla-td-h3 {
        display: inline-block;
        margin-right: 2%;
    }

    .pantalla-tr {
        background: #2D3B48;
    }

    .pantalla-tr-td {
        font-size: 16px;
        background: #2b957a;
        color: white;
    }

    #dataSelect, .dataSelect{
        font-family: monospace;
    }

    #documentoModel {
        margin-top: -20px;
        display: block;
        float: right;
        position: absolute;
        width: 100%;
        right: -320px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    #documentoModel>div>.modal-content {
        height: 90%;
    }

    #devolucion {
        margin-top: -20px;
        margin-left: 75%;
        width: 25%;
        display: block;
        float: right;
        position: absolute;
        height: 100%;
        right: -95%;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    #devolucion>div>.modal-content {
        height: 95%;
    }

    #anulado {
        margin-top: -20px !important;
        margin-left: 75% !important;
        width: 25% !important;
        display: block !important;
        float: right !important;
        position: absolute !important;
        height: 100% !important;
        right: -95% !important;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    #anulado>div>.modal-content {
        /*float: right !important;*/
        height: 100% !important;
    }

    #autorizacion_descuento {
        margin-top: -20px !important;
        margin-left: 75% !important;
        width: 25% !important;
        display: block !important;
        float: right !important;
        position: absolute !important;
        height: 100% !important;
        right: -95% !important;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    #autorizacion_descuento>div>.modal-content {
        /*float: right !important;*/
        height: 100% !important;
    }

    .myTableFormat>tbody>tr>td {
        border-top: 0px solid #eee;
    }

    #procesar_venta , .modal-content {
        height: 1200px;
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
                                        <input type="text" placeholder="Buscar Producto" autocomplete="off" name="[producto_buscar]" class="form-control producto_buscar" style="font-size:18px;">
                                    </div>

                                    <select multiple="" class="form-control dataSelect form-control " id="dataSelect" style="height: 400px; width:1200px; font-size:22px;font-family: monospace;">

                                    </select>

                                    <select multiple="" class="form-control dataSelect2" id="dataSelect2" style="height: 300px; width: 1200px; font-size: 22px; font-family: monospace; display: block;border:3px solid #badae;">

                                    </select>
                                </div>

                                <div class="col-lg-8" style="text-align: left;" id="headerInputs">
                                    <!--
                                    <button class="btn bg-green" id="grabar" style="font-size: 25px;" data-toggle="tooltip" data-placement="bottom" title="Agregar"><i class='fa fa-shopping-cart'></i></button>
                                    -->
                                    <!--<span class='btn bg-green guardar' name="1" id="../venta/guardar_venta" style="font-size: 25px;" data-toggle="tooltip" data-placement="bottom" title="Procesar"><i class='fa fa-money'></i> <span style="font-size:18;">[ F4 ]</span></span>-->

                                    <span class="btn bg-green" id="btn_existencias" data-toggle="tooltip" data-placement="bottom" title="Existencias" style="font-size: 25px;"><i class="fa fa-dropbox"></i> 
                                        <span class="badge badge-success" style="background:#2b957a;font-size: 16px;"> # 6</span>
                                        
                                    </span>
                                    <span class="btn bg-green" id="btn_discount" style="font-size: 25px;">
                                        <i class="fa fa-percent" aria-hidden="true"></i> 
                                        <span class="badge badge-success" style="background:#2b957a;font-size: 16px;"> # 7</span>
                                    </span>

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

                                    <span class="badge badge-success" style="background:#2b957a;font-size: 16px;"> # ?</span>
                                    <input type="number" class="form-control border-input" id="cantidad" name="cantidad" size="1px" value="1" min="1" max="1000" style="width: 80px;display: inline-block;">
                                    <input type="text" class="form-control border-input" placeholder="Des. *" id="descuento" name="descuento" size="2px" style="width: 80px;display: inline-block;">
                                    <input type="text" name="orden_numero" id="orden_numero" placeholder="Orden -" value="" class="form-control" style="width:100px; display: inline-block;" />
                                    <!-- <input type="text" name="venta_numero" id="venta_numero" placeholder="Venta" value="" class="form-control" style="width:120px; display: inline-block;" />-->
                                </div>
                            </div>
                        </div>

                        <!-- START table-responsive-->
                        <div class="table-responsive" style="width: 100%;height:100%;">
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
                                            <th style="color: black;">Precio Uni</th>
                                            <th style="color: black;">Descuento</th>
                                            <th style="color: black;">Total</th>
                                            <th style="color: black;">Bodega</th>
                                            <th style="color: black;"><span class="badge badge-success cantidad_tabla" style="background:#2D3B48;font-size: 16px;">0</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="producto_agregados" style="border-top:  0px solid black; color: black; background: white; overflow: scroll;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END table-responsive-->

                    </div>
                    <!-- end Team Panel-->
                </div>
            </div>
            <?php $this->load->view('notificaciones/success'); ?>
        </div>
        <div class="col-lg-3 col-md-3">
            <div style="border:0px solid black">
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

                    <div class="row">
                        <div class="col-lg-12 col-md-12" style="width: 100%; background: #2D3B48/*#0f4871*/;text-align: center;color: white;">

                            <span style="font-size: 50px;">
                                <?php echo $moneda[0]->moneda_simbolo; ?> <span class="total_msg">0.00</span>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12" style="width: 100%; height:89%; background: white; right: 0px;">

                            <table class="table table-sm table-hover myTableFormat" style="font-size: 22px;">
                                <tr>
                                    <td style="color:#0f4871;"><b>Gravado</b></td>
                                    <td><?php echo $moneda[0]->moneda_simbolo . " "; ?> <span class="sub_total_tabla"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Iva</b></td>
                                    <td><?php echo $moneda[0]->moneda_simbolo . " "; ?><span class="iva_valor"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Exento</b></td>
                                    <td><?php echo $moneda[0]->moneda_simbolo . " "; ?><span class="exento_valor"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Descuento</b></td>
                                    <td><?php echo $moneda[0]->moneda_simbolo . " "; ?><span class="descuento_tabla"></span></td>
                                </tr>
                                <tr>
                                    <td><span class="impuestos_nombre"></span></td>
                                    <td><span class="impuestos_total"></span></td>
                                </tr>
                                <tr>
                                    <td style="color:#0f4871"><b>Total</b></td>
                                    <td><?php echo $moneda[0]->moneda_simbolo . " "; ?><span class="total_tabla"></span></td>
                                </tr>
                            </table>
                            <div class="row" id="anular_documento_msg">
                                <div class="col-lg-12 col-md-12" style="width: 100%;color:#fff;">
                                    <h4 class="anular_documento_msg"></h4>
                                </div>
                            </div>
                            <table class="table myTableFormat">
                                <tr>
                                    <td>
                                        <span class="btn btn-info" data-toggle="modal" data-target="#documentoModel" style="width:100%;background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">1 <i class="icon-settings"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="btn btn-info" style="width:100%;background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">2 <i class="icon-grid"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="btn btn-info" style="width:100%;background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">3 <i class="icon-trash"></i>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="btn btn-info guardar" id="../venta/guardar_venta" style="width:100%;background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">4 <i class="fa fa-credit-card"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="btn btn-info devolucion" data-toggle="modal" data-target="#devolucion" id="../venta/guardar_venta" style="width:100%;background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">5 <i class="fa fa-refresh"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="btn btn-info anulado" data-toggle="modal" data-target="#anulado" id="../venta/guardar_venta" style="width:100%;background: #2D3B48; font-size: 30px;margin-top: 2px;margin-left: 4px;">0 <i class="fa fa-ban"></i>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            <table class="table myTableFormat">
                                <tr class="pantalla-tr">
                                    <td class="pantalla-tr-td" colspan="1">
                                        <h3 class="pantalla-td-h3"><i class="fa fa-desktop"></i></h3>
                                        <div class="pantalla-info">Terminal</div>
                                    </td>
                                    <td class="pantalla-detalle">
                                        <?php echo strtoupper($terminal[0]->nombre_caja); ?> /
                                        <?php echo  $terminal[0]->nombre; ?>
                                    </td>
                                </tr>
                                <tr class="pantalla-tr">
                                    <td class="pantalla-tr-td" colspan="1">
                                        <h3 class="pantalla-td-h3"><i class="fa fa-user"></i></h3>
                                        <div class="pantalla-info">Cajero</div>
                                    </td>
                                    <td class="pantalla-detalle">
                                        <?php echo $empleado[0]->primer_nombre_persona; ?>
                                    </td>
                                </tr>

                                <tr class="pantalla-tr">
                                    <td class="pantalla-tr-td" colspan="1">
                                        <input type="hidden" name="terminal" id="terminal_id" value="<?php echo $terminal[0]->id_terminal ?>" />
                                        <h3 class="pantalla-td-h3"><i class="fa fa-home"></i></h3>
                                        <div class="pantalla-info">Sucursal</div>
                                    </td>
                                    <td class="pantalla-detalle">
                                        <?php
                                        if (isset($empleado[0]->nombre_sucursal)) {
                                            echo $empleado[0]->nombre_sucursal;
                                        } else {
                                            echo "Sin Sucursal";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr class="pantalla-tr">
                                    <td class="pantalla-tr-td" style="text-align:center;">
                                        <h3><label class="time-time"></label></h3>
                                    </td>
                                    <td style="font-size: 16px;color:white;">
                                        <h3><label class="time-date"></label></h3>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-lg-12 col-md-12 paper_cut">
                        </div>

                    </div>

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
            <div id="documentoModel" tabindex="-1" role="dialog" aria-labelledby="documentoModel" class="modal flip fade-scale">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2D3B48;color:white;">
                            <div class="row">
                                <div class="col-lg-1 col-md-1">
                                    <i class="fa fa-cog" style="background:none;font-size:60px;"></i>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <span style="text-align:center;">FACTURACION PARAMETROS</span>
                                </div>
                            </div>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <label> 
                                                <span class="fa fa-edit"></span> 
                                                 Tipo Documento 
                                            </label>
                                            <span class="badge badge-success" style="background:#2b957a;font-size: 16px;float:right;"> Shift + q</span>
                                            <select class="form-control id_tipo_documento_main" name="id_tipo_documento" id="id_tipo_documento">
                                                <?php
                                                foreach ($tipoDocumento as $d) {
                                                    $doc = strtoupper($d->nombre);
                                                    if ($d->id_tipo_documento == $terminal[0]->pred_id_tpdoc) {
                                                        //if (strpos($doc, 'ORDEN') === false) {
                                                ?>
                                                        <option value="<?php echo $d->id_tipo_documento; ?>"><?php echo $d->nombre; ?></option>
                                                    <?php
                                                        //}
                                                    }
                                                }

                                                foreach ($tipoDocumento as $documento) {

                                                    $doc = strtoupper($documento->nombre);

                                                    //if (strpos($doc, 'ORDEN') === FALSE) {
                                                    //if ($documento->id_temp_suc != $terminal[0]->pred_id_tpdoc) {
                                                    ?>
                                                    <option value="<?php echo $documento->id_tipo_documento; ?>"><?php echo $documento->nombre ?></option>
                                                <?php
                                                    //}
                                                    //}
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-user"></span>
                                            <label>
                                                
                                                Cliente Codigo
                                            </label>
                                            <span class="badge badge-success" style="background:#2b957a;font-size: 16px;float:right;"> Shift + w</span>
                                            <input type="text" name="cliente_codigo" class="form-control cliente_codigo" id="cliente_codigo" value="<?php echo $cliente[0]->id_cliente ?>">

                                            <select multiple="" class="form-control cliente_codigo2" id="cliente_codigo2" name="abc"></select>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-user"></span>
                                            <label>
                                                Cliente Nombre</label>
                                                <span class="badge badge-success" style="background:#2b957a;font-size: 16px;float:right"> Shift + r</span>
                                            <input type="text" name="cliente_nombre" class="form-control cliente_nombre" id="cliente_nombre" value="<?php echo $cliente[0]->nombre_empresa_o_compania ?>">
                                            <input type="hidden" name="cliente_direccion" class="form-control direccion_cliente" id="direccion_cliente" value="<?php echo $cliente[0]->direccion_cliente ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-money"></span>
                                            <label>
                                                Forma Pago
                                            </label>
                                            <span class="badge badge-success" style="background:#2b957a;font-size: 16px;float:right"> Shift + e</span>
                                            <select class="form-control" id="modo_pago_id" name="modo_pago_id">
                                                <?php
                                                foreach ($modo_pago as $value) {
                                                ?><option value="<?php echo $value->id_modo_pago; ?>"><?php echo $value->nombre_modo_pago; ?></option><?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-home"></span>
                                            <label>
                                                Sucursal Destino
                                            </label>
                                            <span class="badge badge-success" style="background:#2b957a;font-size: 16px;float:right"> Shift + t</span>
                                            <select class="form-control" name="sucursal_destino" id="sucursal_id">
                                                <?php
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
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-building"></span>
                                            <label>
                                                Bodega</label>
                                                <span class="badge badge-success" style="background:#2b957a;font-size: 16px;float:right"> Shift + y</span>
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
                                            <label>
                                                Sucursal Origin</label>
                                                <span class="badge badge-success" style="background:#2b957a;font-size: 16px;float:right"> Shift + u</span>
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
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group has-success">
                                            <span class="fa fa-clock-o"></span>
                                            <label>
                                                Fecha</label>
                                                <span class="badge badge-success" style="background:#2b957a;font-size: 16px;float:right"> Shift + i</span>
                                            <input type="date" name="fecha" id="fecha_factura" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="vendedor" id="vendedor1" value="<?php echo @$empleado[0]->id_empleado; ?>">
                                <!--
                                <div class="label">
                                    <?php
                                    if (isset($empleado[0]->id_sucursal)) {

                                    ?>
                                        <a 
                                            href="#" 
                                            class="vendedores_lista1" 
                                            style="font-size:22px;text-decoration:none;"
                                            id="<?php echo $empleado[0]->id_sucursal; ?>">
                                            <?php echo "Cajero : " . $empleado[0]->primer_nombre_persona . " " . $empleado[0]->primer_apellido_persona; ?>
                                        </a>
                                    <?php

                                    } else {
                                        echo "No hay Vendedor";
                                    }
                                    ?>

                                </div>
                                -->

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Small-->

            </form>
        </div>
    </div>
</section>

<!-- Modal Large CLIENTES MODAL-->
<div id="anulado" tabindex="-1" role="dialog" aria-labelledby="anulado" class="modal flip fade-scale" style="width:500px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #2D3B48; color:white;">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <h3><i class="fa fa-cart-arrow-down" style="background:none;font-size:60px;"></i> ANULAR VENTA</h3>
                    </div>
                </div>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3><i class="fa fa-close"></i> Anular Documento :</h3>
                <h2 class="anular_documento"></h2>
            </div>
            <div class="modal-footer">
                <input type="button" data-dismiss="modal" id="btn_anular_documento" style="float:left;" class="btn btn-info btn_anular_documento" name="5" value="Aceptar">
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
<div id="existencias" tabindex="-1" role="dialog" aria-labelledby="existencias" class="modal fade fade-scale">
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
                        <tr class="linea_superior">
                            <th style="color: black;">#</th>
                            <th style="color: black;">Sucursal</th>
                            <th style="color: black;">Bodega</th>
                            <th style="color: black;">Existencia</th>
                            <th style="color: black;">Precio</th>
                            <th style="color: black;">Presentación</th>
                            <th style="color: black;">Codigo</th>
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
<div id="en_proceso" tabindex="-1" role="dialog" aria-labelledby="en_proceso" class="modal fade fade-scale">
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
<div id="procesar_venta" tabindex="-1" role="dialog" aria-labelledby="procesar_venta" class="modal flip fade-scale">
    <div class="modal-dialog modal-lg" style="width: 85%;">
        <div class="modal-content">
            <div class="modal-header" style="background: #2D3B48; color:white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; ">[ Proceso de Pago ]</span>

            </div>
            <div class="modal-body">
                <div class="row" style="background:#f7f7f7;">
                    <div class="col-lg-9 col-md-9" style="border-right: 1px solid #e5e5e5; height: 50%;">

                        <div class="row" style="background:#f7f7f7;">

                            <div class="col-lg-2 col-md-2"><br>
                                <span class="badge badge-success" style="background:#2D3B48;font-size: 16px;"> # 8</span>
                                <span>TIPO PAGO</span> 
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

                            <div class="col-lg-1 col-md-1"><br><br>
                                <a href="#" class="btn bg-green addMetodoPago"><i class="fa fa-plus-circle"></i> Agregar</a>
                            </div>
                            <div class="col-lg-9 col-md-9" style="text-align:right;color:#2b957a;">
                                <h4><span class="mensajes_varios"></span></h4>
                            </div>
                        </div>    
                        <div class="row" style="background:#f7f7f7;">

                            <div class="col-lg-2 col-md-2"><br>
                                Documento
                                <select class="form-control id_tipo_documento" name="id_tipo_documento" id="id_tipo_documento">
                                    <?php

                                    foreach ($tipoDocumento as $documento) {
                                        //if ($orden[0]->id_tipod != $documento->id_tipo_documento) {
                                    ?>
                                        <option value="<?php echo $documento->id_tipo_documento; ?>"><?php echo $documento->nombre; ?></option>
                                    <?php
                                        //}
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-2"><br>
                                Correlativo
                                <input type="text" class="form-control has-success" name="correlativo_documento" id="correlativo_documento" placeholder="">
                            </div>

                            <div class="col-lg-2 col-md-2"><br>
                                <spam style="">Nombre Cliente</spam>
                                <input type="text" class="form-control has-success" name="cliente_nombre" id="doc_cli_nombre" placeholder="">
                            </div>

                            <div class="col-lg-2 col-md-2"><br>
                                D. Identificacion
                                <input type="text" class="form-control has-success" name="cliente_identificacion" id="doc_cli_identificacion" placeholder="">
                            </div>

                            <div class="col-lg-2 col-md-2"><br>
                                Estado
                                <select name="orden_estado" id="orden_estado" class="form-control">
                                    <?php
                                    foreach ($estados as $e) {
                                    ?>
                                        <option value="<?php echo $e->id_orden_estado ?>"><?php echo $e->orden_estado_nombre ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>

                        </div>

                        <div class="row correlativos_documentos">
                            <div class="correlativos_documentos"></div>

                        </div>

                        <div class="row" id="metodos_pagos" style="background:#f7f7f7;">

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

                        </div>
                    </div>

                </div>


            </div>
            <div class="modal-footer" style="background: none; color:white;">
                <spam class="db_msj" style="float:left;color:red;"></spam>
                <button type="button" data-dismiss="modal" id="procesar_btn" class="mb-sm btn-lg btn btn-purple btn-outline guardar" name="../venta/guardar_venta">PROCESAR</button>
                <button type="button" data-dismiss="modal" class="mb-sm btn-lg btn btn-danger btn-outline">CANCELAR</button>
            </div>
        </div>
    </div>
    <!-- Modal Small-->


    <!-- METODO DE PAGOS MODAL-->
    <div id="autorizacion_descuento" tabindex="-1" role="dialog" aria-labelledby="autorizacion_descuento" class="modal flip fade-scale">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="background: #2D3B48; color:white;">
                    <div class="row">
                        <div class="col-md-2 col-md-2">
                            <i class="fa fa-check" style="background:none;font-size:60px;"></i>
                        </div>
                        <div class="col-md-8 col-md-8">
                            <span style="text-align:left;"> AUTORIZAR DESCUENTO </span>
                        </div>
                    </div>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-8 col-md-8" style="text-align:center;">
                            <i class="fa fa-user-circle" style="background:none;font-size:160px;"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            Usuario
                            <input type="text" class="form-control has-success" name="input_autorizacion_descuento" id="input_autorizacion_descuento">
                            Password
                            <input type="password" class="form-control has-success" name="input_autorizacion_passwd" id="input_autorizacion_passwd">
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="float:left;">
                    <button type="button" data-dismiss="modal" class="btn btn-success btn_aut_desc" name="5">Autorizar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Small-->

    <!-- METODO DE PAGOS MODAL-->
    <!--<div id="m_orden_creada" tabindex="-1" role="dialog" aria-labelledby="m_orden_creada" class="modal flip fade-scale">
        <div class="modal-dialog modal-md">
            <div class="modal-content" style="background:#f1f1f1;">
                <div class="modal-header" style="background: #2c71b5;color: white;">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span style="font-size: 20px; ">Documento : <?php //$temp[0]->documento_nombre ?> | Formato : <?php //$temp[0]->factura_nombre ?> </span>

                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <?php //include("asstes/temp/" . $file . ".php"); ?>
                        </div>
                        <div class="col-lg-4 col-md-4" style="border-left:1px dashed black;height:900px;position: relative;float:right;margin:0px;">

                            <div class="row">
                                <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                    <?php //echo $msj_title ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                    <h1>
                                        <?php //echo $msj_orden ?>
                                    </h1>
                                </div>
                            </div>
                            <div class="row">
                                <hr style="border-bottom:1px dashed black">
                                <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">

                                    <a href="../nuevo" class="btn btn-default printer">
                                        <h3> <i class="icon-plus"></i> Nueva </h3>
                                    </a>
                                    <a href="#" class="btn btn-success printer" style="color:black">
                                        <h3> <i class="icon-printer"></i> Imprimir </h3>
                                    </a>
                                    <button type="button" data-dismiss="modal" class="btn btn-danger" style="color:black">
                                        <h3> <i class="icon-close"></i> Cerrar </h3>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    -->
    <!-- Modal Small-->

    <!-- METODO DE PAGOS MODAL-->
    <div id="devolucion" tabindex="-1" role="dialog" aria-labelledby="devolucion" class="modal flip fade-scale">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #2D3B48; color:white;">
                    <div class="row">
                        <div class="col-lg-1 col-md-1">
                            <i class="fa fa-reply-all" style="background:none;font-size:60px;"></i>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <span style="text-align:center;">DEVOLUCION - ANULAR</span>
                        </div>
                    </div>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6 col-md-6" style="font-size:24px;text-align:center;margin-top:0px;">
                            <p class="msg_error"></p>

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                    
                                <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:left;margin-top:0px;">
                                    <span class="inline checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" id="check_devolucion" name="check_devolucion" class="">
                                            <span class="fa fa-check check_devolucion"></span> Aplicar Devolución ?
                                        </label>
                                    </span>
                                    <textarea class="form-control" name="nota_devolucion"></textarea>
                                </div>
                        
                                <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:left;margin-top:0px;">
                                    <span class="inline checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" id="check_anulacion" name="check_anulacion" class="">
                                            <span class="fa fa-check check_anulacion"></span> Aplicar Anulación ?
                                        </label>
                                    </span>
                                    <textarea class="form-control" name="nota_anulacion" id="nota_anulacion"></textarea><br>
                                </div>
                        
                                <div class="col-lg-12 col-md-12" style="font-size:18px;text-align:left;margin-top:0px;">
                                    # Documento    
                                    <input type="text" class="form-control has-success input_devolucion" autocomplete="off" name="input_devolucion" id="input_devolucion" value="" style="font-size:16px;"><br>
                                </div>
                        
                                <div class="col-lg-12 col-md-12" style="font-size:18px;text-align:left;margin-top:0px;">
                                    Nombre Cliente
                                    <input type="text" class="form-control has-success" autocomplete="off" name="input_devolucion_nombre" id="input_devolucion_nombre" value="" style="font-size:16px;"><br>
                                </div>
                        
                                <div class="col-lg-12 col-md-12" style="font-size:18px;text-align:left;margin-top:0px;">
                                    DUI Cliente    
                                    <input type="text" class="form-control has-success" autocomplete="off" name="input_devolucion_dui" id="input_devolucion_dui" value="" style="font-size:16px;"><br>
                                </div>
                        
                                <div class="col-lg-12 col-md-12" style="font-size:18px;text-align:left;margin-top:0px;">
                                    NIT Cliente    
                                    <input type="text" class="form-control has-success" autocomplete="off" name="input_devolucion_nit" id="input_devolucion_nit" value="" style="font-size:16px;"><br>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success input_devolucion_btn" style="float:left;" name="5">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Small-->

    <?php $this->load->view('scripts_files.php'); ?>