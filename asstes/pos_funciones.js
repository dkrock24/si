
$(document).ready(function(){

	$(document).on('keyup', '.existencia_buscar', function(){
    	/* Busqueda de productos */
        if($(".existencia_buscar").val() != ""){
            search_texto2(this.value);
        }        
    });

    function search_texto2(texto){

        $('.1dataSelect').show();
        sucursal = $("#sucursal_id").val();
        interno_bodega  = $("#bodega_select").val();
        var contador_precios=1;
        var table_tr="";
        if( sucursal != interno_sucursal){
        
            interno_sucursal = sucursal;
            $.ajax({
                url: "get_productos_lista/"+sucursal+"/"+interno_bodega+"/"+texto,
                datatype: 'json',      
                cache : false,                

                success: function(data){
                    var datos = JSON.parse(data);
                    var productos = datos["productos"];
                    var producto_id = 0;
                    _productos_lista = productos;
                    $('.1dataSelect').show();
                
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

            $(".1dataSelect").html(table_tr);
        }
        $("#grabar").focus();
    }

    $(document).on('keypress', '.1dataSelect', function(){
        
        if ( event.which == 13 ) {
            get_producto_completo2(this.value);
            event.preventDefault();
            $(".producto_buscar").empty();
            $('.1dataSelect').hide();
            $('.1dataSelect').empty();
            $(".existencia_buscar").focus();
        }
        
    });

    $(document).on('keydown', '.existencia_buscar', function(){
        /* Validar Codigo Flecha Abajo - Modal Existencias */
         if ( event.keyCode == 40 ) {
            $('.1dataSelect').focus();            
            document.getElementById('1dataSelect').selectedIndex = 0;
         }
    });

    function get_producto_completo2(producto_id){
        /* Mostrar Existencias */
      $("#grabar").attr('disabled');
        var codigo,presentacion,tipo,precioUnidad,descuento,total

        /*
        * Identificadores de valores del producto
        * 1 = Presentacion / 10 = Modelo / 14 = Costo / 18 = Almacenaje / 19 = Minimos
        * 20 = Medios / 21= maximos / 22 = Descuento Limite / 23 = Precio Venta
        * 24 = Iva / 26 = Incluye / 11 = Imagen / 4 = Cod_Barras
        */

        $.ajax({
            url: "<?php echo base_url().'producto/existencias/' ?>get_producto_completo/"+producto_id,
            datatype: 'json',      
            cache : false,                

            success: function(data){
                var datos = JSON.parse(data);
                var contador =1;
                var existencias_total=0;
                var html='';

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
                $('.dos').html(html);

            },
            error:function(){
            }
        });
    }

    $(document).on('keyup', '.producto_buscar', function(){
        /* 1 - Input Buscar Producto */
        if($(".producto_buscar").val() != ""){
            search_texto(this.value);
        }
    });    
    
    /* 2 - Filtrado del texto a buscar en productos */
    function search_texto(texto){

        //$('.dataSelect').show();
        sucursal = $("#sucursal_id").val();
        var bodega = $("#bodega_select").val();
        
        var contador_precios=1;
        var table_tr="";
        if( bodega != interno_bodega){
            
            interno_sucursal = sucursal;
            interno_bodega = bodega;
            $.ajax({
                url: "get_productos_lista/"+sucursal+"/"+bodega+"/"+texto,
                datatype: 'json',      
                cache : false,                

                success: function(data){
                    var datos = JSON.parse(data);
                    
                    _impuestos['cat']=datos["impuesto_categoria"];
                    _impuestos['cli']=datos["impuesto_cliente"];
                    _impuestos['doc']=datos["impuesto_documento"];
                    _impuestos['pro']=datos["impuesto_proveedor"];

                    var productos = datos["productos"];
                    var producto_id = 0;
                    _productos_lista = productos;
                    
                
                },
                error:function(){
                }
            });
        }else{

            var producto_id = 0;
            interno_sucursal = sucursal;
            $.each(_productos_lista, function(i, item) { 

                var name = item.name_entidad.toUpperCase();
                var cod_barra = item.cod_barra;

                if(name.includes(texto.toUpperCase()) || cod_barra.includes(texto)){
                    producto_id = item.id_entidad;  
                    var precio = 0;
                    
                    table_tr += '<option value="'+item.id_entidad+'">'+item.name_entidad+'</option>';
                    contador_precios++;
                }
                $('.dataSelect').show();    
            });            

            $(".dataSelect").html(table_tr);
        }
    }

});