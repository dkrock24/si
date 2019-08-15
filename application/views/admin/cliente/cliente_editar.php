<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        
        $("#departamento").change(function(){
            $("#ciudad").empty();
            var html_option;
            var departamento = $(this).val();

            $.ajax({
                url: "getCiudadId/"+departamento,
                datatype: 'json',      
                cache : false,                

                success: function(data){
                    var datos = JSON.parse(data);
                    var ciudad = datos["ciudad"];

                   $.each(ciudad, function(i, item) { 
                    html_option += "<option>"+item.nombre_ciudad+"</option>";
                   });
                    $("#ciudad").html(html_option);           
                },
                error:function(){
                }
            });           
        });
    });
</script>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Clientes</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
        

                        <div id="panelDemo10" class="panel">    
                                                
                            <div class="panel-heading menuTop">Nuevo Cliente : <?php //echo $cliente[0]->nombre_submenu ?> </div>
                             <div class="panel-body menuContent">        
                            <p> 
                            <form class="form-horizontal" enctype="multipart/form-data" name="cliente" action='../update' method="post">
                                <input type="hidden" value="<?php echo $cliente[0]->id_cliente; ?>" name="id_cliente">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Website</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="website_cli" name="website_cli" placeholder="Website" value="<?php echo $cliente[0]->website_cli ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NRC</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nrc_cli" name="nrc_cli" placeholder="NRC" value="<?php echo $cliente[0]->nrc_cli ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NIT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nit_cliente" name="nit_cliente" placeholder="NIT" value="<?php echo $cliente[0]->nit_cliente ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Clase Cliente</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="clase_cli" name="clase_cli" placeholder="Clase Cliente" value="<?php echo $cliente[0]->clase_cli ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="mail_cli" name="mail_cli" placeholder="Email" value="<?php echo $cliente[0]->mail_cli ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Nombre Empresa</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nombre_empresa_o_compania" name="nombre_empresa_o_compania" placeholder="Nombre Empresa" value="<?php echo $cliente[0]->nombre_empresa_o_compania ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">N Cuenta</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" placeholder="N Cuenta" value="<?php echo $cliente[0]->numero_cuenta ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Impuesto</label>
                                            <div class="col-sm-9">
                                                <select id="aplica_impuestos" name="aplica_impuestos" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>

                                                </select>                                                
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Direccion</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente" placeholder="Direccion" value="<?php echo $cliente[0]->direccion_cliente ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">% Descuento</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="porcentage_descuentos" name="porcentage_descuentos" placeholder="Descuento" value="<?php echo $cliente[0]->porcentage_descuentos ?>">
                                                
                                            </div>
                                        </div>

                                        

                                    </div>


                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Persona</label>
                                            <div class="col-sm-9">
                                                <select id="Persona" name="Persona" class="form-control">
                                                    <?php
                                                    foreach ($persona as $key => $p) {
                                                        if($cliente[0]->Persona == $p->id_persona){
                                                        ?>
                                                        <option value="<?php echo $p->id_persona; ?>"><?php echo $p->primer_nombre_persona.' '.$p->segundo_nombre_persona.' '.$p->primer_apellido_persona.' '.$p->segundo_apellido_persona; ?></option>
                                                        <?php
                                                        }
                                                    }
                                                    foreach ($persona as $key => $p) {
                                                        if($cliente[0]->Persona != $p->id_persona){
                                                        ?>
                                                        <option value="<?php echo $p->id_persona; ?>"><?php echo $p->primer_nombre_persona.' '.$p->segundo_nombre_persona.' '.$p->primer_apellido_persona.' '.$p->segundo_apellido_persona; ?></option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Natural</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="natural_juridica" name="natural_juridica" placeholder="Natural Juridica" value="<?php echo $cliente[0]->natural_juridica ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Pago</label>
                                            <div class="col-sm-9">
                                                <select id="TipoPago" name="TipoPago" class="form-control">
                                                    <?php

                                                    foreach ($pago as $key => $pp) {
                                                        if($cliente[0]->TipoPago == $pp->id_modo_pago){
                                                        ?>
                                                        <option value="<?php echo $pp->id_modo_pago; ?>"><?php echo $pp->codigo_modo_pago; ?></option>
                                                        <?php
                                                        }
                                                    }

                                                    foreach ($pago as $key => $p) {
                                                        if($cliente[0]->TipoPago != $p->id_modo_pago){
                                                        ?>
                                                        <option value="<?php echo $p->id_modo_pago; ?>"><?php echo $p->codigo_modo_pago; ?></option>
                                                        <?php
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Documento</label>
                                            <div class="col-sm-9">
                                                <select id="TipoDocumento" name="TipoDocumento" class="form-control">
                                                    <?php
                                                    foreach ($documento as $key => $d) {
                                                        if($cliente[0]->TipoDocumento == $d->id_tipo_documento){
                                                        ?>
                                                        <option value="<?php echo $d->id_tipo_documento; ?>"><?php echo $d->nombre; ?></option>
                                                        <?php
                                                        }
                                                    }

                                                    foreach ($documento as $key => $d) {
                                                        if($cliente[0]->TipoDocumento != $p->id_tipo_documento){
                                                        ?>
                                                        <option value="<?php echo $d->id_tipo_documento; ?>"><?php echo $d->nombre; ?></option>
                                                        <?php
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                
                                                <label>
                                                    <select name="estado" class="form-control">
                                                        <?php
                                                        if($cliente[0]->estado ==1){
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
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Logo</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="logo_cli" name="logo_cli" placeholder="Logo" value="<?php //echo $cliente[0]->titulo_submenu ?>">
                                                <img src="data: <?php echo $cliente[0]->logo_type ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode( $cliente[0]->logo_cli ) ?>" clas="preview_producto" style="width:100%" />
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
