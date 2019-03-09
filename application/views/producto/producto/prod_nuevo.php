<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script>
  $(document).ready(function(){

    $('#producto_asociado_modal').appendTo("body");

    var html_cliente2;
    var obj_cliente;
    var obj_sucursales;
    var obj_impuesto;
    var incluyeIva = 0;
    var gravado = 0;
    var incluyeIva=0;
    var gravado_contador=0;
    var contador_precios=0;
    var obj_precios_cont=[];

    
    // Llamadas de funciones catalogos
    get_cliente(); 

    $(document).on('click', '#procuto_asociado', function(){
        $('#producto_asociado_modal').modal('show');
        get_productos_lista();
    });


    function get_productos_lista(){
        
        var table = "<table class='table table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Nombre</th><th>Id Producto</th><th>Marca</th><th>Categoria</th><th>Sub Categoria</th><th>Giro</th><th>Empresa</th><th>Action</th>";
        var table_tr = "<tbody id='list'>";
        var contador_precios=1;

        $.ajax({
            url: "get_productos_lista",  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                    var datos = JSON.parse(data);
                    var productos = datos["productos"];
                    
                    $.each(productos, function(i, item) {   

                        table_tr += '<tr><td>'+contador_precios+'</td><td>'+item.name_entidad+'</td><td>'+item.id_entidad+'</td><td>'+item.nombre_marca+'</td><td>'+item.nombre_categoria+'</td><td>'+item.SubCategoria+'</td><td>'+item.nombre_giro+'</td><td>'+item.nombre_razon_social+'</td><td><a href="#" class="btn btn-primary relacionar_producto" id="'+item.id_entidad+'">Relacionar</a></td></tr>';
                        contador_precios++;
                    });
                    table += table_tr;
                    table += "</tbody></table>";

                    $(".productos_lista_datos").html(table);
                
                },
                error:function(){
                }
            });
    }

    // Agregar el Id del producto al input del producto relacionado
    $(document).on('click', '.relacionar_producto', function(){
        var id = $(this).attr("id");
        $("#procuto_asociado").val(id);
        $('#producto_asociado_modal').modal('hide');
    });

    // filtrar producto
    $(document).on('keyup', '#buscar_producto', function(){
        var texto_input = $(this).val();

        $("#list tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(texto_input) > -1)
        });

        
    });

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

          $.ajax({
            url: "get_categorias_empresa/"+id,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  
                var datos = JSON.parse(data);
                  
                $("#categoria").empty();
                $("#categoria").append('<option value="0">Selecione Categoria</option>');
                $.each(JSON.parse(data), function(i, item) {                    
                    $("#categoria").append('<option value='+item.id_categoria+'>'+item.nombre_categoria+'</option>');
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

    // Calculando utilidad de Productos Dinamicamente
    $(document).on('keyup', '.calculoUtilidad' , function(){
        var contador = $(this).attr('id');

        // calculando utilidad para el precio especifico
        calculoUtilidad(contador);

    });

    // Calculo general de los valores en la tabla de los precios
    function calculoUtilidad(contador){

        var factor = $('input[name*=factor'+contador+']').val();
        var unidad = $('input[name*=unidad'+contador+']').val();
        var precio = $('input[name*=precio'+contador+']').val();
        var costo  = $('input[name*=14]').val();
        var total  = (factor * unidad);
        var x;

        if( gravado==1 && incluyeIva!=0 ){

            //Remover IVA del precio del producto
            x = ( unidad / incluyeIva );

            var utilidad  = x - costo ;
        }else{

            var utilidad  = ( total / factor ) - costo ;
        }        

        $('.precio'+contador).val((total).toFixed(2));
        $('.utilidad'+contador).val((utilidad).toFixed(2));
    }

    // Calcula la utilidad posterior al agregar precios a la tabla de factores
    function calcularUtilidadPosPrecios(){

        //Recorremos los precios exstentes para actualizar sus valores dinamicamente
        obj_precios_cont.forEach(function(element) {

            calculoUtilidad(element);
                    
        });

    }

    //Validar si Gravado Y Quitar Iva estan set
    $(document).on('click','.check26', function(){
        //Position [0] es iva
        
        incluyeIva = obj_impuesto[0].porcentage;
        var checked =1;
        $('.check26').attr('checked');
        $('input[name*=26]').val("1");
        // Validando si es gravado
        gravado = $('select[name*=24]').val();
        if(gravado == 'Gravados' && gravado_contador==0){
            gravado = 1;
            gravado_contador=1;
            if(obj_precios_cont.length > 0){
                
                calcularUtilidadPosPrecios();
            }
        }else{
            gravado = 0;
            gravado_contador=0;
            $('input[name*=26]').val("0");
            if(obj_precios_cont.length > 0){
                
                calcularUtilidadPosPrecios();
            }
        }
    });

    // Dibuja los precios y utlidades en la pantalla de nuevo cliente
    var contador = 0;
    $("#AgregarPrecios").click(function(){
        
        contador++;
        
        obj_precios_cont.push(contador);
        console.log(obj_precios_cont);

        var cliente = html_get_cliente(contador);
        var sucursal = html_get_sucursal(contador);
        var html = "<tr id='"+contador+"'>"+
                    "<td>"+contador+"</td>"+
                    "<td><input type='text' size='10' name='presentacion"+contador+"' class=''/></td>"+
                    "<td><input type='text' size='3' name='factor"+contador+"' class=''></td>"+
                    "<td><input type='text' size='3' name='unidad"+contador+"' class='calculoUtilidad' id='"+contador+"'></td>"+
                    "<td><input type='text' size='4' name='precio"+contador+"' class='precio"+contador+"' value=''></td>"+
                    
                    "<td><input type='text' size='5' name='cbarra"+contador+"' class=''></td>"+
                    "<td>"+cliente+"</td>"+
                    "<td>"+sucursal+"</td>"+
                    "<td><input type='text' size='4' name='utilidad"+contador+"' readonly class='utilidad"+contador+"' value=''/></td>"+
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
        
        obj_precios_cont.forEach(function(element) {

            if(id_tr == element ){
                
                obj_precios_cont.splice( obj_precios_cont.indexOf(element), 1 );
            }
                    
        });
        contador_precios -= 1;
    }

    // Dibujar Objeto Select del Cliente
    function html_get_cliente (contador){
        html_cliente = '<select name="cliente'+contador+'">';
        html_cliente+='<option value=""> - </option>';

        $.each(obj_cliente, function(i, item) {                    
            html_cliente += '<option value='+item.id_cliente+'>'+item.nombre_empresa_o_compania+'</option>';
        });

        html_cliente += "</select>";
        html_cliente2 =html_cliente;

        return html_cliente2 ;
    }

    // Dibujar Objeto select del Sucursal
    function html_get_sucursal (contador){
        html_sucursal = '<select name="sucursal'+contador+'">';
        html_sucursal+='<option value=""> - </option>';
        $.each(obj_sucursales, function(i, item) {                    
            html_sucursal += '<option value='+item.id_sucursal+'>'+item.nombre_sucursal+'</option>';
        });
        html_sucursal += "</select>";
        html_sucursal2 =html_sucursal;

        return html_sucursal2 ;
    }

    // Obtener los clientes desde la base de datos mediante Ajax
    function get_cliente(){
        
        $.ajax({
            url: "get_clientes",  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  
                    var datos     = JSON.parse(data);

                    obj_cliente = datos['cliente'];
                    obj_sucursales = datos['sucursal'];
                    obj_impuesto = datos['impuesto'];

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
                opciones += '<option value="'+item.attr_valor+'">'+item.attr_valor+'</option>';    
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
    function html_template_check(id , plantilla){
        
        var opciones="";
        var nombre =  "";
        
        $.each(plantilla, function(i, item) {
            
            if(id == item.id_prod_atributo){
                nombre = item.nam_atributo;
                opciones += '<input type="hidden" value="0" name="'+item.id_prod_atributo+'"><input type="checkbox" class="check'+item.id_prod_atributo+'" name="'+item.id_prod_atributo+'"/>'+item.attr_valor+'<br>';    
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

    /* Para Combo
    $(document).on('click', '#combo_class', function(){

        $("#producto_formulario").css("display","none");
        $(".combos_html").css("display","1");
        
    });
    */

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
    .link_btn{
        text-decoration: none;
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
                            <div id="" class="panel panel-info" style="height: 550px;">
                                <div class="panel-heading">Nuevo Producto :  </div>

                                <div class="row">
                                <?php
                                $contador_break=0;
                                foreach ($acciones as $key => $value) {
                                    ?>
                                    <div class="col-sm-6 menu-cuadro " id="<?php echo $value->accion_btn_css; ?>">
                                        <a href="<?php echo base_url().$value->accion_btn_url; ?>" class="link_btn">
                                        <h1 class="icon-center">
                                             <i class="<?php echo $value->accion_btn_icon; ?>"></i>
                                        </h1>
                                        </a>
                                        <span class="icon-center">
                                            <?php echo $value->accion_nombre; ?>
                                        </span>
                                        
                                    </div>
                                    <?php
                                }
                                ?>
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

                        <form class="form-horizontal" enctype="multipart/form-data" action='crear' name='producto_formulario' id="producto_formulario" method="post" >

                        <!-- INICIO PRODUCTO ENCABEZADO -->
                        <div class="col-lg-9">
                           
                            <div id="" class="panel panel-info producto_creacion">
                                <div class="panel-heading">Producto General:  </div>
                                    <p>
                                    
                                        <input type="hidden" name="empresa" value="" id="id_empresa">
                                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Nombre</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="name_entidad" required name="name_entidad" placeholder="Nombre Producto" value="">
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div> 
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Empresa</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="empresa" name="empresa" required>
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
                                                        <select class="form-control" id="giro" name="giro" required>
                                                           
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
                                                        <select class="form-control" id="categoria" name="categoria" required>
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
                                                        <select class="form-control" id="sub_categoria" name="sub_categoria" required>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Marca</label>
                                                    <div class="col-sm-8">                                                        
                                                        <select class="form-control" id="marca" name="marca" required>   
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
                                                        <select class="form-control" id="proveedor1" name="proveedor1" required>   
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
                                                        <select class="form-control" id="proveedor2" name="proveedor2" required>   
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
                                                            <select name="producto_estado" class="form-control" required>
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
                                                     <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Linea</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="linea" name="linea" required>   
                                                            <?php
                                                            foreach ($lineas as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_linea; ?>"><?php echo $value->tipo_producto; ?>     
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
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Relacion</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="procuto_asociado" id="procuto_asociado" class="form-control" required>
                                                        
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
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
                                                        <th>Unidad</th>
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


<!-- Modal Large-->
   <div id="producto_asociado_modal" tabindex="-1" role="dialog" aria-labelledby="producto_asociado_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Lista de Productos</h4>
            </div>
            <div class="modal-body">
                <p class="productos_lista_datos"></p>                                 
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
   <!-- Modal Small-->
