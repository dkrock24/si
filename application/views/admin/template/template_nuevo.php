	<script>
		$(document).ready(function(){

			// Mostrar contenido en Vista Previa
			$("#template_html").keyup(function(){
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

			function escapeHtml (string) {
			  return String(string).replace(/[&<>"'`=\/]/g, function (s) {
			  	alert(entityMap[s]);
			    return entityMap[s];
			  });
			}

			$(".control").click(function(){
				var accion = $(this).attr("name");
				var method = $(this).attr("id");

				switch(accion){

					case 'html': html_element(method);break;
					case 'table': table_element(method);break;
					case 'php': php_element(method);break;
					case 'style': style_element(method);break;
					case 'delete': delete_element();break;
					
				}
			});

			function html_element(method){
				var html_form 
	    		if(method == 'div'){
	    			html_form = "<div> </div>";
	    		}else if(method == 'p'){
	    			html_form = "<p> </p>";
	    		}
	    		else if(method == 'label'){
	    			html_form = "<label> </label>";
	    		}
	    		dibujar(html_form);
			}

	    	function dibujar(elemento){

		        var txt = jQuery("#template_html");
		        
		        var caretPos = txt[0].selectionStart;
		        var textAreaTxt = txt.val();
		        var txtToAdd = elemento;
		        txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
		        $('.html').html( txt.val() );
		        $('.template_php').text( txt.val() );
	    	}

	    	function table_element2(){
	    		var filas = prompt("Filas ?");
                var columnas = prompt("columnas ?");
                var html="";
                html +="<table class='table' onmousedown='mydragg.startMoving(this,'"+"'container'"+"',event);' onmouseup='mydragg.stopMoving('"+"'container'"+"');'>";
                for(x=0; x<filas; x++){
                    html += "<tr>";
                    for(b=0; b<columnas; b++){
                        html += "<td>"+b+"</td>";
                    }
                    html += "</tr>";
                }
                html +="</table>";
	    		dibujar(html);
	    	}

	    	function table_element(method){
	    		var html_form 
	    		if(method == 'table2'){
	    			table_element2();
	    		}else{
	    			
	    			var  x = method.substring(method.length - 1);
	    			if(x =='='){
	    				var y = prompt(method + " ?");
	    				html_form = method +"'"+y+"'" ;
	    			}else{
	    				html_form = method;
	    			}
	    			
	    			dibujar(html_form);
	    		}	    		
	    	}

	    	function php_element(method){
	    		var html_form="";
	    		if(method == 'foreach'){
	    			html_form = "<\?php $items = [1,2,3,4,5]; foreach($items as $val){ echo $val; } ?>";
	    		}
	    		if(method == 'date'){
	    			html_form = "<\?php echo date('Y-m-d'); ?>";
	    		}	    		
	    		dibujar(html_form);
	    	}

	    	function style_element(method){
	    		var x = prompt(method + " ?");
	    		if(method=="style"){
	    			var html_form = method+'=" "'+x;
	    		}else{
	    			var html_form = method+x;
	    		}
	    		dibujar(html_form);
	    	}

	    	function delete_element(){
				var editor = document.getElementById("template_html");
				var editorHTML = editor.innerHTML;
            	var selectionStart = 0, selectionEnd = 0;

				  	if (editor.selectionStart) selectionStart = editor.selectionStart;
		            if (editor.selectionEnd) selectionEnd = editor.selectionEnd;
		            if (selectionStart != selectionEnd) {
		                var editorCharArray = editorHTML.split("");
		                editorCharArray.splice(selectionEnd, 0, "</b>");
		                editorCharArray.splice(selectionStart, 0, "<b>"); //must do End first
		                editorHTML = editorCharArray.join("");
		                editor.innerHTML = editorHTML;
		            }
		            var x = editor.value.substring(selectionStart,selectionEnd);
		            console.log(x);
		           $('#template_html').html( x );
			}
	    	
		});



	</script>

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

#template_html{
  caret-color:red;
}
ul li{
	list-style-type: none;
}
.bounceIn:hover{
	background: #1aacda;
}



.btn-left{
	width: 100%;
    
}
</style>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Template</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">

					<div class="container-fluid main-container">
						<div class="col-md-2 ">
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
				                           <li><a href="#" id="table2" 	 name="table" class="control"> Super Table</a></li>
					                        <li><a href="#" id="<table></table>" 	 name="table" class="control"> Table</a></li>
					                        <li><a href="#" id="<tr></tr>" 	 name="table" class="control"> Tr</a></li>
					                        <li><a href="#" id="<td></td>" 	 name="table" class="control"> Td</a></li>
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
						<div class="col-md-10 content" style="height: 100%">
				            <div class="panel menu_title_bar">
				                <div class="panel-heading">
				                    Modelador
				                </div>
				                <form action="crear" method="post">
				                <div class="panel-body"><br>
				                    <div class="container-fluid main-container">
							
										<div class="col-md-6 content">
												<div class="panel panel-info">
													<?php
														$data = [1,2,3,4,5];
													?>
													<div class="panel-heading">
														EDITOR  <span><input type="submit" class="btn btn-default" name="enviar" value="Guardar" style="float: right;" /></span>
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


									<div class="container-fluid main-container">
										<hr>

										<div class="col-md-6 content">
											<div class="panel panel-info">
												<div class="panel-heading">
														PARAMETROS
													</div>
													<div class="panel-body">
														<div class="row">
															<div class="col-md-6"><b>Nombre</b> <input type="text" name="factura_nombre" value="" class="form-control"></div>
															<div class="col-md-6"><b>Descripcion</b> <input type="text" name="factura_descripcion" value="" class="form-control"><br></div>
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
        </div>
    </div>
</section>