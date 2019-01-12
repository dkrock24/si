<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script>

var _orden = [];
var _productos = [];
var contador_productos = 0;
var contador_tabla =1;
var total_msg = 0;

$(document).ready(function(){

    $('#producto_modal').appendTo("body");
    $('#cliente_modal').appendTo("body");
    $('#vendedores_modal').appendTo("body");

    
    // Buscar Producto
    $(document).on('click', '.producto_buscar', function(){
      	$('#producto_modal').modal('show');
        $("#codigo_barra_seleccionado").focus();

        get_productos_lista();
    });

    $(document).on('click', '.cliente_codigo', function(){
      	$('#cliente_modal').modal('show');

        get_clientes_lista();
    });

    $(document).on('click', '.vendedores_lista', function(){
      	$('#vendedores_modal').modal('show');

        get_empleados_lista($(this).attr("id"));
    });

    function get_clientes_lista(){
        
        var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Codigo</th><th>Nombre Cliente</th><th>NRC</th><th>NIT</th><th>Action</th>";
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
                    
                    $.each(clientes, function(i, item) { 

                    	if(cliente_id != item.id_cliente){
                    		cliente_id = item.id_cliente;	
                    		var precio = 0;
	                    	
	                        table_tr += '<tr><td>'+contador_precios+'</td><td>'+item.id_cliente+'</td><td>'+item.nombre_empresa_o_compania+'</td><td>'+item.nrc_cli+'</td><td>'+item.nit_cliente+'</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_cliente" id="'+item.id_cliente+'" name="'+item.nombre_empresa_o_compania+'" rel="'+item.direccion_cliente+'">Agregar</a></td></tr>';
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
    

    function get_productos_lista(){

        var sucursal = $("#sucursal_id").val();
        
        var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Nombre</th><th>Codigo</th><th>Id Producto</th><th>Marca</th><th>Categoria</th><th>Sub Categoria</th><th>Giro</th><th>Empresa</th><th>Action</th>";
        var table_tr = "<tbody id='list'>";
        var contador_precios=1;

        $(".productos_lista_datos").html();

        $.ajax({
            url: "get_productos_lista/"+sucursal,
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

    // Cliente Selecionado
    $(document).on('click', '.seleccionar_cliente', function(){

        $("#cliente_codigo").val($(this).attr('id'));
        $("#cliente_nombre").val($(this).attr('name'));
        $("#direccion_cliente").val($(this).attr('rel'));
        $('#cliente_modal').modal('hide');
    });

    // seleccionar_empleado
    $(document).on('click', '.seleccionar_empleado', function(){

        $(".vendedores_lista").text($(this).attr('name'));
        //$("#cliente_nombre").val($(this).attr('name'));
        //$("#direccion_cliente").val($(this).attr('rel'));
        $('#vendedores_modal').modal('hide');
    });

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

                    var precio_unidad = datos['producto'][8].valor;
                    //precio_unidad = ((precio_unidad).toFixed(2));

            		$("#producto").val(datos['producto'][12].valor);
            		$("#presentacion").val(datos['producto'][0].valor);
            		$("#precioUnidad").val( precio_unidad );
            		$("#descuento").val(datos['producto'][7].valor);
                    $("#bodega").val(datos['producto'][0].nombre_bodega);
                    $("#descripcion").val(datos['producto'][0].name_entidad +" "+ datos['producto'][0].nombre_marca  );

            		var cantidad = $("#cantidad").val();
            		precioUnidad = datos['producto'][8].valor;

            	$("#total").val(calcularTotalProducto(precioUnidad, cantidad));

            	_productos["producto"] = datos['producto'][12].valor;
            	_productos["presentacion"] = datos['producto'][0].valor;
            	_productos["precioUnidad"] = datos['producto'][8].valor;
            	_productos["descuento"] = datos['producto'][7].valor;
            	_productos["cantidad"] = cantidad;
            	_productos["total"] = $("#total").val();
                _productos["bodega"] = datos['producto'][0].nombre_bodega;
                _productos["descripcion"] = datos['producto'][0].name_entidad +" "+ datos['producto'][0].nombre_marca;

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
		    $("#grabar").val("Agregar");		
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

                if(_productos.length == 0){
                    
                    if(_orden.length >= 1){
                        
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
                    }else{
                        _orden[contador_productos] = _productos;
                        total_msg += parseInt(_productos['precioUnidad']);
                        agregar_producto();
                    }
                }
                if(existe==0)
                {
                    _orden[contador_productos] = _productos;
                    total_msg += parseInt(_productos['precioUnidad']);
                    agregar_producto();
                    existe=0;
                }

			}
		}
		$(".total_msg").text("$ "+total_msg.toFixed(2));

    });

    function agregar_producto(){

        contador_productos++;
        if(_productos != null){

    		var tr_html = "<tr class='' style='background-color:#d7e1e8;'>";
    		tr_html += "<td class='border-table-left'>"+contador_tabla+"</td>";
    		tr_html += "<td class='border-left'>"+_productos['producto']+"</td>";
    		tr_html += "<td class='border-left'>"+_productos['descripcion']+"</td>";
    		tr_html += "<td class='border-left "+_productos['producto']+"'>"+_productos['cantidad']+"</td>";
    		tr_html += "<td class='border-left'>"+_productos['presentacion']+"</td>";
    		tr_html += "<td class='border-left'></td>";
    		tr_html += "<td class='border-left'>"+_productos['precioUnidad']+"</td>";
    		tr_html += "<td class='border-left'>"+_productos['descuento']+"</td>";
    		tr_html += "<td class='border-left total"+_productos['producto']+"'>"+_productos['total']+"</td>";
            tr_html += "<td class='border-left '>"+_productos['bodega']+"</td>";
    		tr_html += "<td class='border-left'><input type='button' class='btn btn-primary btn-xs eliminar' name='"+_productos['producto']+"' id='eliminar' value='Eliminar'/></td>";
    		
    		tr_html += "</tr>";

    		$(".producto_agregados").append(tr_html);

    		_productos = [];
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

    // Remueve los productos selecionados
    function depurar_producto(){

        contador_tabla=1;

        if(_orden.length >= 1){
            var tr_html = "";
            
            _orden.forEach(function(element) {
                tr_html += "<tr class='' style='background-color:#d7e1e8;'>";
                tr_html += "<td class='border-table-left'>"+contador_tabla+"</td>";
                tr_html += "<td class='border-left'>"+element.producto+"</td>";
                tr_html += "<td class='border-left'>"+element.descripcion+"</td>";
                tr_html += "<td class='border-left'>"+element.cantidad+"</td>";
                tr_html += "<td class='border-left'>"+element.presentacion+"</td>";
                tr_html += "<td class='border-left'></td>";
                tr_html += "<td class='border-left'>"+element.precioUnidad+"</td>";
                tr_html += "<td class='border-left'>"+element.descuento+"</td>";
                tr_html += "<td class='border-left total'>"+element.total+"</td>";
                tr_html += "<td class='border-left '>"+element.bodega+"</td>";
                tr_html += "<td class='border-left'><input type='button' class='btn btn-primary btn-xs eliminar' name='"+element.producto+"' id='eliminar' value='Eliminar'/></td>";
                
                tr_html += "</tr>";

                contador_tabla++;
            });

            $(".producto_agregados").html(tr_html);
            
        }else{
            contador_productos = 0;
            _orden = [];
            _productos = [];

            total_msg = parseInt(0);
            $(".total_msg").text("$ "+total_msg.toFixed(2));
            $(".producto_agregados").empty();
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

                 <!-- START panel-->
                     <div id="panelDemo1" class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-arrow-right"></i> Datos Generales
                           <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                              <em class="fa fa-minus"></em>
                           </a>
                        </div>
                        <div class="panel-wrapper collapse in">
                           <div class="panel-body">
                                <p>
                                    <div class="panel-body bt">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
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
                                                <div class="form-group has-success">
                                                  <label>Sucursal</label>
                                                  <select class="form-control" name="sucursal" id="sucursal_id">
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

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                  <label>Numero</label>

                                                  <input type="text" name="numero" value="<?php echo $correlativo[0]->siguiente_valor; ?>" class="form-control">
                                               </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                  <label>Total a Pagar</label>
                                                  <h4 class="total_msg"></h4>
                                               </div>
                                            </div>
                                        </div>
                                     </div>
                                    
                                    <div class="panel-body bt">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Cliente Codigo</label>
                                                    <input type="text" name="cliente_codigo" class="form-control cliente_codigo" id="cliente_codigo">
                                               </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                  <label>Cliente Nombre</label>
                                                 <input type="text" name="cliente_nombre" class="form-control cliente_nombre" id="cliente_nombre">
                                               </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                  <label>Cliente Direccion</label>
                                                 <input type="text" name="cliente_direccion" class="form-control direccion_cliente" id="direccion_cliente">
                                               </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                <label>Forma Pago</label>
                                                <select class="form-control">
                                                <?php
                                                foreach ($modo_pago as $value) {
                                                    ?><option value="<?php echo $value->id_modo_pago; ?>"><?php echo $value->nombre_modo_pago; ?></option><?php
                                                }
                                                ?>      
                                                </select>
                                               </div>
                                            </div>
                                        </div>
                                     </div>
                                
                                     <div class="panel-body bt">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                  <label>Comentarios</label>
                                                 <input type="text" name="comentarios" class="form-control">
                                               </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                  <label>Fecha</label>
                                                 <input type="date" name="fecha" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                                               </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group has-success">
                                                    <label>Vendedor</label><br>
                                                    <div class="pull-left">
                                                        <input type="hidden" name="vendedor" id="vendedor" value="<?php $empleado[0]->id_empleado; ?>">
                                                       <div class="label bg-gray"><a href="#" class="vendedores_lista" id="<?php echo $empleado[0]->id_sucursal; ?>"><?php echo $empleado[0]->primer_nombre_persona." ".$empleado[0]->primer_apellido_persona; ?></a></div>
                                                       
                                                    </div>                                                          
                                               </div>
                                            </div>
                                        </div>
                                     </div>
                                </p>
                           </div>
                        </div>
                     </div>
                     <!-- END panel-->

             
                 <div class="panel-body">
                    <!-- START table-responsive-->
                        <div class="table-responsive" >
                           <table class="table table-sm table-hover">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Presentación</th>
                                    <th>Típo</th>
                                    <th>Precío Unidad</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                    <th>Bodega</th>
                                    <th>Acción</th>
                                 </tr>
                              </thead>
                              <tbody class="uno" style="border-bottom: 3px solid grey">
                              	<tr style="border-bottom: 3px solid grey">
                                    <td colspan="2"><input type="text" class="form-control producto_buscar border-input" id="producto" size="2" name="producto">
                                    </td>
                                    <td><input type="text" class="form-control border-input" id="descripcion" name="descripcion"></td>
                                    <td><input type="number" class="form-control border-input" id="cantidad" name="cantidad" size="1px" value="1" min="0" max="1000"></td>
                                    <td><input type="text" class="form-control border-input" id="presentacion" name="presentacion" size="3px"></td>
                                    <td><input type="text" class="form-control border-input" id="tipo" name="tipo" size="2px"></td>
                                    <td><input type="text" class="form-control border-input" id="precioUnidad" name="precioUnidad" size="2px"></td>
                                    <td><input type="text" class="form-control border-input" id="descuento" name="descuento" size="2px"></td>
                                    <td><input type="text" class="form-control border-input" id="total" name="total" size="2px"></td>
                                    <td><input type="text" class="form-control border-input" id="bodega" name="bodega" size="5px"></td>
                                    <td><input type="button" class="form-control border-input" name="" id="grabar" value="Agregar"/></td>
                                    
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

