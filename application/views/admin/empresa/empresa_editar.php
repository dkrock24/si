<style>
    .polaroid{
        margin-top:50px;
    }
</style>
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

                <div id="panelDemo10" class="panel menu_title_bar">

                    <div class="panel-heading menuTop">Nueva Empresa : </div>
                    <div class="panel-body menuContent">
                        <p>
                            <form class="form-horizontal" enctype="multipart/form-data" name="empresa" action='../update' method="post">
                                <input type="hidden" value="<?php echo $empresa[0]->id_empresa; ?>" name="id_empresa">
                                <div class="row">
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group img_logo">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Logo</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" id="logo_empresa" name="logo_empresa" placeholder="Autorizacion" value=""/>
                                                <?php
                                                if($empresa[0]->logo_empresa){
                                                    ?>
                                                    <img src="data: <?php echo $empresa[0]->logo_type ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode($empresa[0]->logo_empresa) ?>" class="preview_producto polaroid" style="width:70%" />
                                                    <?php
                                                }
                                                ?>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                                <label for="inputEmail3" class=" control-label no-padding-right">Razon Social</label>
                                                <input type="text" class="form-control" id="nombre_razon_social" name="nombre_razon_social" required="" placeholder="Nombre Razon Social" value="<?php echo $empresa[0]->nombre_razon_social ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                                <label for="inputPassword3" class=" control-label no-padding-right">Nombre Comercial</label>
                                                <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" required="" placeholder="Nombre Comercial" value="<?php echo $empresa[0]->nombre_comercial ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                                <label for="inputPassword3" class=" control-label no-padding-right">NRC</label>
                                                <input type="text" class="form-control" id="nrc" name="nrc" placeholder="NRC" required="" value="<?php echo $empresa[0]->nrc ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                                <label for="inputPassword3" class=" control-label no-padding-right">NIT</label>
                                                <input type="text" class="form-control" id="nit" name="nit" placeholder="NIT" required="" value="<?php echo $empresa[0]->nit ?>">

                                            </div>
                                        </div>
<!--
                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                                <label for="inputPassword3" class=" control-label no-padding-right">Autorizacion</label>
                                                <input type="text" class="form-control" id="autorizacion" name="autorizacion" placeholder="Autorizacion" value="<?php echo $empresa[0]->autorizacion ?>">

                                            </div>
                                        </div>
                                            -->
                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class=" control-label no-padding-right">Giro</label>
                                                <input type="text" class="form-control" id="giro" name="giro" placeholder="Giro" value="<?php echo $empresa[0]->giro ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class="control-label no-padding-right">Moneda</label>
                                                <select id="Moneda" name="Moneda" class="form-control">
                                                    <?php
                                                    foreach ($moneda as $key => $value) {
                                                        if ($value->id_moneda == $empresa[0]->Moneda) {
                                                            ?>
                                                            <option value="<?php echo $value->id_moneda; ?>"><?php echo $value->moneda_nombre; ?></option>
                                                        <?php
                                                            }
                                                        }

                                                        foreach ($moneda as $key => $value) {
                                                            if ($value->id_moneda != $empresa[0]->Moneda) {
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
                                            
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class="control-label no-padding-right">Tipo Persona</label>
                                                <select id="natural_juridica" name="natural_juridica" class="form-control">
                                                <?php
                                                    if( $empresa[0]->natural_juridica == 0){
                                                        ?>
                                                            <option value="0">Natural</option>  
                                                            <option value="1">Juridica</option>                                          
                                                        <?php

                                                    }else{
                                                        ?>
                                                            <option value="1">Juridica</option>
                                                            <option value="0">Natural</option>                                            
                                                        <?php

                                                    }
                                                ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                                <label for="inputPassword3" class=" control-label no-padding-right">M. I.</label>
                                                <input type="text" class="form-control" id="metodo_inventario" name="metodo_inventario" placeholder="Metodo Inventario" value="<?php echo $empresa[0]->metodo_inventario ?>">

                                            </div>
                                        </div>

                                        

                                        
                                    </div>


                                    <div class="col-lg-4">
                                        <!-- Otro -->                                       

                                        

                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                            <label for="inputEmail3" class=" control-label no-padding-right">Direccion</label>
                                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion" value="<?php echo $empresa[0]->direccion ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class=" control-label no-padding-right">Slogan</label>
                                                <input type="text" class="form-control" id="slogan" name="slogan" placeholder="Slogan" value="<?php echo $empresa[0]->slogan ?>">

                                            </div>
                                        </div>
<!--
                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class=" control-label no-padding-right">Resolusion</label>
                                                <input type="text" class="form-control" id="resolucion" name="resolucion" placeholder="Resolusion" value="<?php echo $empresa[0]->resolucion ?>">
                                            </div>
                                        </div>
                                                -->
                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class=" control-label no-padding-right">Represent.</label>
                                                <input type="text" class="form-control" id="representante" name="representante" placeholder="Representante" value="<?php echo $empresa[0]->representante ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class=" control-label no-padding-right">WebSite</label>
                                                <input type="text" class="form-control" id="website" name="website" placeholder="WebSite" value="<?php echo $empresa[0]->website ?>">

                                            </div>
                                        </div>
<!--
                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class=" control-label no-padding-right">Tiraje</label>
                                                <input type="text" class="form-control" id="tiraje" name="tiraje" placeholder="Tiraje" value="<?php echo $empresa[0]->tiraje ?>">

                                            </div>
                                        </div>
                                                -->
                                        <div class="form-group">
                                            
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class=" control-label no-padding-right">Telefono</label>
                                                <input type="text" class="form-control" id="tel" name="tel" placeholder="Telefono" value="<?php echo $empresa[0]->tel ?>">

                                            </div>
                                        </div>

                                        <?php
                                        if( $this->session->usuario[0]->id_rol == 1 )
                                        {
                                        ?>
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Licencia</label>

                                                <input type="text" class="form-control" id="codigo" required="" name="codigo" placeholder="Licencia" value="<?php echo $empresa[0]->codigo ?>">

                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>

                                        <div class="form-group">
                                            <div class=" col-sm-10">

                                                <label>
                                                    <select name="empresa_estado" class="form-control">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </label>
                                                <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Guardar</button>
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
</section>