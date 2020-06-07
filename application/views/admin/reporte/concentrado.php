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

                    var datos   = JSON.parse(data);
                    var caja    = datos["caja"];
                    var _htmlCaja = "";
                    $.each(caja, function(i, item) {
                        _htmlCaja += '<option value="' + item.id_caja + '">' + item.nombre_caja + ' ' + item.cod_interno_caja + '</option>';
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
        background: #eef5be;
    }
    .filters_report{
        background: #fff;
    }
</style>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Generar Reporte</button>
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
                                    <a href="#" class="btn btn-info" onclick="exportPdf()">
                                        <i class="fa fa-file-pdf-o sz"></i> PDF
                                    </a>
                                    <a href="export" class="btn btn-info">
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
                                                    <label for="" class=""> <i class="fa fa-clock-o sz"></i> Fecha Inicio</label>
                                                    <input type="date" class="form-control" id="fecha_i" name="fecha_i" value="<?php echo $filters['fh_inicio']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-clock-o sz"></i> Fecha Fin</label>
                                                    <input type="date" class="form-control" id="fecha_f" name="fecha_f" value="<?php echo $filters['fh_fin']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-home sz"></i> Sucursal</label>
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
                                                    <label for="" class=""><i class="fa fa-desktop sz"></i> Caja</label>
                                                    <select name="caja" id="caja" class="form-control">
                                                        <option value="0"> - </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-user-o sz"></i> Cajero</label>
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

                                                        foreach ($cajero as $key => $value) {
                                                            if ($filters['cajero'] != $value->id_empleado) {
                                                        ?>
                                                            <option value="<?= $value->id_empleado ?>"><?= $value->primer_apellido_persona . " " . $value->primer_nombre_persona ?></option>
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
                                                    <label for="" class=""><i class="fa fa-edit sz"></i> Turno</label>
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
                                                    <button type="submit" class="btn btn-info">
                                                        <i class="fa fa-search sz icon-white"></i> Filtrar
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
                                                <thead class="header_report">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Documento</th>
                                                        <th>N Inical</th>
                                                        <th>N Final</th>
                                                        <th>C. Devolución</th>
                                                        <th>Total Dev</th>
                                                        <th>Desc</th>
                                                        <th>Monto</th>
                                                        <th>Apli</th>
                                                        <th>Efectivo</th>
                                                        <th>Cheque</th>
                                                        <th>T.Credito</th>
                                                        <th>Credito</th>                                          
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                //$date=date_create("2013-03-15");
                                                //echo date_format($date,"Y/m/d H:i:s");
                                                $cnt = 1;
                                                $total_devolucion=0;
                                                $cantidad_devolucion=0;
                                                foreach ($registros as $key => $value) {
                                                ?>
                                                    <tr>
                                                        <th><?= $cnt++; ?></th>                                                            
                                                        <td><?= $value->nombre ?></td>
                                                        <td><?= $value->inicio ?></td>
                                                        <td><?= $value->fin ?></td>
                                                        <td><?= $value->total_devolucion ?></td>
                                                        <td><?= $value->sum_devolucion ?></td>
                                                        <td><?= $value->descuento ?></td>
                                                        <td><?= $value->descuento ?></td>
                                                        <td><?= $value->descuento ?></td>
                                                        <td><?= $moneda . number_format($value->efectivo, 2) ?></td>
                                                        <td><?= $moneda . number_format($value->cheque, 2) ?></td>
                                                        <td><?= $moneda . number_format($value->tcredito, 2) ?></td>
                                                        <td><?= $moneda . number_format($value->credito, 2) ?></td>
                                                    </tr>
                                                <?php
                                                $cantidad_devolucion += $value->total_devolucion;
                                                $total_devolucion += $value->sum_devolucion;
                                                }
                                                ?>
                                                <thead class="header_report">
                                                    <tr class="">
                                                        <th></th>                                                        
                                                        <th>TOTALES</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th><?= $total_devolucion; ?></th>
                                                        <th><?= $total_devolucion ?></th>
                                                        <th>N Dev</th>
                                                        <th>Monto</th>
                                                        <th>Apli</th>
                                                        <th>Efectivo</th>
                                                        <th>Cheque</th>
                                                        <th>T.Credito</th>
                                                        <th>Credito</th>                                            
                                                    </tr>
                                                 </thead>
                                                </tbody>
                                            </table>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                        </div>
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