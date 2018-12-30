<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script>

var _orden = [];
var _productos = [];
var contador_productos = 0;
var contador_tabla =1;
var total_msg = 0;

$(document).ready(function(){

    $('#producto_modal').appendTo("body");

    
    $(document).on('click', '.producto_buscar', function(){
      	$('#producto_modal').modal('show');
        $("#codigo_barra_seleccionado").focus();

        get_productos_lista();
    });
    

    function get_productos_lista(){
        
        var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Nombre</th><th>Codigo</th><th>Id Producto</th><th>Marca</th><th>Categoria</th><th>Sub Categoria</th><th>Giro</th><th>Empresa</th><th>Action</th>";
        var table_tr = "<tbody id='list'>";
        var contador_precios=1;

        $.ajax({
            url: "get_productos_lista",
            datatype: 'json',      
            cache : false,                

                success: function(data){
                    var datos = JSON.parse(data);
                    var productos = datos["productos"];
                    var producto_id = 0;
                    
                    $.each(productos, function(i, item) { 

                    	if(producto_id != item.id_entidad){
                    		producto_id = item.id_entidad;	
                    		var precio = 0;
	                    	
	                        table_tr += '<tr><td>'+contador_precios+'</td><td>'+item.name_entidad+'</td><td>'+item.cod_barra+'</td><td>'+item.id_entidad+'</td><td>'+item.nombre_marca+'</td><td>'+item.nombre_categoria+'</td><td>'+item.SubCategoria+'</td><td>'+item.nombre_giro+'</td><td>'+item.nombre_razon_social+'</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_producto" id="'+item.id_entidad+'">Agregar</a></td></tr>';
	                        contador_precios++;
                        }
                        
                    });
                    table += table_tr;
                    table += "</tbody></table>";

                    $(".productos_lista_datos").html(table);
                
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

    $(document).on('click', '.seleccionar_producto', function(){
        var producto_id = $(this).attr('id');
        get_producto_completo(producto_id);
        $('#producto_modal').modal('hide');
    });

    function get_producto_completo(producto_id){

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

            		$("#producto").val(datos['producto'][12].valor);
            		$("#presentacion").val(datos['producto'][0].valor);
            		$("#precioUnidad").val(datos['producto'][8].valor);
            		$("#descuento").val(datos['producto'][7].valor);

            		var cantidad = $("#cantidad").val();
            		precioUnidad = datos['producto'][8].valor;

            		$("#total").val(calcularTotalProducto(precioUnidad, cantidad));

            	_productos["producto"] = datos['producto'][12].valor;
            	_productos["presentacion"] = datos['producto'][0].valor;
            	_productos["precioUnidad"] = datos['producto'][8].valor;
            	_productos["descuento"] = datos['producto'][7].valor;
            	_productos["cantidad"] = cantidad;
            	_productos["total"] = $("#total").val();



            },
            error:function(){
            }
        });
    }

    $(document).on('change', '#cantidad', function(){
    	var precion = $("#precioUnidad").val();
    	var cantidad = $("#cantidad").val();

    	$("#total").val(calcularTotalProducto(precion, cantidad));

    	var cantidad = $("#cantidad").val();
    	_productos["cantidad"] = cantidad;
    	_productos["total"] = $("#total").val();
    });

    function calcularTotalProducto(precio , cantidad){
    	var total = (precio * cantidad);
    	return total;
    }

    // Grabar producto en la orden
	$(document).on('click', '#grabar', function(){
		
		$('.uno').find('input').each(function(){
		    this.value = '';	
		    $("#grabar").val("Grabar");		
		    $("#cantidad").val(1);		       	    
		});


		if(_productos != null){

			if(contador_productos==0){

				_orden[contador_productos] = _productos;
				total_msg += parseInt(calcularTotalProducto(_productos['precioUnidad'], _productos['cantidad']));
				agregar_producto();

			}else{				

				var existe =0;
				var cnt = 0;
				$.each(_orden, function(i, item) {

					if(item.producto == _productos['producto'] ){
						existe = 1;

						//Actualizando Cantidad
						var cantidad = parseInt(_productos['cantidad']) + parseInt($("."+_productos['producto']).text());
						$("."+_productos['producto']).text(cantidad);
						_orden[cnt]['cantidad'] = cantidad;

						//Actualizando total
						$(".total"+_orden[cnt]['producto']).text(calcularTotalProducto(_productos['precioUnidad'], cantidad));
						
						total_msg += parseInt(calcularTotalProducto(_productos['precioUnidad'], _productos['cantidad']));
					}
					cnt ++;				
				});
				if(existe == 0){
					_orden[contador_productos] = _productos;
					total_msg += parseInt(_productos['precioUnidad']);

					agregar_producto();
				}
			}
		}
		$(".total_msg").text("$ "+total_msg.toFixed(2));
		console.log(_orden);

    });

    function agregar_producto(){

		contador_productos++;

		var tr_html = "<tr class=''>";
		tr_html += "<td class=''>"+contador_tabla+"</td>";
		tr_html += "<td class='border-left'>"+_productos['producto']+"</td>";
		tr_html += "<td class='border-left'></td>";
		tr_html += "<td class='border-left "+_productos['producto']+"'>"+_productos['cantidad']+"</td>";
		tr_html += "<td class='border-left'>"+_productos['presentacion']+"</td>";
		tr_html += "<td class='border-left'></td>";
		tr_html += "<td class='border-left'>"+_productos['precioUnidad']+"</td>";
		tr_html += "<td class='border-left'>"+_productos['descuento']+"</td>";
		tr_html += "<td class='border-left total"+_productos['producto']+"'>"+_productos['total']+"</td>";
		tr_html += "<td class='border-left '><input type='button' class='btn btn-primary btn-xs' name='eliminar' id='eliminar' value='Eliminar'/></td>";
		
		tr_html += "</tr>";

		$(".producto_agregados").append(tr_html);

		_productos = [];
		contador_tabla++;
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
                    <div class="panel-title">Crear Orden</div>
                 </div>

                 <div class="panel-body bt">
                 	<div class="row">
                 		<div class="col-lg-3 col-md-3">
                 			<div class="form-group">
                              <label>Tipo Documento</label>
                              <select class="form-control">
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

                 		<div class="col-lg-3 col-md-3">
                 			<div class="form-group">
                              <label>Sucursal</label>
                              <select class="form-control">
	                 			<?php
	                 			foreach ($sucursales as $sucursal) {
	                 				?>
	                 				<option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
	                 				<?php
	                 			}
	                 			?>
	                 			</select>
                           </div>
                 		</div>

                 		<div class="col-lg-3 col-md-3">
                 			<div class="form-group">
                              <label>Numero</label>
                              <input type="text" name="numero" class="form-control">
                           </div>
                 		</div>

                 		<div class="col-lg-3 col-md-3">
                 			<div class="form-group">
                              <label>Total a Pagar</label>
                              <h4 class="total_msg"></h4>
                           </div>
                 		</div>
                 	</div>
                 </div>


                 <div class="panel-body bt">
                    <div class="row">

                		<div class="col-lg-3 col-md-3">
                 			<div class="form-group">
                              <label>Cliente</label>
                             <input type="text" name="cliente" class="form-control">
                           </div>
                 		</div>

                 		<div class="col-lg-3 col-md-3">
                 			<div class="form-group">
                              <label>Descripcion</label>
                             <input type="text" name="descripcion" class="form-control">
                           </div>
                 		</div>

                 		<div class="col-lg-3 col-md-3">
                 			<div class="form-group">
                              <label>Entrega En</label>
                             <input type="text" name="descripcion" class="form-control">
                           </div>
                 		</div>

                 		<div class="col-lg-3 col-md-3">
                 			<div class="form-group">
                              <label>Forma pago</label>
                             <select class="form-control">
	                 				<option>Efectivo</option>
	                 			</select>
                           </div>
                 		</div>

                 	</div>

                 </div>
             
                 <div class="panel-body">
                    <!-- START table-responsive-->
                        <div class="table-responsive" >
                           <table class="table table-sm table-hover">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Descripcion</th>
                                    <th>Cantidad</th>
                                    <th>Presentacion</th>
                                    <th>Tipo</th>
                                    <th>Precio Unidad</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                    <th>Accion</th>
                                 </tr>
                              </thead>
                              <tbody class="uno" style="border-bottom: 3px solid grey">
                              	<tr style="border-bottom: 3px solid grey">
                                    <td colspan="2"><input type="text" class="form-control producto_buscar" id="producto" size="2" name="producto">
                                    </td>
                                    <td><input type="text" class="form-control" id="descripcion" name="descripcion"></td>
                                    <td><input type="number" class="form-control" id="cantidad" name="cantidad" size="1" value="1" min="0" max="1000"></td>
                                    <td><input type="text" class="form-control" id="presentacion" name="presentacion" size="3px"></td>
                                    <td><input type="text" class="form-control" id="tipo" name="tipo" size="2px"></td>
                                    <td><input type="text" class="form-control" id="precioUnidad" name="precioUnidad" size="2px"></td>
                                    <td><input type="text" class="form-control" id="descuento" name="descuento" size="3px"></td>
                                    <td><input type="text" class="form-control" id="total" name="total" size="2px"></td>
                                    <td><input type="button" class="form-control" name="" id="grabar" value="Grabar"/></td>
                                    
                                 </tr>
                              </tbody>
                              <tbody class="producto_agregados" style="border-top:  3px solid black" >
                                 
                              </tbody>
                           </table>
                        </div>
                    <!-- END table-responsive-->
                 </div>
                 <div class="panel-footer text-center"><a href="#" class="btn btn-default btn-oval">Manage Team</a>
                 </div>
              </div>
              <!-- end Team Panel-->
           </div>
        </div>
    </div>
</section>

<!-- Modal Large-->
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



