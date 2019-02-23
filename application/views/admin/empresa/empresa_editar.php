<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Empresas</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
            
                    <div class="col-lg-12">

                        <div id="panelDemo10" class="panel panel-info">    
                                                
                            <div class="panel-heading">Nueva Empresa : <?php //echo $empresa[0]->nombre_submenu ?> </div>
                             <div class="panel-body">        
                            <p> 
                            <form class="form-horizontal" enctype="multipart/form-data" name="empresa" action='../update' method="post">
                                <input type="hidden" value="<?php echo $empresa[0]->id_empresa; ?>" name="id_empresa">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nombre_razon_social" name="nombre_razon_social" placeholder="Nombre Razon Social" value="<?php echo $empresa[0]->nombre_razon_social ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" placeholder="Nombre Comercial" value="<?php echo $empresa[0]->nombre_comercial ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">NRC</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nrc" name="nrc" placeholder="NRC" value="<?php echo $empresa[0]->nrc ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">NIT</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nit" name="nit" placeholder="NIT" value="<?php echo $empresa[0]->nit ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Autorizacion</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="autorizacion" name="autorizacion" placeholder="Autorizacion" value="<?php echo $empresa[0]->autorizacion ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Giro</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="giro" name="giro" placeholder="Giro" value="<?php echo $empresa[0]->giro ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Moneda</label>
                                            <div class="col-sm-10">
                                                <select id="Moneda" name="Moneda" class="form-control">
                                                    <?php
                                                    foreach ($moneda as $key => $value) {
                                                        if($value->id_moneda == $empresa[0]->Moneda ){
                                                        ?>
                                                        <option value="<?php echo $value->id_moneda; ?>"><?php echo $value->moneda_nombre; ?></option>
                                                        <?php
                                                        }
                                                    }
                                                    
                                                    foreach ($moneda as $key => $value) {
                                                        if($value->id_moneda != $empresa[0]->Moneda ){
                                                        ?>
                                                        <option value="<?php echo $value->id_moneda; ?>"><?php echo $value->moneda_nombre; ?></option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>                                                
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">N. J.</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="natural_juridica" name="natural_juridica" placeholder="Natural Juridico" value="<?php echo $empresa[0]->natural_juridica ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">M. I.</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="metodo_inventario" name="metodo_inventario" placeholder="Metodo Inventario" value="<?php echo $empresa[0]->metodo_inventario ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Logo</label>
                                            <div class="col-sm-10">   
                                                <input type="file" class="form-control" id="logo_empresa" name="logo_empresa" placeholder="Autorizacion" value="<?php //echo $onMenu[0]->titulo_submenu ?>">                                             
                                                <img src="data: <?php echo $empresa[0]->logo_type ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode( $empresa[0]->logo_empresa ) ?>" clas="preview_producto" style="width:100%" />
                                            </div>
                                        </div>

                                        

                                    </div>


                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Direccion</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion" value="<?php echo $empresa[0]->direccion ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Slogan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="slogan" name="slogan" placeholder="Slogan" value="<?php echo $empresa[0]->slogan ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Resolusion</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="resolucion" name="resolucion" placeholder="Resolusion" value="<?php echo $empresa[0]->resolucion ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Represent.</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="representante" name="representante" placeholder="Representante" value="<?php echo $empresa[0]->representante ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">WebSite</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="website" name="website" placeholder="WebSite" value="<?php echo $empresa[0]->website ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Tiraje</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tiraje" name="tiraje" placeholder="Tiraje" value="<?php echo $empresa[0]->tiraje ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Telefono</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tel" name="tel" placeholder="Telefono" value="<?php echo $empresa[0]->tel ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                
                                                <label>
                                                    <select name="empresa_estado" class="form-control">
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
