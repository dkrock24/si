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
                    
                    //$(".giro_atributos").append('<div class="col-sm-3">' );
                    var id_producto = 0;
                    $.each(plantilla, function(i, item) {  

                        if(id_producto != item.id_prod_atributo){
                            if(item.tipo_atributo == 'text' ||  item.tipo_atributo == 'file'){                            
                                $(".giro_atributos").append( html_template_text(item) );
                            }
                            if(item.tipo_atributo == 'select'){
                                $(".giro_atributos").append(html_template_select(item.id_prod_atributo , plantilla));
                            }
                            id_producto = item.id_prod_atributo;
                        }
                        
                    });

                   // $(".giro_atributos").append( '</div>' );
                
                },
                error:function(){
                }
            });
    });

    function html_template_text(item){
        var html_template ="";
        html_template = '<div class="col-sm-3">'+
                            '<div class="form-group">'+
                            '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">'+item.nam_atributo+'</label><br>'+
                            '<div class="col-sm-offset-1 col-sm-11">'+
                                '<input type="'+item.tipo_atributo+'" name="'+item.id_prod_atributo+'"  class="form-control '+item.nam_atributo+'">'+
                            '</div>'+
                            '<span class="col-sm-1 control-label no-padding-right"></span>'+
                            '</div>'+
                            '</div>';
        return html_template;
    }
    
    function html_template_select(id , plantilla){
        
        var opciones="";
        var nombre =  "";
        
        $.each(plantilla, function(i, item) {
            
            if(id == item.id_prod_atributo){
                nombre = item.nam_atributo
                opciones += '<option>'+item.attr_valor+'</option>';    
            }            
        });

        var html_template ="";
        html_template = '<div class="col-sm-3">'+
                            '<div class="form-group">'+
                            '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">'+ nombre +'</label><br>'+
                            '<div class="col-sm-offset-1 col-sm-11">'+
                                '<select name="'+id+'" class="form-control '+nombre+'">'+opciones+'</select>'+
                            '</div>'+
                            '<span class="col-sm-1 control-label no-padding-right"></span>'+
                            '</div>'+
                            '</div>';
        return html_template;
    }

    $(document).on('change', '.Imagen', function()
    {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
              $('.preview_producto').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }



  });

</script>
<style type="text/css">
    .icon-center{
        text-align: center;
    }
    .menu-cuadro{
        width: 40%;
        border:0px solid black;
        text-align: center;
        margin-left: 7%;
    }
    .menu-cuadro:hover{        
        color:#23b7e5;
    }

    .preview_producto{
        width: 100%;
    }
    .alenado-left{
        float: right;
    }
</style>
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

                        <div class="col-lg-3">
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Nuevo Producto :  </div>
                                
                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-basket icon-center"></h1>
                                        <span class="icon-center">Producto</span>
                                    </div>

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-book-open icon-center"></h1>
                                        <span class="icon-center">Categoria</span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-social-dropbox icon-center"></h1>
                                        <span class="icon-center">Cant. Producto</span>
                                    </div>

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-doc icon-center"></h1>
                                        <span class="icon-center">Sub Categoria</span>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">
                                            <i class="fa fa-barcode"></i>
                                        </h1>
                                        <span class="icon-center">Cod. Barra</span>
                                    </div>
                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">
                                            <i class="fa fa-plus-square"></i>
                                        </h1>
                                        <span class="icon-center">Combo</span>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">
                                            <i class="icon-note"></i>
                                        </h1>
                                        <span class="icon-center">Existencias</span>
                                    </div>

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">
                                            <i class="icon-note"></i>
                                        </h1>
                                        <span class="icon-center">Promociones</span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-social-dropbox icon-center"></h1>
                                        <span class="icon-center">Kit Producto</span>
                                    </div>
                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">                                            
                                            <i class="fa fa-cubes"></i>
                                        </h1>
                                        <span class="icon-center">Promo Detalle</span>
                                    </div>

                                </div>

                                <div class="row">
                                    <br>
                                    <hr>
                                    <br>
                                    <div class="col-sm-12">
                                        <img src="" name="" id="" class="preview_producto" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <form class="form-horizontal" action='crear' method="post">
                        
                        <div class="col-lg-9">
                           
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Nuevo Producto :  </div>
                                    <p>
                                    
                                        <input type="hidden" name="empresa" value="" id="id_empresa">
                                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Nombre</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="name_entidad" name="name_entidad" placeholder="Nombre Producto" value="">
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div> 
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Empresa</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="empresa" name="empresa">
                                                            <option value="0">Empresa</option>
                                                            <?php
                                                            foreach ($empresa as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_empresa; ?>"><?php echo $value->nombre_razon_social; ?>     
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>  
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Linea</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="giro" name="giro">
                                                           
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>  
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Categoria</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="categoria" name="categoria">
                                                          <option value="0">Seleccione</option>
                                                            <?php
                                                            foreach ($categorias as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_categoria; ?>"><?php echo $value->nombre_categoria; ?>     
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Sub Categoria</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="sub_categoria" name="sub_categoria">
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Relacion</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="" id="procuto_asociado" class="form-control">
                                                        <!--<select class="form-control" id="empresa" name="empresa">   
                                                            <?php
                                                            foreach ($lineas as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_linea; ?>"><?php echo $value->tipo_producto; ?>     
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select> -->
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Proveedor1</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="proveedor1" name="proveedor1">   
                                                            <?php
                                                            foreach ($proveedor as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_proveedor; ?>"><?php echo $value->empresa; ?>     
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Proveedor2</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="proveedor2" name="proveedor2">   
                                                            <?php
                                                            foreach ($proveedor as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_proveedor; ?>"><?php echo $value->empresa; ?>     
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Estado</label>
                                                    <div class="col-sm-8">
                                                        
                                                        <label>
                                                            <select name="producto_estado" class="form-control">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </label>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-9 col-sm-2">
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                        </div>

                                    
                                    </p>
                            </div>
                          
                        </div>

                        <div class="col-lg-9">
                           
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Atributos Producto :  </div>
                                <div class="row">
                                    <p class="form-horizontal giro_atributos">
                                    </p>
                                </div>
                            </div>
                          
                        </div>

                        <div class="col-lg-9 alenado-left">
                           
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Precios :  </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                      <div class="panel panel-default">
                                         
                                         <div class="panel-body">
                                            <div class="table-responsive">
                                               <table class="table table-hover">
                                                  <thead>
                                                     <tr>
                                                        <th>#</th>
                                                        <th>Presentacion</th>
                                                        <th>Factor</th>
                                                        <th>Precio</th>
                                                        <th>Cliente</th>
                                                        <th>Sucursal</th>
                                                        <th>Utilidad</th>
                                                        <th>
                                                            <div class="btn-group">
                                                               <button type="button" class="btn btn-default">Opcion</button>
                                                               <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-default">
                                                                  <span class="caret"></span>
                                                                  <span class="sr-only">default</span>
                                                               </button>
                                                               <ul role="menu" class="dropdown-menu">
                                                                  <li><a href="nuevo">Agregar</a></li>
                                                                  <li><a href="nuevo">Buscar</a></li>
                                                                  </li>
                                                               </ul>
                                                            </div>  
                                                        </th>
                                                     </tr>
                                                  </thead>
                                                  <tbody>
                                                     <tr>
                                                        <td>1</td>
                                                        <td>Mark</td>
                                                        <td>Otto</td>
                                                        <td>@mdo</td>
                                                        <td>1</td>
                                                        <td>Mark</td>
                                                        <td>Otto</td>
                                                        <td>
                                                            <div class="btn-group mb-sm">
                                                                <a href="#" class="btn btn-warning btn-sm" alt="Editar"><i class="fa fa-edit"></i></a>
                                                                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-copy"></i></a>
                                                                <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                
                                                            </div>
                                                        </td>
                                                     </tr>                                                     
                                                  </tbody>
                                               </table>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                            </div>
                          
                        </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
