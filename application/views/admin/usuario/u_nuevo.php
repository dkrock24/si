<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('#persona_modal').appendTo("body");

        $(document).on('change', '.Imagen', function()
        {
            readURL(this);
        });

        $(document).on('click', '.persona_codigo', function(){
            $('#persona_modal').modal('show');
            get_clientes_lista();
        });

        function get_clientes_lista(){
        
        var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Codigo</th><th>Nombre Completo</th><th>DUI</th><th>Telefono</th><th>Action</th>";
        var table_tr = "<tbody id='list'>";
        var contador_precios=1;

        $.ajax({
            url: "get_persona",
            datatype: 'json',      
            cache : false,                

            success: function(data){
                var datos = JSON.parse(data);
                var clientes = datos["persona"];
                var cliente_id = 0;
                
                $.each(clientes, function(i, item) { 

                    if(cliente_id != item.id_cliente){
                        cliente_id = item.id_cliente;   
                        var precio = 0;
                        
                        table_tr += '<tr><td>'+contador_precios+'</td><td>'+item.primer_nombre_persona+' '+item.segundo_nombre_persona+' '+item.primer_apellido_persona+' '+item.segundo_apellido_persona+'</td><td>'+item.nombre_empresa_o_compania+'</td><td>'+item.nrc_cli+'</td><td>'+item.nit_cliente+'</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_cliente" id="'+item.id_cliente+'" name="'+item.nombre_empresa_o_compania+'" rel="'+item.direccion_cliente+'" impuesto="'+item.aplica_impuestos+'">Agregar</a></td></tr>';
                        contador_precios++;
                    }
                    
                });
                table += table_tr;
                table += "</tbody></table>";

                $(".cliente_lista_datos").html(table);
            
            },
            error:function(){
            }
        });
    } 

    $("#imagen_nueva").hide();

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
              $('.preview_producto').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
            $("#imagen_nueva").show();
            }
        }
    });
</script>
<!-- Main section-->
<style type="text/css">
    .preview_producto{
        width: 50%;
    }
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Usuario</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
            
                    <div class="col-lg-12">

                        <div id="panelDemo10" class="panel panel-info">    
                                                
                            <div class="panel-heading">Nuevo Usuario : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                             <div class="panel-body">        
                            <p> 
                            <form class="form-horizontal" enctype="multipart/form-data" name="usuario" action='crear' method="post">
                                <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Usuario</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Empresa" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Hora Inicio</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="hora_inicio" name="hora_inicio" placeholder="Hora Inicio" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Hora Fin</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="hora_salida" name="hora_salida" placeholder="Hora Fin" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Encargado</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="encargado" name="encargado" placeholder="Encargado" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="*******" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Repetir Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="password2" name="password2" placeholder="*******" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Rol</label>
                                            <div class="col-sm-9">
                                                <select id="Persona_Proveedor" name="Persona_Proveedor" class="form-control">
                                                    <?php
                                                    foreach ($roles as $key => $p) {
                                                        ?>
                                                        <option value="<?php echo $p->id_rol; ?>"><?php echo $p->role; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Fotografia</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control Imagen" id="logo" name="logo" placeholder="Logo" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Persona</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control persona_codigo" id="persona" name="persona" placeholder="Persona" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                                
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                
                                                <img src="" name="" id="imagen_nueva" class="preview_producto" />
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

<!-- Modal Large CLIENTES MODAL-->
   <div id="persona_modal" tabindex="-1" role="dialog" aria-labelledby="persona_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Buscar Persona</h4>
            </div>
            <div class="modal-body">
                <p class="cliente_lista_datos">
                    
                </p>                                 
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->
