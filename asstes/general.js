
var _tipo_documento;
var total_orden = 0;
var docVal, catVal, proVal, cliVal;
var _docVal = [];
var _catVal = [];
var _proVal = [];
var _cliVal = [];
var _impuestos_orden = [];


$(document).ready(function(){

	// Cambiar Tipo Documento

	_tipo_documento = $("#id_tipo_documento").val();
	$("#id_tipo_documento").change(function(){
		tipo_documento($(this).val());

		
	});

});

function tipo_documento(tipo_documento){
	_tipo_documento = tipo_documento;

}

function _config_impuestos(){
	impuestos();
}



function impuestos(){
    /*
     * Calcular los impuestos a productos en la orden
     */
    docVal = imp_doc_val(_impuestos.doc , _tipo_documento);

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
			    		//aplicar_imp_especial(element);
			    	}
		    	}
	    	}
	    });
    }
    
    get_total_orden();
    aplicar_imp_especial();
}

function imp_doc_val(imp_doc , doc){
	
	var x = false;
	var c = 0;
	_docVal = [];

	$.each(imp_doc, function(i, item) {

    	if(item.Documento == doc && item.estado != 0 ){
    		
    		_docVal[c] = {
    			'entidad' : item.nombre, 
    			'valor' : item.porcentage, 
    			'especial': item.especial, 
    			'excluyente': item.excluyente,
    			'condicion' : item.condicion,
    			'condicion_valor': item.condicion_valor,
    			'condicion_simbolo': item.condicion_simbolo
    		};

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
			//Que no exista impuesto para agregarlo
			$.each(_docVal, function(i, item2) {
				
				if(item2.entidad == item.nombre){					
					_catVal[_catVal.length] = {
						'entidad' : item.nombre, 
						'valor' : item.porcentage, 
						'especial': item.especial, 
						'excluyente': item.excluyente,
						'condicion' : item.condicion,
    					'condicion_valor': item.condicion_valor,
    					'condicion_simbolo' : item.condicion_simbolo
					};
				}
				
			});
			
			x = true;	
			c+=1;
		}
	});

	return x;
}

function aplicar_imp( prod){
	
	var total = 0;
	var sub_total = 0;
	var aplicable = false;
	
	_orden.forEach(function(element) {

		if(element.producto2 == prod.producto2 && element.id_producto_combo == null){

			$.each(_catVal, function(i, item) {
				if( item.condicion == 0 ){
					aplicable = true;
					total += (element.total_anterior * item.valor);
				}				
			});

			if(aplicable){
				sub_total =  parseFloat(_orden[_orden.indexOf(element)].total_anterior) + parseFloat(total.toFixed(2));
			
				_orden[_orden.indexOf(element)].total = sub_total.toFixed(2);
				_orden[_orden.indexOf(element)].impA = 1;

			}
		}
	});
}

function aplicar_imp_combo( prod){
	
	var total = 0;
	var sub_total = 0;
	var aplicable = false;
	
	_orden.forEach(function(element) {

		if(element.producto2 == prod.id_producto_detalle && prod.combo == 1){
			
			$.each(_catVal, function(i, item) {
				if( item.especial == 0 && item.condicion!=1){
					aplicable = true;
					total += (element.total_anterior * item.valor);
				}
			});

			if(aplicable){
				sub_total =  parseFloat(_orden[_orden.indexOf(element)].total_anterior) + parseFloat(total.toFixed(2));

				_orden[_orden.indexOf(element)].total = sub_total.toFixed(2);
				_orden[_orden.indexOf(element)].impA = 1;
				aplicable = false;
			}
			
		}
	});	
}

function aplicar_imp_duplicado( prod){
	_orden.forEach(function(element) {
		//console.log("3",element.total_anterior , imp);
		if(element.producto2 == prod.producto2){
			
			total = (element.total_anterior * _catVal);
			
			_orden[_orden.indexOf(element)].total = total.toFixed(2);
		}
	});
}

function aplicar_imp_especial(prod){

	var total = 0;

	$.each(_catVal, function(i, item) {

		if( item.condicion == 1 ){

			if(item.condicion_simbolo == '>='){
				if(eval(total_orden >= item.condicion_valor) ){
					_impuestos_orden[i] = {
						ordenImpName : item.entidad,
						ordenImpVal  : item.valor,
						ordenImpTotal: (total_orden * item.valor)
					}
				}
			}

			if(item.condicion_simbolo == '<='){
				if(eval(total_orden <= item.condicion_valor) ){
					_impuestos_orden[i] = {
						ordenImpName : item.entidad,
						ordenImpVal  : item.valor,
						ordenImpTotal: (total_orden * item.valor)
					}
				}
			}

		}				
	});
}

function aplicar_imp_condicional(){

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