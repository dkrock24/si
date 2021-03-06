<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    var headers = <?php echo json_encode($fields['field']); ?>;
    var records = <?php echo json_encode($registros); ?>

    var documento_titulo = <?php echo json_encode($fields['titulo']); ?>;

    $(document).ready(function() {
        $("#sucursal").change(function(){
            var sucursal = $(this).val();
            $.ajax({
                url: "change_caja/"+sucursal,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    $("#caja").empty();
                    var datos   = JSON.parse(data);
                    var caja    = datos["caja"];
                    var _htmlCaja = "";
                    $.each(caja, function(i, item) {
                        _htmlCaja += '<option value="' + item.id_caja + '">' + item.nombre_caja + ' ' + item.codigo + '</option>';
                    });
                    _htmlCaja += '<option value=0>' + ' - ' +'</option>';

                    $("#caja").html(_htmlCaja);

                },
                error: function() {}
            });
        });        
    });
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
    .btn-process{
        display:inline-block;
        float: right;
    }
    .header_report{
        background: #2D3B48; 
    }
    .header_report > tr > th {
        text-align:right;
    }
    .filters_report{
        background: #fff;
    }

    .btn-color{
        background: #4974a7;
        color:white;
    }
    .table > thead > tr > th {
        color:black;
    }

    .text-right{
        text-align:right;
    }
</style>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-success"> Generar Reporte</button>
            </a>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">
                        <i class="fa fa-cart-arrow-down sz2"></i> VENTAS CONCENTRADAS
                        <div class="row btn-process">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <br>
                                    <a href="#" class="btn btn-danger btn-color sz" onclick="exportPdf()">
                                        <i class="fa fa-file-pdf-o sz"></i> PDF
                                    </a>
                                    <a href="export2" class="btn btn-danger btn-color sz">
                                        <i class="fa fa-file-excel-o h sz"></i> XLS
                                    </a>
                                </div>
                            </div>
                        </div><br><br>
                    </div>
                    <div class="menuContent">
                        <form class="form-horizontal" name="reporte_ventas" action='concentrado' method="post">
                            <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                            <div class="b">
                                <div class="panel-body">
                                    <div class="row filters_report">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""> <i class="fa fa-clock-o sz2"></i> Fecha Inicio</label>
                                                    <input type="date" class="form-control" id="fecha_i" name="fecha_i" value="<?php echo $filters['fh_inicio']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-clock-o sz2"></i> Fecha Fin</label>
                                                    <input type="date" class="form-control" id="fecha_f" name="fecha_f" value="<?php echo $filters['fh_fin']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-home sz2"></i> Sucursal</label>
                                                    <select name="sucursal" id="sucursal" class="form-control">
                                                        <?php
                                                        if ($filters['sucursal']) {
                                                            foreach ($sucursal as $key => $value) {
                                                                if ($filters['sucursal'] == $value->id_sucursal) {
                                                        ?>
                                                                    <option value="<?= $value->id_sucursal ?>"><?= $value->nombre_sucursal ?></option>
                                                                    <option value="0">-</option>
                                                            <?php
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                            <option value="0">-</option>
                                                            <?php
                                                        }
                                                        foreach ($sucursal as $key => $value) {
                                                            if ($filters['sucursal'] != $value->id_sucursal) {
                                                            ?>
                                                                <option value="<?= $value->id_sucursal ?>"><?= $value->nombre_sucursal ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-desktop sz2"></i> Caja</label>
                                                    <select name="caja" id="caja" class="form-control">
                                                        <option value="0"> - </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-user-o sz2"></i> Cajero</label>
                                                    <select name="cajero" class="form-control">
                                                        <?php
                                                        if ($filters['cajero']) {
                                                            foreach ($cajero as $key => $value) {
                                                                if ($filters['cajero'] == $value->id_empleado) {
                                                                ?>
                                                                    <option value="<?= $value->id_empleado ?>"><?= $value->primer_apellido_persona . " " . $value->primer_nombre_persona ?></option>
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <option value="0"> - </option>
                                                        <?php

                                                        if($cajero) {
                                                        foreach ($cajero as $key => $value) {
                                                            if ($filters['cajero'] != $value->id_empleado) {
                                                        ?>
                                                            <option value="<?= $value->id_empleado ?>"><?= $value->primer_apellido_persona . " " . $value->primer_nombre_persona ?></option>
                                                        <?php
                                                            }
                                                        }
                                                    }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-edit sz2"></i> Turno</label>
                                                    <select name="turno" class="form-control">
                                                        <?php
                                                        if ($filters['turno']) {

                                                            foreach ($turno as $key => $value) {
                                                                if ($filters['turno'] == $value->id_turno) {
                                                        ?>
                                                                    <option value="<?= $value->id_turno ?>"><?= $value->nombre_turno ?></option>
                                                                    <option value="0">-</option>
                                                            <?php
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                            <option value="0">-</option>
                                                            <?php
                                                        }

                                                        foreach ($turno as $key => $value) {
                                                            if ($filters['turno'] != $value->id_turno) {
                                                            ?>
                                                                <option value="<?= $value->id_turno ?>"><?= $value->nombre_turno ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <br>
                                                    <button type="submit" class="btn btn-primary btn-color sz">
                                                        <i class="fa fa-search sz icon-white"></i> FILTRAR
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php

                                        if (isset($registros) && $registros != 1) {
                                        ?>
                                            <table id="tablePreview" class="table table-striped table-hover table-sm table-borderless">
                                                <thead class="header_report text-right">
                                                    <tr>
                                                        <th style="color:#fff">#</th>
                                                        <th style="color:#fff">Documento</th>
                                                        <th style="color:#fff">Inical</th>
                                                        <th style="color:#fff">Final</th>
                                                        <th style="color:#fff">Devolución</th>
                                                        <th style="color:#fff">Σ</th>
                                                        <th style="color:#fff">Anuado</th>
                                                        <th style="color:#fff">Σ</th>
                                                        <th style="color:#fff">Descuento</th>
                                                        <th style="color:#fff">Monto</th>
                                                        <th style="color:#fff">Apli</th>
                                                        <th style="color:#fff">Efectivo</th>
                                                        <th style="color:#fff">TCredito</th>
                                                        <th style="color:#fff">Cheque</th>
                                                        <th style="color:#fff">Credito</th>                                          
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                //$date=date_create("2013-03-15");
                                                //echo date_format($date,"Y/m/d H:i:s");
                                                $cnt = 1;
                                                $total_devolucion       =0.00;
                                                $suma_devolucion        =0.00;
                                                $cantidad_devolucion    =0.00;
                                                $suma_descuento         =0.00;
                                                $suma_efectivo          =0.00;
                                                $suma_tcredito          =0.00;
                                                $suma_cheque            =0.00;
                                                $suma_credito           =0.00;
                                                $total_anulado          =0.00;
                                                $suma_anulado           =0.00;

                                                foreach ($registros as $key => $value) {
                                                    $monto = $value->efectivo + $value->tcredito + $value->cheque
                                                ?>
                                                    <tr class="" style="font-size:14px;font-family: monospace;text-align:right;">
                                                        <th><?php echo $cnt++; ?></th>                                                            
                                                        <td style="text-align:left"><?php echo $value->nombre ?></td>
                                                        <td><?php echo $value->inicio ?></td>
                                                        <td><?php echo $value->fin ?></td>
                                                        <td><?php echo $moneda . number_format($value->sum_devolucion,2) ?></td>
                                                        <td><?php echo $value->total_devolucion ?></td>
                                                        <td><?php echo $moneda . number_format($value->sum_anulado,2) ?></td>
                                                        <td><?php echo $value->total_anulado ?></td>
                                                        <td><?php echo $moneda . number_format($value->descuento,2) ?></td>
                                                        <td><?php echo $moneda . $monto ?></td>
                                                        <td><?php echo $moneda . $value->descuento ?></td>
                                                        <td><?php echo $moneda . number_format($value->efectivo, 2) ?></td>
                                                        <td><?php echo $moneda . number_format($value->tcredito, 2) ?></td>
                                                        <td><?php echo $moneda . number_format($value->cheque, 2) ?></td>
                                                        <td><?php echo $moneda . number_format($value->credito, 2) ?></td>
                                                    </tr>
                                                <?php

                                                $cantidad_devolucion    += $value->total_devolucion;
                                                $total_devolucion       += $value->total_devolucion;
                                                $total_anulado          += $value->total_anulado;
                                                $suma_devolucion        += $value->sum_devolucion;
                                                $suma_anulado           += $value->sum_anulado * (-1);
                                                $suma_descuento         += $value->descuento;
                                                $suma_efectivo          += $value->efectivo;
                                                $suma_tcredito          += number_format($value->tcredito,2);
                                                $suma_cheque            += number_format($value->cheque,2);
                                                $suma_credito           += number_format($value->credito,2);
                                                }
                                                ?>
                                                <thead class="header_report">
                                                    <tr class="" style="font-size:14px;font-family: monospace;">
                                                        <th style="color:#fff"></th>                                                        
                                                        <th style="color:#fff">TOTALES</th>
                                                        <th style="color:#fff"></th>
                                                        <th style="color:#fff"></th>
                                                        <th style="color:#fff"><?php echo $moneda ." ". number_format($suma_devolucion,2); ?></th>
                                                        <th style="color:#fff"><?php echo $total_devolucion ?></th>
                                                        <th style="color:#fff"><?php echo $moneda ." ". number_format($suma_anulado,2); ?></th>
                                                        <th style="color:#fff"><?php echo $total_anulado ?></th>
                                                        <th style="color:#fff"><?php echo  $moneda ." ". number_format($suma_descuento,2) ?></th>
                                                        <th style="color:#fff">N/A</th>
                                                        <th style="color:#fff">Apli</th>
                                                        <th style="color:#fff"><?php echo $moneda ." ". $suma_efectivo ?></th>
                                                        <th style="color:#fff"><?php echo $moneda ." ". $suma_tcredito ?></th>
                                                        <th style="color:#fff"><?php echo $moneda ." ". $suma_cheque ?></th>
                                                        <th style="color:#fff"><?php echo $moneda ." ". $suma_credito ?></th>
                                                    </tr>
                                                 </thead>
                                                </tbody>
                                            </table>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>