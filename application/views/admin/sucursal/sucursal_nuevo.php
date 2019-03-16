<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista Sucursales</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Nuevo</button>
            </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Nueva Sucursal</div>
                <!-- START table-responsive-->
                <div class="">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-white">

                                <div class="panel-body">
                                    <div class="col-lg-6">
                                        <div id="" class="panel panel-info">
                                            <div class="panel-heading">Sucursal Formulario : <?php //echo $roles[0]->role ?> </div>
                                            <p>
      
                                            <div class="panel-body">
                                                <form class="form-horizontal" action='crear' method="post">
                                                    
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="nombre_sucursal" name="nombre_sucursal" value="<?php //echo $roles[0]->role ?>">
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Direccion</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="direct" name="direct" value="<?php //echo $roles[0]->pagina ?>">
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Encargado</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="encargado" name="encargado" value="<?php //echo $roles[0]->pagina ?>">
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Telefono</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="tel" name="tel" value="<?php //echo $roles[0]->pagina ?>">
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Celular</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="cel" name="cel" value="<?php //echo $roles[0]->pagina ?>">
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Empresa</label>
                                                        <div class="col-sm-10">
                                                            <select name="Empresa_Suc" class="form-control">
                                                                <?php
                                                                foreach ($empresa as $e) {
                                                                    ?>
                                                                    <option value="<?php echo $e->id_empresa; ?>"><?php echo $e->nombre_comercial; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Ciudad</label>
                                                        <div class="col-sm-10">
                                                            <select name="Ciudad_Suc" class="form-control">
                                                                <?php
                                                                foreach ($ciudad as $c) {
                                                                    ?>
                                                                    <option value="<?php echo $c->id_ciudad; ?>"><?php echo $c->nombre_ciudad; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <label>
                                                                    <select name="estado" class="form-control">
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