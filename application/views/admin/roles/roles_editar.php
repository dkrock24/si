
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-white">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="tools-action" href="#" data-toggle="collapse">
                        <i class="pe-7s-angle-up"></i>
                    </a>
                    <a class="tools-action" href="#" data-toggle="dispose">
                        <i class="pe-7s-close"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-lg-6">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h3 class="panel-title"><a href="../index"><i class="fa fa-arrow-left"></i> Lista Roles</a> / Editar </h3>
                            <div class="panel-tools">
                                <a class="tools-action" href="#" data-toggle="collapse">
                                    <i class="pe-7s-angle-up"></i>
                                </a>
                                <a class="tools-action" href="#" data-toggle="dispose">
                                    <i class="pe-7s-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" action='../update_roles' method="post">
                                <input type="hidden" value="<?php echo $roles[0]->role_id; ?>" name="role_id">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="role" name="role" placeholder="Nombre menu" value="<?php echo $roles[0]->role ?>">
                                        <p class="help-block">Nombre del menu a crear.</p>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Url</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="pagina" name="pagina" placeholder="URL" value="<?php echo $roles[0]->pagina ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <select name="estado_rol" class="form-control">
                                                    <?php 
                                                        if( $roles[0]->estado_rol ==1 ){ 
                                                            ?>
                                                            <option value="1">Activo</option>
                                                            <option value="0">Inactivo</option>
                                                            <?php
                                                        } else{
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
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
    </div>
            </div>
        </div>
    </div>
</div>
