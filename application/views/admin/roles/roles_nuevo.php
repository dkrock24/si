<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista Roles</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Nuevo</button>
            </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Nuevo Rol</div>
                <!-- START table-responsive-->
                <div class="">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-white">

                                <div class="panel-body">
                                    <div class="col-lg-6">
                                        <div id="" class="panel panel-info">
                                            <div class="panel-heading">Editar Rol : <?php //echo $roles[0]->role ?> </div>
                                            <p>
      
                                            <div class="panel-body">
                                                <form class="form-horizontal" action='save_rol' method="post">
                                                    
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="role" name="role" placeholder="Nombre Rol" value="<?php //echo $roles[0]->role ?>">
                                                            <p class="help-block">Nombre del rol.</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Url</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="pagina" name="pagina" placeholder="URL" value="<?php //echo $roles[0]->pagina ?>">
                                                            <p class="help-block">Pagina Inicio.</p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <label>
                                                                    <select name="estado_rol" class="form-control">
                                                                        <option value="0">Inactivo</option>
                                                                        <option value="1">Activo</option>
                                                                    </select>
                                                                </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
