<!DOCTYPE html>
<html lang="en">
<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>../asstes/login/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/css/main.css">
    <!--===============================================================================================-->
    <title><?php echo $nodo[0]->nodo_nombre; ?></title>
</header>

<body class="" style="background:#ebedef;">
    <div class="row" style="height:100%;width:100%;background:red">
        <div class="card" style="height:100%;width:100%;background:#ebedef;">
            <div class="card-body" style="height:100%;width:100%;">
                <div class=" justify-content-between">

                    <div class="commandas" style="position: absolute;display:inline-block; margin-top:10px;width:100%;">
                        <div class="row">
                            <?php
                            foreach ($ordenes as $comanda) {
                            ?>
                                
                                    <div class="card">
                                        <div class="card-body row text-center">
                                            <div class="col">
                                                <div class="text-value-xl"><h4># <?php echo $comanda->id; ?></h4></div>
                                                <div class="text-uppercase text-muted small">ORDEN</div>
                                            </div>
                                            <div class="c-vr"></div>
                                            <div class="col">
                                                <div class="text-value-xl"><h4><?php echo count((array)$comanda->detalle); ?></h4></div>
                                                <div class="text-uppercase text-muted small">Articulos</div>
                                            </div>
                                        </div>
                                        <div class="card-header bg-facebook content-center">
                                            <table class="table">
                                                <?php
                                                foreach ($comanda->detalle as $detalle) {
                                                ?>

                                                    <tr>
                                                        <td><?php echo $detalle->cantidad ?></td>
                                                        <td><?php echo $detalle->descripcion ?></td>
                                                    </tr>

                                                <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>

                                
                                <br>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas class="chart chartjs-render-monitor" id="main-chart" height="300" width="1546" style="display: block; width: 1546px; height: 300px;"></canvas>
                    <div id="main-chart-tooltip" class="c-chartjs-tooltip center" style="opacity: 0; left: 1002.25px; top: 302.554px;">
                        <div class="c-tooltip-header">
                            <div class="c-tooltip-header-item">T</div>
                        </div>
                        <div class="c-tooltip-body">
                            <div class="c-tooltip-body-item"><span class="c-tooltip-body-item-color" style="background-color: rgba(3, 9, 15, 0.1);"></span><span class="c-tooltip-body-item-label">My First dataset</span><span class="c-tooltip-body-item-value">163</span></div>
                            <div class="c-tooltip-body-item"><span class="c-tooltip-body-item-color" style="background-color: transparent;"></span><span class="c-tooltip-body-item-label">My Second dataset</span><span class="c-tooltip-body-item-value">97</span></div>
                            <div class="c-tooltip-body-item"><span class="c-tooltip-body-item-color" style="background-color: transparent;"></span><span class="c-tooltip-body-item-label">My Third dataset</span><span class="c-tooltip-body-item-value">65</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer" style="bottom:0px;position: relative; background:white;">
                <div class="row text-center">
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">Activas</div><h2><strong><?php echo count((array) $ordenes) ?></strong></h2>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">Finalizadas</div><h2><strong><?php echo count((array) $ordenes) ?></strong></h2>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">Promedio</div><h2><strong><?php echo count((array) $ordenes) ?></strong></h2>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">Fecha</div><h2><strong><?php echo date('d-m-Y') ?></strong></h2>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">Hora</div><h2><strong><?php echo date('h:m:i') ?></strong></h2>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<!--===============================================================================================-->
<script src="<?php echo base_url(); ?>../asstes/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->

<!--===============================================================================================-->
<script src="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/js/popper.js"></script>
<script src="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/js/bootstrap.min.js"></script>

</html>