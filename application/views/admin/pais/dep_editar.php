<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../dep/<?php echo $dep[0]->pais; ?>" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista Departamentos</button> </a> 
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Departamento</button>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel menu_title_bar">

                        <div class="panel-body">
                            <div class="col-lg-6">
                               
                                <div id="" class="panel panel-info">
                                    <div class="panel-heading">Editar Departamento : <?php echo $dep[0]->nombre_departamento ?> </div>
                                        <p>
                                        <form class="form-horizontal" action='../update_dep' method="post">
                                            <input type="hidden" value="<?php echo $dep[0]->id_departamento; ?>" name="id_departamento">
                                            <input type="hidden" value="<?php echo $dep[0]->id_pais; ?>" name="id_pais">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nombre_dep" name="nombre_departamento" placeholder="Nombre menu" value="<?php echo $dep[0]->nombre_departamento ?>">
                                                    <p class="help-block">Nombre dep.</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                        <label>
                                                            <select name="estado_departamento" class="form-control">
                                                                <?php 
                                                                    if( $dep[0]->estado_departamento ==1 ){ 
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
