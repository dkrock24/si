<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#imprimir').appendTo("body");
    });
</script>

<style>
    .linea-sombra{
        background:#eee;
        font-size:18px;
    }
    .data-right{
        float:right;
        position:relative;
    }
    .line-right{
        border-right:1px solid black;        
    }

    .borders{
        border-left:1px solid grey;
        border-right:1px solid grey;
    }
    .label-primary{
        background:none;
        border:1px solid grey;
        color:black;
    }
</style>

<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista Ventas</button></a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Ver</button>
        </h3>

        <div class="row menu_title_bar">
            <div class="col-md-8">

                <!-- Aside panel-->

                <div class="panel-body ">
                    <p>
                        <h3>
                            <i class="fa fa-cart-arrow-down sz2"></i>
                            Venta Información : <span class="label label-info"><strong><?php echo $encabezado[0]->num_correlativo; ?></strong></span>
                            <?php $date = date_create($encabezado[0]->fecha);  ?>
                            <span class="label label-info 2x-lg"><?php echo date_format($date, "m/d/Y H:i a"); ?></span>
                            <a href="#" class="">
                                <i class="fa fa-print" data-toggle='modal' data-target='#imprimir' >
                                </i>
                            </a>
                        </h3>
                    </p>

                </div>
                <table class="table table-borderless ">
                    <tbody>

                        <tr>
                            <td class="linea-sombra line-right">CLIENTE
                                <h4 class="data-right">
                                <span class="label label-primary"><strong><?php echo $encabezado[0]->nombre_empresa_o_compania; ?></strong></span>
                                </h4>
                            </td>

                            <td class="linea-sombra">SUCURSAL
                                <h4 class="data-right">
                                <span class="label label-primary"><strong><?php echo $encabezado[0]->nombre_sucursal; ?></strong></span>
                                </h4>
                            </td>
                        </tr>

                        <tr>
                            <td class="linea-sombra line-right">DEVOLUCION
                                <h4 class="data-right">
                                    <?php if($encabezado[0]->devolucion_documento){ ?>
                                    <span class="label label-danger"><strong><?php echo $encabezado[0]->devolucion_documento; ?></strong></span>
                                    <?php } ?>
                                </h4>
                            </td>

                            <td class="linea-sombra">CAJA
                                <h4 class="data-right">
                                <span class="label label-danger"><strong><?php echo $encabezado[0]->num_caja; ?></strong></span>
                                </h4>
                            </td>
                        </tr>

                        <tr>
                            <td class="linea-sombra line-right">DOCUMENTO
                                <h4 class="data-right">
                                <span class="label label-primary"><strong><?php echo $encabezado[0]->tipo_documento; ?></strong></span>
                                </h4>
                            </td>
                            <td class="linea-sombra">MODO PAGO
                                <h4 class="data-right">
                                <span class="label label-primary"><strong><?php echo $encabezado[0]->nombre_modo_pago; ?></strong></span>
                                </h4>
                            </td>

                        </tr>

                        <tr>
                            <td class="linea-sombra line-right">ESTADO
                                <h4 class="data-right">
                                <span class="label label-primary"><strong><?php echo $encabezado[0]->orden_estado_nombre; ?></strong></span>
                                </h4>
                            </td>

                            <td class="linea-sombra">USUARIO
                                <h4 class="data-right">
                                <span class="label label-primary"><strong><?php echo $encabezado[0]->nombre_usuario; ?></strong></span>
                                </h4>
                            </td>

                        </tr>

                    </tbody>
                </table>
                <!-- end Aside panel-->
            </div>

            <div class="col-md-4">
                <div class="panel-body linea_superior">
                    <p>
                        <h3><i class="fa fa-money"></i> PAGO : <?php //echo $venta[0]->fecha ?></h3>
                    </p>
                </div>
                <table id="" class="table table-striped borders">

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
                        foreach ($modo_pago as $key => $value) {
                        ?>
                            <tr>
                                <td><?= $cnt ?></td>
                                <td><?= $value->nombre_metodo_pago ?></td>
                                <td><?= $moneda[0]->moneda_simbolo . " " . $value->valor_metodo_pago ?></td>
                                <td><?php if ($value->estado_venta_pago == 1) {
                                        echo "Cancelado";
                                    } else {
                                        echo "Pendiente";
                                    }   ?>
                                </td>
                            </tr>
                        <?php
                            $cnt++;
                        }
                        ?>
                    </tbody>
                </table>

                <div class="panel-body linea_superior">
                    <p>
                        <h3><i class="fa fa-refresh"></i> DATOS DEVOLUCION : <?php //echo $venta[0]->fecha ?></h3>
                    </p>
                </div>
                <table id="" class="table table-striped borders">

                    <thead class="menuContent">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>DUI</th>
                            <th>NIT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><?= $encabezado[0]->devolucion_nombre ?></td>
                            <td><?= $encabezado[0]->devolucion_dui ?></td>
                            <td><?= $encabezado[0]->devolucion_nit ?></td>
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
                    <table id="" class="table table-striped borders">

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
                                <th>Descuento</th>
                                <th>Total</th>
                                <th>Inc.Iva</th>

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
                                    <td><?= $value->descripcion ?></td>
                                    <td><?= $value->modelo ?></td>
                                    <td><?= $value->nombre_bodega ?></td>
                                    <td><?= $value->presentacion ?></td>
                                    <td><?= $moneda[0]->moneda_simbolo . " " . number_format($value->precio_venta,2) ?></td>
                                    <td><?= $value->factor ?></td>
                                    <td><?= number_format($value->cantidad,1) ?></td>
                                    <td><?= $moneda[0]->moneda_simbolo . " " . number_format($encabezado[0]->desc_val,2) ?></td>
                                    <td><?= $moneda[0]->moneda_simbolo . " " . number_format($value->total - $encabezado[0]->desc_val,2) ?></td>
                                    <td><?= $value->incluye_iva ?></td>

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