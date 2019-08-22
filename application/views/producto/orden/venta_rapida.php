<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script type="text/javascript">
    var _orden = [];
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
    var interno_bodega= 0;
    var producto_escala;
    var clientes_lista;
    var combo_total = 0.00;
    var combo_descuento = 0.00;
    var _conf = [];
    var _impuestos = [];
</script>
<script src="<?php echo base_url(); ?>../asstes/general.js"></script>
<script src="<?php echo base_url(); ?>../asstes/pos_funciones.js"></script>

<script>

$(document).ready(function(){

    $('#existencias').appendTo("body");
    $('#cliente_modal').appendTo("body");
    $('#vendedores_modal').appendTo("body");
    $('#presentacion_modal').appendTo("body");
    $('#en_proceso').appendTo("body");
    $('#en_reserva').appendTo("body");
    $('.dataSelect').hide();
    $('.dataSelect2').hide();
    $(".producto_buscar").focus();
    $('.1dataSelect').hide();
    $('.1dataSelect2').hide();    
    
    

    $(document).on('keydown', '.producto_buscar', function(){
         if ( event.keyCode == 40 ) {
            $('.dataSelect').focus();
            document.getElementById('dataSelect').selectedIndex = 0;
         }
    });

    /* 3 - Selecionado Producto de la lista y precionando ENTER */
    $(document).on('keypress', '.dataSelect', function(){

        if ( event.which == 13 ) {
            get_producto_completo(this.value);
            event.preventDefault();
            
            $("#producto_buscar").val(this.value);
            $('#dataSelect').hide();
            $('#dataSelect').empty();
            //$(".producto_buscar").focus();
            $("#grabar").focus();
            $(".producto_buscar").val("");
        }
        
    });

    function get_producto_completo(producto_id){
        /* 4 - Buscar producto por Id para agregarlo a la linea */
        $("#grabar").attr('disabled');
    	var codigo,presentacion,tipo,precioUnidad,descuento,total

    	/*
    	* Identificadores de valores del producto
    	* 1 = Presentacion / 10 = Modelo / 14 = Costo / 18 = Almacenaje / 19 = Minimos
    	* 20 = Medios / 21= maximos / 22 = Descuento Limite / 23 = Precio Venta
    	* 24 = Iva / 26 = Incluye / 11 = Imagen / 4 = Cod_Barras
    	*/

    	$.ajax({
            url: "get_producto_completo/"+producto_id+"/"+interno_bodega,
            datatype: 'json',      
            cache : false,                

            success: function(data){
            	var datos = JSON.parse(data);
                //console.log("X -> ",datos['producto']);

                var precio_unidad = datos['producto'][8].valor;
                producto_escala = datos['producto'][0].Escala;
                var prod_precio = datos["prod_precio"];
                _productos_precio = prod_precio;
                _conf.comboAgrupado = parseInt(datos['conf'][0].valor_conf);
                _conf.impuesto = parseInt(datos['impuesto'][0].valor_conf);

                //console.log(datos['producto_imagen']);

                if( parseInt(_productos_precio.length) >= 1 && producto_escala!=1 ){
                    get_presentacio_lista( _productos_precio );
                    
                }else{
                    enLinea();
                }



            		$("#producto").val(datos['producto'][12].valor);
                    $("#bodega").val(datos['producto'][0].nombre_bodega);
            		$("#precioUnidad").val( _productos_precio[0].unidad );
                    
                    $("#descripcion").val(datos['producto'][0].name_entidad +" "+ datos['producto'][0].nombre_marca  );

            		producto_cantidad_linea = 1;
                    $("#cantidad").val(1);
            		precioUnidad = _productos_precio[0].unidad;

                	set_calculo_precio(precioUnidad, producto_cantidad_linea);

                    _productos.producto_id  = datos['producto'][0].id_entidad;
                    _productos.combo        = datos['producto'][0].combo;
                    _productos.inventario_id= datos['producto'][0].id_inventario;
                	_productos.producto     = datos['atributos'].Cod_Barras;
                    _productos.descuento_limite     = datos['atributos'].Descuento_Limite;
                	_productos.descuento    = 0.00;// datos['producto'][7].valor;
                	_productos.cantidad     = producto_cantidad_linea;
                	_productos.total        = 0.00;//$("#total").val();
                    _productos.id_producto_combo = null;
                    _productos.combo_total  = null;
                    _productos.invisible    = 0;
                    _productos.bodega       = datos['producto'][0].nombre_bodega;
                    _productos.id_bodega    = datos['producto'][0].id_bodega;
                    _productos.impuesto_id  = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                    _productos.por_desc     = datos['producto'][0].porcentage;
                    _productos.gen          = datos['producto'][10].valor;
                    _productos.iva          = datos['atributos']['Incluye Iva'];//datos['producto'][9].valor;
                    _productos.descripcion  = datos['producto'][0].name_entidad +" "+ datos['producto'][0].nombre_marca;
                    
                    _productos.total = datos['prod_precio'][0].precio;
                    _productos.categoria    = datos['producto'][0].categoria;

            },
            error:function(){
            }
        });
    }

    function get_presentacio_lista( _productos_precio ){
        /* 5 - Retornando lista de presentaciones dentro de la tabla */
        var contador_precios=1;
        var table_tr;

        if(_productos_precio.length > 1){
            // Productos con una lista de presentaciones
            $.each(_productos_precio, function(i, item) { 
                table_tr += '<option value="'+item.id_producto_detalle+'">'+item.presentacion+'</option>';
                contador_precios++;            
            });
            $(".dataSelect2").html(table_tr);
            $('.dataSelect2').show();
        }else{
            // Productos con 1 Unica Presentacion 
            seleccionar_productos_array(_productos_precio[0].id_producto_detalle);
        }        
        $('.dataSelect2').focus();  

        document.getElementById('dataSelect2').selectedIndex = 0;     
    }

    function enLinea(){
        $("#presentacion").val(_productos_precio[0].presentacion);  
        $("#factor").val(_productos_precio[0].factor);
        _productos.presentacion = _productos_precio[0].presentacion;
        _productos.precioUnidad = _productos_precio[0].unidad;
        _productos.presentacionFactor = _productos_precio[0].factor;
        _productos.id_producto_detalle = _productos_precio[0].id_producto_detalle;

        _productos.presentacionPrecio = _productos_precio[0].precio
        _productos.presentacionUnidad = _productos_precio[0].unidad;
        _productos.presentacionCliente = _productos_precio[0].Cliente;
        _productos.producto2 = _productos_precio[0].id_producto_detalle;
        _productos.presentacionCodBarra = _productos_precio[0].cod_barra;
    }
    
    function validar_escalas( c ){
        /* Valida las escalas de los productos cuando se aunmenta la cantidad */
        var total_precio_escala = 0;

        $.each(_productos_precio, function(i, item) {
            
            pf = parseInt(item.factor);
            if( c == pf ){
                total_precio_escala = item.unidad;
                _productos.presentacion = item.presentacion;
                _productos.presentacionFactor = item.factor;
                _productos.id_producto_detalle = item.id_producto_detalle;
                $("#presentacion").val(item.presentacion);  
                $("#factor").val(item.factor);
            }else{

                if( c >= pf ){
                    total_precio_escala = item.unidad;
                    _productos.presentacionFactor = item.factor;
                    _productos.presentacion = item.presentacion;
                    _productos.id_producto_detalle = item.id_producto_detalle;
                    $("#presentacion").val(item.presentacion);  
                    $("#factor").val(item.factor);
                }                
            }

        });
        return total_precio_escala;
    }

    $(document).on('keypress', '.dataSelect2', function(){
        /* 6 - Selecionado Presentacion de la lista y precionando ENTER */
        if ( event.which == 13 ) {
            var precio_id = this.value;
            event.preventDefault();
            $('.dataSelect2').hide();
            $('.dataSelect2').empty();
            //$(".producto_buscar").focus();
            $("#grabar").focus();

            seleccionar_productos_array(precio_id);
        }
    });

    document.onkeydown = function(e) {
    switch (e.keyCode) {
        case 37:
            //alert('left');
            $(".producto_buscar").focus();
            break;
        case 38:
            //alert('up');
            break;
        case 39:
            //alert('right');
            $("#cantidad").focus();
            break;
        case 40:
            //alert('down');
            break;
    }
};

    // Accesos Directos
    $(document).keypress(function(e){
        //alert(e.keyCode);
        if (e.keyCode == 43 ) { // 43(+)

            //var x = e.keyCode; 
            //var y = String.fromCharCode(x);

            $("#cantidad").focus();
        } 
        if (e.keyCode === 38) { // 46(.)   32(espacio)  

            if(_productos.presentacion != null){
                grabar();
            }
        }
        if (e.keyCode === 95) { // 95(-)

            $("#btn_delete").focus();
            
            $("#eliminar").css("background","black");

            $("button[type=button]").focus(function(){
        
                $(this).css("background","#27c24c");
            });

            $("button[type=button]").blur(function(){
        
                $(this).css("background","#6964bb");
            }); 
            
        }
    });

    $("input[type=text]").focus(function(){
        $(this).css("background","#0f4871");
        $(this).css("color","white");

        $('.dataSelect2').hide();
    });
    $("input[type=text]").blur(function(){
        $(this).css("background","white");
        $(this).css("color","black");
    });

    $("input[type=number]").focus(function(){
        $(this).css("background","#0f4871");
    });

    $("input[type=number]").blur(function(){
        $(this).css("background","white");
    });

    $("button[type=button]").focus(function(){
        
        $(this).css("background","#27c24c");
    });

    $("button[type=button]").blur(function(){
        
        $(this).css("background","#6964bb");
    });

    function seleccionar_productos_array( precio_id ){
        $.each(_productos_precio, function(i, item) { 
            
            if(precio_id == item.id_producto_detalle){

                _productos.presentacion = item.presentacion;
                _productos.id_producto_detalle = item.id_producto_detalle;
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

    $(document).on('click', '#grabar', function(){
        
        grabar();  

        if(_conf.impuesto == 1){
            _config_impuestos();
            depurar_producto();
        }     
        
    });

    function grabar(){
        // 7 - Grabar producto en la orden
        $(".producto_buscar").empty();
        $(".producto_buscar").focus();
        if(_productos.cantidad != null ){           
            _productos.descuento = $("#descuento").val();

            if(contador_productos==0){
                _productos.descuento = $("#descuento").val();
                
                grabar_combo();
                grabar_primeraves();

            }else{ 
                grabar_mas();

                if(_conf.impuesto == 1){
                    _config_impuestos();
                    depurar_producto();
                }                   
            }
        }

        $('.uno').find('input').each(function(){
            
            this.value = '';    
            $("#grabar").val("Agregar");        
            $("#cantidad").val(1);     
        });

    }

    function grabar_primeraves(){        
        
        _orden[contador_productos] = _productos;  
        
        _productos.descuento_calculado = calcular_descuento(_productos.descuento , _productos.total, _productos.descuento_limite);
        
        agregar_producto();
        
    }

    function grabar_mas(){
        var existe =0;
        var cnt = 0;
        
        if(_productos != ""){
           
           contador_productos = _orden.length;

            if(_orden.length >= 1){
                
                $.each(_orden, function(i, item) {
                    
                    if(item.producto2 == _productos.producto2 && item.id_producto_combo==null){
                        existe = 1;
                                         
                        var cantidad = parseInt(_productos.cantidad) + parseInt(item.cantidad);
                        
                        if(producto_escala!=0){

                            var c = validar_escalas(cantidad);

                            _orden[cnt].presentacion        = _productos.presentacion;
                            _orden[cnt].presentacionFactor  = _productos.presentacionFactor;
                            _orden[cnt].precioUnidad        = c;                            
                            
                            var total_temp = calcularTotalProducto(c, cantidad);
                            $(".total"+_orden[cnt]['producto2']).text(total_temp);
                            _orden[cnt]['total'] = total_temp;
                        }else{

                            if(item.combo != 1){
                                var total_temp = calcularTotalProducto(_productos.presentacionPrecio, cantidad);    
                            }                            
                        }
                         _orden[cnt]['total'] = total_temp;

                        _orden[cnt]['cantidad'] = cantidad;

                        if( $("#descuento").val() != ""){
                            _orden[cnt].descuento = $("#descuento").val();
                        }

                        _orden[cnt].descuento_calculado = calcular_descuento(_orden[cnt].descuento , _orden[cnt].total, _orden[cnt].descuento_limite);
                        
                        if(item.combo == 1){

                            var t = (_orden[cnt].precioUnidad * cantidad);

                            if(_conf.comboAgrupado == 1){

                                _orden[cnt].descuento_calculado = calcular_descuento(_orden[cnt].descuento , t , _orden[cnt].descuento_limite);
                                
                            }else{
                                var x = _orden[cnt].combo_total * _orden[cnt].cantidad;

                                _orden[cnt].descuento_calculado = calcular_descuento(_orden[cnt].descuento , x, _orden[cnt].descuento_limite);
                            }
                            
                            _orden[cnt].total =  _orden[cnt].precioUnidad * _orden[cnt].cantidad;
                            
                            //recalcular_factor_combo( item.id_producto_detalle , cantidad  );
                        }

                        calculo_totales();
                        depurar_producto();
                    }
                    
                    cnt ++;             
                });
            }else{
                grabar_combo();

                _productos.descuento = $("#descuento").val();
                _productos.descuento_calculado = calcular_descuento(_productos.descuento , _productos.total, _productos.descuento_limite);

                _orden[contador_productos] = _productos;
                agregar_producto();
                
            }
        }
        if(existe==0)
        {
            grabar_combo();

            _productos.descuento = $("#descuento").val();
            _productos.descuento_calculado = calcular_descuento(_productos.descuento , _productos.total , _productos.descuento_limite);
                
            _orden[contador_productos] = _productos;
            agregar_producto();
            existe=0;

        }
    }

    function grabar_combo(){
        
        if(_productos.combo ==1 ){
            combo_descuento = $("#descuento").val();                     
            producto_combo( _productos.producto_id, _productos.id_bodega , _productos.id_producto_detalle );
        }    
    }

    // ------------------  COMBO

    function producto_combo( producto_id , id_bodega , id_producto_detalle){
        
        $.ajax({
            type: 'POST',
            data: { producto_id :producto_id, id_bodega:id_bodega },
            url: "producto_combo",

            success: function(data){
                var productoX = JSON.parse(data);
                
                if(_conf.comboAgrupado ==0){
                    
                    agregar_directo(id_producto_detalle,productoX);
                }else{
                    
                    agregar_agrupado(id_producto_detalle,productoX);
                    agregar_invisible(id_producto_detalle,productoX);
                }
                
            },
            error:function(){
                alert("Error En Combo");
            } 
        });
    }

    function combo_recalculo_cantidad(id_producto_detalle){
        var cant;
        _orden.forEach(function(element) {
            if(element.id_producto_detalle == id_producto_detalle ){
                cant = element.cantidad;
            }
        });
        return cant;
    }

    function agregar_directo(id_producto_detalle, p){
        var combo_padre_total = 0;
        
        p.forEach(function(datos) {

            var cantidad_final = combo_recalculo_cantidad(id_producto_detalle);

            _productos.descuento_calculado  = 0;
            _productos.id_producto_combo    = id_producto_detalle;
            _productos.id_producto_detalle  = datos['precios'][0].id_producto_detalle;
            _productos.descuento_limite     = datos['atributos'].Descuento_Limite;
            _productos.presentacionCliente  = datos['prod_precio'][0].Cliente;
            _productos.presentacionCodBarra = datos['precios'][0].cod_barra;
            _productos.presentacionPrecio   = datos['precios'][0].precio;
            _productos.presentacionUnidad   = datos['precios'][0].unidad;
            _productos.combo_total          = null;

            _productos.producto2    = datos['precios'][0].id_producto_detalle;            
            _productos.producto_id  = datos['producto'][0].id_entidad;
            _productos.combo        = datos['producto'][0].combo;
            _productos.inventario_id= datos['producto'][0].id_inventario;
            _productos.producto     = datos['atributos'].Cod_Barras;
            _productos.descuento    = 0.00;
            _productos.invisible    = 0;
            _productos.cantidad     = parseInt(datos['combo_cantidad']) * cantidad_final  ;
            _productos.precioUnidad = datos['prod_precio'][0].precio;
            _productos.bodega       = datos['producto'][0].nombre_bodega;
            _productos.id_bodega    = datos['producto'][0].id_bodega;
            _productos.impuesto_id  = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
            _productos.por_desc     = datos['producto'][0].porcentage;
            _productos.gen  = datos['producto'][10].valor;
            _productos.iva          = datos['atributos']['Incluye Iva'];//datos['producto'][9].valor;
            _productos.descripcion  = datos['producto'][0].name_entidad +" "+ datos['producto'][0].nombre_marca;
            _productos.presentacion = datos['producto'][0].valor;
            _productos.total        = (datos['prod_precio'][0].precio * _productos.cantidad);
            _productos.presentacionFactor = (datos['combo_cantidad'] * producto_cantidad_linea );

            if(combo_descuento){
                combo_total +=  _productos.total;    
                combo_padre_total += _productos.total;
            }else{
                combo_padre_total += _productos.total;
            }

            if(datos != null){
                var tr_html = "<tr class='yxy' style=''>";
                tr_html += "<td class='border-table-left'>"+contador_tabla+"</td>";
                tr_html += "<td class='border-left'>"+_productos.producto+"</td>";
                tr_html += "<td class='border-left'>"+_productos.descripcion+"</td>";
                tr_html += "<td class='border-left "+_productos.producto2+"'>"+_productos.cantidad+"</td>";
                tr_html += "<td class='border-left presentacion"+_productos.producto2+"'>"+_productos.presentacion+"</td>";
                tr_html += "<td class='border-left factor"+_productos.producto2+"'>"+_productos.presentacionFactor+"</td>";
                tr_html += "<td class='border-left precioUnidad"+_productos.producto2+"'>"+_productos.precioUnidad+"</td>";
                tr_html += "<td class='border-left'>"+_productos.descuento_calculado+"</td>";
                tr_html += "<td class='border-left total"+_productos.producto2+"'>"+_productos.total+"</td>";
                tr_html += "<td class='border-left '>"+_productos.bodega+"</td>";
                if(_productos.combo){
                    tr_html += "<td class='border-left'><input type='button' class='btn btn-primary btn-xs eliminar' name='"+_productos.id_producto_detalle+"' id='eliminar' value='Eliminar'/></td>";
                }else{
                    tr_html += "<td class='border-left'> - </td>";
                }
                
                tr_html += "</tr>";      

                $(".producto_agregados").append(tr_html);
            }

            contador_productos = _orden.length;
            _orden[contador_productos] = _productos;
            _productos = {};

            calculo_totales();

        });
        if(combo_total){
            recalcular_descuento_combo(id_producto_detalle, combo_total , combo_descuento);
        }
        sumar_combo_total(combo_padre_total , id_producto_detalle); 

        if(_conf.impuesto == 1){
            _config_impuestos();
            depurar_producto(); 
        }

    }

    function sumar_combo_total(combo_padre_total , id_producto_detalle){
        _orden.forEach(function(element) {
            if(element.id_producto_detalle == id_producto_detalle ){
                _orden[_orden.indexOf(element)].combo_total = combo_padre_total;

            }

        });
        depurar_producto(); 
    }

    function agregar_agrupado(id_producto_detalle, p){
        var sub_total;
        var unidad;

        p.forEach(function(datos) {

            _orden.forEach(function(element) {
                if(element.id_producto_detalle == id_producto_detalle){
                    var id = _orden.indexOf(element);
                    
                    sub_total = (datos['combo_cantidad'] * datos['prod_precio'][0].precio );

                    _orden[id].total = parseInt( _orden[id].total) + ( parseFloat(sub_total) * _orden[id].cantidad);
                    
                    _orden[id].precioUnidad = parseFloat(_orden[id].precioUnidad) + parseFloat(sub_total);

                    _orden[id].combo_total = parseInt( _orden[id].total) + ( parseFloat(sub_total) * _orden[id].cantidad);

                    recalcular_descuento_combo(id_producto_detalle, _orden[id].total , _orden[id].descuento);
                    
                    _orden[id].descuento_calculado = calcular_descuento(_orden[id].descuento , _orden[id].total , _orden[id].descuento_limite);
                }
                
            });
            calculo_totales();

        });

        if(_conf.impuesto ==1){
            impuestos();      
        }        
        depurar_producto(); 
    }

    function agregar_invisible(id_producto_detalle, p){
        var combo_padre_total = 0;
        
        p.forEach(function(datos) {

            var cantidad_final = combo_recalculo_cantidad(id_producto_detalle);

            _productos.descuento_calculado  = 0;
            _productos.id_producto_combo    = id_producto_detalle;
            _productos.id_producto_detalle  = datos['precios'][0].id_producto_detalle;
            _productos.descuento_limite     = datos['atributos'].Descuento_Limite;
            _productos.presentacionCliente  = datos['prod_precio'][0].Cliente;
            _productos.presentacionCodBarra = datos['precios'][0].cod_barra;
            _productos.presentacionPrecio   = datos['precios'][0].precio;
            _productos.presentacionUnidad   = datos['precios'][0].unidad;
            _productos.combo_total          = null;

            _productos.producto2    = datos['precios'][0].id_producto_detalle;            
            _productos.producto_id  = datos['producto'][0].id_entidad;
            _productos.combo        = datos['producto'][0].combo;
            _productos.inventario_id= datos['producto'][0].id_inventario;
            _productos.producto     = datos['atributos'].Cod_Barras;
            _productos.descuento    = 0.00;
            _productos.cantidad     = parseInt(datos['combo_cantidad']) * cantidad_final  ;
            _productos.precioUnidad = datos['prod_precio'][0].precio;
            _productos.bodega       = datos['producto'][0].nombre_bodega;
            _productos.id_bodega    = datos['producto'][0].id_bodega;
            _productos.impuesto_id  = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
            _productos.por_desc     = datos['producto'][0].porcentage;
            _productos.gen  = datos['producto'][10].valor;
            _productos.iva          = datos['atributos']['Incluye Iva'];// datos['producto'][9].valor;
            _productos.descripcion  = datos['producto'][0].name_entidad +" "+ datos['producto'][0].nombre_marca;
            _productos.presentacion = datos['producto'][0].valor;
            _productos.total        = 0.00;
            _productos.presentacionFactor = (datos['combo_cantidad'] * producto_cantidad_linea );
            _productos.invisible     = 1;

            if(combo_descuento){
                combo_total +=  _productos.total;    
                combo_padre_total += _productos.total;
            }else{
                combo_padre_total += _productos.total;
            }



            contador_productos = _orden.length;
            _orden[contador_productos] = _productos;
            _productos = {};

            calculo_totales();

        });
        if(combo_total){
            recalcular_descuento_combo(id_producto_detalle, combo_total , combo_descuento);
        }
        sumar_combo_total(combo_padre_total , id_producto_detalle);
        
    }

    function recalcular_descuento_combo(id_producto_detalle, combo_total, combo_descuento ){
        
        _orden.forEach(function(element) {
            if(element.id_producto_detalle == id_producto_detalle ){
                var d = calcular_descuento(combo_descuento , combo_total, element.descuento_limite);
                _orden[_orden.indexOf(element)].descuento = combo_descuento;
                _orden[_orden.indexOf(element)].descuento_calculado = d;
                _orden[_orden.indexOf(element)].combo_total = combo_total;
            }
        });
        depurar_producto();
    }

    function recalcular_factor_combo( id_producto_detalle, cantidad ){
        
        _orden.forEach(function(element) {
            if(element.id_producto_combo == id_producto_detalle ){

                var pf = _orden[_orden.indexOf(element)].presentacionFactor; 
                var pu = _orden[_orden.indexOf(element)].precioUnidad;
                
                _orden[_orden.indexOf(element)].cantidad = cantidad * pf;
                _orden[_orden.indexOf(element)].total = cantidad * pf * pu  ;
            }
        });
        depurar_producto();

    }

    // ------------------ END COMBO

    function set_calculo_precio(precioUnidad, producto_cantidad_linea){
        // General - Set Calculo Precio
        $("#total").val(calcularTotalProducto(precioUnidad, producto_cantidad_linea));
    }

    $(document).on('change', '#cantidad', function(){
        // Actualizar la cantidad

        var cantidad = $("#cantidad").val();

        if( _productos.producto != null &&  _productos.combo!=1){
            producto_cantidad_linea = $("#cantidad").val();
            var producto_precio_flag = productos_precios_validacion();

            var precion  = $("#precioUnidad").val();
            var cantidad = producto_cantidad_linea;
            

            if(producto_escala == 1){
                
                var escala_precio = validar_escalas(cantidad);

                $("#total").val(calcularTotalProducto( escala_precio, cantidad));
                $("#precioUnidad").val( escala_precio );
                _productos.precioUnidad = escala_precio;

            }else{
                
                $("#total").val(calcularTotalProducto( _productos.presentacionPrecio, cantidad));
                $("#precioUnidad").val( _productos.precioUnidad );
            }

            _productos.cantidad = cantidad;
            _productos.total = $("#total").val();
            factor_precio = 0;
            factor_total = 0;
        }else{
            $("#total").val(calcularTotalProducto( _productos.presentacionPrecio, cantidad));
                $("#precioUnidad").val( _productos.precioUnidad );
            _productos.cantidad = cantidad;
            //_productos.total = $("#total").val();
            factor_precio = 0;
            factor_total = 0;
        }    	
    });

    function calcularTotalProducto(precio , cantidad){
        // total Producto
    	var total = (precio * cantidad);
    	return Number(total).toFixed(2);
    }
 
    $(document).on('change', '#sucursal_id', function(){
        correlativos_sucursales($(this).val());
    });

    $(document).on('change', '#sucursal_id2', function(){
        correlativos_sucursales($(this).val());           
    });

    function correlativos_sucursales(sucursal){
        // Cambiar Bodega
        $("#bodega_select").empty();
        var select_option;
        $.ajax({
            url: "get_bodega_sucursal/"+ sucursal,
            datatype: 'json',      
            cache : false,                

            success: function(data){
                var datos = JSON.parse(data);
                var bodega = datos["bodega"];
                $.each(bodega, function(i, item) { 
                    select_option += '<option value="'+item.id_bodega+'">'+item.nombre_bodega+'</option>';            
                });

                $("#bodega_select").html(select_option);   
                
                var correlativo = datos['correlativo'];
                $("#c_numero").val(correlativo[0].siguiente_valor);
            },
            error:function(){
            }
        });
    }

    function productos_precios_validacion(){

        var factor = 0;
        var precio_unidad = 0;
        var precio_total = 0;
        var flag = false;

        var descuento_digitado = $("descuento").val();

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

    function calcular_descuento( descuento, total , descuento_limite){
        var valor = 0;
        
        if(descuento){

            var primer_digito = descuento.substring(0,1);
            var tipo_descuento_limite = descuento_limite.substring(0,1);
            //alert(descuento_limite);
            if(descuento){

                if(primer_digito == 0 ){

                    if(tipo_descuento_limite == 0){
                        // Limite en %   
                        if(descuento <= parseInt(descuento_limite)  ){
                            valor = descuento * total;
                        }else{
                            valor = descuento_limite * total;
                        }
                    }else{
                        // Limite #
                        valor = ( parseInt(descuento_limite) / 100 );
                        if(descuento <= valor  ){
                            valor = descuento * total;
                        }else {
                            valor = (parseInt(descuento_limite) / 100 ) * total;
                        }
                    }
                }else{
                    if(tipo_descuento_limite == 0){
                        // Limite en %  y descuento %
                        valor = ( descuento / 100 );                 
                        if(valor <= parseInt(descuento_limite)  ){
                            valor = valor * total;
                        }else{
                            valor = descuento_limite * total;
                        }
                    }else{                   
                        // Limite # y descuento # 
                        valor = ( descuento / 100 );
                        if(valor <= (descuento_limite / 100)  ){
                            valor = valor * total ;
                        }else{
                            valor = total * (descuento_limite / 100);
                        }
                    }
                }
                _productos.descuento_calculado = valor.toFixed(2);
            }else{
                _productos.descuento_calculado = valor.toFixed(2);
            }
        }        
        return valor;
    }

    function agregar_producto(){

        if(_productos.presentacion != null){

        if(factor_total !=0 && factor_precio!=0){
            _productos.total = factor_total;
            _productos.precioUnidad = factor_precio;
        }

        total_msg += parseFloat(_productos.total);

        $(".total_msg").text("$ "+total_msg.toFixed(2));   

        contador_productos = _orden.length;

        if(_productos != null){
    		var tr_html = "<tr class='' style=''>";
    		tr_html += "<td class='border-table-left'>"+contador_tabla+"</td>";
    		tr_html += "<td class='border-left'>"+_productos.producto+"</td>";
    		tr_html += "<td class='border-left'>"+_productos.descripcion+"</td>";
    		tr_html += "<td class='border-left "+_productos.producto2+"'>"+_productos.cantidad+"</td>";
    		tr_html += "<td class='border-left presentacion"+_productos.producto2+"'>"+_productos.presentacion+"</td>";
    		tr_html += "<td class='border-left factor"+_productos.producto2+"'>"+_productos.presentacionFactor+"</td>";
    		tr_html += "<td class='border-left precioUnidad"+_productos.producto2+"'>"+_productos.precioUnidad+"</td>";
    		tr_html += "<td class='border-left'>"+_productos.descuento_calculado+"</td>";
    		tr_html += "<td class='border-left total"+_productos.producto2+"'>"+_productos.total+"</td>";
            tr_html += "<td class='border-left '>"+_productos.bodega+"</td>";
    		tr_html += "<td class='border-left'><button type='button' class='btn btn-labeled btn-danger eliminar' name='"+_productos.id_producto_detalle+"' id='eliminar' value=''><span class=''><i class='fa fa-times'></i></span></button></td>";
    		
    		tr_html += "</tr>";
            
            calculo_totales();

    		$(".producto_agregados").append(tr_html);

    		_productos = {};
            factor_total =0; 
            factor_precio =0;
    		contador_tabla++;
        }}
    }

    function calculo_totales(){
        
        var descuento = 0;
        var t   = 0;
        var t2  = 0;
        var sub = 0;
        var imp_espeical_total = 0;
        var iva_nombre ="";
        var iva_valor ="";
        var iva_total ="";

        // --------------- * -----------------------------

        if(_orden !=null){
            _orden.forEach(function(element) {

                t +=parseInt(element.cantidad);
                if( (_conf.comboAgrupado == 0) && ( element.id_producto_combo !=null && element.combo == 0) ){
                        
                    //t2 +=parseFloat(element.total);
                }else{
                    if(element.id_producto_combo == 0 || element.id_producto_combo== null){
                        t2 +=parseFloat(element.total);
                    }
                }                
                descuento += parseFloat(element.descuento_calculado);

            });
        }else{
            t = 0;
        }

        /* ------------Impuestos Especial Dibujados  -----------*/
        
        if(_impuestos_orden_condicion.length !=0 || _impuestos_orden_excluyentes!=0){
            
            var impuestos_nombre = "";
            var impuestos_valor = "";
            var impuestos_total = "";
            
            _impuestos_orden_condicion.forEach(function(element){
                
                sub = element.ordenImpTotal.toFixed(2);
                imp_espeical_total += parseFloat(sub);
                //t2 += parseFloat(sub);
               
                impuestos_nombre += "<i style='text-align: right;'>"+element.ordenImpName+"("+element.ordenImpVal+")</i><br>";                
                
                impuestos_total += "<i><?php echo $moneda[0]->moneda_simbolo; ?>"+sub+"</i><br>";
               
            });

            _impuestos_orden_especial.forEach(function(element){
                
                sub = element.ordenImpTotal.toFixed(2);
                imp_espeical_total += parseFloat(sub);
               
                impuestos_nombre += "<i style='text-align: right;'>"+element.ordenImpName+"("+element.ordenImpVal+")</i><br>";                
                
                impuestos_total += "<i><?php echo $moneda[0]->moneda_simbolo; ?>"+sub+"</i><br>";
               
            });

            _impuestos_orden_excluyentes.forEach(function(element){
                
                sub = element.ordenImpTotal.toFixed(2);
                if(element.condicion_simbolo == "+"){
                    imp_espeical_total += parseFloat(sub);
                }else if(element.condicion_simbolo == " - "){
                    imp_espeical_total -= parseFloat(sub);
                }
                
               
                impuestos_nombre += "<i style='text-align: right;'>"+element.ordenImpName+"("+element.ordenImpVal+")</i><br>";                
                
                impuestos_total += "<i><?php echo $moneda[0]->moneda_simbolo; ?> "+sub+"</i><br>";
               
            });

            $(".impuestos_nombre").html(impuestos_nombre);
            $(".impuestos_total").html(impuestos_total);
        }else{
            $(".impuestos_nombre").empty();
            $(".impuestos_total").empty();
        }

        /* ------------Impuestos - IVA -----------*/

        var total_msg = (t2 - descuento);

        $(".iva_nombre").empty();
        $(".iva_valor").empty();
        $(".iva_total").empty();
        var temp = 0;
        if(total_iva != 0 && _orden.length!=0 ){
            total_msg += parseFloat(total_iva_suma);
        }
            
            iva_nombre += "<p style='text-align: right;'>IVA</p>";                
            iva_valor += "<?php echo $moneda[0]->moneda_simbolo; ?>"+total_iva.toFixed(2);
            iva_total += "<p><?php echo $moneda[0]->moneda_simbolo; ?>"+total_msg.toFixed(2)+"</p>";

            $(".iva_nombre").html(iva_nombre);
            $(".iva_valor").text(iva_valor);
            $(".iva_total").html(iva_total);
        
        total_msg += parseFloat(imp_espeical_total);

        // --------------- * -----------------------------
        $(".total_msg").text(total_msg.toFixed(2) );
        $(".cantidad_tabla").text(t.toFixed(2) );
        $(".sub_total_tabla").text(t2.toFixed(2) );
        $(".total_tabla").text(total_msg.toFixed(2) );
        $(".descuento_tabla").text(descuento.toFixed(2));

    }

    $(document).on('click', '.eliminar', function(){
        // Remover los Productos de la lista.

        var x = 0;
        var _orden_temp = [];
        var producto_id = $(this).attr('name');

        remover_combo(producto_id);
        
        _orden.forEach(function(element) {
            
            if(element.id_producto_detalle == producto_id && element.id_producto_combo == null){

                total_msg -= parseInt(calcularTotalProducto(element.precioUnidad, element.cantidad));
                $(".total_msg").text("$ "+total_msg.toFixed(2));
                
                _orden.splice(_orden.indexOf(element),1);
                if(_conf.impuesto == 1){
                    _config_impuestos();
                    depurar_producto(); 
                }
                depurar_producto();
            }            
        });    
    });

    function remover_combo(producto_id){
        var L = 1;
        
        while(L <= _orden.length){
            _orden.forEach(function(element) {
                
                if(element.id_producto_combo == producto_id){

                    _orden.splice(_orden.indexOf(element),1);
                    depurar_producto();
                }
            });
            L++;
        }
    }

    function depurar_producto(){
        // Remueve los productos selecionados
        contador_tabla=1;

        
        if(_orden.length >= 1){
            var tr_html = "";
            
            _orden.forEach(function(element) {
                if(element.invisible == 0){
                tr_html += "<tr class='' style='' id='"+element.producto_id+"'>";
                tr_html += "<td class='border-table-left'>"+contador_tabla+"</td>";
                tr_html += "<td class=''>"+element.producto+"</td>";
                tr_html += "<td class=''>"+element.descripcion+"</td>";
                tr_html += "<td class=''>"+element.cantidad+"</td>";
                tr_html += "<td class=''>"+element.presentacion+"</td>";
                tr_html += "<td class=''>"+element.presentacionFactor+"</td>";
                tr_html += "<td class=''>"+element.precioUnidad+"</td>";
                tr_html += "<td class=''>"+element.descuento_calculado+"</td>";
                tr_html += "<td class=' total'>"+element.total+"</td>";
                tr_html += "<td class=' '>"+element.bodega+"</td>";
                if(element.combo == 1 || !element.id_producto_combo){
                    tr_html += "<td class='border-left'><button type='button' class='btn btn-labeled btn-danger eliminar' name='"+element.id_producto_detalle+"' id='eliminar' value=''><span class=''><i class='fa fa-times'></i></span></button></td>";
                }else{
                     tr_html += "<td class='border-left'> - </td>";
                }
                
                tr_html += "</tr>";

                contador_tabla++;
                }
            });
            $(".cantidad_tabla").val(4);
            $(".sub_total_tabla").val(4);

            calculo_totales();

            $(".producto_agregados").html(tr_html);
            
        }else{
            contador_productos = 0;
            _orden = [];
            _productos = {};
            _impuestos_orden_condicion = [];
            _impuestos_orden_especial = [];
            _impuestos_orden_excluyentes = [];

            total_msg = parseFloat(0.00);
            $(".total_msg").text("$ "+total_msg.toFixed(2));
            $(".producto_agregados").empty();
            calculo_totales();
        }

    }

    function get_clientes_lista(){
        
        var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'><input type='text' placeholder='Buscar Cliente' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<tr class='bg-info-dark'><th>#</th><th>Codigo</th><th>Nombre Cliente</th><th>NRC</th><th>NIT</th><th>Action</th></tr>";
        var table_tr = "<tbody id='list'>";
        var contador_precios=1;

        $.ajax({
            url: "get_clientes_lista",
            datatype: 'json',      
            cache : false,                

            success: function(data){
                var datos = JSON.parse(data);
                var clientes = datos["clientes"];
                var cliente_id = 0;
                clientes_lista = clientes;
                
                $.each(clientes, function(i, item) { 

                    if(cliente_id != item.id_cliente){
                        cliente_id = item.id_cliente;   
                        var precio = 0;
                        
                        table_tr += '<tr><td>'+contador_precios+'</td><td>'+item.id_cliente+'</td><td>'+item.nombre_empresa_o_compania+'</td><td>'+item.nrc_cli+'</td><td>'+item.nit_cliente+'</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_cliente" id="'+item.id_cliente+'" name="'+item.nombre_empresa_o_compania+'" rel="'+item.direccion_cliente+'" impuesto="'+item.aplica_impuestos+'">Agregar</a></td></tr>';
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

    // filtrar producto
    $(document).on('keyup', '#buscar_producto', function(){
        var texto_input = $(this).val();

        $("#list tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(texto_input) > -1)
        }); 
    });

    $(document).on('click', '.guardar', function(){
        // Guardar Orden en la DB
        
        var formulario = $('#encabezado_form').serializeArray();
        var orden_estado = $(this).attr('name');

        if(_orden.length !=0){
        
            $.ajax({
                type: 'POST',
                data: {orden :_orden, encabezado : formulario, estado:orden_estado },
                url: "guardar_orden",

                success: function(data){
                    location.reload();
                },
                error:function(){
                } 
            });
        }   
    });  

    $(document).on('click', '.seleccionar_cliente', function(){
        var id = $(this).attr('id');
        
        $("#cliente_codigo").val($(this).attr('id'));
        $("#cliente_nombre").val($(this).attr('name'));
        $("#direccion_cliente").val($(this).attr('rel'));
        $("#impuesto").val($(this).attr('impuesto'));
        $('#cliente_modal').modal('hide');

        // Poniendo Tipo Documento a cliente.
        $.ajax({
            url: "get_clientes_documento/"+id,
            datatype: 'json',      
            cache : false,                

            success: function(data){
                var datos = JSON.parse(data);
                var ciente_documento = datos["cliente_tipo_pago"];  
                var tipo_documento = datos["tipoDocumento"];  
                var tipo_pago = datos["tipoPago"]; 

                clientes_lista =  ciente_documento;
                calculo_totales();

                $.each(tipo_documento , function(i, item){
                  if(item.id_tipo_documento == ciente_documento[0].TipoDocumento){
                    $("#id_tipo_documento").html("<option value='"+item.id_tipo_documento+"'>"+item.nombre+"</option>");

                    
                    $.each(tipo_documento , function(i, item){
                        if(item.id_tipo_documento != ciente_documento[0].TipoDocumento){
                            $("#id_tipo_documento").append("<option value='"+item.id_tipo_documento+"'>"+item.nombre+"</option>");
                        }
                    });
                    

                  }
                });

                // Poniendo Tipo Pago a cliente.
                $.each(tipo_pago , function(i, item){
                  if(item.id_modo_pago == ciente_documento[0].TipoPago){
                    $("#modo_pago_id").html("<option value='"+item.id_modo_pago+"'>"+item.nombre_modo_pago+"</option>");

                    
                    $.each(tipo_pago , function(i, item){
                        if(item.id_tipo_documento != ciente_documento[0].TipoPago){
                            $("#modo_pago_id").append("<option value='"+item.id_modo_pago+"'>"+item.nombre_modo_pago+"</option>");
                        }
                    });
                    

                  }
                });
            },
            error:function(){
            }
        });
    });

    $(document).on('click', '.seleccionar_empleado', function(){

        $(".vendedores_lista").text($(this).attr('name'));
        $('#vendedores_modal').modal('hide');
    });

    function get_empleados_lista(sucursal){
        
        var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Codigo Empleado</th><th>Nombre Empleado</th><th>Apellido Empleado</th><th>Apellido Empleado</th><th>Action</th>";
        var table_tr = "<tbody id='list'>";
        var contador_precios=1;

        $.ajax({
            url: "get_empleados_by_sucursal/"+sucursal,
            datatype: 'json',      
            cache : false,                

            success: function(data){
                var datos = JSON.parse(data);
                var clientes = datos["empleados"];
                var cliente_id = 0;
                
                $.each(clientes, function(i, item) { 

                    if(cliente_id != item.id_empleado){
                        cliente_id = item.id_empleado;  
                        var precio = 0;
                        
                        table_tr += '<tr><td>'+contador_precios+'</td><td>'+item.id_empleado+'</td><td>'+item.primer_nombre_persona+'</td><td>'+item.segundo_nombre_persona+'</td><td>'+item.primer_apellido_persona+'</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_empleado" id="'+item.id_empleado+'" name="'+item.primer_nombre_persona+' '+item.primer_apellido_persona+'">Agregar</a></td></tr>';
                        contador_precios++;
                    }
                    
                });
                table += table_tr;
                table += "</tbody></table>";

                $(".vendedor_lista_datos").html(table);
            
            },
            error:function(){
            }
        });
    }

    $(document).on('click', '.cliente_codigo', function(){
        $('#cliente_modal').modal('show');
        get_clientes_lista();
    });

    $(document).on('click', '.vendedores_lista', function(){
        $('#vendedores_modal').modal('show');
        get_empleados_lista($(this).attr("id"));
    }); 

    $(document).on('click', '#btn_existencias', function(){
        $(".existencia_buscar").focus();
    });

    $(document).on('click', '#btn_impuestos', function(){
        _config_impuestos();
        depurar_producto();
    });

    

});
</script>

<?php $this->load->view('styles_files.php'); ?>
<title><?php echo $title; ?></title>
   

<style type="text/css">

    body{
        background: #e9ebee;
    }
    .paper_cut{
        
        margin-top: 0px;
        
        content: " ";
        display: block;
        position: relative;
        top: 0px;
        left: 0px;
        height: 36px;
        background: -webkit-linear-gradient(#FFFFFF 0%, transparent 0%), -webkit-linear-gradient(135deg, #e9ebee 33.33%, transparent 33.33%) 0 0%, #e9ebee -webkit-linear-gradient(45deg, #e9ebee 33.33%, #FFFFFF 33.33%) 0 0%;
        background-repeat: repeat-x;
        background-size: 0px 100%, 14px 27px, 14px 27px;
    }
	
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
    .btn-pre{
        background: #CA293E;
        color: white;
    }

    #dataSelect, #dataSelect2{
        position: absolute;
        margin-left: 0px;
        display: inline-block;
        float: left;
        z-index: 100;
    }

    /* Productos Tabla Seleccion */
    * {
        
        font-family: 'Helvetica', Arial, Sans-Serif;
        }
</style>

<script type="text/javascript">

    jQuery(document).ready(function(){

        var currCell = $('tr').first();
        var editing = false;

        $(document).on("click","tr",function(){
           $('tr').css('background','none');
           $('tr').css('color','black');

           $(this).css('background','#0f4871');
           $(this).css('color','#fff');
        
            currCell = $(this);
            currCell.focus();
            var producto_imagen_id = $(this).attr('id');
            imagen(producto_imagen_id);
        });

        function imagen(producto_imagen_id){
            getImagen(producto_imagen_id);
        }

        document.onkeydown = function(e) {
            var c = "";
            if (e.keyCode == 39) {
                // Right Arrow
                c = currCell.next();
            } else if (e.keyCode == 37) { 
                // Left Arrow
                c = currCell.prev();
            } else if (e.keyCode == 38) { 
                // Up Arrow
                c = currCell.closest('tr').prev().find('td:eq(' + 
                  currCell.index() + ')');

                $('tr').css('background','none');
                $('tr').css('color','black');

                if($(currCell.closest('tr')).attr('id')){
                    imagen($(currCell.closest('tr').prev()).attr('id'));
                }
                

            } else if (e.keyCode == 40) { 
                // Down Arrow
                c = currCell.closest('tr').next().find('td:eq(' + 
                  currCell.index() + ')');

                $('tr').css('background','none');
                $('tr').css('color','black');

                if($(currCell.closest('tr')).attr('id')){
                    imagen($(currCell.closest('tr').next()).attr('id'));
                }

            } else if (!editing && (e.keyCode == 13 || e.keyCode == 32)) { 
                // Enter or Spacebar - edit cell
                //e.preventDefault();
                //edit();
            } else if (!editing && (e.keyCode == 9 && !e.shiftKey)) { 
                // Tab
                e.preventDefault();
                c = currCell.next();
            } else if (!editing && (e.keyCode == 9 && e.shiftKey)) { 
                // Shift + Tab
                e.preventDefault();
                c = currCell.prev();
            } 
            
            // If we didn't hit a boundary, update the current cell
            if (c.length > 0) {
                currCell.parent().css('background','none');
                currCell.parent().css('color','#131e26');

                //$('tr').css('color','#131e26');
                currCell = c;
                console.log(currCell.parent().index());
                var x = currCell.parent().index();
                currCell.focus();
                
                currCell.parent().css('background','#0f4871');
                currCell.parent().css('color','#fff');
            }
        }

        $('#edit').keydown(function (e) {
            if (editing && e.which == 27) { 
                 editing = false;
                $('#edit').hide();
                currCell.toggleClass("editing");
                currCell.focus();
            }
        });

    });
</script>

<!-- Main section-->


<section>

    <div class="row">
        <div class="col-lg-9 col-md-9">
           
            <div class="row">
                <div class="col-lg-12 col-md-12">
                  <!-- Team Panel-->
                    <div class="panel panel-default" style="height: 70px; width: 100%; background: white;text-align: center;color: white;font-size: 30px;">
                        <div class="panel-heading" style="background: #2D3B48; color: white;">
                            <div class="row">

                                <div class="col-lg-4">
                               
                                    <div class="input-group m-b">
                                        <span class="input-group-addon btn-pre"><i class="fa fa-search"></i></span>
                                        <input type="text" placeholder="Buscar Producto" autocomplete="off" name="producto_buscar" class="form-control producto_buscar">
                                    </div>

                                    <select multiple="" class="form-control dataSelect" id="dataSelect">

                                    </select>

                                    <select multiple="" class="form-control dataSelect2" id="dataSelect2" style="display: inline-block;">

                                    </select>
                                </div>

                                <div class="col-lg-8">
                                    <button type="button" class="btn btn-pre" name="" id="grabar" value=""><span class='btn-label'><i class='icon-plus'></i></span>[ . ]</button>

                                    <button type="button" class="btn btn-pre guardar" name="1" id="" value=""><span class='btn-label'><i class='fa fa-save'></i></span></button>

                                    <a href="#" class="btn btn-pre" id="btn_existencias" data-toggle='modal' data-target='#existencias'><i class="icon-menu"></i> Existencias</a>                            
                                    
                                    <div class="btn-group">
                                       <button type="button" class="btn btn-pre">Opcion</button>
                                       <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-pre">
                                          <span class="caret"></span> 
                                          <span class="sr-only">default</span>
                                       </button>
                                       <ul role="menu" class="dropdown-menu">
                                         <li><a href="#" class="btn btn-warning" id="btn_impuestos" data-toggle='modal'><i class="fa fa-money"></i> Impuestos</a></li>

                                            <li><a href="#" class="btn btn-warning" id="btn_en_proceso" data-toggle='modal' data-target='#en_proceso'><i class="fa fa-key"></i> En Espera</a></li>
                                          
                                          <li class="divider"></li>
                                          <li>
                                            <li><a href="#" class="btn btn-warning" id="btn_en_reserva" data-toggle='modal' data-target='#en_reserva'><i class="icon-cursor"></i> En Reserva</a>
                                          </li>
                                       </ul>
                                    </div>

                                    <div class="pull-right">
                                        <div class="" style="font-size: 20px;">  <?php echo Date("Y-m-d"); ?>  </div>
                                        <?php //echo gethostbyaddr($_SERVER['REMOTE_ADDR'])  ; ?>
                                    </div>
                                </div>  
                            </div>                            
                        </div>
                     
                    <!-- START table-responsive-->
                        <div class="table-responsive" style="width: 100%;">
                           <table class="table table-sm table-hover" >
                            
                            
                            
                              <thead class="bg-info-dark" style="background: #cfdbe2;">
                                 <tr>
                                    <th style="color: black;">#</th>
                                    <th style="color: black;">Producto</th>
                                    <th style="color: black;">Descripción</th>
                                    <th style="color: black;">Cantidad</th>
                                    <th style="color: black;">Presentación</th>
                                    <th style="color: black;">Factor</th>
                                    <th style="color: black;">Unidad</th>
                                    <th style="color: black;">Descuento</th>
                                    <th style="color: black;">Total</th>
                                    <th style="color: black;">Bodega</th>
                                    <th style="color: black;"><!--<input type="button" class="form-control border-input btn btn-default guardar" name="1" id="" value="Guardar"/>--></th>
                                 </tr>
                              </thead>
                              <tbody class="uno bg-gray-light" style="border-bottom: 0px solid grey">
                                <tr style="border-bottom: 1px dashed grey">
                                    <td colspan="2">
                                        <input type="text" name="producto_buscar" class="form-control border-input" id="producto_buscar" readonly="1" style="width: 100px;">
                                    </td>
                                    <td><input type="text" class="form-control border-input" id="descripcion" name="descripcion" readonly="1"></td>
                                    <td><input type="number" class="form-control border-input" id="cantidad" name="cantidad" size="1px" value="1" min="1" max="1000" style="width: 80px;"></td>
                                    <td><input type="text" class="form-control border-input" id="presentacion" name="presentacion" size="3px" readonly="1"></td>
                                    <td><input type="text" class="form-control border-input" id="factor" name="factor" size="2px" readonly="1" style="width: 50px;"></td>
                                    <td><input type="text" class="form-control border-input" id="precioUnidad" name="precioUnidad" size="2px" readonly="1" style="width: 70px;"></td>
                                    <td><input type="text" class="form-control border-input" id="descuento" name="descuento" size="2px" style="width: 80px;"></td>
                                    <td><input type="text" class="form-control border-input" id="total" name="total" size="2px" readonly="1"></td>
                                    <td><input type="text" class="form-control border-input" id="bodega" name="bodega" size="5px" readonly="1"></td>
                                    <td><button type="button" id="btn_delete" class="btn btn-labeled btn-pre" name="1"><span class='btn-label'><i class='fa fa-trash'></i></span></button></td>
                                    
                                 </tr>
                              </tbody>
                              <tbody class="producto_agregados" style="border-top:  0px solid black; background: white;" >

                              </tbody>
                            
                           </table>
                           <div class="col-lg-12 col-md-12 paper_cut">
                            </div>
                        </div>
                    <!-- END table-responsive-->
                     
                  </div>
                  <!-- end Team Panel-->
               </div>
            </div>
            
        </div>
        <div class="col-lg-3 col-md-3">
            <div style="border:0px solid black">
                <form name="encabezado_form" id="encabezado_form" method="post" action="">

                <!-- Campos de la terminal -->
                <input type="hidden" name="terminal_id" value="<?php echo $terminal[0]->id_terminal; ?>"/>
                <input type="hidden" name="terminal_numero" value="<?php echo $terminal[0]->numero; ?>"/>
                <!-- Fin Campos de la terminal -->

                <!-- Campos del cliente -->
                <input type="hidden" name="impuesto" value="" id="impuesto" />
                <!-- Fin Campos del cliente -->

                

                <div class="row">
                    <div class="col-lg-12 col-md-12" style="width: 100%; background: #0f4871;text-align: center;color: white;">
                        
                        <span style="font-size: 50px;">
                            <?php echo $moneda[0]->moneda_simbolo; ?> <span class="total_msg">0.00</span>
                        </span>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12" style="width: 100%; background: white;">

                        <table class="table table-sm table-hover">
                            <tr>
                                <td style="color:#0f4871"><b>Sub total</b></td>
                                <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="sub_total_tabla"></span></td>
                            </tr>
                            <tr>
                                <td><b>Iva</b></td>
                                <td><span class="iva_valor"></span></td>
                            </tr>
                            <tr>
                                <td><span class="impuestos_nombre"></span></td>
                                <td><span class="impuestos_total"></span></td>
                            </tr>
                            <tr>
                                <td style="color:#0f4871"><b>Total</b></td>
                                <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="total_tabla"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-12 col-md-12 paper_cut">
                    </div>
                </div><br>

                <div class="row">
                
                <div id="panelDemo1" class="panel panel-default">

                    <div class="panel-heading">Facturacion
                       <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right btn-pre">
                          <em class="fa fa-minus"></em>
                       </a>
                    </div>


                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                        <label>Tipo Documento</label>
                                        <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">
                                        <?php
                                        foreach ($tipoDocumento as $documento) {
                                            ?>
                                            <option value="<?php echo $documento->id_tipo_documento; ?>"><?php echo $documento->nombre; ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>                    
                                <div class="col-lg-6 col-md-6">

                                    <div class="form-group has-success">
                                        <label>Cliente Codigo</label>
                                        <input type="text" name="cliente_codigo" class="form-control cliente_codigo" id="cliente_codigo" value="<?php echo $cliente[0]->id_cliente ?>">
                                   </div>
                                                                
                                </div>                    
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                        <label>Forma Pago</label>
                                        <select class="form-control" id="modo_pago_id" name="modo_pago_id">
                                        <?php
                                        foreach ($modo_pago as $value) {
                                            ?><option value="<?php echo $value->id_modo_pago; ?>"><?php echo $value->nombre_modo_pago; ?></option><?php
                                        }
                                        ?>      
                                        </select>
                                   </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                      <div class="form-group has-success">
                                          <label>Cliente Nombre</label>
                                         <input type="text" name="cliente_nombre" class="form-control cliente_nombre" id="cliente_nombre" value="<?php echo $cliente[0]->nombre_empresa_o_compania ?>">
                                         <input type="hidden" name="cliente_direccion" class="form-control direccion_cliente" id="direccion_cliente" value="<?php echo $cliente[0]->direccion_cliente ?>">
                                       </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                      <label>Sucursal Destino</label>
                                      <select class="form-control" name="sucursal_destino" id="sucursal_id">
                                        <?php
                                        $id_sucursal=0;
                                        
                                        foreach ($empleado as $sucursal) {
                                            $id_sucursal = $sucursal->id_sucursal; 
                                            ?>
                                            <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                            <?php
                                        }

                                        foreach ($sucursales as $sucursal) {
                                            if($sucursal->id_sucursal != $id_sucursal){
                                                ?>
                                                <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                   </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                        <label>Bodega</label>
                                        <select class="form-control" name="bodega" id="bodega_select">
                                        <?php
                                            foreach ($bodega as $b) {
                                                if($b->Sucursal == $id_sucursal){
                                        ?>
                                        <option value="<?php echo $b->id_bodega; ?>"><?php echo $b->nombre_bodega; ?></option>
                                        <?php
                                                }   
                                            }
                                        ?>
                                        </select>
                                   </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                   <div class="form-group has-success">
                                      <label>Fecha</label>
                                     <input type="date" name="fecha" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                                   </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                        <label>Sucursal Origin</label>
                                        <select class="form-control" name="sucursal_origin" id="sucursal_id2">
                                        <?php
                                        $id_sucursal=0;
                                        $id_sucursal = $empleado[0]->id_sucursal;
                                        foreach ($empleado as $sucursal) {
                                             
                                            ?>
                                            <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                            <?php
                                        }

                                        foreach ($sucursales as $sucursal) {
                                            if($sucursal->id_sucursal != $id_sucursal){
                                                ?>
                                                <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                   </div>
                                   <?php
                                                                      
                                      foreach ($correlativo as $key => $value) {
                                        
                                          if($id_sucursal == $value->id_sucursal ){
                                            $secuencia = $value->siguiente_valor;
                                          }
                                      }
                                      ?>
                                      <input type="hidden" name="numero" value="<?php echo $secuencia; ?>" class="form-control" id="c_numero">
                                </div>
                            </div>

                            <input type="hidden" name="vendedor" id="vendedor1" value="<?php echo $empleado[0]->id_empleado; ?>">
                            <div class="label bg-gray"><a href="#" class="vendedores_lista1" id="<?php echo $empleado[0]->id_sucursal; ?>"><?php echo $empleado[0]->primer_nombre_persona." ".$empleado[0]->primer_apellido_persona; ?></a></div>

                        </div>
                    </div>
                </div>

                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12" style="width: 100%; background: white;">
                        Imagen
                      <div class="panel b m0">
                       
                         <div class="panel-body">
                            <p>
                               <a href="#">
                                  <span class="producto_imagen"></span>
                               </a>
                            </p>
                            
                         </div>
                      </div>
                    </div>
                </div>
                
            </div>
        </form>
        </div>
    </div>
</section>



<!-- Modal Large CLIENTES MODAL-->
   <div id="cliente_modal" tabindex="-1" role="dialog" aria-labelledby="cliente_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="panel-header" style="background: #535D67; color: white;">
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

<!-- Modal Large PRODUCTOS MODAL-->
   <div id="existencias" tabindex="-1" role="dialog" aria-labelledby="existencias"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <div class="input-group m-b">
                    <span class="input-group-addon btn-pre"><i class="fa fa-search"></i></span>
                    <input type="text" placeholder="Buscar Exsitencia" name="existencia_buscar" class="form-control existencia_buscar">
                </div>

                <select multiple="" class="form-control 1dataSelect" id="1dataSelect">

                </select>

                <select multiple="" class="form-control 1dataSelect2" style="display: inline-block;">

                </select>

            </div>
            <div class="modal-body">
                <table class="table table-sm table-hover">
                    <thead>
                     <tr class="bg-info-dark" style="color: black;">
                        <th style="color: white;">#</th>
                        <th style="color: white;">Sucursal</th>
                        <th style="color: white;">Bodega</th>
                        <th style="color: white;">Existencia</th>
                        <th style="color: white;">Costo</th>
                        <th style="color: white;">Costo Anterior</th>
                        <th style="color: white;">Costo utilidad</th>
                        <th style="color: white;">Cod ubicacion</th>                                    
                     </tr>
                      </thead>
                      <tbody class="dos" style="border-bottom: 3px solid grey">
                        
                      </tbody>
                </table>                                
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default btn-pre">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

<!-- Modal Large PRODUCTOS MODAL-->
   <div id="en_proceso" tabindex="-1" role="dialog" aria-labelledby="en_proceso"  class="modal fade">
      <div class="modal-dialog modal-sm">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               Notificacion
            </div>
            <div class="modal-body">
                Cambiar Orden a Espera ?
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-success guardar btn-pre" name="5">Si</button>               
               <button type="button" data-dismiss="modal" class="btn btn-warning">No</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->


<!-- Modal Large PRODUCTOS MODAL-->
   <div id="en_reserva" tabindex="-1" role="dialog" aria-labelledby="en_reserva"  class="modal fade">
      <div class="modal-dialog modal-sm">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               Notificacion
            </div>
            <div class="modal-body">
                Cambiar Orden a Reservado ?
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-success guardar btn-pre" name="2">Si</button>               
               <button type="button" data-dismiss="modal" class="btn btn-warning">No</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->


<?php $this->load->view('scripts_files.php'); ?>