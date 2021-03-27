<script>
	$(document).ready(function() {
		$("#ModalEmpresa").appendTo('body');

		setTimeout(function() {
            $("#ModalEmpresa").modal();
            
        }, 1000);

		$("#btn_template").on("click", function(){
			$("#ModalEmpresa").modal('toggle');
		});

		(function($) {

			var allPanels = $('.accordion > dd').hide();

			$('.accordion > dt > a').click(function() {
				allPanels.slideUp();
				$(this).parent().next().slideDown();
				return false;
			});

		})(jQuery);		

		// Mostrar contenido en Vista Previa
		$("#template_html").keyup(function() {
			$('.html').html($(this).val());
			//$('.source_code').html($(this).val());
		});		

		var entityMap = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#39;',
			'/': '&#x2F;',
			'`': '&#x60;',
			'=': '&#x3D;'
		};

		function escapeHtml(string) {
			return String(string).replace(/[&<>"'`=\/]/g, function(s) {
				alert(entityMap[s]);
				return entityMap[s];
			});
		}

		$(".control").click(function() {
			var accion = $(this).attr("name");
			var method = $(this).attr("id");
			var valor = $(this).text();

			switch (accion) {

				case 'html':
					html_element(method, valor);
					break;
				case 'table':
					table_element(method);
					break;
				case 'php':
					php_element(method);
					break;
				case 'style':
					style_element(method);
					break;
				case 'delete':
					delete_element();
					break;

			}
		});

		function html_element(method, valor) {
			var html_form
			if (method == 'div') {
				html_form = "<div> </div>";
			} else if (method == 'p') {
				html_form = "<p> </p>";
			} else if (method == 'label') {
				html_form = "<label> </label>";
			} else if( method == 'key'){
				html_form = '$'+valor;
			}

			dibujar(html_form);
		}

		function dibujar(elemento) {

			var txt = jQuery("#template_html");

			var caretPos = txt[0].selectionStart;
			var textAreaTxt = txt.val();
			var txtToAdd = elemento;
			txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
			$('.html').html(txt.val());
			$('.template_php').text(txt.val());
		}

		function table_element2() {
			var filas = prompt("Filas ?");
			var columnas = prompt("columnas ?");
			var html = "";
			html += "<table class='table' onmousedown='mydragg.startMoving(this,'" + "'container'" + "',event);' onmouseup='mydragg.stopMoving('" + "'container'" + "');'>";
			for (x = 0; x < filas; x++) {
				html += "<tr>";
				for (b = 0; b < columnas; b++) {
					html += "<td>" + b + "</td>";
				}
				html += "</tr>";
			}
			html += "</table>";
			dibujar(html);
		}

		function table_element(method) {
			var html_form
			if (method == 'table2') {
				table_element2();
			} else {

				var x = method.substring(method.length - 1);
				if (x == '=') {
					var y = prompt(method + " ?");
					html_form = method + "'" + y + "'";
				} else {
					html_form = method;
				}

				dibujar(html_form);
			}
		}

		function php_element(method) {
			var html_form = "";
			if (method == 'foreach') {
				html_form = "<\?php $items = [1,2,3,4,5]; foreach($items as $val){ echo $val; } ?>";
			}
			if (method == 'date') {
				html_form = "<\?php echo date('Y-m-d'); ?>";
			}
			dibujar(html_form);
		}

		function style_element(method) {
			var x = prompt(method + " ?");
			if (method == "style") {
				var html_form = method + '=" "' + x;
			} else {
				var html_form = method + x;
			}
			dibujar(html_form);
		}

		function delete_element() {
			var editor = document.getElementById("template_html");
			var editorHTML = editor.innerHTML;
			var selectionStart = 0,
				selectionEnd = 0;

			if (editor.selectionStart) selectionStart = editor.selectionStart;
			if (editor.selectionEnd) selectionEnd = editor.selectionEnd;
			if (selectionStart != selectionEnd) {
				var editorCharArray = editorHTML.split("");
				editorCharArray.splice(selectionEnd, 0, "</b>");
				editorCharArray.splice(selectionStart, 0, "<b>"); //must do End first
				editorHTML = editorCharArray.join("");
				editor.innerHTML = editorHTML;
			}
			var x = editor.value.substring(selectionStart, selectionEnd);

			$('#template_html').html(x);
		}

	});
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/css/css_general.css" />

<style type="text/css">
	h1.page-header {
		margin-top: -5px;
	}

	.sidebar {
		padding-left: 0;
	}

	.main-container {
		background: #FFF;
		padding-top: 15px;
		margin-top: -20px;
	}

	.footer {
		width: 100%;
	}

	#template_html {
		caret-color: red;
	}

	ul li {
		list-style-type: none;
	}

	.bounceIn:hover {
		background: #1aacda;
	}

	.btn-left {
		width: 100%;

	}

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

	.accordion {
		margin-left:50px;

		dt,
		dd {
			padding: 1px;
			border: 1px solid black;
			border-bottom: 0;

			&:last-of-type {
				border-bottom: 1px solid black;
			}

			a {
				display: block;
				color: black;
				font-weight: bold;
			}
		}

		dd {
			border-top: 0;
			font-size: 12px;

			&:last-of-type {
				border-top: 1px solid white;
				position: relative;
				top: -1px;
			}
		}
	}
</style>


<!-- Main section-->
<section>
	<!-- Page content-->
	<div class="content-wrapper">
		<h3 style="height: 50px; font-size: 13px;">
			<a name="admin/template/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
				<button type="button" class="mb-sm btn btn-success"> Template</button>
			</a>
			<button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>

		</h3>
		<div class="row menu_title_bar">
			<div class="col-lg-12">
				<div class="row">

					<a href="#" class="listar_giros" id="<?php ?>" data-toggle="modal" data-target="#ModalEmpresa">
						<span class="btn btn-warning">
							<i class="fa fa-building-o"></i>
						</span> Empresa
					</a>

				</div>
			</div>
		</div>
	</div>
</section>


<!-- Modal Large-->
<div id="ModalEmpresa" tabindex="-1" role="dialog" aria-labelledby="ModalEmpresa" aria-hidden="true" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-label="Close" class="close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 id="myModalLabelLarge" class="modal-title">Crear Documento Template Empresa</h4>
			</div>
			<div class="modal-body">

				<!-- START panel-->
				<div class="panel">
					<div class="panel-heading" id="giro_nombre2"></div>
					<!-- START table-responsive-->
					<div class="table-responsive">
						<div class="row">

							<div class="container-fluid main-container ">
								<div class="col-md-1 ">
									<ul class="nav nav-pills nav-stacked collapse navbar-collapse navbar-ex1-collapse">
										<li style="padding:10px;">
											<div class="btn-group btn-left">
												<button data-toggle="dropdown" class="btn btn-default btn-left">HTML <b class="caret"></b>
												</button>
												<ul role="menu" class="dropdown-menu animated bounceIn">
													<li><a href="#" id="div" name="html" class="control">Div</a></li>
													<li><a href="#" id="p" name="html" class="control">P</a></li>
													<li><a href="#" id="label" name="html" class="control">Label</a></li>
												</ul>
											</div>
										</li>
										<li style="padding:10px;">
											<div class="btn-group btn-left">
												<button data-toggle="dropdown" class="btn btn-default btn-left">TABLE <b class="caret"></b>
												</button>
												<ul role="menu" class="dropdown-menu animated bounceIn">
													<li><a href="#" id="table2" name="table" class="control"> Super Table</a></li>
													<li><a href="#" id="<table></table>" name="table" class="control"> Table</a></li>
													<li><a href="#" id="<tr></tr>" name="table" class="control"> Tr</a></li>
													<li><a href="#" id="<td></td>" name="table" class="control"> Td</a></li>
													<li><a href="#" id="colspan=" name="table" class="control"> Colspan</a></li>
													<li><a href="#" id="celspan=" name="table"> Celspan</a></li>
													<li><a href="#" id="border=" name="table" class="control"> Border</a></li>
												</ul>
											</div>
										</li>
										<li style="padding:10px;">

											<div class="btn-group btn-left">
												<button data-toggle="dropdown" class="btn btn-default btn-left">STYLE <b class="caret"></b>
												</button>
												<ul role="menu" class="dropdown-menu animated bounceIn">
													<li><a href="#" id="color" name="style" class="control"> Color</a></li>
													<li><a href="#" id="style" name="style" class="control"> Style</a></li>
													<li><a href="#" id="height" name="style" class="control"> Height</a></li>
													<li><a href="#" id="width" name="style" class="control"> Width</a></li>
													<li><a href="#" id="padding" name="style" class="control"> Padding</a></li>
													<li><a href="#" id="margin" name="style" class="control"> Margin</a></li>
													<li><a href="#" id="bgcolor" name="style" class="control"> Bgcolor</a></li>
													<li><a href="#" id="background" name="style" class="control"> Background</a></li>
												</ul>
											</div>
										</li>
										<li style="padding:10px;">

											<div class="btn-group btn-left">
												<button data-toggle="dropdown" class="btn btn-default btn-left">PHP <b class="caret"></b>
												</button>
												<ul role="menu" class="dropdown-menu animated bounceIn">
													<li><a href="#" id="date" name="php" class="control"> Date</a></li>
													<li><a href="#" id="subtotal" name="php" class="control"> Sub Total</a></li>
													<li><a href="#" id="total" name="php" class="control"> Total</a></li>
													<li><a href="#" id="foreach" name="php" class="control"> Foreach</a></li>
												</ul>
											</div>
										</li>
										<li id="delete" class="control" style="padding:10px;">

											<div class="btn-group btn-left">
												<button data-toggle="dropdown" class="btn btn-default btn-left">Delete <b class="caret"></b>
												</button>
												<ul role="menu" class="dropdown-menu animated bounceIn">
													<a href="#"> Delete</a>
												</ul>
											</div>
										</li>
									</ul>
								</div>
								<div class="col-md-11 content" style="height: 100%">
									<div class="panel ">

										<form id="template" method="post">
											<div class="panel-body"><br>

												<div class="row">
													<div class="col-md-12 content">
														<div class="panel panel-info">
															<div class="panel-heading">
																CAMPOS
															</div>
															<div class="panel-body">
																<div class="row">

																	<dl class="accordion">

																		<dt><a href="">Tabla : ORDEN</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($orden_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																		<dt><a href="">Tabla : ORDEN DETALLE</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($ordenDetalle_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																		<dt><a href="">Tabla : EMPRESA</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($empresa_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																		<dt><a href="">Tabla : CAJA</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($caja_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																		<dt><a href="">Tabla : SUCURSAL</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($sucursal_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																		<dt><a href="">Tabla : PAGOS</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($pagos_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																		<dt><a href="">Tabla : DOCUMENTOS</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($documento_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																		<dt><a href="">Tabla : CORRELATIVOS</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($correlativos_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																		<dt><a href="">Tabla : CLIENTES</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($clientes_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																		<dt><a href="">Tabla : VENDEDOR</a></dt>
																		<dd>
																			<ul>
																				<?php
																				foreach ($usuario_fields as $key => $value) {
																				?>
																					<li id="key" name="html" class="control" style="display:inline-block;margin:3px;padding:5px;background:#1aacda;color:white;"><?php echo $value ?></li>
																				<?php
																				}
																				?>
																			</ul>
																		</dd>

																	</dl>

																</div>

															</div>
														</div>
													</div>
												</div>


												<div class="row">

													<div class="col-md-6 content">
														<div class="panel panel-info">
															<?php
															$data = [1, 2, 3, 4, 5];
															?>
															<div class="panel-heading">
																EDITOR <span>
																<input type="button" id="btn_template" name="<?php echo base_url() ?>admin/template/crear" data="template" class="btn btn-success enviar_data" value="Guardar">
																</span>
															</div>
															<div class="panel-body">
																<textarea name="template_html" id="template_html" cols="30" rows="10" class="form-control"></textarea>
															</div>
														</div>
													</div>
													<div class="col-md-6 content">
														<div class="panel panel-success">
															<div class="panel-heading">
																VISTA PREVIA
															</div>
															<div class="panel-body">
																<span class="html" style="width:100%; height:100px; "></span>
															</div>
														</div>
													</div>
												</div>

												<div class="row">

													<div class="col-md-6 content">
														<div class="panel panel-info">
															<div class="panel-heading">
																PARAMETROS
															</div>
															<div class="panel-body">
																<div class="row">
																	<div class="col-md-6"><b>Nombre</b> <input type="text" name="factura_nombre" value="" class="form-control"></div>
																	<div class="col-md-6"><b>Descripcion</b> <input type="text" name="factura_descripcion" value="" class="form-control"><br></div>
																	
																	<div class="col-md-6"><b>Imprimir Lineas En Formato</b> 
																		<select class="form-control" name="imprimir_lineas_documento" >
																			<option value="1">Si</option>
																			<option value="0">No</option>
																		</select>
																	</div>
																	<div class="col-md-6"><b>Imprimir Lineas En Copias </b> 
																		<select class="form-control" name="imprimir_lineas_copia" >
																			<option value="1">Si</option>
																			<option value="0">No</option>
																		</select>
																	<br></div>
																	
																	<div class="col-md-6"><b>Lineas</b> <input type="text" name="factura_lineas" value="" class="form-control"></div>
																	<div class="col-md-6"><b>Estado</b> <input type="text" name="factura_estatus" value="1" class="form-control"></div>
																</div>

															</div>
														</div>
													</div>
													<div class="col-md-6 content">
														<div class="panel panel-success">
															<div class="panel-heading">
																CODIGO FUENTE
															</div>
															<div class="panel-body">
																<span class="template_php" name="template_php" id="template_php" style="width:100%; height:100px; "></span>
															</div>
														</div>
													</div>

												</div>

											</div>
										</form>
									</div>


								</div>

							</div>

						</div>
					</div>
					<!-- END table-responsive-->
					<div class="panel-footer">
					</div>
				</div>
				<!-- END panel-->

			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Small-->