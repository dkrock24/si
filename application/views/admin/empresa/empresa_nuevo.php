<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a name="admin/empresa/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mmb-sm btn btn-success"> Empresas</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">    
                                                
                    <div class="panel-heading menuTop">Nueva Empresa : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                        <div class="menuContent">
                            <div class="b">    
                                <div class="panel-heading"></div>
                    
                                <form class="form-horizontal" enctype="multipart/form-data" name="empresa" id='empresa' method="post">
                                    <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Razon Social</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nombre_razon_social" name="nombre_razon_social" placeholder="Nombre Razon Social" required="" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Nombre Comercial</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" placeholder="Nombre Comercial" required="" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NRC</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nrc" name="nrc" placeholder="NRC" required="" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NIT</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nit" name="nit" placeholder="NIT" required="" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Autorizacion</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="autorizacion" name="autorizacion" placeholder="Autorizacion" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>
                                            -->
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Giro</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="giro" name="giro" placeholder="Giro" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Logo</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control" id="logo_empresa" name="logo_empresa" placeholder="Autorizacion" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Moneda</label>
                                                <div class="col-sm-9">
                                                    <select id="Moneda" name="Moneda" class="form-control" >
                                                        <?php
                                                        foreach ($moneda as $key => $value) {
                                                            ?>
                                                            <option value="<?php echo $value->id_moneda; ?>"><?php echo $value->moneda_nombre; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>                                                
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Persona</label>
                                                <div class="col-sm-9">
                                                    <select id="natural_juridica" name="natural_juridica" class="form-control">
                                                        <option value="0">Natural</option>
                                                        <option value="1">Juridica</option>

                                                    </select>                                       
                                                    
                                                </div>
                                            </div>

                                            

                                            

                                        </div>

                                        <div class="col-lg-6">
                                            <!-- Otro -->

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">M. I.</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="metodo_inventario" name="metodo_inventario" placeholder="Metodo Inventario" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Direccion</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Slogan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="slogan" name="slogan" placeholder="Slogan" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                    
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Resolusion</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="resolucion" name="resolucion" placeholder="Resolusion" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                                </div>
                                            </div>
                                            -->
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Represent.</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="representante" name="representante" placeholder="Representante" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">WebSite</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="website" name="website" placeholder="WebSite" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tiraje</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="tiraje" name="tiraje" placeholder="Tiraje" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>
                                            -->
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Telefono</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="tel" name="tel" placeholder="Telefono" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>
                                            <?php
                                            if( $this->session->usuario[0]->id_rol == 1 )
                                            {
                                            ?>
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Licencia</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Licencia" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                    
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    
                                                    <label>
                                                        <select name="empresa_estado" class="form-control">
                                                            <option value="1">Activo</option>
                                                            <option value="0">Inactivo</option>
                                                        </select>
                                                    </label>                                                    
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="panel-footer text-right">
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <input type="button" name="<?php echo base_url() ?>admin/empresa/crear" data="empresa" class="btn btn-warning enviar_data" value="Guardar">
                                            </div>
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
