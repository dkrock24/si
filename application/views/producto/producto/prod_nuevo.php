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
                            if(item.tipo_atributo == 'radio'){
                                $(".giro_atributos").append(html_template_radio(item.id_prod_atributo , plantilla));
                            }
                            if(item.tipo_atributo == 'check'){
                                $(".giro_atributos").append(html_template_check(item.id_prod_atributo , plantilla));
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

    $(document).on('click', '.deletePrecio', function(){

        html_remove_precios($(this).attr('name'));
    
    });

    // Dibuja los precios y utlidades en la pantalla de nuevo cliente
    var html_cliente2;
    var obj_cliente;
    var obj_sucursales;
    var contador = 0;
    $("#AgregarPrecios").click(function(){
        
        contador++;
        var cliente = html_get_cliente(contador);
        var sucursal = html_get_sucursal(contador);
        var html = "<tr id='"+contador+"'>"+
                    "<td>"+contador+"</td>"+
                    "<td><select name='presentacion"+contador+"' class=''><option>Docena</option></select></td>"+
                    "<td><input type='text' size='5' name='factor"+contador+"' class=''></td>"+
                    "<td><input type='text' size='5' name='precio"+contador+"' class=''></td>"+
                    "<td><input type='text' size='10' name='cbarra"+contador+"' class=''></td>"+
                    "<td>"+cliente+"</td>"+
                    "<td>"+sucursal+"</td>"+
                    "<td>$</td>"+
                        "<td>"+
                            "<div class='btn-group mb-sm'>"+
                               " <a href='#' class='btn btn-danger btn-sm deletePrecio' name='"+contador+"'><i class='fa fa-trash'></i></a>"+

                           " </div>"+
                 "   </td>"+
                " </tr>";
        $(".preciosTable").append(html);
    });

    // Remover los precios por presentacion de la tabla
    function html_remove_precios( id_tr ){
        $('table#preciosTable tr#'+id_tr).remove();
    }

    // Dibujar Objeto Select del Cliente
    function html_get_cliente (contador){
        html_cliente = '<select name="cliente'+contador+'">';
        $.each(JSON.parse(obj_cliente), function(i, item) {                    
            html_cliente += '<option value='+item.id_cliente+'>'+item.nombre_empresa_o_compania+'</option>';
        });
        html_cliente += "</select>";
        html_cliente2 =html_cliente;

        return html_cliente2 ;
    }

    // Dibujar Objeto select del Sucursal
    function html_get_sucursal (contador){
        html_sucursal = '<select name="sucursal'+contador+'">';
        $.each(JSON.parse(obj_sucursales), function(i, item) {                    
            html_sucursal += '<option value='+item.id_sucursal+'>'+item.nombre_sucursal+'</option>';
        });
        html_sucursal += "</select>";
        html_sucursal2 =html_sucursal;

        return html_sucursal2 ;
    }
    
    // Llamadas de funciones catalogos
    get_cliente(); 
    get_sucursal();

    // Obtener los clientes desde la base de datos mediante Ajax
    function get_cliente(){
        
        $.ajax({
            url: "get_clientes",  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  
                obj_cliente = data;

                },
                error:function(){
                }
            });
    }

    // Obtener las sucursales desde la base de datos mediante Ajax
    function get_sucursal(){
        
        $.ajax({
            url: "get_sucursales",  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  
                obj_sucursales = data;

                },
                error:function(){
                }
            });
    }

    // Dibuja los atributos de tipo TEXT
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
    
    // Dibuja los atributos de tipo SELECT
    function html_template_select(id , plantilla){
        
        var opciones="";
        var nombre =  "";
        
        $.each(plantilla, function(i, item) {
            
            if(id == item.id_prod_atributo){
                nombre = item.nam_atributo;
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

    // Dibuja los atributos de tipo RADIO
    function html_template_radio(id , plantilla){
        
        var opciones="";
        var nombre =  "";
        
        $.each(plantilla, function(i, item) {
            
            if(id == item.id_prod_atributo){
                nombre = item.nam_atributo;
                opciones += '<input type="radio" class="" name="'+item.id_prod_atributo+'" value="'+nombre+'"/>'+item.attr_valor+'<br>';    
            }            
        });

        var html_template ="";
        html_template = '<div class="col-sm-3">'+
                            '<div class="form-group">'+
                            '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">'+ nombre +'</label><br>'+
                            '<div class="col-sm-offset-1 col-sm-11">'+
                                opciones+
                            '</div>'+
                            '<span class="col-sm-1 control-label no-padding-right"></span>'+
                            '</div>'+
                            '</div>';
        return html_template;
    }

    // Dibuja los atributos de tipo CHECK -- PENDIENTE
    function html_template_radio(id , plantilla){
        
        var opciones="";
        var nombre =  "";
        
        $.each(plantilla, function(i, item) {
            
            if(id == item.id_prod_atributo){
                nombre = item.nam_atributo;
                opciones += '<input type="radio" class="" name="'+item.id_prod_atributo+'" value="'+nombre+'"/>'+item.attr_valor+'<br>';    
            }            
        });

        var html_template ="";
        html_template = '<div class="col-sm-3">'+
                            '<div class="form-group">'+
                            '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">'+ nombre +'</label><br>'+
                            '<div class="col-sm-offset-1 col-sm-11">'+
                                opciones+
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

                        <!-- INICIO MENU IZQUIERDO -->
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
                        <!-- FIN MENU IZQUIERDO -->

                        <form class="form-horizontal" action='crear' method="post">
                        
                        <!-- INICIO PRODUCTO ENCABEZADO -->
                        <div class="col-lg-9">
                           
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Producto General:  </div>
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
                                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Giro</label>
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
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Marca</label>
                                                    <div class="col-sm-8">                                                        
                                                        <select class="form-control" id="marca" name="marca">   
                                                            <?php
                                                            foreach ($marcas as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_marca; ?>"><?php echo $value->nombre_marca; ?>     
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        
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

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Relacion</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="procuto_asociado" id="procuto_asociado" class="form-control">
                                                        
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-7 col-sm-3">
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                    
                                    </p>
                            </div>
                          
                        </div>
                        <!-- FIN PRODUCTO ENCABEZADO -->

                        <!-- INICIO PRODUCTO ATRIBUTOS -->
                        <div class="col-lg-9">
                           
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Producto Atributos:  </div>
                                <div class="row">
                                    <p class="form-horizontal giro_atributos">
                                    </p>
                                </div>
                            </div>
                          
                        </div>
                        <!-- FIN PRODUCTO ATRIBUTOS -->

                        <!-- INICIO PRODUCTO PRECIOS -->
                        <div class="col-lg-9 alenado-left">
                           
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Producto Precios :  </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                      <div class="panel panel-default">
                                         
                                         <div class="panel-body">
                                            <div class="table-responsive">
                                               <table class="table table-hover" id="preciosTable">
                                                  <thead>
                                                     <tr>
                                                        <th>#</th>
                                                        <th>Presentacion</th>
                                                        <th>Factor</th>
                                                        <th>Precio</th>
                                                        <th>Code Barra</th>
                                                        <th>Cliente</th>
                                                        <th>Sucursal</th>
                                                        <th>Utilidad</th>
                                                        <th>
                                                            <div class="btn-group">
                                                            
                                                                <a href="#" id="AgregarPrecios" class="btn btn-default">Agregar</a>
                                                          
                                                            </div>  
                                                        </th>
                                                     </tr>
                                                  </thead>
                                                  <tbody class="preciosTable">
                                                                                                     
                                                  </tbody>
                                               </table>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                            </div>
                          
                        </div>
                        <!-- FIN PRODUCTO PRECIOS -->

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

