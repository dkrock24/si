<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        
        $("#departamento").change(function(){
            $("#Ciudad").empty();
            var html_option;
            var departamento = $(this).val();

            $.ajax({
                url: "../getCiudadId/"+departamento,
                datatype: 'json',      
                cache : false,                

                success: function(data){
                    var datos = JSON.parse(data);
                    var ciudad = datos["ciudad"];

                   $.each(ciudad, function(i, item) { 
                    html_option += "<option value='"+item.id_ciudad+"'>"+item.nombre_ciudad+"</option>";
                   });
                    $("#Ciudad").html(html_option);           
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
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Persona</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
            
                    <div class="col-lg-12">

                        <div id="panelDemo10" class="panel panel-info">    
                                                
                            <div class="panel-heading">Editar Persona : <?php //echo $persona[0]->nombre_submenu ?> </div>
                             <div class="panel-body">        
                            <p> 
                            <form class="form-horizontal" name="persona" action='../update' method="post">
                                <input type="hidden" value="<?php echo $persona[0]->id_persona; ?>" name="id_persona">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Primer Nombre</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="primer_nombre_persona" name="primer_nombre_persona" placeholder="Primer Nombre" value="<?php echo $persona[0]->primer_nombre_persona ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Segundo Nombre</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="segundo_nombre_persona" name="segundo_nombre_persona" placeholder="Segundo Nombre" value="<?php echo $persona[0]->segundo_nombre_persona ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Primer Apellido</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="primer_apellido_persona" name="primer_apellido_persona" placeholder="Primer Apellido" value="<?php echo $persona[0]->primer_apellido_persona ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Segundo Apellido</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="segundo_apellido_persona" name="segundo_apellido_persona" placeholder="Seegundo Apellido" value="<?php echo $persona[0]->segundo_apellido_persona ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Fecha Nacimiento</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="fecha_cumpleaños_persona" name="fecha_cumpleaños_persona" placeholder="Fecha Nacimiento" value="<?php echo $persona[0]->fecha_cumpleaños_persona ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">DUI</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="dui" name="dui" placeholder="DUI" value="<?php echo $persona[0]->dui ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NIT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nit" name="nit" placeholder="NIT" value="<?php echo $persona[0]->nit ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Sexo</label>
                                            <div class="col-sm-9">
                                                <select id="Sexo" name="Sexo" class="form-control">
                                                    <?php
                                                    foreach ($sexo as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id_sexo; ?>"><?php echo $value->sexo; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>                                                
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Direccion 1</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="direccion_residencia_persona1" name="direccion_residencia_persona1" placeholder="Direccion 1" value="<?php echo $persona[0]->direccion_residencia_persona1 ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Direccion 2</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="direccion_residencia_persona2" name="direccion_residencia_persona2" placeholder="Direccion 2" value="<?php echo $persona[0]->direccion_residencia_persona2 ?>">
                                                
                                            </div>
                                        </div>

                                        

                                    </div>


                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Telefono</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="tel" name="tel" placeholder="Telefono" value="<?php echo $persona[0]->tel ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Celular</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="cel" name="cel" placeholder="Celular" value="<?php echo $persona[0]->cel ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="mail" name="mail" placeholder="Email" value="<?php echo $persona[0]->mail ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Whatsapp</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Whatsapp" value="<?php echo $persona[0]->whatsapp ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Departmento</label>
                                            <div class="col-sm-9">
                                                <select id="departamento" name="departamento" class="form-control">
                                                    <option value="<?php echo $persona[0]->id_departamento; ?>"><?php echo $persona[0]->nombre_departamento; ?></option>
                                                    <?php
                                                    $id_anterior = 0;
                                                    foreach ($ciudad as $key => $value) {

                                                        if($id_anterior != $value->id_departamento &&  $persona[0]->id_departamento != $value->id_departamento ){
                                                        ?>
                                                        <option value="<?php echo $value->id_departamento; ?>"><?php echo $value->nombre_departamento; ?></option>
                                                        <?php
                                                        }
                                                        $id_anterior = $value->id_departamento;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Ciudad</label>
                                            <div class="col-sm-9">
                                                <select id="Ciudad" name="Ciudad" class="form-control">
                                                    <option value="<?php echo $persona[0]->Ciudad ?>"><?php echo $persona[0]->nombre_ciudad ?></option>
                                                    <?php
                                                    $id_anterior = 0;
                                                    foreach ($ciudad2 as $key => $value) {

                                                        if($id_anterior != $value->id_ciudad &&  $persona[0]->Ciudad != $value->id_ciudad ){
                                                        ?>
                                                        <option value="<?php echo $value->id_ciudad; ?>"><?php echo $value->nombre_ciudad; ?></option>
                                                        <?php
                                                        }
                                                        $id_anterior = $value->id_ciudad;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Comentarios</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="comentarios" name="comentarios" placeholder="Comentarios" value="<?php echo $persona[0]->comentarios ?>">
                                                
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                
                                                <label>
                                                    <select name="persona_estado" class="form-control">
                                                        <?php
                                                        if( $persona[0]->persona_estado ==1 ){ 
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
