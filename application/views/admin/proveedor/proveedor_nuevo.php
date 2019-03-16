<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        
        
    });
</script>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Proveedores</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
            
                    <div class="col-lg-12">

                        <div id="panelDemo10" class="panel panel-info">    
                                                
                            <div class="panel-heading">Nuevo Proveedor : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                             <div class="panel-body">        
                            <p> 
                            <form class="form-horizontal" enctype="multipart/form-data" name="cliente" action='crear' method="post">
                                <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Empresa</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="empresa" name="empresa" placeholder="Empresa" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Titular</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="titular_proveedor" name="titular_proveedor" placeholder="NRC" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NRC</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nrc" name="nrc" placeholder="NIT" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NIT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nit_empresa" name="nit_empresa" placeholder="Clase Cliente" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Giro</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="giro" name="giro" placeholder="Email" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Direccion Empresa</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="direc_empresa" name="direc_empresa" placeholder="Nombre Empresa" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Telefono</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="tel_empresa" name="tel_empresa" placeholder="N Cuenta" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Celular</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="cel_empresa" name="cel_empresa" placeholder="Direccion" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Website</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="website" name="website" placeholder="Descuento" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        

                                    </div>


                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Persona</label>
                                            <div class="col-sm-9">
                                                <select id="Persona_Proveedor" name="Persona_Proveedor" class="form-control">
                                                    <?php
                                                    foreach ($persona as $key => $p) {
                                                        ?>
                                                        <option value="<?php echo $p->id_persona; ?>"><?php echo $p->primer_nombre_persona.' '.$p->segundo_nombre_persona.' '.$p->primer_apellido_persona.' '.$p->segundo_apellido_persona; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Natural</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="natural_juridica" name="natural_juridica" placeholder="Natural Juridica" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Logo</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="logo" name="logo" placeholder="Logo" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Linea</label>
                                            <div class="col-sm-9">
                                                <select id="lineas" name="lineas" class="form-control">
                                                    <?php
                                                    foreach ($linea as $key => $l) {
                                                        ?>
                                                        <option value="<?php echo $l->id_linea; ?>"><?php echo $l->tipo_producto; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                
                                                <label>
                                                    <select name="estado" class="form-control">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
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