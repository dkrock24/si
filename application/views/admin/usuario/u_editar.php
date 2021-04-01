<!-- Main section-->
<script type="text/javascript">

$('#persona_modal').appendTo("body");
$('#error').appendTo("body");

function getEmpleado(){
    $('#persona_modal').modal('show');
    get_clientes_lista();
}

function get_clientes_lista(){
        
    var table = "<table class='table table-sm table-hover'>";
        table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
        table += "<th>#</th><th>Nombre Completo</th><th>DUI</th><th>NIT</th><th>Telefono</th><th>Action</th>";
    var table_tr = "<tbody id='list'>";
    var contador_precios=1;

    $.ajax({
        url: "get_empleado",
        url: "<?php echo base_url(). 'admin/usuario/get_empleado'; ?>",
        datatype: 'json',      
        cache : false,                

        success: function(data){
            var datos = JSON.parse(data);
            var clientes = datos["empleado"];
            
            $.each(clientes, function(i, item) { 
                    name = item.primer_nombre_persona+' '+item.segundo_nombre_persona+' '+item.primer_apellido_persona+' '+item.segundo_apellido_persona;
                    table_tr += '<tr><td>'+contador_precios+'</td><td>'+item.primer_nombre_persona+' '+item.segundo_nombre_persona+' '+item.primer_apellido_persona+' '+item.segundo_apellido_persona+'</td><td>'+item.dui+'</td><td>'+item.nit+'</td><td>'+item.cel+'</td><td><a href="#" class="btn btn-primary btn-xs" onClick="seleccionar_persona('+item.id_empleado+');" id="'+item.id_empleado+'" name="'+item.primer_nombre_persona+' '+item.segundo_nombre_persona+' '+item.primer_apellido_persona+' '+item.segundo_apellido_persona+'">Agregar</a></td></tr>';
                    contador_precios++;
            });
            table += table_tr;
            table += "</tbody></table>";

            $(".cliente_lista_datos").html(table);
        
        },
        error:function(){
        }
    });
} 

// filtrar producto
$(document).on('keyup', '#buscar_producto', function(){
    var texto_input = $(this).val();

    $("#list tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(texto_input) > -1)
    });        
});

function seleccionar_persona(id){
    $.ajax({
        url: "<?php echo base_url(). 'admin/usuario/validar_usuario/'; ?>"+ id,
        datatype: 'json',      
        cache : false,                

        success: function(data){
            if(data){
                $(".notificacion_texto").text("Empleado ya vinculado a un usuario existente.");
                $('#error').modal('show');

            }else{
                $("#persona").val(id);
                $("#nombre_persona").val($('#'+id).attr('name'));
                $('#persona_modal').modal('hide');
            }               
        },
        error:function(){
        }
    });
}

    //Compar password
    $(document).on('click','#btn_save',function(){
        var password = $("#password").val();
        var password2 = $("#password2").val();

        if( (password == password2) ){
            //$('form#crear').submit();
        }else{
            $(".notificacion_texto").text("Password Diferente.");
            $('#error').modal('show');
        }
    });

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

function agregar_rol(id_rol,accion)
{
    var usuario = $("#id_usuario").val();
    var data = {id_rol : id_rol, usuario:usuario, metodo:accion };
    var url = "<?php echo base_url() ?>"; 

    $.ajax({
        url:  url+"admin/usuario/agregar_remover_rol",
        datatype: 'json',
        type : 'GET',
        data : data,
        cache : false,                

        success: function(data){
            dibujar(data);
        },
        error:function(){
        }
    });
}

function dibujar(response_data){
    var html = '';
    var datos = JSON.parse(response_data);
    $(".roels_asignados").empty();
            
    $.each(datos, function(i, item) {
        html += "<label class='btn btn-success label-lg' onClick='agregar_rol("+item.id_rol+", "+'"remover"'+")'; style='margin-top:2px;' name='remover' id="+item.id_rol+">";
            html += item.role;
        html += '</label>';
    });

    $(".roels_asignados").html(html);
}


$(document).on('change', '.Imagen', function()
{
    readURL(this);
});
</script>


<style type="text/css">
    .preview_producto{
        width: 50%;
    }
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a name="admin/usuario/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Usuario</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
            
        </h3>
        <form class="form-horizontal" enctype="multipart/form-data" id="usuario" name="usuario" method="post">
        <div class="row">
            <div class="col-lg-12">
                
                <div id="panelDemo10" class="panel menu_title_bar">    
                                        
                    <div class="panel-heading menuTop">Editar Usuario </div>
                    <div class="menuContent">        
                    <div class="b"> 
                    <div class="panel-heading">                                   
                                </div>
                        
                        <input type="hidden" value="<?php echo $usuario[0]->id_usuario; ?>" name="id_usuario" id="id_usuario">
                        <div class="row">

                            <div class="col-lg-4">
                            <i class="fa fa-info-circle text-purple"></i> Información Básica.<br>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Usuario</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Empresa" value="<?php echo $usuario[0]->nombre_usuario ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Hora Inicio</label>
                                    <div class="col-sm-9">
                                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" placeholder="Hora Inicio" value="<?php echo $usuario[0]->hora_inicio ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Hora Fin</label>
                                    <div class="col-sm-9">
                                        <input type="time" class="form-control" id="hora_salida" name="hora_salida" placeholder="Hora Fin" value="<?php echo $usuario[0]->hora_salida ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Encargado</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="encargado" name="encargado" placeholder="Encargado" value="<?php echo $usuario[0]->usuario_encargado ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password" name="contrasena_usuario" placeholder="*******" value="<?php //echo $usuario[0]->contrasena_usuario ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Repetir Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password2" name="password2" placeholder="*******" value="<?php //echo $usuario[0]->contrasena_usuario ?>">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4" style="border-left:1px solid grey;border-right:1px solid grey">
                            <i class="fa fa-info-circle text-purple"></i> Información Básica.<br>

                                       <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Rol</label>
                                    <div class="col-sm-9">

                                        <select id="id_rol" name="id_rol" class="form-control">
                                            <?php

                                            foreach ($roles as $key => $p) {
                                                if($p->id_rol == $usuario[0]->id_rol ){
                                                ?>
                                                <option value="<?php echo $p->id_rol; ?>"><?php echo $p->role; ?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            foreach ($roles as $key => $p) {
                                                if($p->id_rol != $usuario[0]->id_rol ){
                                                ?>
                                                <option value="<?php echo $p->id_rol; ?>"><?php echo $p->role; ?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Fotografia</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control Imagen" id="img" name="foto" placeholder="Foto" value="<?php //echo $usuario[0]->titulo_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Empleado</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control persona_codigo" onClick="getEmpleado();" name="nombre_persona" placeholder="Nombre Persona" value="<?php echo $usuario[0]->primer_nombre_persona.' '.$usuario[0]->segundo_nombre_persona.' '.$usuario[0]->primer_apellido_persona.' '.$usuario[0]->segundo_apellido_persona ?>">
                                        <input type="hidden" class="form-control persona_codigo" id="persona" name="persona" placeholder="Persona" value="<?php echo $usuario[0]->Empleado ?>">
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <?php echo $usuario[0]->primer_apellido_persona .' '. $usuario[0]->primer_nombre_persona ?><br>
                                        
                                        <img id="" class="preview_producto"  src="data: <?php echo $usuario[0]->img_type ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode( $usuario[0]->img ) ?>" style="width:50%" />
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        
                                        <label>
                                            <select name="estado" class="form-control">
                                                <?php 
                                                    if( $usuario[0]->usuario_estado ==1 ){ 
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

                 
                            </div>

                            <div class="col-lg-4">
                                <i class="fa fa-info-circle"></i> Vincular Roles al Usuario.
                                <br><br> <b> <h4> Lista Roles </h4> <b>
                                <?php
                                foreach ($roles as $key => $rol) {
                                    ?>
                                    <label class="btn btn-info label-lg" onClick="agregar_rol(<?php echo $rol->id_rol; ?>,'agregar');" style="margin-top:2px;" name="agregar" id="<?php echo $rol->id_rol; ?>">
                                        <?php echo $rol->role; ?>
                                    </label>
                                    <?php
                                }
                                ?>

                                <br><br> <b> <h4>Roles Asignados</h4> </b>
                                <span class="roels_asignados">
                                <?php
                                $cont =1;                                
                                foreach ($usuario_roles as $ur) {   
                                    ?>
                                    <label class="btn btn-success label-lg" onClick="agregar_rol(<?php echo $ur->id_rol; ?>, 'remover');" style="margin-top:2px;margin-left:2px;" name="remover" id="<?php echo $ur->id_rol; ?>">
                                        <?php echo $ur->role; ?>
                                    </label>
                                    
                                    <?php
                                    $cont ++;
                                }
                                ?>
                                </span>
                            </div>
                        </div>

                        <div class="panel-footer text-right">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="button" name="<?php echo base_url() ?>admin/usuario/update" data="usuario" class="btn btn-warning enviar_data" value="Guardar">                             
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        </form>
        <?php $this->load->view('notificaciones/success'); ?>
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


<!-- Modal Large CLIENTES MODAL-->
   <div id="error" tabindex="-1" role="dialog" aria-labelledby="error"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header bg-info-dark">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title"><i class="fa fa-warning fa-fw"></i> Notificación</h4>
            </div>
            <div class="modal-body">
               <p style="text-align: center; font-size: 18px;" class="notificacion_texto"></p>
            </div>
            <div class="modal-footer bg-gray">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->