<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Marca</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Editar Marca : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                    <div class="panel-body menuContent">
                        <form class="form-horizontal" name="marca" action='../update' method="post">
                            <input type="hidden" value="<?php echo $marca[0]->id_marca; ?>" name="id_marca">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Otro -->
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="nombre_marca" name="nombre_marca" placeholder="Nombre Marca" value="<?php echo $marca[0]->nombre_marca ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="descripcion_marca" name="descripcion_marca" placeholder="Descripcion Marca" value="<?php echo $marca[0]->descripcion_marca ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <label>
                                                <select name="estado_marca" class="form-control">
                                                    <?php
                                                    if($marca[0]->estado_marca == 1){
                                                        ?>
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                        <?php
                                                    }else{
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
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-info">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                        </form>                                                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>