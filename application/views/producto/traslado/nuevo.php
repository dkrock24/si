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

    

    $(document).ready(function() {

        $("#persona_modal").appendTo("body");

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
                url: "../../admin/empleado/get_persona",
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
  
            $("#firma_llegada").val(id);
            $("#firma_llegada").val(name);
    
               
        });

    });
</script>

<script src="<?php echo base_url(); ?>../asstes/general.js"></script>

<?php
include("asstes/traslados_funciones.php");
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
<!-- Main section-->
<section>
    <!-- Page content-->


    <div class="row">
        <div class="col-lg-12 col-md-12">
            <!-- Team Panel-->
            <div class="">

                <!-- START panel-->
                <form name="encabezado_form" id="encabezado_form" method="post" action="">

                    <div id="panelDemo1" class="panel" style="margin-top: 60px;">

                        <a href="index" style="top: 0px;position: relative; text-decoration: none; float: left;">
                            <button type="button" class="mb-sm btn btn-pill-right btn-primary btn-outline"> Lista Traslados </button>
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
                                                    <label><i class="fa fa-clock-o sz"></i> Fecha Salida</label>
                                                    <input type="date" name="fecha_salida" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label><i class="fa fa-clock-o sz"></i> Fecha Llegada</label>
                                                    <input type="date" name="fecha_llegada" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label><i class="fa fa-user sz"></i> Envia :</label>
                                                    <select class="form-control" name="firma_salida" id="firma_salida">
                                                        <?php

                                                        foreach ($empleado as $emp) {

                                                        ?>
                                                            <option value="<?php echo $emp->id_persona; ?>"><?php echo $emp->primer_nombre_persona; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label><i class="fa fa-user sz"></i> Recibe :</label>
                                                    <input type="text" class="form-control" name="firma_llegada" id="firma_llegada"/>
                                         
                                                </div>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label><i class="fa fa-building sz"></i> Sucursal Destino</label>
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

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label><i class="fa fa-home sz"></i> Bodega Destino</label>
                                                    <select class="form-control" name="bodega" id="bodega_select">
                                                        <?php

                                                        if (isset($bodega[0]->nombre_bodega)) {

                                                            foreach ($bodega as $b) {

                                                                if ($b->Sucursal == $id_sucursal) {

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
                                                    <label><i class="fa fa-building sz"></i> Sucursal Origin</label>
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
                                                <div class="form-group has-success">
                                                    <label><i class="fa fa-home sz"></i> Bodega Origin</label>
                                                    <select class="form-control" name="bodega" id="bodega_select">
                                                        <?php

                                                        if (isset($bodega[0]->nombre_bodega)) {

                                                            foreach ($bodega as $b) {

                                                                if ($b->Sucursal == $id_sucursal) {

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

                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label><i class="fa fa-comment sz"></i> Comentarios</label>
                                                    <input type="text" name="descripcion_tras" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label><i class="fa fa-truck sz"></i> Placa Transporte</label>
                                                    <input type="text" name="transporte_placa" class="form-control">
                                                </div>
                                            </div>

                                            <div class="btn-group col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Estado</label>
                                                    <select name="estado_tras" id="estado_tras" class="form-control">
                                                        <option value="1">Creado</option>
                                                        <option value="2">Enviado</option>
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
                    <div class="col-md-12">
                        <table class="table table-sm table-hover">

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

                                    <button type="button" class="btn btn-labeled bg-green" style="font-size: 25px;" name="save_traslado" id="guardar_orden"><i class='fa fa-save'></i> </button>
                                    <span class="btn bg-green" id="btn_existencias" data-toggle='modal' style="font-size: 18px;" data-target='#existencias'><i class="fa fa-dropbox"></i> <span style="font-size:18;">[ F8 ]</span></span>

                                </div>
                            </div>

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
                                    <tbody class="uno bg-gray-light" style="border-bottom: 0px solid grey">
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
                                    </tbody>
                                </div>

                            </div>
                        </table>

                        <div class="lista_productos" style="height:100px;">
                            <table class="table table-sm table-hover" id="lista_productos">
                                <tbody class="producto_agregados" style="border-top:  0px solid black" id="prod_list">
                                </tbody>
                            </table>
                        </div>

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