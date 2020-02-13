<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {


    });
</script>

<style>
    .sz {
        font-size: 20px;
    }

    .sz2 {
        font-size: 30px;
        color: #0f4871;
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

                    <div class="panel-heading menuTop"> <i class="fa fa-cart-arrow-down sz2"></i> VENTAS </div>
                    <div class="panel-body menuContent">

                        <form class="form-horizontal" name="reporte_ventas" action='index' method="post">
                            <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; 
                                                        ?>" name="id_submenu">

                            <div class="panel b">
                                <div class="panel-heading">


                                </div>

                                <div class="panel-body">
                                    <div class="row">

                                        <div class="col-lg-2">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""> <i class="fa fa-clock-o sz"></i> Fecha Inicio</label>
                                                    <input type="date" class="form-control" id="fecha_i" name="fecha_i" value="<?php echo date("Y-m-d"); ?>">

                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-2">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-clock-o sz"></i> Fecha Fin</label>
                                                    <input type="date" class="form-control" id="fecha_f" name="fecha_f" value="<?php echo date("Y-m-d"); ?>">

                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-2">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-user-o sz"></i> Cajero</label>
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

                                        <div class="col-lg-2">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="" class=""><i class="fa fa-edit sz"></i> Turno</label>
                                                    <select name="turno" class="form-control">
                                                        <option value="0"> - </option>
                                                        <?php
                                                        foreach ($turno as $key => $value) {
                                                        ?>
                                                            <option value="<?= $value->id_turno ?>"><?= $value->nombre_turno ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-2">

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

                                        echo date("h:i:s");

                                        if (isset($result)) {
                                        ?>
                                            <table id="tablePreview" class="table table-striped table-hover table-sm table-borderless">

                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Id</th>
                                                        <th>Documento</th>
                                                        <th>Numero</th>
                                                        <th>Fecha</th>
                                                        <th>Id Cliente</th>
                                                        <th>Nombre</th>
                                                        <th>Cond-Pago</th>
                                                        <th>Valor Grabado</th>
                                                        <th>Valor Exento Total</th>
                                                        <th>Estado</th>
                                                        <th>
                                                            <div class="btn-group dropright mb-sm">
                                                                <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-xs" style="background: #dde6e9">Opcion
                                                                    <span class="caret"></span>
                                                                </button>
                                                                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                                                    <li>
                                                                        <a href="">
                                                                            <span class="btn btn-success">
                                                                                <i class="">Hola</i>
                                                                            </span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                //$date=date_create("2013-03-15");
                                                //echo date_format($date,"Y/m/d H:i:s");
                                                $cnt = 1;
                                                foreach ($result as $key => $value) {
                                                ?>
                                                    <tbody>
                                                        <tr>
                                                            <th><?= $cnt++; ?></th>
                                                            <td><?= $value->id ?></td>
                                                            <td><?= $value->nombre ?></td>
                                                            <td><?= $value->num_correlativo ?></td>
                                                            <td><?= $value->fh_inicio ?></td>
                                                            <td><?= $value->id_cliente ?></td>
                                                            <td><?= $value->nombre_empresa_o_compania ?></td>
                                                            <td><?= $value->nombre_metodo_pago ?></td>
                                                            <td><?= number_format($value->total_doc, 2) ?></td>
                                                            <td><?= number_format($value->total_doc, 2) ?></td>
                                                            <td><?= $value->orden_estado_nombre ?></td>
                                                            <td>
                                                                <div class="btn-group dropright mb-sm">
                                                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-xs" style="background: #dde6e9">Opcion
                                                                        <span class="caret"></span>
                                                                    </button>
                                                                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                                                        <li>
                                                                            <a href="">
                                                                                <span class="btn btn-success">
                                                                                    <i class="">Hola</i>
                                                                                </span>
                                                                            </a>
                                                                        </li>

                                                                    </ul>
                                                                </div>
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