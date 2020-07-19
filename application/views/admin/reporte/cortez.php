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

<script>
    $(document).ready(function() {

        setTimeout(function() {
            $("#m_orden_creada").modal();
            //$("#imprimir").modal(); 
        }, 1000);

        $(".printer").click(function() {

            $("#m_orden_creada").modal();

        });

        $("#prin").click(function(){
            var id = $(this).attr('name');
            var strWindowFeatures = "location=yes,height=670,width=820,scrollbars=yes,status=yes";
            var URL = "../print_venta/"+id;
            var win = window.open(URL, "_blank", strWindowFeatures);
            //window.open('http://localhost:8080/index.php/producto/traslado/print_traslado/11');
        });

        $("#m_orden_creada").appendTo("body");

        $("#printer").click(function(){

            var printContents = document.getElementById('formato').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

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

    .btn-color{
        background: #129cd6;
    }
    .table > thead > tr > th {
        color:black;
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
                        <i class="fa fa-money sz2"></i> CORTE Z
                        <div class="row btn-process">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <br>
                                    <a href="#" class="btn btn-info btn-color" onclick="exportPdf()">
                                        <i class="fa fa-file-pdf-o sz"></i> PDF
                                    </a>
                                    <a href="export2" class="btn btn-info btn-color">
                                        <i class="fa fa-file-excel-o h sz"></i> XLS
                                    </a>
                                </div>
                            </div>
                        </div><br><br>
                    </div>
                    <div class="menuContent">
                        <form class="form-horizontal" name="reporte_ventas" action='cortez' method="post">
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
                                                    <button type="submit" class="btn btn-info btn-color">
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
                                                <thead class="header_report">
                                                    <tr>
                                                        <th style="color:#fff">#</th>
                                                        <th style="color:#fff">Documento</th>
                                                        <th style="color:#fff">Cantidad</th>
                                                        <th style="color:#fff"># Inical</th>
                                                        <th style="color:#fff"># Final</th>
                                                        <th style="color:#fff">C. Devolución</th>
                                                        <th style="color:#fff">Σ Devolución</th>
                                                        <th style="color:#fff">Descuento</th>
                                                        <th style="color:#fff">Monto</th>
                                                        <th style="color:#fff">Apli</th>
                                                        <th style="color:#fff">Σ Efectivo</th>
                                                        <th style="color:#fff">Σ TCredito</th>
                                                        <th style="color:#fff">Σ Cheque</th>
                                                        <th style="color:#fff">Credito</th>                                          
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                //$date=date_create("2013-03-15");
                                                //echo date_format($date,"Y/m/d H:i:s");
                                                $cnt = 1;
                                                $total_devolucion       =0;
                                                $suma_devolucion        =0.00;
                                                $cantidad_devolucion    =0.00;
                                                $suma_descuento         =0.00;
                                                $suma_efectivo          =0.00;
                                                $suma_tcredito          =0.00;
                                                $suma_cheque            =0.00;
                                                $suma_credito           =0.00;

                                                foreach ($registros as $key => $value) {
                                                ?>
                                                    <tr>
                                                        <th><?= $cnt++; ?></th>                                                            
                                                        <td><?= $value->nombre ?></td>
                                                        <td><?= $value->cantidad_documentos ?></td>
                                                        <td><?= $value->inicio ?></td>
                                                        <td><?= $value->fin ?></td>
                                                        <td><?= $value->total_devolucion ?></td>
                                                        <td><?= $moneda . number_format($value->sum_devolucion,2) ?></td>
                                                        <td><?= $moneda . number_format($value->descuento,2) ?></td>
                                                        <td><?= $moneda . $value->descuento ?></td>
                                                        <td><?= $moneda . $value->descuento ?></td>
                                                        <td><?= $moneda . number_format($value->efectivo, 2) ?></td>
                                                        <td><?= $moneda . number_format($value->tcredito, 2) ?></td>
                                                        <td><?= $moneda . number_format($value->cheque, 2) ?></td>
                                                        <td><?= $moneda . number_format($value->credito, 2) ?></td>
                                                    </tr>
                                                <?php

                                                $cantidad_devolucion    += $value->total_devolucion;
                                                $total_devolucion       += $value->total_devolucion;
                                                $suma_devolucion        += number_format($value->sum_devolucion,2) * (-1);
                                                $suma_descuento         += number_format($value->descuento,2);
                                                $suma_efectivo          += $value->efectivo;
                                                $suma_tcredito          += number_format($value->tcredito,2);
                                                $suma_cheque            += number_format($value->cheque,2);
                                                $suma_credito           += number_format($value->cheque,2);
                                                }
                                                ?>
                                                <thead class="header_report">
                                                    <tr class="">
                                                        <th style="color:#fff"></th>                                                        
                                                        <th style="color:#fff">TOTALES</th>
                                                        <th style="color:#fff"></th>
                                                        <th style="color:#fff"></th>
                                                        <th style="color:#fff"></th>
                                                        <th style="color:#fff"><?= $total_devolucion; ?></th>
                                                        <th style="color:#fff"><?= $moneda ." ". $suma_devolucion ?></th>
                                                        <th style="color:#fff"><?= $moneda ." ". $suma_descuento ?></th>
                                                        <th style="color:#fff">N/A</th>
                                                        <th style="color:#fff">Apli</th>
                                                        <th style="color:#fff"><?= $moneda ." ". $suma_efectivo ?></th>
                                                        <th style="color:#fff"><?= $moneda ." ". $suma_tcredito ?></th>
                                                        <th style="color:#fff"><?= $moneda ." ". $suma_cheque ?></th>
                                                        <th style="color:#fff"><?= $moneda ." ". $suma_credito ?></th>
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

<div id="m_orden_creada" tabindex="-1" role="dialog" aria-labelledby="m_orden_creada" class="modal flip">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="background:#f1f1f1;">
            <div class="modal-header" style="background: #2c71b5;color: white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; ">Documento : <?= $temp[0]->documento_nombre ?> | Formato : <?= $temp[0]->factura_nombre ?> </span>

            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <?php include("asstes/temp/" . $file . ".php"); ?>
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
                            <?php
                                $vista_id  = $orden[0]->venta_vista_id;
                                $vista_url = "../../orden/venta_rapida";

                                if($vista_id == 13 ){
                                    $vista_url = "../../orden/nuevo";
                                }else if($vista_id == 38){
                                    $vista_url = "../../orden/venta_rapida";
                                }
                            ?>

                                <a href="<?= $vista_url; ?>" class="btn btn-default printer">
                                    <h3> <i class="icon-plus"></i> Nueva </h3>
                                </a>
                                <a href="#" id="prin" name="<?= $orden[0]->id ?>" class="btn btn-success" style="color:black">
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