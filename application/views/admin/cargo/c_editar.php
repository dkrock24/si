<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {});
</script>
<!-- Main section-->
<style type="text/css">
    .preview_producto {
        width: 50%;
    }
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-success"> Cargos</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>

        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">

                    <div class="panel-heading menuTop">Editar Cargo Laboral : <?php //echo $onMenu[0]->nombre_submenu 
                                                                                ?> </div>
                    <div class="panel-body menuContent">
                        <p>
                            <form class="form-horizontal" enctype="multipart/form-data" id="../update" name="cargo" action='../update' method="post">
                                <input type="hidden" value="<?php echo $cargo[0]->id_cargo_laboral; ?>" name="id_cargo_laboral">
                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="panel b">
                                            <div class="panel-heading">
                                                <div class="pull-right">
                                                    <div class="label label-info">Importante</div>
                                                </div>
                                                <h4 class="m0">Editar Cargo</h4>
                                                <small class="text-muted">Editar Cargo Selecionado.</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="cargo_laboral" name="cargo_laboral" placeholder="Nombre" value="<?php echo $cargo[0]->cargo_laboral ?>">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Descripcion</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="descripcion_cargo_laboral" name="descripcion_cargo_laboral" placeholder="Descripcion" value="<?php echo $cargo[0]->descripcion_cargo_laboral ?>">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Salario</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="salario_mensual_cargo_laboral" name="salario_mensual_cargo_laboral" placeholder="Salario" value="<?php echo $cargo[0]->salario_mensual_cargo_laboral ?>">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">

                                                    <label>
                                                        <select name="estado" class="form-control">
                                                            <?php
                                                            if ($cargo[0]->cargo_estado == 1) {
                                                                ?>
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            <?php
                                                            } else {
                                                                ?>
                                                                <option value="0">Inactivo</option>
                                                                <option value="1">Activo</option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="panel-footer text-left">

                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                        <button type="submit" id="btn_save" class="btn btn-info">Guardar</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                </div>


                            </form>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal Large CLIENTES MODAL-->
<div id="persona_modal" tabindex="-1" role="dialog" aria-labelledby="persona_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title">Buscar Persona</h4>
            </div>
            <div class="modal-body">
                <p class="cliente_lista_datos">

                </p>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->


<!-- Modal Large CLIENTES MODAL-->
<div id="error" tabindex="-1" role="dialog" aria-labelledby="error" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info-dark">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title"><i class="fa fa-warning fa-fw"></i> Notificación</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center; font-size: 18px;" class="notificacion_texto"></p>
            </div>
            <div class="modal-footer bg-gray">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->