<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Menus</button> </a> 
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Nuevo</button>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-white">

                        <div class="panel-body">
                            <div class="col-lg-6">
                               
                                <div id="" class="panel panel-info">
                                    <div class="panel-heading">Nuevo Menu : <?php //echo $onMenu[0]->nombre_menu ?> </div>
                                        <p>
                                        <form class="form-horizontal" action='save_menu' method="post">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nombre_menu" name="nombre_menu" placeholder="Nombre menu" value="<?php //echo $onMenu[0]->nombre_menu ?>">
                                                    <p class="help-block">Nombre del menu a crear.</p>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Url</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="url_menu" name="url_menu" placeholder="URL" value="<?php //echo $onMenu[0]->url_menu ?>">
                                                    <p class="help-block">Url a mostrar.</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Icono</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="icon_menu" name="icon_menu" placeholder="ICON" value="<?php //echo $onMenu[0]->icon_menu ?>">
                                                    <p class="help-block">Icono para mostrar.</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">CSS</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="class_menu" name="class_menu" placeholder="Class CSS" value="<?php //echo $onMenu[0]->class_menu ?>">
                                                    <p class="help-block">Clase CSS.</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                        <label>
                                                            <select name="estado_menu" class="form-control">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
   
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
                                        </p>
                                </div>
                              
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
