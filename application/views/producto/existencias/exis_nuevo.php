<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script>

    var _orden = {};
    var _productos = {};
    var _productos_precio = [];
    var _productos_lista;
    var contador_productos = 0;
    var contador_tabla =1;
    var total_msg = 0.00;
    var factor_precio = 0;
    var factor_total = 0;
    var producto_cantidad_linea = 1;
    var sucursal = 0;
    var interno_sucursal=0;


    $(document).ready(function(){

        $('#producto_modal').appendTo("body");
        $('#cliente_modal').appendTo("body");
        $('#vendedores_modal').appendTo("body");
        $('#presentacion_modal').appendTo("body");
        $('.dataSelect').hide();
        $('.dataSelect2').hide();
        $(".producto_buscar").focus();

        /* 1 - Input Buscar Producto */
        $(document).on('keyup', '.producto_buscar', function(){
            if($(".producto_buscar").val() != ""){
                search_texto(this.value);
            }

        });    
        /* 2 - Filtrado del texto a buscar en productos */
        function search_texto(texto){

            $('.dataSelect').show();
            sucursal = $("#sucursal_id").val();

            var contador_precios=1;
            var table_tr="";
            if( sucursal != interno_sucursal){

                interno_sucursal = sucursal;
                $.ajax({
                    url: "get_productos_lista/"+texto,
                    datatype: 'json',      
                    cache : false,                

                    success: function(data){
                        var datos = JSON.parse(data);
                        var productos = datos["productos"];
                        var producto_id = 0;
                        _productos_lista = productos;
                    },
                    error:function(){
                    }
                });
            }else{

                var productos = _productos_lista;
                var producto_id = 0;
                interno_sucursal = sucursal;
                $.each(productos, function(i, item) { 

                    var name = item.name_entidad.toUpperCase();
                    var cod_barra = item.cod_barra;

                    if(name.includes(texto.toUpperCase()) || cod_barra.includes(texto)){
                        producto_id = item.id_entidad;  
                        var precio = 0;

                        table_tr += '<option value="'+item.id_entidad+'">'+item.name_entidad+'</option>';
                        contador_precios++;
                    }
                });

                $(".dataSelect").html(table_tr);
            }
        }

        /* 3 - Selecionado Producto de la lista y precionando ENTER */
        $(document).on('keypress', '.dataSelect', function(){

            if ( event.which == 13 ) {

                get_producto_completo(this.value);
                event.preventDefault();
                $('#dataSelect').hide();
                $('.dataSelect').hide();
                $(".producto_buscar").focus();
                $(".producto_buscar").empty();

                $("#producto_buscar").val(this.value);

                $(".producto_buscar").val("");
            }

        });

        $(document).on('keydown', '.producto_buscar', function(){
           if ( event.keyCode == 40 ) {
            $('.dataSelect').focus();
            document.getElementById('dataSelect').selectedIndex = 0;
        }

    });

        /* 4 - Buscar producto por Id para agregarlo a la linea */
        function get_producto_completo(producto_id){

          $("#grabar").attr('disabled');
          var codigo,presentacion,tipo,precioUnidad,descuento,total

          $.ajax({
            url: "get_producto_completo/"+producto_id,
            datatype: 'json',      
            cache : false,                

            success: function(data){
                var datos = JSON.parse(data);
                var contador =1;
                var existencias_total=0;
                var html='';

                $("#nombre_producto").text("Producto : "+datos['producto'][0].name_entidad);
                
                $.each(datos['producto'], function(i, item) { 

                    existencias_total+= parseInt(item.Cantidad);
                    html +='<tr>';
                    html +='<td>'+contador+'</td>';
                    html +='<td>'+item.nombre_sucursal+'</td>';
                    html +='<td>'+item.nombre_bodega+'</td>';
                    html +='<td>'+item.Cantidad+'</td>';
                    html +='<td>'+item.valor+'</td>';
                    html +='<td>'+0.00+'</td>';
                    html +='<td>'+item.valor+'</td>';
                    html +='<td>'+item.Descripcion+'</td>';
                    html +='</tr>';
                    contador++;
                });
                html += '<tr><td colspan="3"></td><td>'+existencias_total+'</td><td colspan="4"></td></tr>'
                $('.uno').html(html);

            },
            error:function(){
            }
        });
      }

      /* 5 - Retornando lista de presentaciones dentro de la tabla */
      function get_presentacio_lista( _productos_precio ){

        var contador_precios=1;
        var table_tr;
        $.each(_productos_precio, function(i, item) { 
            table_tr += '<option value="'+item.id_producto_detalle+'">'+item.presentacion+'</option>';
            contador_precios++;
            
        });
        $(".dataSelect2").html(table_tr);
        $('.dataSelect2').show();
        $('.dataSelect2').focus();
        $('.dataSelect').hide();
        
    }


    /* 6 - Selecionado Presentacion de la lista y precionando ENTER */
    $(document).on('keypress', '.dataSelect2', function(){
        alert(5);
        if ( event.which == 13 ) {
            var precio_id = this.value;
            event.preventDefault();
            $('.dataSelect2').hide();
            $('.dataSelect2').empty();
            $(".producto_buscar").focus();
            $('.dataSelect').hide();


            $.each(_productos_precio, function(i, item) { 

                if(precio_id == item.id_producto_detalle){
                    _productos.presentacion = item.presentacion;
                    _productos.presentacionFactor = item.factor;
                    _productos.presentacionPrecio = item.precio;
                    _productos.presentacionUnidad = item.unidad;
                    _productos.presentacionCliente = item.Cliente;
                    _productos.presentacionCliente = item.Sucursal;
                    _productos.presentacionCodBarra = item.cod_barra;

                    _productos.precioUnidad = item.unidad;
                    _productos.total = item.precio;
                    _productos.producto2 = item.id_producto_detalle

                    $("#presentacion").val( _productos.presentacion );
                    $("#precioUnidad").val( _productos.presentacionUnidad );
                    $("#factor").val(item.factor);

                    set_calculo_precio(item.unidad, item.factor);
                }
            });
        }
    });


// General - Set Calculo Precio
function set_calculo_precio(precioUnidad, producto_cantidad_linea){
    $("#total").val(calcularTotalProducto(precioUnidad, producto_cantidad_linea));
}




function productos_precios_validacion(){

    var factor = 0;
    var precio_unidad = 0;
    var precio_total = 0;
    var flag = false;

    if( _productos_precio != null){

        $.each(_productos_precio, function(i, item) {

            factor = item.factor;
            if( factor == producto_cantidad_linea ){

                factor_precio = item.unidad;
                factor_total  = item.precio; 

                $("#total").val( calcularTotalProducto( factor_precio, factor ) );
                $("#precioUnidad").val( factor_precio ); 
                _productos.cantidad = producto_cantidad_linea;
                flag = true;
            }
        });
    }
    return flag;        
}

function agregar_producto(){

    if(factor_total !=0 && factor_precio!=0){
        _productos.total = factor_total;
        _productos.precioUnidad = factor_precio;
    }

    total_msg += parseFloat(_productos.total);

    $(".total_msg").text("$ "+total_msg);        

    contador_productos++;
    if(_productos != null){
        var tr_html = "<tr class='bg-gray-light' style='background-color:#d7e1e8;'>";
        tr_html += "<td class='border-table-left'>"+contador_tabla+"</td>";
        tr_html += "<td class='border-left'>"+_productos.producto+"</td>";
        tr_html += "<td class='border-left'>"+_productos.descripcion+"</td>";
        tr_html += "<td class='border-left "+_productos.producto2+"'>"+_productos.cantidad+"</td>";
        tr_html += "<td class='border-left'>"+_productos.presentacion+"</td>";
        tr_html += "<td class='border-left'>"+_productos.presentacionFactor+"</td>";
        tr_html += "<td class='border-left precioUnidad"+_productos.precioUnidad+"'>"+_productos.precioUnidad+"</td>";
        tr_html += "<td class='border-left'>"+_productos.descuento+"</td>";
        tr_html += "<td class='border-left total"+_productos.producto2+"'>"+_productos.total+"</td>";
        tr_html += "<td class='border-left '>"+_productos.bodega+"</td>";
        tr_html += "<td class='border-left'><input type='button' class='btn btn-primary btn-xs eliminar' name='"+_productos.producto+"' id='eliminar' value='Eliminar'/></td>";

        tr_html += "</tr>";

        $(".producto_agregados").append(tr_html);

        _productos = {};
        factor_total =0; 
        factor_precio =0;
        contador_tabla++;
    }
}

});
</script>

<style type="text/css">

    .border-left {
        border-left: 1px solid grey;
    }
    .border-right{
        border-right:1px solid grey;
    }
    .border-input{
        border:1px solid grey;
    }
    .border-table-left{
        border-left: 1px solid grey;
    }
    .border-table-right{
        border-right: 1px solid grey;
    }

    .dataSelect , .dataSelect2{
        float: left;
        display: none;
        position: absolute;
    }
</style>
<title><?php echo $title; ?></title>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; ">Existencias </h3>

            <div class="panel-heading menuTop menu_title_bar" style="background: #2D3B48; color: white;">
                <div class="row">

                <div class="col-lg-6 col-md-6">
                    <div class="input-group m-b" style="position: relative;">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input type="text" placeholder="Buscar Producto" name="producto_buscar" class="form-control producto_buscar" autocomplete="off">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="pull-right">

                        <a href="<?php echo base_url().'producto/producto/nuevo' ?>" style='float: right;' class="btn btn-info"><i class="fa fa-arrow-left"></i> Producto</a>
                        <span id="nombre_producto" style="position: relative;float: right;margin-right: 50px;font-size: 20px;"></span>
                    </div>
                </div>
                </div>

            </div>

            <div class="table-responsive" >
                <table class="table table-sm table-hover">
                    <div class="col-lg-4">

                        <select multiple="" class="form-control dataSelect" id="dataSelect">

                        </select>

                        <select multiple="" class="form-control dataSelect2">

                        </select>
                    </div>

                    <thead class="menuTop linea_superior" style="color: black;">
                       <tr>
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Bodega</th>
                        <th>Existencia</th>
                        <th>Costo</th>
                        <th>Costo Anterior</th>
                        <th>Costo utilidad</th>
                        <th>Cod ubicacion</th>                                    
                        </tr>
                    </thead>
                    <tbody class="uno" style="border-bottom: 3px solid grey">

                    </tbody>
                    <tbody class="producto_agregados" style="border-top:  3px solid black" >

                    </tbody>
                </table>
            </div>              

</div>
</section>

<style type="text/css">
    .modal-dialog {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
  }

  .modal-content {
      height: auto;
      min-height: 100%;
      border-radius: 0;
  }
</style>