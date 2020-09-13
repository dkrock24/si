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
    .mover_right{
	    float:right;
	    display: inline;
    }
    .panel-body {
        padding: 0px;
    }
</style>

<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-success"> Lista Ventas</button></a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Ver</button>
        </h3>

        <div class="row menu_title_bar">
            <div class="col-md-7">

                <!-- Aside panel-->
                <div class="panel-body linea_superior">
                    <p>
                        <h3>
                            <i class="fa fa-cart-arrow-down sz2"></i>
                            Venta Información : <span class="label label-default" style="color:black"># <strong><?php echo $encabezado[0]->num_correlativo; ?></strong></span>
                            <?php $date = date_create($encabezado[0]->fecha);  ?>
                            <span class="label label-default 2x-lg mover_right" style="color:black"><?php echo date_format($date, "m/d/Y"). " |"; ?> <span class="label label-success 2x-lg mover_right"> <?php echo date_format($date, "H:i a"); ?></span></span>
                        </h3>
                    </p>
                </div>

                <table id="" class="table table-striped borders">
                    <thead class="menuContent">
                        <tr>
                            <th>Sucursal</th>
                            <th>Caja</th>
                            <th>Documento</th>
                            <th>Pago</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span class=""><strong><?php echo $encabezado[0]->nombre_sucursal; ?></strong></span>
                            </td>
                            <td>
                                <span class=""><strong># <?php echo $encabezado[0]->num_caja; ?></strong></span>
                            </td>
                            <td>
                                <span><strong><?php echo $encabezado[0]->tipo_documento; ?></strong></span>
                            </td>
                            <td>
                                <span><strong><?php echo $encabezado[0]->nombre_modo_pago; ?></strong></span>
                            </td>
                            <td>
                                <span><strong><?php echo $encabezado[0]->nombre_empresa_o_compania; ?></strong></span>
                            </td>
                            <td>
                                <span><strong><?php echo $encabezado[0]->nombre_usuario; ?></strong></span>
                            </td>
                            <td>
                                <span><strong><?php echo $encabezado[0]->orden_estado_nombre; ?></strong></span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="panel-body linea_superior">
                    <p>
                        <h3><i class="fa fa-refresh"></i> Anulado Información : <?php //echo $venta[0]->fecha ?></h3>
                    </p>
                </div>

                <table id="" class="table table-striped borders">
                    <thead class="menuContent">
                        <tr>
                            <th>Anulado</th>
                            <th>Anulado por</th>
                            <th>Anulado en</th>
                            <th>Anulado comentario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class=""> 
                                <?php if($encabezado[0]->anulado){ ?>
                                <span class="label label-danger"><strong>Si</strong></span>
                                <?php }else{
                                    ?>
                                    <span class="label label-danger"><strong>No</strong></span>
                                    <?php
                                } ?>
                            </td>

                            <td class="">
                                <h4 class="data-right">
                                <?php if($encabezado[0]->anulado_el){ ?>
                                <span class="label label-danger"><strong><?php echo $encabezado[0]->anulado_el; ?></strong></span>
                                <?php } ?>
                                </h4>
                            </td>

                            <td class=""> 
                                <h4 class="data-right">
                                    <?php if($encabezado[0]->anulado_nombre){ ?>
                                    <span class="label label-danger"><strong><?php echo $encabezado[0]->anulado_nombre; ?></strong></span>
                                    <?php } ?>
                                </h4>
                            </td>

                            <td class="">
                                <h4 class="data-right">
                                <?php if($encabezado[0]->anulado_conc){ ?>
                                <span class="label label-danger"><strong><?php echo $encabezado[0]->anulado_conc; ?></strong></span>
                                <?php } ?>
                                </h4>
                            </td>                            
                        </tr>

                    </tbody>
                </table>
                <!-- end Aside panel-->
            </div>

            <div class="col-md-5">
                <div class="panel-body linea_superior">
                    <p>
                        <h3><i class="fa fa-money"></i> Pago Información: <?php //echo $venta[0]->fecha ?>
                        <a href="#" class="mover_right">
                            <i class="fa fa-print" data-toggle='modal' data-target='#imprimir' ></i>
                        </a>
                        </h3>
                    </p>                    
                </div>
                <table id="" class="table table-striped borders">

                    <thead class="menuContent">
                        <tr>
                            <th>#</th>
                            <th>Metodo Pago</th>
                            <th>Valor</th>
                            <th>Banco</th>
                            <th>Número</th>
                            <th>Serie</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $cnt = 1;
                        $total_pago = 0.00;
                        foreach ($modo_pago as $key => $value) {
                        ?>
                            <tr>
                                <td><?php echo $cnt ?></td>
                                <td><?php echo $value->nombre_metodo_pago ?></td>
                                <td><?php echo $moneda[0]->moneda_simbolo . " " . $value->valor_metodo_pago ?></td>
                                <td><?php echo $value->banco_metodo_pago ?></td>
                                <td><?php echo $value->numero_metodo_pago ?></td>
                                <td><?php echo $value->series_metodo_pago ?></td>
                                <td><?php if ($value->estado_venta_pago == 1) {
                                        echo "Cancelado";
                                    } else {
                                        echo "Pendiente";
                                    }   ?>
                                </td>
                            </tr>
                        <?php
                            $total_pago += $value->valor_metodo_pago;
                            $cnt++;
                        }
                        ?>
                        <tr style="border-top:2px solid black;">
                            <td><?php //echo $cnt ?></td>
                            <td>TOTAL</td>
                            <td><?php echo $moneda[0]->moneda_simbolo .' '.$total_pago ?></td>
                            <td colspan="4"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="panel-body linea_superior">
                    <p>
                        <h3><i class="fa fa-refresh"></i> Devolución Información: <?php //echo $venta[0]->fecha ?></h3>
                    </p>
                </div>
                <table id="" class="table table-striped borders">

                    <thead class="menuContent">
                        <tr>
                            <th>Devolución</th>
                            <th>Nombre</th>
                            <th>DUI</th>
                            <th>NIT</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($encabezado[0]->devolucion_nombre!=""): ?>
                        <tr>
                            <td>
                                    <?php if($encabezado[0]->devolucion_documento){ ?>
                                    <span><strong># <?php echo $encabezado[0]->devolucion_documento; ?></strong></span>
                                    <?php } ?>
                            </td>
                            <td><?php echo $encabezado[0]->devolucion_nombre ?>  </td>
                            <td><?php echo $encabezado[0]->devolucion_dui ?>     </td>
                            <td><?php echo $encabezado[0]->devolucion_nit ?>     </td>
                                <?php $date = date_create($encabezado[0]->modi_el);  ?>
                            <td><?php echo date_format($date, "m/d/Y") ?>        </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="panel-body linea_superior">
                    <p>
                        <h3><i class="fa fa-shopping-cart"></i> Productos Información :</h3>
                    </p>
                </div>

                <div class="table-responsive" style="overflow: auto; position: relative;">
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
                            $cnt        = 1;
                            $gen        = "";
                            $totalVenta =0.00;
                            $cantidad   =0.00;
                            $descuento  =0.00;
                            $monedaSimbolo = $moneda[0]->moneda_simbolo;
                            foreach ($detalle as $key => $venta) {
                                $total      = number_format($venta->total,2);
                                $descuento  = number_format($encabezado[0]->desc_val,2);
                                $cantidad   = number_format($venta->cantidad,1);
                                $precioVenta= number_format($venta->precio_venta,2);
                                $neto = number_format($total - $descuento,2);
                            ?>
                                <tr>
                                    <td><?php echo $cnt ?></td>
                                    <td><?php echo $venta->codigo_producto ?></td>
                                    <td><?php echo $venta->name_entidad ?></td>
                                    <td><?php echo $venta->descripcion ?></td>
                                    <td><?php echo $venta->modelo ?></td>
                                    <td><?php echo $venta->nombre_bodega ?></td>
                                    <td><?php echo $venta->presentacion ?></td>
                                    <td><?php echo $monedaSimbolo . " " . $precioVenta ?></td>
                                    <td><?php echo $venta->factor ?></td>
                                    <td><?php echo $cantidad ?></td>
                                    <td><?php echo $monedaSimbolo . " " . $descuento ?></td>
                                    <td><?php echo $monedaSimbolo . " " . $neto ?>
                                        <?php echo substr($venta->gen,0,1); ?>
                                    </td>
                                    <td>
                                        <?php if($venta->incluye_iva == 0): ?>
                                            <?php echo "No"; ?>
                                        <?php else: ?>
                                            <?php echo "Si"; ?>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php
                                $cnt++;
                                $cantidad   += $venta->cantidad;
                                $descuento  += $descuento;
                                $totalVenta += $neto;
                            }
                            ?>
                            <?php
                            foreach ($impuestos as $key => $impuestos) {
                                ?>
                                <tr style="border-top:0px solid black;">
                                    <td colspan="10"><?php //echo $cnt ?></td>                                    
                                    <td><b> <?php echo $impuestos->ordenImpName; ?></b></td>
                                    <td>    <?php echo $monedaSimbolo ." ". number_format($impuestos->ordenImpTotal,2).' ('.$impuestos->ordenImpVal.')'; ?></td>
                                    <td>    <?php echo $impuestos->ordenSimbolo ? $impuestos->ordenSimbolo : ""; ?></td>
                                </tr>
                                <?php
                                if ($impuestos->ordenImpName != "IVA") {
                                    $total += number_format($impuestos->ordenImpTotal,2);
                                }
                            }
                            ?>
                            <tr style="border-top:2px solid grey;">
                                <td colspan="8"><?php //echo $cnt ?></td>
                                <td><h3>Total</h3></td>
                                <td><h3><?php echo number_format($cantidad,2); ?></h3></td>
                                <td><h3><?php echo $monedaSimbolo . " " . number_format($descuento,2); ?></h3></td>
                                <td><h3><?php echo $monedaSimbolo . " " . number_format($totalVenta,2); ?></h3></td>
                                <td></td>
                            </tr>
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