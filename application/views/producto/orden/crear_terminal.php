
<style type="text/css">

</style>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; ">
            <span style="top: -12px;position: relative; text-decoration: none;margin-left:2%;"> Ingresar Información</span>
        </h3>

        <!-- START table-responsive-->
        <div class="row menu_title_bar">
            <div class="col-lg-6">
                <!-- START panel-->
                <div id="panelDemo10" class="panel" style="border:1px solid grey;margin-left:2%;">
                    <form id="crear_terminal" action="nuevo" method="post">
                        <div class="panel-heading menuTop"></div>
                        <div class="panel-body">

                            <div class="col-sm-12 col-md-12">
                                <div class="thumbnail">
                                    <h2 style="text-align:center"><i class="fa fa-desktop"></i></h2>
                                    <div class="caption">
                                        <h3>NOTIFICACION</h3>
                                        <p style="font-size:16px;">
                                            <?php echo $mensaje; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">DISPOSITIVO NOMBRE</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" name="nombre_input" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <br><br>
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">LICENCIA EMPRESA</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" name="licencia_input" value="">
                                    </div>
                                </div>
                            </div>

                            <br>
                        </div>
                        <div class="panel-footer">
                            <input type="submit" name="" class="btn btn-success" value="Registrar">
                        </div>
                    </form>
                </div>
                <!-- END panel-->
            </div>
        </div>
    </div>

</section>