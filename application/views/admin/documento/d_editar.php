<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Documento</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">

                <div id="panelDemo10" class="panel">
                                                
                            <div class="panel-heading menuTop">Editar Tipo Documento : <?php //echo $documento[0]->nombre_submenu ?> </div>
                             <div class="panel-body menuContent">        
                            
                            <form class="form-horizontal" name="documento" action='../update' method="post">
                                <input type="hidden" value="<?php echo $documento[0]->id_tipo_documento; ?>" name="id_tipo_documento">
                                <div class="row">


                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Documento" value="<?php echo $documento[0]->nombre ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Inventario</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="efecto_inventario" name="efecto_inventario" placeholder="Efecto Inventario" value="<?php echo $documento[0]->efecto_inventario ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Iva</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="efecto_en_iva" name="efecto_en_iva" placeholder="Efecto Iva" value="<?php echo $documento[0]->efecto_en_iva ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Cuentas</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="efecto_en_cuentas" name="efecto_en_cuentas" placeholder="Efecto Cuentas" value="<?php echo $documento[0]->efecto_en_cuentas ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Cajas</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="efecto_en_caja" name="efecto_en_caja" placeholder="Efecto Cajas" value="<?php echo $documento[0]->efecto_en_caja ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Reportes</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="efecto_en_report_venta" name="efecto_en_report_venta" placeholder="Efecto Reportes" value="<?php echo $documento[0]->efecto_en_report_venta ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Autmatico</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="automatico" name="automatico" placeholder="Autmatico" value="<?php echo $documento[0]->automatico ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Emitir a</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="emitir_a" name="emitir_a" placeholder="Emitir a" value="<?php echo $documento[0]->emitir_a ?>">
                                            </div>
                                        </div>

                                        

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                
                                                <label>
                                                    <select name="estado" class="form-control">
                                                        <?php
                                                        if($documento[0]->estado == 1){
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
