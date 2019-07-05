
var _tipo_documento;
var docVal, catVal, proVal, cliVal;
var _docVal = [];
var _catVal = [];
var _proVal = [];
var _cliVal = [];

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
   //console.log(_orden);
    _orden.forEach(function(element) {

    	if(element.combo == 1){

    		if((element.iva != "on" || element.iva != 1)  ){

    			if(_conf.comboAgrupado == 0){ // referencia combo_total
    				console.log("A");

    				_orden[_orden.indexOf(element)].impA = 0;
    				_orden[_orden.indexOf(element)].total_anterior = (element.combo_total * element.cantidad);

    			}else{ // referencia total
    				console.log("B");
    				
    				_orden[_orden.indexOf(element)].impA = 0;
    				_orden[_orden.indexOf(element)].total_anterior = (element.precioUnidad * element.cantidad);
    			}
				
				aplicar_imp_combo(_docVal , element );	    		

    		}else{
    			// No hacer nada
    			aplicar_imp_duplicado(_docVal , element );
    		}
    	}else{
    		if((element.iva ==0) && element.id_producto_combo == null  ){

	    		if((element.id_producto_combo == null || element.id_producto_combo==0)){
					console.log("C");
					// Doc Aplica Impuesta.
	    			_orden[_orden.indexOf(element)].impA = 0;
	    			_orden[_orden.indexOf(element)].total_anterior = (element.presentacionPrecio * element.cantidad);
	    			aplicar_imp(_docVal , element );

	    		}else{
	    			console.log("D");
	    			// No hacer nada
	    			//_orden[_orden.indexOf(element)].total_anterior = (element.presentacionPrecio * element.cantidad);
	    			//aplicar_imp_duplicado(_docVal , element);
	    		}
	    	}
    	}
    });
}

function imp_doc_val(imp_doc , doc){
	
	var x = false;
	var c = 0;

	$.each(imp_doc, function(i, item) {

    	if(item.Documento == doc && item.aplicar_a_producto == 1 ){

    		_docVal[c] = item.porcentage;
    		x = true;
    		c+=1;
    	}

    });

	return x;
}

/*
	function imp_cat_val(){

	}

	function imp_pro_val(){

	}

	function imp_cli_val(){

	}

	function impuesto_excento(){

	}

*/

function aplicar_imp(imp , prod){
	
	var total = 0;
	console.log(_orden);
	_orden.forEach(function(element) {

		if(element.producto2 == prod.producto2 && element.id_producto_combo == null){
			console.log("xxxx ",element.id_producto_detalle);
			total = (element.total_anterior * imp);
			
			_orden[_orden.indexOf(element)].total = total.toFixed(2);
			_orden[_orden.indexOf(element)].impA = 1;

		}
	});
}

function aplicar_imp_combo(imp , prod){
	
	var total = 0;

	_orden.forEach(function(element) {

		if(element.producto2 == prod.id_producto_detalle && prod.combo == 1){
			console.log("3",element.descripcion);
			total = (element.total_anterior * imp);
			_orden[_orden.indexOf(element)].total = total.toFixed(2);
			_orden[_orden.indexOf(element)].impA = 1;
			
		}
	});	
}

function aplicar_imp_duplicado(imp , prod){
	_orden.forEach(function(element) {
		//console.log("3",element.total_anterior , imp);
		if(element.producto2 == prod.producto2){
			
			total = (element.total_anterior * imp);
			
			_orden[_orden.indexOf(element)].total = total.toFixed(2);
		}
	});
}

function quitar_imp(imp, prod){

}