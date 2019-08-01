
var _tipo_documento;
var _tipo_cliente;
var total_orden = 0;
var total_iva = 0;
var docVal, catVal, proVal, cliVal;
var _ImpList = [];
var _docVal = [];
var _catVal = [];
var _proVal = [];
var _cliVal = [];
var _impuestos_orden = [];
var _impuestos_total = [];

/* Impuestos Acumulados */

$(document).ready(function(){

	_tipo_documento = $("#id_tipo_documento").val();
	$("#id_tipo_documento").change(function(){
		tipo_documento($(this).val());

	});

});

function tipo_cliente(){
	var id = $("#cliente_codigo").val();
	return id;
}

function _config_impuestos(){
	_impuestos_total = [];
	impuestos();
}

function impuestos(){
    /*
     * Calcular los impuestos a productos en la orden
     */
    docVal = imp_list(_impuestos.doc , _tipo_documento);
    imp_cli_val();

    if(docVal){

    	_orden.forEach(function(element) {

    		var exist_cat = imp_cat_val(element.categoria);
    		
    		if(exist_cat){

		    	if(element.combo == 1){

		    		if((element.iva != "on" && element.iva != 1)  ){

		    			if(_conf.comboAgrupado == 0){ // referencia combo_total
		    				console.log("A");

		    				_orden[_orden.indexOf(element)].impA = 0;
		    				_orden[_orden.indexOf(element)].total_anterior = (element.combo_total * element.cantidad);

		    			}else{ // referencia total
		    				console.log("B");
		    				
		    				_orden[_orden.indexOf(element)].impA = 0;
		    				_orden[_orden.indexOf(element)].total_anterior = (element.precioUnidad * element.cantidad);
		    			}
						
						aplicar_imp_combo( element );	    		

		    		}else{
		    			// No hacer nada
		    			//aplicar_imp_duplicado( element );
		    		}
		    	}else{

		    		if((element.iva ==0) && element.id_producto_combo == null  ){

			    		if((element.id_producto_combo == null || element.id_producto_combo==0)){
							console.log("C");
							// Doc Aplica Impuesta.
			    			_orden[_orden.indexOf(element)].impA = 0;
			    			_orden[_orden.indexOf(element)].total_anterior = (element.presentacionPrecio * element.cantidad);
			    			aplicar_imp( element );

			    		}else{
			    			console.log("D");
			    			// No hacer nada
			    			//_orden[_orden.indexOf(element)].total_anterior = (element.presentacionPrecio * element.cantidad);
			    			//aplicar_imp_duplicado(_docVal , element);
			    		}
			    	}else{
			    		console.log("E");
			    		_orden[_orden.indexOf(element)].impA = 0;
		    			_orden[_orden.indexOf(element)].total_anterior = (element.presentacionPrecio * element.cantidad);
			    		separar_iva(element);
			    	}
		    	}
	    	}
	    });
    }
    
    get_total_orden();
    aplicar_imp_especial();
    ivaTotal();
    
}

function imp_list(imp_doc , doc){
	
	var x = false;
	var c = 0;
	_ImpList = [];

	$.each(_impuestos.doc, function(i, item) {

    	if(item.Documento == doc && item.estado != 0 ){
    		
    		_ImpList[c] = item;
    		_ImpList[c].nombre = item.nombre;
    		_ImpList[c].nombres = item.nombre;

    		x = true;
    		c+=1;
    	}
    });

	return x;
}

function imp_cat_val(categoria){

	var x = false;
	var c = 0;
	_catVal = [];

	$.each(_impuestos.cat, function(i, item) {
    	
    	// Categoria de producto sea igual
    	if(item.Categoria == categoria && item.estado !=0 )
		{			
			_catVal[_catVal.length] = item;
			
			x = true;	
			c+=1;
		}
	});

	return x;
}

function imp_cli_val(){
	var x = false;
	var c = 0;
	_cliVal = [];

	_tipo_cliente = tipo_cliente();

	if(_tipo_cliente == 0){
		alert("Cliente es 0. Seleccione cliente");
		return;
	}

	$.each(_impuestos.cli, function(i, item) {
    	
    	if(item.Cliente == _tipo_cliente && item.estado !=0 )
		{
			$.each(_ImpList, function(i, item2) {
				
				if(item2.nombre == item.nombre){					
					_cliVal[_cliVal.length] = item;
				}				
			});
			
			x = true;	
			c+=1;
		}
	});
}

function aplicar_imp( prod){
	
	var total = 0;
	var sub_total = 0;
	var aplicable = false;
	
	_orden.forEach(function(element) {

		if(element.producto2 == prod.producto2 && element.id_producto_combo == null){
			
			$.each(_catVal, function(i, item) {

				var yes = check_aplicable(item.nombre);
				
				if( item.condicion == 0 && yes == true){
					
					aplicable = true;
					total += (element.total_anterior * item.porcentage);
				}
				
			});
			if(aplicable){
				sub_total =  parseFloat(_orden[_orden.indexOf(element)].total_anterior) + parseFloat(total.toFixed(2));
				
				_orden[_orden.indexOf(element)].impSuma = total;
				//_orden[_orden.indexOf(element)].total = sub_total.toFixed(2);
				_orden[_orden.indexOf(element)].impA = 1;

				aplicable = false;

			}

			
		}
	});
}

function check_aplicable( imp_categoria ){

	var flag1 = false;
	var flag2 = false;
	var flag3 = false;

	$.each(_ImpList, function(i, item) {
		if( item.nombres = imp_categoria ){
			flag1 = true;
		}
	});

	$.each(_cliVal, function(i, item) {
		if( item.nombres = imp_categoria ){
			flag2 = true;
		}
	});

	if(flag1 == true && flag2==true){
		flag3 = true;
	}
	return flag3;
}

function aplicar_imp_combo( prod){
	
	var total = 0;
	var sub_total = 0;
	var aplicable = false;
	
	_orden.forEach(function(element) {

		if(element.producto2 == prod.id_producto_detalle && prod.combo == 1){
			
			$.each(_catVal, function(i, item) {
				var yes = check_aplicable(item.nombre);
				if( item.especial == 0 && item.condicion!=1 && yes == true ){
					aplicable = true;
					total += (element.total_anterior * item.porcentage);
				}
				
			});		
			if(aplicable){
				sub_total =  parseFloat(_orden[_orden.indexOf(element)].total_anterior) + parseFloat(total.toFixed(2));
				
				_orden[_orden.indexOf(element)].impSuma = total;
				//_orden[_orden.indexOf(element)].total = sub_total.toFixed(2);
				_orden[_orden.indexOf(element)].impA = 1;
				aplicable = false;
			}	
			
		}
	});	
}

function aplicar_imp_duplicado( prod){
	_orden.forEach(function(element) {
		
		if(element.producto2 == prod.producto2){
			
			total = (element.total_anterior * _catVal);
			
			_orden[_orden.indexOf(element)].total = total.toFixed(2);
		}
	});
}

function aplicar_imp_especial(prod){

	var total = 0;
	var contador = 0;
	_impuestos_orden = [];

	$.each(_ImpList, function(i, item) {
		
		if( item.condicion == 1  ){
			
			if(item.condicion_simbolo == '>='){

				if(eval(total_orden >= item.condicion_valor) ){

					_impuestos_orden[contador] = {
						ordenImpName : item.nombre,
						ordenImpVal  : item.porcentage,
						ordenImpTotal: (total_orden * item.porcentage)
					};
					contador++;	
				}
			}

			if(item.condicion_simbolo == '<='){
				if(eval(total_orden <= item.condicion_valor) ){
					_impuestos_orden[contador] = {
						ordenImpName : item.nombre,
						ordenImpVal  : item.porcentage,
						ordenImpTotal: (total_orden * item.porcentage)
					};
					contador++;	
				}
			}
		}
	});
}

function get_total_orden(){

	total_orden = 0;

	_orden.forEach(function(element) {
		total_orden += parseFloat(element.total);
	});

	return total_orden;
}

function quitar_imp(imp, prod){
	// Remover Impuesto de la orden

}

function separar_iva(prod){
	var total = 0;
	var sub_total = 0;
	
	_orden.forEach(function(element) {

		if(element.producto2 == prod.producto2 && element.id_producto_combo == null){

			$.each(_catVal, function(i, item) {
				if( item.nombre == 'IVA'){
					total += (element.total_anterior / (1 + item.porcentage));
					//console.log(item.nombre , item.porcentage, total );
				}				
			});
			
			sub_total =  parseFloat(_orden[_orden.indexOf(element)].total_anterior) - parseFloat(total.toFixed(2));
			
			_orden[_orden.indexOf(element)].impSuma = total;
			_orden[_orden.indexOf(element)].total = sub_total.toFixed(2);
			_orden[_orden.indexOf(element)].impA = 1;
		}
	});
}

function ivaTotal(){
	total_iva = 0;
	var c = 1;
	
	$.each(_orden, function(i, item) {

		if(item.impSuma){

			var tmp = item.impSuma.toFixed(2);
			total_iva += parseFloat(tmp);

		}
		c++;
		
	});	

}

/*********** Orden  ************/

function getImagen(producto_id){
	$.ajax({
        url: "get_productos_imagen/"+producto_id,
        datatype: 'json',      
        cache : false,                

        success: function(data){

            var datos = JSON.parse(data);
            html = '<img src="data: '+datos['type']+' ;<?php echo 'base64'; ?>,'+datos['imagen']+'" class="preview_producto" style="width:400px" />';
            $('.producto_imagen').html(html);
        
        },
        error:function(){
        }
    });
}

/*********** select product grid **********/



