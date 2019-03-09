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

<script type="text/javascript">
    
    $(document).on("change","#total_pagina",function(){
        $.ajax({
            type: "post",
            url: "",
            success: function() {
                //location.reload();
                $('#pagina_x').submit();
            }
        });
    });

</script>

<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; "><?php echo $fields['titulo']; ?> </h3>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-lg-1 text-left">
                        <form method="post" id="pagina_x" name="data">
                        <select class="form-control" id="total_pagina" name="total_pagina">
                            <option class="0">-</option>
                            <option class="10">10</option>
                            <option class="15">15</option>
                            <option class="20">20</option>
                            <option class="50">50</option>
                            <option class="100">100</option>
                        </select>
                        </form>
                    </div>
                </div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                              <?php
                              foreach ($column as $key => $combo) {
                                ?>
                                <th><?php echo $combo; ?></th>
                                <?php
                              }
                              ?>
                                
                                <th>
                                    <div class="btn-group">
                                       <button type="button" class="btn btn-default">Opcion</button>
                                       <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-default">
                                          <span class="caret"></span>
                                          <span class="sr-only">default</span>
                                       </button>
                                       <ul role="menu" class="dropdown-menu">
                                        <?php
                                        if($acciones){
                                        foreach ($acciones as $key => $value) {
                                            if($value->accion_valor == 'btn_superior'){
                                            ?>
                                            <li><a href="<?php echo $value->accion_btn_url;  ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                            <?php
                                        }}}
                                        ?>
                                          <li class="divider"></li>
                                          <li><a href="#">Otros</a>               </li>
                                          <li><a href="#" class="listar_giros" id="<?php //echo $giros->id_giro; ?>" data-toggle="modal" data-target="#ModalEmpresa">Empresa</a></li>
                                       </ul>
                                    </div>
                                </th>                            
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $contador = $contador_tabla;
                            if($registros){
                                foreach ($registros as $table) {
                                    $id =  $fields['id'][0];
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $contador; ?></th>
                                    <?php
                                    foreach ($fields['field'] as $key => $field) {

                                    if($field != 'estado'){
                                    ?>
                                      <td><?php echo $table->$field; ?></td>
                                    <?php
                                    }
                                        if($field == 'estado'){
                                            $estado = $fields['estado'][0];
                                            ?>
                                            <td>
                                                <?php 
                                                    if($table->$estado == 1){
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
                                            
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                
                                <td>
                                                                  
                                    <div class="btn-group mb-sm">
                                        <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-primary btn-xs">Opcion
                                                <span class="caret"></span>
                                            </button>
                                        <ul role="menu" class="dropdown-menu">
                                                <?php
                                                if($acciones){
                                                foreach ($acciones as $key => $value) {
                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre != 'Eliminar') {
                                                    ?>
                                                    <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $table->$id; ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                                    <?php
                                                    }
                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre == 'Eliminar') {
                                                    ?>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $table->$id; ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                                    <?php
                                                    }
                                                }}
                                                ?>                                                                    
                                                <li class="divider"></li>     
                                                <li><a href="#" class="listar_atributos" id="<?php echo $table->$id; ?>" data-toggle="modal" data-target="#ModalAtributos">Atributos</a></li>                                                      

                                        </ul>
                                    </div>
                                
                                </td>
                            </tr>
                                <?php
                            $contador+=1;
                        }
                        }
                      ?>                       
                                   
                        </tbody>
                    </table>

                </div>
                <div class="row">
                    
                    <div class="col-lg-12 text-right">
                        <ul class="pagination pagination-md">
                           <?php foreach ($links as $link) {
                            echo "<li class='page-item '>". $link ."</li>";
                        } ?>
                        </ul>
                    </div>

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
