<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script type="text/javascript">
    var path = "../";

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

    $(document).ready(function() {

        $("#prin").click(function() {
            var id = $(this).attr('name');
            var strWindowFeatures = "location=yes,height=670,width=820,scrollbars=yes,status=yes";
            var URL = "../print_compra/" + id;
            var win = window.open(URL, "_blank", strWindowFeatures);
        });

        $("#persona_modal").appendTo("body");

        $("#printer").click(function() {

            var printContents = document.getElementById('formato').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

        });

        setTimeout(function() {

            //$("#m_orden_creada").modal();


        }, 1000);

        $(document).on('click', '#firma_llegada', function() {
            $('#persona_modal').modal('show');
            accion = $(this).attr("id");
            get_encargado_lista();
        });

        // Seleccionar Persona
        function get_encargado_lista() {

            var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Nombre Completo</th><th>DUI</th><th>NIT</th><th>Telefono</th><th>Action</th>";
            var table_tr = "<tbody id='list'>";
            var contador_precios = 1;

            $.ajax({
                url: path + "../../admin/empleado/get_persona",
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var persona = datos["persona"];

                    $.each(persona, function(i, item) {

                        table_tr += '<tr><td>' + contador_precios + '</td><td>' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '</td><td>' + item.dui + '</td><td>' + item.nit + '</td><td>' + item.cel + '</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_persona" id="' + item.id_persona + '" name="' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '">Agregar</a></td></tr>';
                        contador_precios++;
                    });
                    table += table_tr;
                    table += "</tbody></table>";

                    $(".cliente_lista_datos").html(table);

                },
                error: function() {}
            });
        }

        // Seleccionar Persona
        $(document).on('click', '.seleccionar_persona', function() {
            var id = $(this).attr("id");
            var name = $(this).attr("name");

            $("#recibe_nombre").val(id);
            $("#firma_llegada").val(name);


        });

    });
</script>

<script src="<?php echo base_url(); ?>../asstes/general.js"></script>

<?php
include("asstes/js/compras/pos_funciones.php");
?>
<script src="<?php echo base_url(); ?>../asstes/js/generalAlert.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/pos.css" />

<script language="JavaScript">
    //window.print();
</script>

<style>
    .sz {
        font-size: 20px;
        font-style: bold;
    }

    .sz2 {
        font-size: 30px;
        color: #0f4871;
    }

    .btn-process {
        display: inline-block;
        float: right;
    }

    .header_report {
        background: #eef5be;
    }

    .filters_report {
        background: #fff;
    }
</style>
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
</style>
<!-- Main section-->
<section>
    <!-- Page content-->


    <div class="row">
        <div class="col-lg-12 col-md-12">
            <!-- Team Panel-->
            <div class="">

                <!-- START panel-->
                <form name="encabezado_form" id="encabezado_form" method="post" action="#">

                    <input type="hidden" name="id_compras" value="<?php echo $compra[0]->id_compras; ?>" />

                    <div id="panelDemo1" class="panel" style="margin-top: 60px;">

                        <a href="../index" style="top: 0px;position: relative; text-decoration: none; float: left;">
                            <button type="button" class="mb-sm btn btn-pill-right btn-primary btn-outline"> Lista Compras </button>
                        </a>

                        <span style="text-align: left; font-size: 20px;overflow: hidden;margin-left:20px;">

                        </span>

                        <div class="panel-heading" style="text-align: right; font-size: 20px;">
                            <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right bg-green">
                                <em class="fa fa-minus"></em>
                            </a>
                        </div>

                        <div class="panel-wrapper collapse in">
                            <div class="panel-body"><br>
                                <p>
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Tipo Documento</label>
                                                    <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">
                                                        <?php
                                                        foreach ($vista_doc as $key => $value) {
                                                        ?>
                                                            <option value="<?= $value->id_tipo_documento ?>"><?= $value->nombre ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Sucursal Destino</label>
                                                    <select class="form-control" name="sucursal" id="sucursal_id">
                                                        <?php
                                                        $id_sucursal = 0;

                                                        foreach ($sucursal as $s) {
                                                            $id_sucursal = $s->id_sucursal;
                                                            if ($s->id_sucursal == $compra[0]->Sucursal) {
                                                        ?>
                                                                <option value="<?php echo $s->id_sucursal; ?>"><?php echo $s->nombre_sucursal; ?></option>
                                                            <?php
                                                            }
                                                        }

                                                        foreach ($sucursal as $s) {
                                                            if ($s->id_sucursal != $compra[0]->Sucursal) {
                                                            ?>
                                                                <option value="<?php echo $s->id_sucursal; ?>"><?php echo $s->nombre_sucursal; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Bodega Destino</label>
                                                    <select class="form-control" name="bodega" id="bodega_select">
                                                        <?php

                                                        if (isset($bodega[0]->nombre_bodega)) {
                                                            foreach ($bodega as $b) {
                                                                if ($b->id_bodega == $compra[0]->Bodega) {
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

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Fecha Compra</label>
                                                    <input type="date" name="fecha_compra" value="<?php $date = new DateTime($compra[0]->fecha_compra);
                                                                                                    echo $date->format('Y-m-d'); ?>" class="form-control">

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Proveedor Codigo</label>
                                                    <?php
                                                    if (isset($proveedor[0]->id_proveedor)) {
                                                    ?>
                                                        <input type="text" name="proveedor" class="form-control cliente_codigo" id="cliente_codigo" value="<?php echo $proveedor[0]->id_proveedor ?>">
                                                        <select multiple="" class="form-control cliente_codigo2" id="cliente_codigo2" name="abc"></select>
                                                    <?php
                                                    } else {
                                                        echo "No Hay Cliente";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Proveedor Nombre</label>
                                                    <?php
                                                    if (isset($proveedor[0]->id_proveedor)) {
                                                    ?>
                                                        <input type="text" name="cliente_nombre" class="form-control cliente_nombre" id="cliente_nombre" value="<?php echo $proveedor[0]->empresa_proveedor ?>">
                                                    <?php
                                                    } else {
                                                        echo "No Hay Cliente";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Proveedor NRC</label>
                                                    <?php
                                                    if (isset($proveedor[0]->id_proveedor)) {
                                                    ?>
                                                        <input type="text" name="cliente_direccion" class="form-control direccion_cliente" id="direccion_cliente" value="<?php echo $proveedor[0]->nrc ?>">
                                                    <?php
                                                    } else {
                                                        echo "No Hay Cliente";
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label><i class="fa fa-user sz"></i> Empleado :</label>
                                                    <input type="hidden" class="form-control" name="empleado" id="recibe_nombre" value="<?php echo $empleado[0]->id_empleado ?>" />
                                                    <input type="text" class="form-control" name="empleado2" id="firma_llegada" value="<?php echo $empleado[0]->primer_nombre_persona." ".$empleado[0]->segundo_nombre_persona." ".$empleado[0]->primer_apellido_persona." ".$empleado[0]->segundo_apellido_persona ?>" />

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Forma Pago</label>
                                                    <select class="form-control" id="modo_pago_id" name="modo_pago_id">
                                                        <?php
                                                        if ($modo_pago) {
                                                            foreach ($modo_pago as $value) {
                                                        ?><option value="<?php echo $value->id_modo_pago; ?>"><?php echo $value->nombre_modo_pago; ?></option><?php
                                                                                                                                                            }
                                                                                                                                                        } else {
                                                                                                                                                                ?><option value=""><?php echo "No Hay Pagos"; ?></option><?php
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                            ?>

                                                    </select>
                                                </div>
                                            </div>
                                            

                                        </div>
                                    </div>


                                </p>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END panel-->

                <!-- START table-responsive-->
                <div class="row" style="padding:20px;">
                    <div class="col-md-10">
                        <table class="table table-sm table-hover" style="margin-bottom: 0px;">

                            <?php
                            if ($compra[0]->status_open_close == 1) {
                            ?>
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="input-group m-b">
                                            <span class="input-group-addon bg-green">[ <i class="fa fa-arrow-left"></i> ] <i class="fa fa-search"></i></span>

                                            <input type="text" placeholder="Buscar Producto" autocomplete="off" name="producto_buscar" class="form-control producto_buscar">
                                        </div>

                                        <select multiple="" class="form-control dataSelect" id="dataSelect">

                                        </select>

                                        <select multiple="" class="form-control dataSelect2" id="dataSelect2" style="display: inline-block;">

                                        </select>

                                    </div>
                                    <div class="col-md-6">

                                        <button type="button" class="btn btn-labeled bg-green" style="font-size: 25px;" name="update_compra" id="guardar_orden"><i class='fa fa-save'></i> </button>
                                        <span class="btn bg-green" id="btn_existencias" data-toggle='modal' style="font-size: 18px;" data-target='#existencias'><i class="fa fa-dropbox"></i> <span style="font-size:18;">[ F8 ]</span></span>

                                        <div class="btn-group ">
                                            <button type="button" class="btn bg-green"><i class="fa fa-plus" style="font-size: 25px;"></i></button>
                                            <button type="button" data-toggle="dropdown" class="btn dropdown-toggle bg-green" style="font-size: 17px;">
                                                <span class="caret"></span>
                                                <span class="sr-only">default</span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="#" data-toggle='modal' data-target='#m_orden_creada'><i class="icon-printer"></i> Imprimir</a></li>

                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="row">

                                <div class="col-md-9">
                                    <thead class="bg-info-dark" style="background: #cfdbe2;">
                                        <tr>
                                            <th style="color: black;">#</th>
                                            <th style="color: black;">Producto</th>
                                            <th style="color: black;">Descripción</th>
                                            <th style="color: black;">Cantidad</th>
                                            <th style="color: black;">Presentación</th>
                                            <th style="color: black;">Factor</th>
                                            <th style="color: black;">Precio Unidad</th>

                                            <th style="color: black;">Total</th>
                                            <th style="color: black;">Bodega</th>
                                            <th style="color: black;">

                                            </th>
                                        </tr>
                                    </thead>

                                    <!--
                                        <tr style="border-bottom: 1px dashed grey">
                                            <td colspan="2">
                                                <input type="text" name="producto_buscar" class="form-control border-input" id="producto_buscar" readonly="1" style="width: 100px;">
                                            </td>
                                            <td><input type="text" class="form-control border-input" id="descripcion" name="descripcion" readonly="1"></td>
                                            <td><input type="number" class="form-control border-input" id="cantidad" name="cantidad" size="1px" value="1" min="1" max="1000" style="width: 80px;"></td>
                                            <td><input type="text" class="form-control border-input" id="presentacion" name="presentacion" size="3px" readonly="1"></td>
                                            <td><input type="text" class="form-control border-input" id="factor" name="factor" size="2px" readonly="1" style="width: 50px;"></td>
                                            <td><input type="text" class="form-control border-input" id="precioUnidad" name="precioUnidad" size="2px" readonly="1" style="width: 70px;"></td>

                                            <td><input type="text" class="form-control border-input" id="total" name="total" size="2px" readonly="1"></td>
                                            <td><input type="text" class="form-control border-input" id="bodega" name="bodega" size="5px" readonly="1"></td>
                                            <td><button type="button" id="btn_delete" class="btn btn-labeled bg-green" name="1"><span class='btn-label'><i class='fa fa-trash'></i></span></button></td>

                                        </tr>
                                        -->

                                </div>

                            </div>
                        </table>

                        <div class="lista_productos" style="height:500px;">
                            <table class="table table-sm table-hover" id="lista_productos">
                                <tbody class="producto_agregados" style="border-top:  0px solid black" id="prod_list">
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="col-md-2"><br><br>
                        <div class="row">
                            <div class="col-md-12" style="width: 100%; background: #2D3B48/*#0f4871*/;text-align: center;color: white;">

                                <span style="font-size: 40px;">
                                    <?php echo $moneda[0]->moneda_simbolo; ?> <span class="total_msg">0.00</span>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" style="width: 100%; background: white;">

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
                                        <td style="font-size:14px;"><span class="impuestos_nombre"></span></td>
                                        <td><span class="impuestos_total"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="color:#0f4871"><b>Total</b></td>
                                        <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="total_tabla"></span></td>
                                    </tr>
                                </table>
                            </div>


                        </div><br>
                    </div>



                </div>



                <div class="row" style="border-top: 1px dashed grey;">
                    <div class="col-lg-12 col-md-12">
                        <div class="row" style="font-size: 22px">
                            <div class="col-lg-2 col-md-2" style="color:#0f4871;"><span style="float: left;">Cant </span> <span class="cantidad_tabla"></span></div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 paper_cut1">
                </div>


                <!-- END table-responsive-->


            </div>
            <!-- end Team Panel-->
        </div>
    </div>


</section>


<!-- Modal Large CLIENTES MODAL-->
<div id="persona_modal" tabindex="-1" role="dialog" aria-labelledby="persona_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title">Buscar Persona</h4>
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
<div id="existencias" tabindex="-1" role="dialog" aria-labelledby="existencias" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="input-group m-b">
                    <span class="input-group-addon bg-green"><i class="fa fa-search"></i></span>
                    <input type="text" placeholder="Buscar Exsitencia" name="existencia_buscar" class="form-control existencia_buscar">
                </div>

                <select multiple="" class="form-control 1dataSelect" id="1dataSelect">

                </select>

                <select multiple="" class="form-control 1dataSelect2" style="display: inline-block;">

                </select>

            </div>
            <div class="modal-body">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr style="color: black;">
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

<!-- METODO DE PAGOS MODAL-->
<div id="m_orden_creada" tabindex="-1" role="dialog" aria-labelledby="m_orden_creada" class="modal flip">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="background:#f1f1f1;">
            <div class="modal-header" style="background: #2c71b5;color: white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; ">Documento : <?= $temp[0]->nombre ?> | Formato : <?= $temp[0]->factura_nombre  ?> </span>

            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <?php
                        include("asstes/temp/" . $file . ".php");

                        ?>
                    </div>
                    <div class="col-lg-4 col-md-4" style="border-left:1px dashed black;height:900px;position: relative;float:right;margin:0px;">

                        <div class="row">
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <?php echo $msj_title ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <h1>
                                    <?php echo $msj_orden ?>
                                </h1>
                            </div>
                        </div>
                        <div class="row">
                            <hr style="border-bottom:1px dashed black">
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">

                                <a href="../nuevo" class="btn btn-default printer">
                                    <h3> <i class="icon-plus"></i> Nueva </h3>
                                </a>
                                <a href="#" id="prin" name="<?= $compra[0]->id_compras ?>" class="btn btn-success" style="color:black">
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
<!-- Modal Small-->

<!-- Modal Large CLIENTES MODAL-->
<div id="persona_modal" tabindex="-1" role="dialog" aria-labelledby="persona_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title">Buscar Persona</h4>
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