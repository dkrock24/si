<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">                
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista Roles</button> 
        </a> 
        <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Editar</button>
        </h3>                

        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel">   
                    
                    <div class="panel-heading menuTop">Editar Rol : <?php echo $roles[0]->role ?> </div>
                    

                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" action='../update_roles' method="post">
                                    <input type="hidden" value="<?php echo $roles[0]->id_rol; ?>" name="role_id">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="role" name="role" placeholder="Nombre menu" value="<?php echo $roles[0]->role ?>">
                                            
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
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
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
</section>
