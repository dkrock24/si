<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista Bodegas</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Nuevo</button>
            </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Nueva Bodega</div>
                <!-- START table-responsive-->
                <div class="">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-white">

                                <div class="panel-body">
                                    <div class="col-lg-6">
                                        <div id="" class="panel panel-info">
                                            <div class="panel-heading">Bodega Formulario : <?php //echo $roles[0]->role ?> </div>
                                            <p>
      
                                            <div class="panel-body">
                                                <form class="form-horizontal" action='save_bodega' method="post">
                                                    
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="nombre_bodega" name="nombre_bodega" value="<?php //echo $roles[0]->role ?>">
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Direccion</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="direccion_bodega" name="direccion_bodega" value="<?php //echo $roles[0]->pagina ?>">
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Encargado</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="encargado_bodega" name="encargado_bodega" value="<?php //echo $roles[0]->pagina ?>">
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Sucursal</label>
                                                        <div class="col-sm-10">
                                                            <select name="Sucursal" class="form-control">
                                                                <?php
                                                                foreach ($sucursal as $sucursales) {
                                                                    ?>
                                                                    <option value="<?php echo $sucursales->id_sucursal; ?>"><?php echo $sucursales->nombre_sucursal; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Principal</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="predeterminada_bodega">
                                                                <option value="0">No</option>
                                                                <option value="1">Si</option>
                                                            </select>                                                            
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <label>
                                                                    <select name="bodega_estado" class="form-control">
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
