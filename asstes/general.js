
var _tipo_documento;
var _tipo_cliente;
var total_orden = 0;
var total_iva = 0;
var total_iva_suma = 0;
var exento_iva = 0;
var exento_iva_suma = 0;
var total_sin_impuesto = 0;
var result = 0;
var docVal, catVal, proVal, cliVal;
var _ImpList = [];
var _docVal = [];
var _catVal = [];
var _proVal = [];
var _cliVal = [];
var _impuestos = [];
var _impuestos_orden_condicion = [];
var _impuestos_orden_especial = [];
var _impuestos_orden_excluyentes = [];
var _impuestos_orden_iva = [];
var _impuestos_orden_exento = [];
var _impuestos_total = [];
var exist_cat;
var _conf = [];
var sub_total_ = 0;
var registro_editado = 0;

/* Impuestos Acumulados */

$(document).ready(function(){

	_tipo_documento = $("#id_tipo_documento").val();
	$("#id_tipo_documento").change(function(){
		//tipo_documento($(this).val());
	});

});

function tipo_cliente(){
	var id = $("#cliente_codigo").val();
	return id;
}

function _config_impuestos(){
	
	_impuestos_total = [];
	_impuestos_orden_condicion = [];
	_impuestos_orden_especial = [];
	//_impuestos_orden_excluyentes = [];
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

    		if(element.id_producto_combo==null || element.id_producto_combo==0){
    			exist_cat = imp_cat_val(element.categoria);			
		    	if(element.combo == 1){
					
		    		if((element.iva != "on" || element.iva != 1)  ){

		    			if(_conf.comboAgrupado == 0){ // referencia combo_total
		    				console.log("A");

							_orden[_orden.indexOf(element)].impA = 0;
							_orden[_orden.indexOf(element)].precioUnidad = element.combo_total;
							
		    				_orden[_orden.indexOf(element)].total_anterior = (element.combo_total * element.presentacionFactor);

		    			}else{ // referencia total
		    				console.log("B", element.categoria);
		    				imp_cat_val(element.categoria);		    				
		    				_orden[_orden.indexOf(element)].impA = 0;
		    				_orden[_orden.indexOf(element)].total_anterior = (element.precioUnidad * element.presentacionFactor * element.cantidad);
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
			    		}
			    	}else{
			    		console.log("E");
			    		_orden[_orden.indexOf(element)].impA = 0;
		    			_orden[_orden.indexOf(element)].total_anterior = (element.precioUnidad * element.presentacionFactor);
			    		
			    		var f = producto_valido_especial(element);
			    		if(f){
			    			impuesto_valor(element);
			    			aplicar_imp(element);
			    		}else{
			    			aplicar_imp(element);
						}
						aplicar_imp_combo( element );
			    		
			    	}
		    	}
	    	}
	    });
    }
    
    get_total_orden();
    aplicar_imp_especial();
    get_total_orden();
    ivaTotal();
    get_total_orden();
    
}

function imp_list(imp_doc , doc){
	
	var x 	= false;
	var c 	= 0;
	_ImpList= [];
	_proVal = [];
	doc = parseInt(doc);
	var impuestos_internos = _impuestos.doc.filter(x => x.Documento  ==  doc);
	
	$.each(impuestos_internos, function(i, item) {
		if(item.estado != 0 ){
    		_ImpList[c] = item;
    		x = true;
    		c+=1;
    	}
    });

    $.each(_impuestos.pro, function(i,item){
		_proVal[_proVal.length] = item;
	});

	return x;
}

function imp_cat_val(categoria){

	var x 	= false;
	var c 	= 0;
	_catVal = [];
	_proVal = [];
	categoria = parseInt(categoria);
	var impuestos_internos = _impuestos.cat.filter(x => x.Categoria  ==  categoria);

	$.each(impuestos_internos, function(i, item) {    	
    	// Categoria de producto sea igual
    	if(item.estado !=0 )
		{			
			_catVal[_catVal.length] = item;			
			x = true;	
			c+=1;
		}
	});

	$.each(_impuestos.pro, function(i,item){
		_proVal[_proVal.length] = item;
	});

	return x;
}

function imp_cli_val(){
	var x = false;
	var c = 0;
	_cliVal = [];
	_proVal = [];

	_tipo_cliente = tipo_cliente();
	
	if(_tipo_cliente == 0){
		alert("Cliente es 0. Seleccione cliente");
		return;
	}

	var impuestos_internos = _impuestos.cli.filter(x => x.Cliente  ==  _tipo_cliente);

	$.each(impuestos_internos, function(i, item) {
    	
    	if(item.estado !=0 )
		{
			var impuestos_internos2 = _ImpList.filter(x => x.nombre  ==  item.nombre);
			$.each(impuestos_internos2, function(i, item2) {
				if(item2.nombre == item.nombre){					
					_cliVal[_cliVal.length] = item;
				}				
			});			
			x = true;	
			c+=1;
		}
	});

	$.each(_impuestos.pro, function(i,item){
		_proVal[_proVal.length] = item;
	});
}

function aplicar_imp( prod){
	
	var total = 0;
	var sub_total = 0;
	var aplicable = false;
	
	var orden_interna = _orden.filter(x => x.producto2  ==  prod.producto2);

	orden_interna.forEach(function(element) {

		if(element.id_producto_combo == null || element.id_producto_combo == 0){

			$.each(_catVal, function(i, item) 
			{
				var yes = check_aplicable(item.nombre);	
				
				if( item.condicion == 0 && item.especial==0 && yes == true)
				{					
					aplicable = true;
					var calcu = (parseFloat(element.precioUnidad) * parseFloat( element.presentacionFactor) * (element.cantidad));
					
					var calcu2 = (calcu / (parseFloat (item.porcentage) + 1 ));
					
					var calcu3 = (calcu2  * item.porcentage);

					total += calcu3;
					console.log(" G -> ", total);

					if(element.gen !="Exentos")
					{
						alert(2);
						if(_impuestos_orden_iva.length==0 )
						{
							_impuestos_orden_iva[_impuestos_orden_iva.length] = {
								ordenImpName : item.nombre,
								ordenSimbolo : 0,
								ordenImpVal  : item.porcentage,
								ordenImpTotal: total,
								ordenEspecial: item.especial
							};
						}

						$.each(_impuestos_orden_iva, function(i, ioi) {
							if(ioi.ordenImpName == item.nombre)
							{
								_impuestos_orden_iva[_impuestos_orden_iva.indexOf(ioi)] = {
									ordenImpName : item.nombre,
									ordenSimbolo : 0,
									ordenImpVal  : item.porcentage,
									ordenImpTotal: total,
									ordenEspecial: item.especial
								};
							}
						});

					}else{
						if(_impuestos_orden_exento.length==0 )
						{
							_impuestos_orden_exento[_impuestos_orden_exento.length] = {
								ordenImpName : item.nombre,
								ordenSimbolo : 'E',
								ordenImpVal  : 0.13,
								ordenImpTotal: total,
								ordenEspecial: item.especial
							};
						}

						$.each(_impuestos_orden_exento, function(i, ioi) {
							if(ioi.ordenImpName == item.nombre)
							{
								_impuestos_orden_exento[_impuestos_orden_exento.indexOf(ioi)] = {
									ordenImpName : item.nombre,
									ordenSimbolo : 'E',
									ordenImpVal  : 0.13,
									ordenImpTotal: total,
									ordenEspecial: item.especial
								};
							}
						});
					}				

					return false;
				}

				if(item.condicion == 0 && item.especial==1 && item.excluyente==1 && yes == true){
					console.log("2 aplicar_imp");
					//impuesto_valor(prod);
					
					if(_impuestos_orden_especial.length==0){
						_impuestos_orden_especial[_impuestos_orden_especial.length] = {
							ordenImpName : item.nombre,
							ordenSimbolo : 0,
							ordenImpVal  : item.porcentage,
							ordenImpTotal: (element.total_anterior * item.porcentage),
							ordenEspecial: item.especial
						};
					}
					
					$.each(_impuestos_orden_especial, function(i, ioe) {
						if(ioe.ordenImpName == item.nombre){

							_impuestos_orden_especial[_impuestos_orden_especial.indexOf(ioe)] = {
								ordenImpName : item.nombre,
								ordenSimbolo : 0,
								ordenImpVal  : item.porcentage,
								ordenImpTotal: (element.total_anterior * item.porcentage),
								ordenEspecial: item.especial
							};

						}else{

							_impuestos_orden_especial[_impuestos_orden_especial.length] = {
								ordenImpName : item.nombre,
								ordenSimbolo : 0,
								ordenImpVal  : item.porcentage,
								ordenImpTotal: (element.total_anterior * item.porcentage),
								ordenEspecial: item.especial
							};
						}
					});
				}

				if(item.excluyente ==0 && item.especial==1){
					console.log("3 aplicar_imp");
					//alert("Excluyente");
				}
			});
			if(aplicable){
				console.log("4 aplicar_imp", total);
				sub_total =  parseFloat(_orden[_orden.indexOf(element)].total_anterior) + parseFloat(total.toFixed(2));				
				_orden[_orden.indexOf(element)].impSuma = total;
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
	var flag4 = false;
	var flag5 = false;

	var impList = _ImpList.filter(x => x.nombre  ==  imp_categoria);

	if( impList ){
		flag1 = true;
	}

	var cliVal = _cliVal.filter(x => x.nombre  ==  imp_categoria);
	
	if( cliVal ){
		flag2 = true;
	}

	var catVal = _catVal.filter(x => x.nombre  ==  imp_categoria);

	if( catVal ){
		flag3 = true;
	}

	var proVal = _proVal.filter(x => x.nombre  ==  imp_categoria);

	if( proVal ){
		flag4 = true;
	}

	if(flag1 == true && flag2==true && flag3==true && flag4==true){
		
		flag5 = true;
	}
	return flag5;
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
					total += ((element.precioUnidad * element.cantidad * element.presentacionFactor) * item.porcentage) / (parseFloat(item.porcentage)+1);
					console.log("Imp Combo ->", total);
				}				
			});
			if(aplicable){
				console.log("COMBO ->", total);
				sub_total =  parseFloat(_orden[_orden.indexOf(element)].total_anterior) + parseFloat(total.toFixed(2));
				
				_orden[_orden.indexOf(element)].impSuma = total;
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
	_impuestos_orden_condicion = [];

	$.each(_catVal, function(i, item) {
		
		var yes = check_aplicable(item.nombre);		

			if( item.condicion == 1 && yes == true){
				
				if(item.condicion_simbolo == '>='){

					if(eval(total_orden >= item.condicion_valor) ){

						_impuestos_orden_condicion[_impuestos_orden_condicion.length] = {
							ordenImpName : item.nombre,
							ordenSimbolo : 0,
							ordenImpVal  : item.porcentage,
							ordenImpTotal: (total_orden * item.porcentage),
							ordenEspecial 	 : item.especial
						};
						contador++;	
					}
				}

				if(item.condicion_simbolo == '<='){

					if(eval(total_orden <= item.condicion_valor) ){

						_impuestos_orden_condicion[_impuestos_orden_condicion.length] = {
							ordenImpName : item.nombre,
							ordenSimbolo : 0,
							ordenImpVal  : item.porcentage,
							ordenImpTotal: (total_orden * item.porcentage),
							ordenEspecial 	 : item.especial
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
		if(element.id_producto_combo == null || element.id_producto_combo==0){
			total_orden += parseFloat(element.total);
		}
	});
	console.log("Total orden -> ", total_orden);
	return total_orden;
}

function quitar_imp(imp, prod){
	// Remover Impuesto de la orden
}

function impuesto_valor(prod){

	var dinero 			= 0;
	var cant_galon 		= 0;
	var precio_galon 	= 0;
	var imp_asociados 	= 0;

	$.each(_impuestos.cat, function(i, item) {	

		if(_orden[_orden.indexOf(prod)].categoria == item.Categoria){
			if(item.excluyente ==0 && item.especial==1 ){
				
				imp_asociados += parseFloat(item.porcentage);
			}
		}
	});

	console.log("B");

	_orden.forEach(function(element) {

		if(!element.dinero && (_orden[_orden.indexOf(prod)].id_producto_detalle == element.id_producto_detalle) ){
			is_money = true;
			do{
				if(registro_editado!=1){
					result = prompt("Monto en Dinero");
					dinero = parseFloat(result);
				}				
				if(dinero){
					is_money = false;
					_orden[_orden.indexOf(prod)].total = dinero;
					_orden[_orden.indexOf(prod)].dinero = dinero;
				}else{
					is_money = false;
					dinero = (_orden[_orden.indexOf(prod)].total_anterior * _orden[_orden.indexOf(prod)].cantidad);
					_orden[_orden.indexOf(prod)].total = _orden[_orden.indexOf(prod)].total_anterior;
					_orden[_orden.indexOf(prod)].dinero = (_orden[_orden.indexOf(prod)].total_anterior * _orden[_orden.indexOf(prod)].cantidad);
				}
			}while(is_money);

			if(imp_asociados!= 0 && element.dinero){

				precio_galon = _orden[_orden.indexOf(prod)].total_anterior + imp_asociados;
				cant_galon = dinero / precio_galon;
				//console.log("G = ", cant_galon , precio_galon, imp_asociados);
				
				_orden[_orden.indexOf(prod)].cantidad = cant_galon.toFixed(3);
				
				$.each(_impuestos.cat, function(i, item) {
					if(_orden[_orden.indexOf(prod)].categoria == item.Categoria){
						if(item.excluyente ==0 && item.especial==1 ){

							if(_impuestos_orden_excluyentes.length ==0){

								_impuestos_orden_excluyentes[_impuestos_orden_excluyentes.length] = {
									ordenImpName : item.nombre,
									ordenImpVal  : item.porcentage,
									ordenImpTotal: (cant_galon * item.porcentage),
									ordenEspecial: item.excluyente,
									ordenSimbolo : item.condicion_simbolo
								};
							}else{

								$imp_flag = true;
								_impuestos_orden_excluyentes.forEach(function(impuestos_especial){
									
									if(impuestos_especial.ordenImpName == item.nombre){
										
										$imp_flag = false;
										_impuestos_orden_excluyentes[_impuestos_orden_excluyentes.indexOf(impuestos_especial)].ordenImpTotal += (cant_galon * item.porcentage);
										
									}									
								});

								if($imp_flag){
									_impuestos_orden_excluyentes[_impuestos_orden_excluyentes.length] = {
										ordenImpName : item.nombre,
										ordenImpVal  : item.porcentage,
										ordenImpTotal: (cant_galon * item.porcentage),
										ordenEspecial: item.excluyente,
										ordenSimbolo : item.condicion_simbolo
									};
								}
							}				

						}
					}					
				});					
			}			
		}		
	});
	
}

function producto_valido_especial(prod){

	var flag = false;

	$.each(_impuestos.cat, function(i, item) {	
		if(_orden[_orden.indexOf(prod)].categoria == item.Categoria){
			if(item.excluyente == 0 && item.especial==1 ){
				flag=true;
			}
		}
	});	
	return flag;
}

function separar_iva(prod){
	var total = 0;
	var sub_total = 0;
	var aplicable = false;
	var dinero = 0;
	var valores = 0;
	var inpuesto = 0;
	_impuestos_orden_excluyentes = [];
	
	console.log("A");
	_orden.forEach(function(element) {

		if(element.iva == 1 || element.iva=='on'){
			
			$.each(_impuestos.cat, function(i, item) {				
				
				if(item.Categoria == element.categoria){
					
					if(item.excluyente ==0 && item.especial==1 ){
						if(!element.dinero){

							is_money = true;
							
							do{
								result = prompt("Monto en Dinero");
								dinero = parseFloat(result);
								
								if(dinero){
									is_money = false;
									_orden[_orden.indexOf(element)].total = dinero;
								}
							}while(is_money);

							
							_orden[_orden.indexOf(element)].dinero = dinero;
						}else{
							dinero = _orden[_orden.indexOf(element)].dinero;
						}

						valores = (dinero / _orden[_orden.indexOf(element)].total_anterior);
						inpuesto = (valores * item.porcentage);

						
						_impuestos_orden_excluyentes[_impuestos_orden_excluyentes.length] = {
							ordenImpName : item.nombre,
							ordenImpVal  : item.porcentage,
							ordenImpTotal: (valores * item.porcentage),
							ordenEspecial: item.excluyente,
							ordenSimbolo : 0
						};
						
						a = _orden[_orden.indexOf(element)].total;
						b = valores * item.porcentage;
						c = a - b;

						_orden[_orden.indexOf(element)].total = c.toFixed(2);
						

						aplicable = false;
					}else{
						
						b = parseFloat(valores)  * parseFloat(item.porcentage) ;

						if(item.nombre == 'IVA'){
							
							total = b;						
							sub_total =  _orden[_orden.indexOf(element)].total - parseFloat(b) ;						
							
							_orden[_orden.indexOf(element)].impSuma = b;
							_orden[_orden.indexOf(element)].total = sub_total.toFixed(2);
							_orden[_orden.indexOf(element)].impA = 1;

							aplicable = false;

						}
						if(item.nombre == 'IVA' && !element.dinero){
							console.log("Dentro de C", b);
							total = b;
							aplicable = true;
						}
					}

					if(aplicable){
						console.log(total, " quien es");
						sub_total =  parseFloat(_orden[_orden.indexOf(element)].total) - parseFloat(total.toFixed(2));
								
						_orden[_orden.indexOf(element)].impSuma = total;
						_orden[_orden.indexOf(element)].total = sub_total.toFixed(2);
						_orden[_orden.indexOf(element)].impA = 1;
					}

				}
			});

		}
	});
}

function ivaTotal(){
	total_iva 		= 0;
	exento_iva 		= 0;
	exento_iva_suma = 0;
	total_iva_suma 	= 0;
	sub_total_ 		= 0;
	sub_total_exento= 0;
	var c 			= 1;
	
	$.each(_orden, function(i, item) {

		if(item.impSuma && item.gen !="Exentos"){
			
			var tmp = parseFloat(item.impSuma).toFixed(2);

			total_iva += parseFloat(tmp);

			sub_total_ += parseFloat(item.total_anterior ) - parseFloat( tmp ) ;						

			if(item.iva==0){
				//total_iva_suma += parseFloat(tmp);
			}
		}else{
			exento_iva_suma += (parseFloat(item.total_anterior )*0.13)/1.13 ;
		}
		c++;		
	});
	
	//total_iva_suma =  sub_total_;
	sub_total();
}

function sub_total(){
	
	var _total_impues_exclu=0;

	$.each(_impuestos_orden_excluyentes , function(i, item){
		_total_impues_exclu += parseFloat( item.ordenImpTotal );
		
	});
	sub_total_ = total_orden - _total_impues_exclu ;
}

/*********** Orden  ************/

function getImagen(producto_id){
	/*$.ajax({
        url: "get_productos_imagen/"+producto_id,
        datatype: 'json',      
        cache : false,                

        success: function(data){

            var datos = JSON.parse(data);

            html = '<img src="data: '+datos['type']+' ; base64 ,'+datos['imagen']+'" class="preview_producto img-responsive img-thumbnail" style="" />';
            $('.producto_imagen').html(html);
        
        },
        error:function(){
        }
    });*/
}

/*********** select product grid **********/



