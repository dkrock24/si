
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
                            <h3 class="panel-title"><a href="../submenu/<?php echo $onMenu[0]->id_menu; ?>"><i class="fa fa-arrow-left"></i> Lista Sub Menu</a> / Editar</h3>
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
                            <form class="form-horizontal" action='../update_sub_menu' method="post">
                                <input type="hidden" value="<?php echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nombre_submenu" name="nombre_submenu" placeholder="Nombre menu" value="<?php echo $onMenu[0]->nombre_submenu ?>">
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Url</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="url_submenu" name="url_submenu" placeholder="URL" value="<?php echo $onMenu[0]->url_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Icono</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="icon_submenu" name="icon_submenu" placeholder="ICON" value="<?php echo $onMenu[0]->icon_submenu ?>
                                        ">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">CSS</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="titulo_submenu" name="titulo_submenu" placeholder="Class CSS" value="<?php echo $onMenu[0]->titulo_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Menu Padre</label>
                                    <div class="col-sm-10">
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
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
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
