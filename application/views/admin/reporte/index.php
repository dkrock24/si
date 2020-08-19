<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    var headers = <?php echo json_encode($fields['field']); ?>;
    var records = <?php echo json_encode($registros); ?>;
    
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
        background: #707b73;
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
                <button type="button" class="mb-sm btn btn-success"> Generar Reporte</button>
            </a>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">
                        <i class="fa fa-cart-arrow-down sz2"></i> VENTAS GENERALES
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
                        <form class="form-horizontal" name="reporte_ventas" action='index' method="post">
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
                                                        <option value="0"> - </option>
                                                        <?php
                                                        foreach ($cajero as $key => $value) {
                                                        ?>
                                                            <option value="<?= $value->id_empleado ?>"><?= $value->primer_apellido_persona . " " . $value->primer_nombre_persona ?></option>
                                                        <?php
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
                                                    <button type="submit" class="btn btn-info">
                                                        <i class="fa fa-search sz icon-white"></i> Filtrar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">  
                                    <?php $this->load->view('notificaciones/success'); ?>                     
                                        <?php
                                        if (isset($registros) && $registros != 1) {
                                        ?>
                                            <table id="tablePreview" class="table table-striped table-hover table-sm table-borderless">
                                                <thead class="header_report">
                                                    <tr>
                                                        <th style="color:#fff">#</th>
                                                        <th style="color:#fff">Id</th>
                                                        <th style="color:#fff">Sucursal</th>
                                                        <th style="color:#fff">Documento</th>
                                                        <th style="color:#fff">Número</th>
                                                        <th style="color:#fff">Fecha</th>
                                                        <th style="color:#fff">Cliente</th>
                                                        <th style="color:#fff">Cond-Pago</th>
                                                        <th style="color:#fff">C/U</th>
                                                        <th style="color:#fff">Valor Gravado</th>
                                                        <th style="color:#fff">Valor Exento</th>
                                                        <th style="color:#fff">Total</th>
                                                        <th style="color:#fff">Estado</th>
                                                        <th style="color:#fff">Detalle</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                //$date=date_create("2013-03-15");
                                                //echo date_format($date,"Y/m/d H:i:s");
                                                $cnt = 1;
                                                
                                                foreach ($registros as $key => $value) {
                                                    $exento = 0;
                                                    $grabado = 0;
                                                    $grabado = $value->grabado + $value->impuesto;
                                                    $exento  = !$value->p_inc_imp0 ? ($value->exento  + $value->impuesto) : $value->exento;
                                                ?>
                                                <tbody>
                                                    <tr>
                                                        <th><?php echo $cnt++; ?></th>
                                                        <td><?php echo $value->id ?></td>
                                                        <td><?php echo $value->nombre_sucursal ?></td>
                                                        <td><?php echo $value->nombre ?></td>
                                                        <td><?php echo $value->num_correlativo ?></td>
                                                        <td><?php echo $value->fh_inicio ?></td>
                                                        <td><?php echo  $value->id_cliente." ".$value->nombre_empresa_o_compania ?></td>
                                                        <td><?php echo $value->nombre_metodo_pago ?></td>
                                                        <td><?php echo $value->producto_total ?></td>
                                                        <td><?php echo $moneda . number_format($grabado, 2) ?></td>
                                                        <td><?php echo $moneda . number_format($exento, 2) ?></td>
                                                        <td><?php echo $moneda . number_format($grabado+$exento, 2) ?></td>
                                                        <td><?php echo $value->orden_estado_nombre ?></td>
                                                        <td>
                                                            <a href="../../producto/venta/ver/<?php echo  $value->id ?>" target="_blank">
                                                                <span class="btn btn-success btn-sm" style="background:#5d9cec">
                                                                    <i class="fa fa-arrow-right"></i> Detalle
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <?php
                                                }
                                                ?>
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