<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#imprimir').appendTo("body");
    });
</script>

<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-success"> Lista Traslados</button></a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Detalle</button>
        </h3>

        <form action="../aceptar" name="aceptar" method="post">

            <div class="row menu_title_bar">
                <div class="col-md-8">

                    <!-- Aside panel-->

                    <div class="panel-body linea_superior">
                        <p>
                            <h3>
                                <i class="fa fa-file-text-o"></i>
                                TRASLADO : <?php $date = date_create($traslado[0]->creado_tras);  ?>
                                <span class="label label-default 2x-lg" style="color:black"><?php echo date_format($date, "m/d/Y H:i a"); ?></span>
                                <a href="#" class="">
                                    <i class="fa fa-print" data-toggle='modal' data-target='#imprimir'>
                                    </i>
                                </a>
                            </h3>
                        </p>

                    </div>
                    <table class="table table-striped">


                        <tbody class="menuContent">

                            <tr>
                                <td>FECHA SALIDA</td>
                                <td><?php $date = date_create($traslado[0]->fecha_salida);  ?>
                                    <strong><?php echo date_format($date, "m/d/Y H:i a");  ?></strong>
                                </td>
                                <td>FECHA LLEGADA</td><?php $date = date_create($traslado[0]->fecha_llegada);  ?>
                                <td> <strong><?php echo date_format($date, "m/d/Y H:i a"); ?></strong></td>
                            </tr>

                            <tr>
                                <td>ENVIADO POR</td>
                                <td>
                                    <strong><?php echo $traslado[0]->envia; ?></strong>
                                </td>
                                
                                <td>SUCURSAL ENVIA</td>
                                <td> <strong><?php echo $traslado[0]->nombre_sucursal ?></strong></td>


                            </tr>
                            <tr>
                                
                                <td>RECIBIDO POR</td>
                                <td>
                                    <strong><?php echo $traslado[0]->recibe; ?></strong>
                                </td>
                                <td>SUCURSAL RECIBE</td>
                                <td> <strong><?php echo $traslado[0]->nombre_sucursal_destino
                                                ?></strong></td>
                            
                            </tr>

                            <tr>

                            <td>TRANSPORTE</td>
                                <td> <strong><?php echo $traslado[0]->transporte_placa ?></strong></td>
                                <td>ESTADO</td>
                                <td>
                                    <strong>
                                        <?php
                                        if ($traslado[0]->estado_tras == 1) {
                                        ?>
                                            ENVIADO
                                        <?php

                                        } else {
                                        ?>
                                            PROCESADO                                       
                                        <?php
                                        }
                                        ?>
                                    </strong>
                                </td>
                                
                            </tr>

                        </tbody>
                    </table>
                    <!-- end Aside panel-->
                </div>

                <div class="col-md-4">
                    <div class="panel-body linea_superior">
                        <p>
                            <h3><i class="fa fa-arrow-up"></i> ACEPTAR TRASLADO : </h3>
                        </p>
                    </div>
                    <table id="" class="table table-striped">

                        <tbody class="menuContent">
                            <tr>
                                <td>
                                    <?php
                                        if($traslado[0]->estado_tras == 8 ){ // 8 Estado Creado
                                            ?>
                                            <input type="submit" class="btn btn-info" value="ACEPTAR">
                                            <?php
                                        }else{
                                            ?>
                                            <h2><label class="label label-success">Traslado Completado!</label></h2>
                                            <?php
                                        }
                                    ?>                                    
                                </td>
                                <td></td>
                            </tr>
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
                                    <th>Descripción</th>
                                    <th>Modelo</th>
                                    <th>Bodega Origen</th>
                                    <th>Bodega Destino</th>
                                    <th>Presentación</th>
                                    <th>Precio</th>
                                    <th>Factor</th>
                                    <th>Cant.Envia</th>
                                    <th>Cant.Recibe</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 1;
                                foreach ($detalle as $key => $value) {
                                ?>
                                    <tr>
                                        <td><?= $cnt ?></td>
                                        <td><?= $value->codigo_producto ?></td>
                                        <td><?= $value->name_entidad ?></td>
                                        <td><?= $value->descripcion_producto ?></td>
                                        <td><?= $value->modelo ?></td>
                                        <td><?= $value->nombre_bodega ?></td>
                                        <td><?= $value->bodega_destino_val ?></td>
                                        <td><?= $value->presentacion ?></td>
                                        <td><?= $moneda[0]->moneda_simbolo . " " . number_format($value->precio_venta,2) ?></td>
                                        <td><?= $value->factor ?></td>
                                        <td><?= $value->cantidad_product_tras ?></td>
                                        <td><input type="text" name="<?= $value->id_tras_detalle ?>" value="<?= $value->cantidad_product_tras ?>" class="form-control" /></td>
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

        </form>
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

                        <?php include("asstes/temp/" . $file . ".php"); ?>

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