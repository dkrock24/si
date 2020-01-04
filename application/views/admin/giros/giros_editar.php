<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista</button> </a> 
                <a href="" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" style="top: 0px; position: relative;" class="mb-sm btn btn-info btn-outline">Editar</button></a>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel menu_title_bar">
                        <div id="panelDemo10" class="panel ">  
                            <div class="panel-heading menuTop">Editar Giro </div>
                                <div class="panel-body menuContent"> 
                                     <div class="row">
                                        <div class="col-lg-6">
                                        <form class="form-horizontal" action='../actualizar' method="post">
                                            <input type="hidden" value="<?php echo $giros[0]->id_giro; ?>" name="id_giro">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nombre_giro" name="nombre_giro" value="<?php echo $giros[0]->nombre_giro; ?>" placeholder="Nombre" value="">
                                                    
                                                </div>
                                            </div>   
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tipo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tipo_giro" name="tipo_giro" value="<?php echo $giros[0]->tipo_giro; ?>" placeholder="Tipo" value="">
                                                    
                                                </div>
                                            </div>  

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descri.</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="descripcion_giro" name="descripcion_giro" value="<?php echo $giros[0]->descripcion_giro; ?>" placeholder="Descri" value="">
                                                    
                                                </div>
                                            </div>   

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="codigo_giro" name="codigo_giro" value="<?php echo $giros[0]->codigo_giro; ?>" placeholder="Codigo" value="">
                                                    
                                                </div>
                                            </div>                                          


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                        <label>
                                                            <select name="estado_giro" class="form-control">
                                                               <?php 
                                                                    if( $giros[0]->estado_giro ==1 ){ 
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
                </div>
            </div>
        </div>
    </section>
