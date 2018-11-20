<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script>
  $(document).ready(function(){

    $("#categoria").change(function(){
          $("#sub_categoria").empty();
          var id = $(this).val();
          $.ajax({
            url: "sub_categoria_byId/"+id,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  //console.log(data);
                  $.each(JSON.parse(data), function(i, item) {                    
                    $("#sub_categoria").append('<option value='+item.id_categoria+'>'+item.nombre_categoria+'</option>');
                });
                
                },
                error:function(){
                }
            });
    });

    $("#empresa").change(function(){
          $("#giro").empty();
          var id = $(this).val();
          $.ajax({
            url: "get_giros_empresa/"+id,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  
                var datos = JSON.parse(data);
                  
                $("#id_empresa").val(datos[0].Empresa);
                $("#giro").append('<option value="0">Selecione Giro</option>');
                $.each(JSON.parse(data), function(i, item) {                    
                    $("#giro").append('<option value='+item.id_giro_empresa+'>'+item.nombre_giro+'</option>');
                });
                
                },
                error:function(){
                }
            });
    });

    // Busca el Giro para dibujar los inputs del producto
    $("#giro").change(function(){
          var id = $(this).val();
          $.ajax({
            url: "get_empresa_giro_atributos/"+id,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                
                    var datos = JSON.parse(data);
                    var plantilla = datos["plantilla"];
                    $(".giro_atributos").empty();
                    $.each(plantilla, function(i, item) {                    
                        $(".giro_atributos").append(
                            '<div class="form-group">'+
                            '<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">'+item.nam_atributo+'</label>'+
                            '<div class="col-sm-8">'+
                                '<input type="text" name="demo" class="form-control">'+
                            '</div>'+
                            '<span class="col-sm-1 control-label no-padding-right"></span>'+
                            '</div>'
                        );
                    });
                
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
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Producto</button> </a> 
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Nuevo</button>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-white">

                        <div class="panel-body">
                            <div class="col-lg-6">
                               
                                <div id="" class="panel panel-info">
                                    <div class="panel-heading">Nuevo Producto :  </div>
                                        <p>
                                        <form class="form-horizontal" action='crear' method="post">
                                            <input type="hidden" name="empresa" value="" id="id_empresa">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="name_entidad" name="name_entidad" placeholder="Nombre Producto" value="">
                                                    <p class="help-block">Nombre Producto.</p>
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Empresa</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="empresa" name="empresa">
                                                        <option value="0">Seleccione Empresa</option>
                                                        <?php
                                                        foreach ($empresa as $value) {
                                                            ?>
                                                            <option value="<?php echo  $value->id_empresa; ?>"><?php echo $value->nombre_razon_social; ?>     
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <p class="help-block">Nombre Empresa.</p>
                                                </div>
                                            </div>  

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Giro</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="giro" name="giro">
                                                       
                                                    </select>
                                                    <p class="help-block">Nombre Giro.</p>
                                                </div>
                                            </div>  

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Categoria</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="categoria" name="categoria">
                                                      <option value="0">Seleccione Categoria</option>
                                                        <?php
                                                        foreach ($categorias as $value) {
                                                            ?>
                                                            <option value="<?php echo  $value->id_categoria; ?>"><?php echo $value->nombre_categoria; ?>     
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <p class="help-block">Categoria.</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Sub Categoria</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="sub_categoria" name="sub_categoria">
                                                    </select>
                                                    <p class="help-block">Sub Categoria.</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                    <label>
                                                        <select name="producto_estado" class="form-control">
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
                                        </form>
                                        </p>
                                </div>
                              
                            </div>

                            <div class="col-lg-6">
                               
                                <div id="" class="panel panel-info">
                                    <div class="panel-heading">Atributos Producto :  </div>
                                        <p class="form-horizontal giro_atributos">
                                        </p>
                                </div>
                              
                            </div>


                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>
