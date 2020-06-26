<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">  
            <h3 style="height: 50px; font-size: 13px;">  
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-success"> Menus</button> 
                </a> 
                <a href="../submenu/<?php echo  $onMenu[0]->id_menu; ?>" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-primary btn-outline"> Lista Sub Menu</button> 
                </a> 
                <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Editar</button>
                
            </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel menu_title_bar">
                                                                 
                        <div class="panel-heading menuTop">Editar Sub Menu : <?php echo  $onMenu[0]->nombre_submenu; ?> </div>
                            <div class="panel-body menuContent">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form class="form-horizontal" action='../update_sub_menu' method="post">
                                            <input type="hidden" value="<?php echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nombre_submenu" name="nombre_submenu" placeholder="Nombre menu" value="<?php echo $onMenu[0]->nombre_submenu; ?>">
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Url</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="url_submenu" name="url_submenu" placeholder="URL" value="<?php echo $onMenu[0]->url_submenu; ?>">
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Icono</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="icon_submenu" name="icon_submenu" placeholder="ICON" value="<?php echo $onMenu[0]->icon_submenu ; ?>
                                                    ">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">CSS</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="titulo_submenu" name="titulo_submenu" placeholder="Class CSS" value="<?php echo $onMenu[0]->titulo_submenu; ?>">
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Menu Padre</label>
                                                <div class="col-sm-9">
                                                    <select name="id_menu" class="form-control">
                                                        <?php foreach ($allMenus as $menus) {
                                                            if( $menus->id_menu == $onMenu[0]->id_menu){
                                                            ?>
                                                            <option value="<?php echo $menus->id_menu ?>"><?php echo $menus->nombre_menu ?></option>
                                                            <?php
                                                            }
                                                        } ?>
                                                        <?php foreach ($allMenus as $menus) {
                                                            ?>
                                                            <option value="<?php echo $menus->id_menu ?>"><?php echo $menus->nombre_menu ?></option>
                                                            <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Vista</label>
                                                <div class="col-sm-9">
                                                    <select name="vista" class="form-control">
                                                        <?php foreach ($vistas as $vistas) {
                                                            if( $vistas->id_vista == $onMenu[0]->id_vista){
                                                            ?>
                                                            <option value="<?php echo $vistas->id_vista ?>"><?php echo $vistas->vista_nombre ?></option>
                                                            <?php
                                                            }
                                                        } ?>
                                                        <?php foreach ($vistas2 as $demo) {
                                                             if( $demo->id_vista != $onMenu[0]->id_vista){
                                                            ?>
                                                            <option value="<?php echo $demo->id_vista ?>"><?php echo $demo->vista_nombre ?></option>
                                                            <?php
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    
                                                        <label>
                                                            <select name="estado_menu" class="form-control">
                                                                <?php 
                                                                    if( $onMenu[0]->estado_submen ==1 ){ 
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
                                            
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="submit" class="btn btn-info">Guardar</button>
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
        </div>
    </section>
