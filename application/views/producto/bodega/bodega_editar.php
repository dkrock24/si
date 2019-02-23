<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista Bodega</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Editar</button>
            </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Editar Bodega</div>
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
                                                <form class="form-horizontal" action='../update_bodega' method="post">
                                                    <input type="hidden" name="id_bodega" value="<?php echo $bodega[0]->id_bodega; ?>">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="nombre_bodega" name="nombre_bodega" value="<?php echo $bodega[0]->nombre_bodega ?>">
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Direccion</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="direccion_bodega" name="direccion_bodega" value="<?php echo $bodega[0]->direccion_bodega ?>">
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Encargado</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="encargado_bodega" name="encargado_bodega" value="<?php echo $bodega[0]->encargado_bodega ?>">
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Sucursal</label>
                                                        <div class="col-sm-10">
                                                            <select name="Sucursal" class="form-control">
                                                                <option value="<?php echo $bodega[0]->id_sucursal; ?>"><?php echo $bodega[0]->nombre_sucursal; ?></option>
                                                                <?php
                                                                foreach ($sucursal as $sucursales) {
                                                                    if($sucursales->id_sucursal != $bodega[0]->id_sucursal){
                                                                    ?>
                                                                    <option value="<?php echo $sucursales->id_sucursal; ?>"><?php echo $sucursales->nombre_sucursal; ?></option>
                                                                    <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Principal</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="predeterminada_bodega">
                                                                <?php
                                                                if($bodega[0]->predeterminada_bodega == 0){
                                                                    ?>
                                                                     <option value="0">No</option>
                                                                     <option value="1">Si</option>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                     <option value="1">Si</option>
                                                                     <option value="0">No</option>
                                                                    <?php
                                                                }
                                                                ?>                                                                
                                                            </select>                                                            
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <label>
                                                                    <select name="bodega_estado" class="form-control">
                                                                        <?php
                                                                        if($bodega[0]->bodega_estado == 0){
                                                                            ?>
                                                                             <option value="0">Inactivo</option>
                                                                            <?php
                                                                        }else{
                                                                            ?>
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
