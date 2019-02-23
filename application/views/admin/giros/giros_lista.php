<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script>
  $(document).ready(function(){

    $(".listar_atributos").click(function(){
          $(".dataPlantilla").empty();
          var id = $(this).attr('id');
          $.ajax({
            url: "get_atributos/"+id,  
            datatype: 'json',      
            cache : false,                

                success: function(data){

                  var datos     = JSON.parse(data);
                  var atributos = datos["atributos"];
                  var giro      = datos["giro"];
                  var atributos_total = datos["atributos_total"];
                  var plantilla_giro_total =  datos["plantilla_giro_total"];

                  dibujarPlantilla(datos["plantilla"]);
                  //console.log(atributos_total[0].atributos_total);

                  $("#giro_nombre").text(giro[0].nombre_giro);
                  $(".giro_id").val(giro[0].id_giro);
                  $(".atributos_total").text(atributos_total[0].atributos_total);
                  $(".plantilla_giro_total").text(plantilla_giro_total[0].atributos_total)

                  var contador=1;
                  $.each(atributos, function(i, item) {                   
                    $(".dataPlantilla").append(
                        '<tr>'+
                        '<td>'+contador+'</td>'+
                        '<td>'+item.nam_atributo+'</td>'+
                        '<td>'+item.tipo_atributo+'</td>'+
                        '<td>'+item.descripcion_atributo+'</td>'+
                        '<td>'+item.estado_atributo+'</td>'+
                        '<td><div class="checkbox c-checkbox">'+
                                 '<label>'+
                                    '<input type="checkbox" name="'+item.id_prod_atributo+'">'+
                                    '<span class="fa fa-check"></span>'+
                                 '</label>'+
                              '</div></td>'+
                        '</tr>');
                    contador+=1;
                });
                
                },
                error:function(){
                }
            });
        });

    $("#guardar_giro_atributos").click(function(){

        var dataForm = $("#datosForm").serialize();
        
        $.ajax({
            type: "POST",
            url: "guardar_giro_atributos",
            data: dataForm,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  var datos     = JSON.parse(data);
                  var plantilla = datos["plantilla"];
                  var plantilla_giro_total =  datos["plantilla_giro_total"];
                  $(".plantilla_giro_total").text(plantilla_giro_total[0].atributos_total)

                  dibujarPlantilla( plantilla );

                },
                error:function(){
                }
        });
    });


    $("#eliminar_giro_atributos").click(function(){
      // Eliminar los Atributos del Giro

      var dataForm = $("#datosForm2").serialize();
      $.ajax({
            type: "POST",
            url: "eliminar_giro_atributos",
            data: dataForm,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  var datos     = JSON.parse(data);
                  var plantilla = datos["plantilla"];
                  var plantilla_giro_total =  datos["plantilla_giro_total"];
                  $(".plantilla_giro_total").text(plantilla_giro_total[0].atributos_total)

                  dibujarPlantilla( plantilla );

                },
                error:function(){
                }
        });
      // Fin - Eliminar los Atributos del Giro
    });

    // Administracion de GIROS

    $(".listar_giros").click(function(){
          $(".girosLista").empty();
          $(".lista_empresa").empty();
//          var id = $(this).attr('id');
          $.ajax({
            url: "listar_giros",  
            datatype: 'json',      
            cache : false,                

                success: function(data){

                  var datos     = JSON.parse(data);
                  var giros = datos["lista_giros"];
                  var empresa = datos["lista_empresa"];
                  $(".lista_empresa").append("<option value='0'>Selecionar Empresa</option>");
                  $.each(empresa, function(i, item) {  
                    $(".lista_empresa").append(
                        '<option value="'+item.id_empresa+'">'+
                        item.nombre_razon_social+
                        '</option>');
                  });

                  //dibujarPlantilla(datos["plantilla"]);
                  //console.log(atributos_total[0].atributos_total);

                  var contador=1;
                  $.each(giros, function(i, item) {                   
                    $(".girosLista").append(
                        '<tr>'+
                        '<td>'+contador+'</td>'+
                        '<td>'+item.nombre_giro+'</td>'+
                        '<td>'+item.tipo_giro+'</td>'+
                        '<td>'+item.codigo_giro+'</td>'+
                        '<td>'+item.estado_giro+'</td>'+
                        '<td><div class="checkbox c-checkbox">'+
                                 '<label>'+
                                    '<input type="checkbox" name="'+item.id_giro+'">'+
                                    '<span class="fa fa-check"></span>'+
                                 '</label>'+
                              '</div></td>'+
                        '</tr>');
                    contador+=1;
                });
                
                },
                error:function(){
                }
            });
    });

    $("#guardar_giro_empresa").click(function(){

        var dataForm = $("#guardar_giro_empresa").serialize();
        
        $.ajax({
            type: "POST",
            url: "guardar_giro_empresa",
            data: dataForm,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                },
                error:function(){
                }
        });
    });

    $("#empresa_giros").change(function(){
      var id_empresa = $(this).val();

      $.ajax({
            type: "POST",
            url: "get_empresa_giro/"+id_empresa, 
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  var datos     = JSON.parse(data);
                  var giros = datos["lista_giros"];
                  var total = datos["empresa_giro_total"];

                  $(".empresa_giro_total").text(total[0].total_empresa_giro);

                  dibujarGirosEmpresa(giros);
                },
                error:function(){
                }
        });
    });

    $("#eliminar_giro_empresa").click(function(){
      // Eliminar Giro de Emrpesa

      var dataForm = $("#giro_empresa").serialize();
      $.ajax({
            type: "POST",
            url: "eliminar_giro_empresa",
            data: dataForm,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  var datos     = JSON.parse(data);
                  var giros = datos["lista_giros"];
                  var total = datos["empresa_giro_total"];

                  $(".empresa_giro_total").text(total[0].total_empresa_giro);

                  dibujarGirosEmpresa( giros );

                },
                error:function(){
                }
        });
      // Fin - Eliminar los Atributos del Giro
    });

    function dibujarGirosEmpresa(giros){
      var contador=1;

        $(".girosEmpresa").empty();
        $.each(giros, function(i, item) {                   
          $(".girosEmpresa").append(
              '<tr>'+
              '<td>'+contador+'</td>'+
              '<td>'+item.nombre_giro+'</td>'+
              '<td>'+item.tipo_giro+'</td>'+
              '<td>'+item.codigo_giro+'</td>'+
              '<td><div class="checkbox c-checkbox">'+
                       '<label>'+
                          '<input type="checkbox" name="'+item.id_giro+'">'+
                          '<span class="fa fa-check"></span>'+
                       '</label>'+
                    '</div></td>'+
              '</tr>');
          contador+=1;
        });
    }

    function dibujarPlantilla(plantilla){
      var contador=1;

        $(".giroPlantilla").empty();
        $.each(plantilla, function(i, item) {                   
          $(".giroPlantilla").append(
              '<tr>'+
              '<td>'+contador+'</td>'+
              '<td>'+item.nam_atributo+'</td>'+
              '<td>'+item.tipo_atributo+'</td>'+
              '<td>'+item.estado_giro_plantilla+'</td>'+
              '<td><div class="checkbox c-checkbox">'+
                       '<label>'+
                          '<input type="checkbox" name="'+item.id_giro_pantilla+'">'+
                          '<span class="fa fa-check"></span>'+
                       '</label>'+
                    '</div></td>'+
              '</tr>');
          contador+=1;
        });
    }


  });
</script>

<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Giros </h3>

            <?php $this->load->view('notificaciones/success'); ?>            

            <div class="panel panel-default">
                <div class="panel-heading">Giros</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Tipo</th>                               
                                <th>Descripcion</th>
                                <th>Codigo</th>
                                <th>Creado</th>
                                <th>Actualizado</th>
                                <th>Estado</th>
                                <th>
                                    <div class="btn-group">
                                       <button type="button" class="btn btn-default">Opcion</button>
                                       <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-default">
                                          <span class="caret"></span>
                                          <span class="sr-only">default</span>
                                       </button>
                                       <ul role="menu" class="dropdown-menu">
                                          <li><a href="nuevo">Nuevo</a>                </li>
                                          <li><a href="#">Exportar</a>              </li>
                                          <li class="divider"></li>
                                          <li><a href="#" class="listar_giros" id="<?php //echo $giros->id_giro; ?>" data-toggle="modal" data-target="#ModalEmpresa">Empresa</a></li>
                                          </li>
                                       </ul>
                                    </div>
                                </th>                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $contado=1;
            	               foreach ($lista_giros as $giros) {
            	               ?>
                    			<tr>
		                            <th scope="row"><?php echo $contado; ?></th>
		                            <td><?php echo $giros->nombre_giro; ?></td>
		                            <td><?php echo $giros->tipo_giro; ?></td>
		                            <td><?php echo $giros->descripcion_giro; ?></td>
                                    <td><?php echo $giros->codigo_giro; ?></td>
                                    <td><?php echo $giros->fecha_giro_creado; ?></td>
                                    <td><?php echo $giros->fecha_giro_actualizado; ?></td>
		                            <td>
		                            	<?php 
		                            		if($giros->estado_giro==1){
		                            			?>
		                            			<span class="label label-success">Activo</span>
		                            			<?php
		                            		}else{
                                                ?>
                                                <span class="label label-warning">Inactivo</span>
                                                <?php
                                            }
                                        ?>
                                    </td>
		                            <td>
		                            	                                
		                                <div class="btn-group mb-sm">
		                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-primary btn-xs">Opcion
                                            <span class="caret"></span>
                                            </button>
		                                    <ul role="menu" class="dropdown-menu">                                                                    
		                                        <li><a href="#" class="listar_atributos" id="<?php echo $giros->id_giro; ?>" data-toggle="modal" data-target="#ModalAtributos"><i class="fa fa-gears"></i> Atributos</a></li>
                                                <li><a href="#" class="listar_atributos" id="<?php echo $giros->id_giro; ?>" data-toggle="modal" data-target="#ModalAtributos"><i class="fa fa-bars"></i> Categorias</a></li>
                                                <li><a href="editar/<?php echo $giros->id_giro; ?>"><i class="fa fa-edit"></i> Editar</a></li>
                                                <li class="divider"></li>
		                                        <li><a href="delete/<?php echo $giros->id_giro; ?>"><i class="fa fa-trash"></i> Eliminar</a></li>
		                                    </ul>
		                                </div>
                        				
		                            </td>
		                        </tr>
                                <?php
                                    $contado+=1;
    	                    	}
                            ?>                       
                                   
                                </tbody>
                            </table>
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
               <h4 id="myModalLabelLarge" class="modal-title">Giros Empresa</h4>
            </div>
            <div class="modal-body">
                
                    <!-- START panel-->
            <div class="panel panel-default">
               <div class="panel-heading" id="giro_nombre2"></div>
               <!-- START table-responsive-->
               <div class="table-responsive">
                    <div class="row">
                        <div class="col-lg-6">
                          <!-- START panel-->
                          <form action="guardar_giro_empresa" method="post" id="guardar_giro_empresa">
                            <select name="empresa" class="lista_empresa input-sm form-control">
                                      
                            </select>
                            
                          <div id="panelDemo7" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-lg-3"> Giros </div>
                                    <div class="col-lg-6">
                                        <div class="pull-right label label-danger atributos_total"></div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="button" value="Guardar" id="guardar_giro_empresa" name="" class="input-sm form-control">
                                    </div>
                                </div>
                            </div>

                             <div class="panel-body">
                                <p>
                                    <table id="table-ext-1" class="table table-bordered table-hover">
                                     <thead>
                                        <tr>
                                           <th>ID</th>
                                           <th>Giro</th>
                                           <th>Tipo</th>                           
                                           <th>Codigo</th>
                                           <th>Estado</th>
                                           <th data-check-all>
                                              <div data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox">
                                                 <label>
                                                    <input type="checkbox">
                                                    <span class="fa fa-check"></span>
                                                 </label>
                                              </div>
                                           </th>
                                        </tr>
                                     </thead>
                                     
                                     <tbody class="girosLista">
                                                             
                                     </tbody>
                                      
                                    </table>
                                </p>
                             </div>
                             <div class="panel-footer"></div>
                          </div>
                          <!-- END panel-->
                          </form>
                       </div>

                       <div class="col-lg-6">
                        <form action="giro_empresa" method="post" id="giro_empresa">
                          <select name="empresa" id="empresa_giros" class="lista_empresa input-sm form-control">
                                      
                          </select>

                            <div id="panelDemo9" class="panel panel-success">
                              <input type="hidden" class="giro_id" name="giro" value="">
                                 <div class="panel-heading">
                                  <div class="row">
                                    <div class="col-lg-4"> Empresa Giros </div>
                                    <div class="col-lg-4">
                                        <div class="pull-right label label-danger empresa_giro_total"></div>
                                    </div>
                                    <div class="col-lg-4">                                        
                                        <input type="button" value="Eliminar" id="eliminar_giro_empresa" name="" class="input-sm form-control">
                                    </div>
                                </div>
                                 </div>
                                 <div class="panel-body">
                                    <p>
                                        <table id="table-ext-1" class="table table-bordered table-hover">
                                         <thead>
                                            <tr>
                                               <th>Giro</th>
                                               <th>Atributo</th>                           
                                               <th>Label</th>
                                               <th>Estado</th>
                                               <th data-check-all>
                                              <div data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox">
                                                 <label>
                                                    <input type="checkbox">
                                                    <span class="fa fa-check"></span>
                                                 </label>
                                              </div>
                                           </th>
                                            </tr>
                                         </thead>
                                         <tbody class="girosEmpresa">
                                                                 
                                         </tbody>
                                        </table>
                                    </p>
                                 </div>
                                 
                            </div>
                          </form>
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





<!-- Modal Large-->
   <div id="ModalAtributos" tabindex="-1" role="dialog" aria-labelledby="ModalAtributos" aria-hidden="true" class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Plantilla</h4>
            </div>
            <div class="modal-body">
                
                    <!-- START panel-->
            <div class="panel panel-default">
               <div class="panel-heading" id="giro_nombre"></div>
               <!-- START table-responsive-->
               <div class="table-responsive">
                    <div class="row">
                        <div class="col-lg-6">
                          <!-- START panel-->
                          <form action="guardar_giro_atributos" method="post" id="datosForm">
                            <input type="hidden" class="giro_id" name="giro" value="">
                          <div id="panelDemo7" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-lg-3"> Atributos </div>
                                    <div class="col-lg-6">
                                        <div class="pull-right label label-danger atributos_total"></div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="button" value="Guardar" id="guardar_giro_atributos" name="" class="input-sm form-control">
                                    </div>
                                </div>
                            </div>

                             <div class="panel-body">
                                <p>
                                    <table id="table-ext-1" class="table table-bordered table-hover">
                                     <thead>
                                        <tr>
                                           <th>ID</th>
                                           <th>Atributo</th>
                                           <th>Tipo</th>                           
                                           <th>Descripcion</th>
                                           <th>Estado</th>
                                           <th data-check-all>
                                              <div data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox">
                                                 <label>
                                                    <input type="checkbox">
                                                    <span class="fa fa-check"></span>
                                                 </label>
                                              </div>
                                           </th>
                                        </tr>
                                     </thead>
                                     
                                     <tbody class="dataPlantilla">
                                                             
                                     </tbody>
                                      
                                    </table>
                                </p>
                             </div>
                             <div class="panel-footer"></div>
                          </div>
                          <!-- END panel-->
                          </form>
                       </div>

                       <div class="col-lg-6">
                        <form action="eliminar_giro_atributos" method="post" id="datosForm2">
                            <div id="panelDemo9" class="panel panel-success">
                              <input type="hidden" class="giro_id" name="giro" value="">
                                 <div class="panel-heading">
                                  <div class="row">
                                    <div class="col-lg-4"> Giro Atributos </div>
                                    <div class="col-lg-5">
                                        <div class="pull-right label label-danger plantilla_giro_total"></div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="button" value="Eliminar" id="eliminar_giro_atributos" name="" class="input-sm form-control">
                                    </div>
                                </div>
                                 </div>
                                 <div class="panel-body">
                                    <p>
                                        <table id="table-ext-1" class="table table-bordered table-hover">
                                         <thead>
                                            <tr>
                                               <th>Giro</th>
                                               <th>Atributo</th>                           
                                               <th>Label</th>
                                               <th>Estado</th>
                                               <th data-check-all>
                                              <div data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox">
                                                 <label>
                                                    <input type="checkbox">
                                                    <span class="fa fa-check"></span>
                                                 </label>
                                              </div>
                                           </th>
                                            </tr>
                                         </thead>
                                         <tbody class="giroPlantilla">
                                                                 
                                         </tbody>
                                        </table>
                                    </p>
                                 </div>
                                 
                            </div>
                          </form>
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
