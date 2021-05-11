<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/menu/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Documento</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
        </h3>
            <div class="row">
                <div class="col-lg-12">
                               
                <div id="panelDemo10" class="panel menu_title_bar"> 
                    <div class="panel-heading menuTop">Nuevo Menu : <?php //echo $onMenu[0]->nombre_menu ?> </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='menu' method="post">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombre_menu" name="nombre_menu" placeholder="Nombre menu" value="<?php //echo $onMenu[0]->nombre_menu ?>">
                                    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Url</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="url_menu" name="url_menu" placeholder="URL" value="<?php //echo $onMenu[0]->url_menu ?>">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Icono</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="icon_menu" name="icon_menu" placeholder="ICON" value="<?php //echo $onMenu[0]->icon_menu ?>">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">CSS</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="class_menu" name="class_menu" placeholder="Class CSS" value="<?php //echo $onMenu[0]->class_menu ?>">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Orden</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="orden_menu" name="orden_menu" placeholder="Class CSS" value="<?php //echo $onMenu[0]->class_menu ?>">
                                    
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
                                    <input type="button" name="<?php echo base_url() ?>admin/menu/crear" data="menu" class="btn btn-success enviar_data" value="Guardar">
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
    </section>
