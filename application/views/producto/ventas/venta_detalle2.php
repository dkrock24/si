<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/whirl/dist/whirl.css">

     <!-- DATATABLES-->
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/datatables-colvis/css/dataTables.colVis.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/datatables/media/css/dataTables.bootstrap.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/dataTables.fontAwesome/index.css">
   
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/bootstrap.css" id="bscss">

    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/select2-bootstrap-theme/dist/select2-bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/select2/dist/css/select2.css">
    

    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/app.css" id="maincss">

    <script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
    <script src="<?php echo base_url(); ?>../asstes/js/HoldOn.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/HoldOn.min.css">


    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/whirl/dist/whirl.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/bootstrap.css" id="bscss">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/app.css" id="maincss">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/css/css_general.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/css/modal_style.css">
    


<section style="background:white">
    <!-- Page content-->
    <div class="content-wrapper">


        <div class="row menu_title_bar">
            <div class="col-md-8">

                <!-- Aside panel-->

                <div class="panel-body linea_superior">
                    <p>
                        <h3>
                            <i class="fa fa-file-text-o"></i>
                            VENTA : <?php $date = date_create($venta[0]->fecha);  ?>
                            <span class="label label-info 2x-lg"><?php echo date_format($date, "m/d/Y H:i a"); ?></span>
                            <a href="#" class="">
                                <i class="fa fa-print" data-toggle='modal' data-target='#imprimir' >
                                </i>
                            </a>
                        </h3>
                    </p>

                </div>
                <table class="table table-striped">

                    <thead class="menuContent">
                        <tr>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>

                        </tr>
                    </thead>

                    <tbody>

                        <tr>

                            <td>CLIENTE</td>
                            <td>
                                <strong><?php echo $venta[0]->nombre_empresa_o_compania; ?></strong>
                            </td>


                            <td>SUCURSAL</td>
                            <td> <strong><?php echo $venta[0]->nombre_sucursal ?></strong></td>

                        </tr>

                        <tr>
                            <td>CORRELATIVO</td>
                            <td>
                                <strong><?php echo $venta[0]->num_correlativo; ?></strong>
                            </td>

                            <td>CAJA</td>
                            <td> <strong><?php echo $venta[0]->num_caja ?></strong></td>

                        </tr>

                        <tr>
                            <td>DOCUMENTO</td>
                            <td>
                                <strong><?php echo $venta[0]->tipo_documento; ?></strong>
                            </td>
                            <td>MODO PAGO</td>
                            <td> <strong><?php echo $venta[0]->nombre_modo_pago ?></strong></td>

                        </tr>

                        <tr>
                            <td>ESTADO</td>
                            <td>
                                <strong><?php echo $venta[0]->orden_estado_nombre; ?></strong>
                            </td>
                            <td>USUARIO</td>
                            <td> <strong><?php echo $venta[0]->nombre_usuario ?></strong></td>

                        </tr>

                    </tbody>
                </table>
                <!-- end Aside panel-->
            </div>

            <div class="col-md-4">
                <div class="panel-body linea_superior">
                    <p>
                        <h3><i class="fa fa-money"></i> PAGO : <?php //echo $venta[0]->fecha 
                                                                ?></h3>
                    </p>
                </div>
                <table id="" class="table table-striped">

                    <thead class="menuContent">
                        <tr>
                            <th>#</th>
                            <th>Metodo Pago</th>
                            <th>Valor</th>
                            <th>Estado</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $cnt = 1;
                        foreach ($venta_pagos as $key => $value) {
                        ?>
                            <tr>
                                <td><?php echo $cnt ?></td>
                                <td><?php echo $value->nombre_metodo_pago ?></td>
                                <td><?php echo $moneda[0]->moneda_simbolo . " " . $value->valor_metodo_pago ?></td>
                                <td><?php if ($value->estado_venta_pago == 1) {
                                        echo "Cancelado";
                                    } else {
                                        echo "Pendiente";
                                    }   ?></td>
                            </tr>
                        <?php
                            $cnt++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="panel-body linea_superior">
                    <p>
                        <h4><i class="fa fa-shopping-cart"></i> ARTICULOS </h4>
                    </p>

                </div>

                <div class="table-responsive" style="height: 400px; overflow: auto; position: relative;">
                    <table id="" class="table table-striped">

                        <thead class="menuContent">
                            <tr>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Modelo</th>
                                <th>Bodega</th>
                                <th>Presentacion</th>
                                <th>Precio</th>
                                <th>Factor</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Inc.Iva</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cnt = 1;
                            foreach ($venta_detalle as $key => $value) {
                            ?>
                                <tr>
                                    <td><?php echo $cnt ?></td>
                                    <td><?php echo $value->codigo_producto ?></td>
                                    <td><?php echo $value->name_entidad ?></td>
                                    <td><?php echo $value->descripcion ?></td>
                                    <td><?php echo $value->modelo ?></td>
                                    <td><?php echo $value->nombre_bodega ?></td>
                                    <td><?php echo $value->presentacion ?></td>
                                    <td><?php echo $moneda[0]->moneda_simbolo . " " . $value->precio_venta ?></td>
                                    <td><?php echo $value->factor ?></td>
                                    <td><?php echo $value->cantidad ?></td>
                                    <td><?php echo $moneda[0]->moneda_simbolo . " " . $value->total ?></td>
                                    <td><?php echo $value->incluye_iva ?></td>

                                </tr>
                            <?php
                                $cnt++;
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</section>


<!-- Modal Large PRODUCTOS MODAL-->
<div id="imprimir" tabindex="-1" role="dialog" aria-labelledby="imprimir" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #2c71b5;color: white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="icon-printer"></i> Imprimir
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 vista_ticket">

                    <?php include("asstes/temp/".$file.".php"); ?>

                    </div>
                    <div class="col-lg-8 col-md-8">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->



<script src="<?php echo base_url(); ?>../asstes/vendor/modernizr/modernizr.custom.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/matchMedia/matchMedia.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/bootstrap/dist/js/bootstrap.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/jQuery-Storage-API/jquery.storageapi.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/jquery.easing/js/jquery.easing.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/vendor/animo.js/animo.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/slimScroll/jquery.slimscroll.min.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/vendor/screenfull/dist/screenfull.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/jquery-localize-i18n/dist/jquery.localize.js"></script>



  <script src="<?php echo base_url(); ?>../asstes/vendor/sparkline/index.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/js/demo/demo-rtl.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/js/printer/pdf/jspdf.debug.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/js/printer/pdf/jspdf.plugin.autotable.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/js/printer/print.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/js/printer/xls.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/js/generalAlert.js"></script>



  <!-- =============== PAGE VENDOR SCRIPTS ===============-->
  <!-- DATATABLES-->
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-colvis/js/dataTables.colVis.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables/media/js/dataTables.bootstrap.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/dataTables.buttons.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.bootstrap.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.colVis.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.flash.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.html5.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.print.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-responsive/js/dataTables.responsive.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-responsive/js/responsive.bootstrap.js"></script>

  <!-- =============== APP SCRIPTS ===============-->
  <!--
   <script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/bootstrap/dist/js/bootstrap.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/jquery.easing/js/jquery.easing.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/animo.js/animo.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/slimScroll/jquery.slimscroll.min.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/screenfull/dist/screenfull.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/jquery-localize-i18n/dist/jquery.localize.js"></script>

    -->
  <script src="<?php echo base_url(); ?>../asstes/vendor/sweetalert/dist/sweetalert.min.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/vendor/select2/dist/js/select2.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/js/app.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/js/moment.min.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
        $('#imprimir').appendTo("body");

        $('#imprimir').modal();
    });
</script>