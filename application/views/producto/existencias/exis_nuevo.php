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
                url: "get_productos_lista/"+2+"/"+texto,
                datatype: 'json',      
                cache : false,                

                success: function(data){
                    var datos = JSON.parse(data);
                    var productos = datos["productos"];
                    var producto_id = 0;
                    _productos_lista = productos;
                    $('.dataSelect').show();
                
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
                    //table_tr += '<tr><td>'+contador_precios+'</td><td>'+item.name_entidad+'</td><td>'+item.cod_barra+'</td><td>'+item.id_entidad+'</td><td>'+item.cantidad+'</td><td>'+item.nombre_marca+'</td><td>'+item.nombre_categoria+'</td><td>'+item.SubCategoria+'</td><td>'+item.nombre_giro+'</td><td>'+item.nombre_razon_social+'</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_producto" id="'+item.id_entidad+'">Agregar</a></td></tr>';
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
            $("#producto_buscar").val(this.value);
            $('.dataSelect').hide();
            $('.dataSelect').empty();
            $(".producto_buscar").focus();
        }
        
    });

/* 4 - Buscar producto por Id para agregarlo a la linea */
    function get_producto_completo(producto_id){
      $("#grabar").attr('disabled');
        var codigo,presentacion,tipo,precioUnidad,descuento,total

        /*
        * Identificadores de valores del producto
        * 1 = Presentacion / 10 = Modelo / 14 = Costo / 18 = Almacenaje / 19 = Minimos
        * 20 = Medios / 21= maximos / 22 = Descuento Limite / 23 = Precio Venta
        * 24 = Iva / 26 = Incluye / 11 = Imagen / 4 = Cod_Barras
        */

        $.ajax({
            url: "get_producto_completo/"+producto_id,
            datatype: 'json',      
            cache : false,                

            success: function(data){
                var datos = JSON.parse(data);
                var contador =1;
                var existencias_total=0;
                var html='';
                console.log(datos);
                $.each(datos['producto'], function(i, item) { 
                    console.log(contador);
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
            
            //table_tr += '<tr><td>'+contador_precios+'</td><td>'+item.presentacion+'</td><td><div class="pull-center label label-success">'+item.factor+'</div></td><td>'+item.precio+'</td><td>'+item.unidad+'</td><td>'+item.cod_barra+'</td><td>'+item.estado_producto_detalle+'</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_presentacion" id="'+item.id_producto_detalle+'">Seleccionar</a></td></tr>';
            table_tr += '<option value="'+item.id_producto_detalle+'">'+item.presentacion+'</option>';
            contador_precios++;
            
        });
        $(".dataSelect2").html(table_tr);
        $('.dataSelect2').show();
        $('.dataSelect2').focus();
        
    }


/* 6 - Selecionado Presentacion de la lista y precionando ENTER */
    $(document).on('keypress', '.dataSelect2', function(){

        if ( event.which == 13 ) {
            var precio_id = this.value;
            event.preventDefault();
            $('.dataSelect2').hide();
            $('.dataSelect2').empty();
            $(".producto_buscar").focus();

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

// 7 - Grabar producto en la orden
    $(document).on('click', '#grabar', function(){
        
        $('.uno').find('input').each(function(){
            this.value = '';    
            $("#grabar").val("Agregar");        
            $("#cantidad").val(1);                  
        });
        
        if(_productos != null){
            if(contador_productos==0){
                
                _orden[contador_productos] = _productos;
                
                agregar_producto();

            }else{  
                                        
                var existe =0;
                var cnt = 0;

                if(_productos.length == 0){
                    
                    if(_orden.length >= 1){
                        
                        $.each(_orden, function(i, item) {

                            if(item.producto2 == _productos.producto2 ){
                                existe = 1;

                                //Actualizando Cantidad
                                var cantidad = parseInt(_productos.cantidad) + parseInt($("."+_productos.producto2).text());
                                
                                $("."+_productos.producto2).text(cantidad);
                                _orden[cnt]['cantidad'] = cantidad;

                                

                                $(".total"+_orden[cnt]['producto2']).text(calcularTotalProducto(_productos.presentacionPrecio, cantidad));

                                //total_msg += parseInt(calcularTotalProducto(_productos['presentacionPrecio'], cantidad));

                                // Buscar precios validos
                                /*
                                if(_productos_precio != null){
                                    alert(1);
                                    $.each(_productos_precio, function(i, item) {
                    
                                        factor = item.factor;
                                        if( factor == cantidad ){
                                            alert(2);
                                            factor_precio = item.unidad;
                                            factor_total  = item.precio; 

                                            $(".total"+_orden[cnt]['producto']).text(calcularTotalProducto(factor_precio, cantidad));
                                            $(".precioUnidad"+_orden[cnt]['precioUnidad']).text(factor_precio);
                                
                                            
                                        }else{
                                            alert(3);
                                            //Actualizando total
                                            $(".total"+_orden[cnt]['producto']).text(calcularTotalProducto(_productos['precioUnidad'], cantidad));
                                            $(".precioUnidad"+_orden[cnt]['precioUnidad']).text(_productos['precioUnidad']);
                                            
                                
                                            total_msg += parseInt(calcularTotalProducto(_productos['precioUnidad'], _productos['cantidad']));
                                        }
                                    });
                                }else{
                                    alert(4);
                                    //Actualizando total
                                    $(".total"+_orden[cnt]['producto']).text(calcularTotalProducto(_productos['precioUnidad'], cantidad));
                                    $(".precioUnidad"+_orden[cnt]['precioUnidad']).text(_productos['precioUnidad']);
                                
                                    total_msg += parseInt(calcularTotalProducto(_productos['precioUnidad'], _productos['cantidad']));
                                }*/

                            }
                            cnt ++;             
                        });
                    }else{
                        _orden[contador_productos] = _productos;
                        
                        //total_msg += parseInt(_productos['precioUnidad']);
                        agregar_producto();
                    }
                }
                if(existe==0)
                {
                    _orden[contador_productos] = _productos;
                    
                    //total_msg += parseInt(_productos['precioUnidad']);
                    agregar_producto();
                    existe=0;
                }

            }
        
        }
    });

// General - Set Calculo Precio
    function set_calculo_precio(precioUnidad, producto_cantidad_linea){
        $("#total").val(calcularTotalProducto(precioUnidad, producto_cantidad_linea));
    }

// Actualizar la cantidad
    $(document).on('change', '#cantidad', function(){

        if( _productos.producto != null ){
            producto_cantidad_linea = $("#cantidad").val();
            var producto_precio_flag = productos_precios_validacion();

            //if(producto_precio_flag != true){

                var precion  = $("#precioUnidad").val();
                var cantidad = producto_cantidad_linea;
                var cantidad = $("#cantidad").val();

                $("#total").val(calcularTotalProducto( _productos.presentacionPrecio, cantidad));
                $("#precioUnidad").val( _productos.precioUnidad );


                
                _productos.cantidad = cantidad;
                _productos.total = $("#total").val();

                factor_precio = 0;
                factor_total = 0;

            //}
        }
        
    });

// total Producto
    function calcularTotalProducto(precio , cantidad){
        var total = (precio * cantidad);
        return total;
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
            var tr_html = "<tr class='' style='background-color:#d7e1e8;'>";
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

// Remover los Productos de la lista.
    $(document).on('click', '.eliminar', function(){
        var producto_id = $(this).attr('name');
        _orden.forEach(function(element) {
            if(element.producto == producto_id){

                total_msg -= parseInt(calcularTotalProducto(element.precioUnidad, element.cantidad));
                $(".total_msg").text("$ "+total_msg.toFixed(2));
                
                _orden.splice(_orden.indexOf(element), 1);
                depurar_producto();
                
            }
            
        });
    });



    
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
        position: relative;
        display: none;
    }
</style>

<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; ">Orden </h3>
        <div class="row">
           <div class="col-lg-12 col-md-12">
              <!-- Team Panel-->
              <div class="panel panel-default">
                 <div class="panel-heading" style="background: #8dddf5;">
                    <div class="pull-right">
                       <div class="label label-success">Fecha <?php echo Date("Y-m-d"); ?></div>
                    </div>
                    <div class="panel-title">Consultar Existencias<span style="float: right;"><?php //echo gethostbyaddr($_SERVER['REMOTE_ADDR'])  ; ?></span> </div>
                 </div>

                 <!-- START panel-->
                
                <!-- END panel-->

             
                 <div class="panel-body">
                    <!-- START table-responsive-->
                        <div class="table-responsive" >
                           <table class="table table-sm table-hover">
                            <div class="col-lg-4">
                                <input type="text" class="form-control border-input producto_buscar" name="producto_buscar" width="100%">
                                <select multiple="" class="form-control dataSelect">

                                </select>

                                <select multiple="" class="form-control dataSelect2">

                                </select>
                            </div>
  
                            </span>
                            
                              <thead>
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
                    <!-- END table-responsive-->
                 </div>
                 <div class="panel-footer text-center">
                    <a href="#" class="btn btn-primary btn-oval">Seleccionar</a>
                    <a href="#" class="btn btn-success btn-oval">Volver</a>
                    <a href="#" class="btn btn-info btn-oval">kardex</a>
                 </div>
              </div>
              <!-- end Team Panel-->
           </div>
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

<!-- Modal Large PRODUCTOS MODAL-->
   <div id="producto_modal" tabindex="-1" role="dialog" aria-labelledby="producto_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Buscar Producto</h4>
            </div>
            <div class="modal-body">
                <p class="productos_lista_datos">
                    
                </p>                                 
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

<!-- Modal Large PRESENTACIONES MODAL-->
   <div id="presentacion_modal" tabindex="-1" role="dialog" aria-labelledby="presentacio_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Selecionar Tipo de Presentacion</h4>
            </div>
            <div class="modal-body">
                <p class="presentacion_lista_datos">
                    
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
   <div id="cliente_modal" tabindex="-1" role="dialog" aria-labelledby="cliente_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Buscar Cliente</h4>
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

<!-- Modal Large VENDEDORES MODAL-->
   <div id="vendedores_modal" tabindex="-1" role="dialog" aria-labelledby="vendedores_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Buscar Empleado</h4>
            </div>
            <div class="modal-body">
                <p class="vendedor_lista_datos">
                    
                </p>                                 
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

