<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">

   $(document).ready(function(){
      $('#param_modal').appendTo("body");
      $('#editar_param_modal').appendTo("body");
      $('#modulo_modal').appendTo("body");
      $('#edit_modulo_modal').appendTo("body");

      $(".save_params").on('click',function(){

         var clas = $(this).attr('name');
         
         var form = $("."+clas).serializeArray();
         var method = '../'+ $(this).attr('id');
         
         $.ajax({
             type: 'POST',
             data: {
                 param : form,
             },
             url: method,

             success: function(data){
                 location.reload();
             },
             error:function(){
             } 
         });
      });

      $(".btn_conf").on('click', function(){
         var id = $(this).attr('name');
         var method = "../get_params";

         $.ajax({
             type: 'POST',
             data: {
                 id : id,
             },
             url: method,

             success: function(data){
               
               var datos = JSON.parse(data);
               var conf = datos['conf'];
               var modulo = datos['modulo'];

               var modulo_conf = "<select name='modulo_conf' class='form-control'>" ;
               modulo_conf += "<option value="+conf[0].id_modulo+">"+conf[0].nombre_modulo+"</option>";
               $.each(modulo, function(i, item) {
                  if(item.id_modulo != conf[0].id_modulo){
                     modulo_conf += "<option value="+item.id_modulo+">"+item.nombre_modulo+"</option>";
                  }
               });
               modulo_conf+='</select>';           

               $(".modulo_conf").html(modulo_conf);
               $("#componente_conf").val(conf[0].componente_conf);
               $("#valor_conf").val(conf[0].valor_conf);
               $("#descripcion_conf").val(conf[0].descripcion_conf);
               $("#id_conf").val(conf[0].id_conf);

               var estado_conf = "<select name='estado_conf' class='form-control'>" ;
               $.each(conf, function(i, item) {
                  if(item.estado_conf == 1){
                     estado_conf += "<option value='1'>Activo</option>";
                     estado_conf += "<option value='0'>Inactivo</option>";
                  }else{
                     estado_conf += "<option value='0'>Inactivo</option>";
                     estado_conf += "<option value='1'>Activo</option>";
                  }
               });
               estado_conf+='</select>';
               $(".estado_conf").html(estado_conf);

               $("#editar_param_modal").modal();
             },
             error:function(){
             } 
         });
      });

      $(".edit_modulo").on('click', function(){
         var id = $(this).attr('id');
         var method = "../get_modulo";

         $.ajax({
             type: 'POST',
             data: {
                 id : id,
             },
             url: method,

             success: function(data){
               
               var datos = JSON.parse(data);
               var modulo = datos['modulo'];       

               $("#nombre_modulo").val(modulo[0].nombre_modulo);
               $("#codigo_modulo").val(modulo[0].codigo_modulo);
               $("#precio_modulo").val(modulo[0].precio_modulo);
               $("#descripcion_modulo").val(modulo[0].descripcion_modulo);
               $("#id_modulo").val(modulo[0].id_modulo);

               var estado_modulo = "<select name='estado_modulo' class='form-control'>" ;
               $.each(modulo, function(i, item) {
                  if(item.estado_modulo == 1){
                     estado_modulo += "<option value='1'>Activo</option>";
                     estado_modulo += "<option value='0'>Inactivo</option>";
                  }else{
                     estado_modulo += "<option value='0'>Inactivo</option>";
                     estado_modulo += "<option value='1'>Activo</option>";
                  }
               });
               estado_modulo+='</select>';
               $("#estado_modulo").html(estado_modulo);

               $("#edit_modulo_modal").modal();
             },
             error:function(){
             } 
         });
      });

   });   
</script>

<section>
   <!-- Page content-->
   <div class="content-wrapper">
      <h3>Parametros Modulos</h3>
      <div class="row menu_title_bar">
         <div class="col-md-4">
            <div class="mb-lg clearfix">
               <div class="pull-left">
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" 
                     data-target="#modulo_modal" >Nuevo Modulo</button>
               </div>

            </div>
            <!-- Aside panel-->
            <div class="panel b">
               <div class="panel-body bb">
                  <p>Lista Modulos</p>
  
               </div>
               <table class="table bb">
                  <tbody>

                     <?php
                     foreach ($modulo as $m) {
                        ?>
                        <tr>
                           <td>
                              <strong><?php echo $m->nombre_modulo; ?></strong>
                           </td>
                           <td>Codigo <?php echo $m->codigo_modulo ?></td>
                           <td>
                              <a class="btn btn-info" style="float: right;" href="<?php echo base_url().'admin/param/index/'. $m->id_modulo ?>"><i class="icon-list"></i></a>
                              <a class="btn btn-green edit_modulo" style="float: right;" data-toggle="modal" id="<?php echo $m->id_modulo ?>" data-target="#edit_modulo_modal" href="#"><i class="icon-pencil"></i></a>
                           </td>
                        </tr>
                        <?php
                     }
                     ?>
                  </tbody>
               </table>
               <div class="panel-body menuContent">
                  <p>Metricas</p>
                  <div class="row text-center">
                     <div class="col-xs-3 col-md-6 col-lg-3">
                        <div class="inline mv">
                           <div data-sparkline="" values="20,80" data-type="pie" data-height="50" data-slice-colors="[&quot;#edf1f2&quot;, &quot;#23b7e5&quot;]" class="sparkline"></div>
                        </div>
                        <p class="mt-lg">Issues</p>
                     </div>
                     <div class="col-xs-3 col-md-6 col-lg-3">
                        <div class="inline mv">
                           <div data-sparkline="" values="60,40" data-type="pie" data-height="50" data-slice-colors="[&quot;#edf1f2&quot;, &quot;#27c24c&quot;]" class="sparkline"></div>
                        </div>
                        <p class="mt-lg">Bugs</p>
                     </div>
                     <div class="col-xs-3 col-md-6 col-lg-3">
                        <div class="inline mv">
                           <div data-sparkline="" values="20,80" data-type="pie" data-height="50" data-slice-colors="[&quot;#edf1f2&quot;, &quot;#ff902b&quot;]" class="sparkline"></div>
                        </div>
                        <p class="mt-lg">Hours</p>
                     </div>
                     <div class="col-xs-3 col-md-6 col-lg-3">
                        <div class="inline mv">
                           <div data-sparkline="" values="30,70" data-type="pie" data-height="50" data-slice-colors="[&quot;#edf1f2&quot;, &quot;#f05050&quot;]" class="sparkline"></div>
                        </div>
                        <p class="mt-lg">Assigned</p>
                     </div>
                  </div>
               </div>
               
            </div>
            <!-- end Aside panel-->
         </div>
         <div class="col-md-8">
            <div class="mb-lg clearfix">
               <div class="pull-left">
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" 
                     data-target="#param_modal" >Nueva Configuracion</button>

               </div>
               <div class="pull-right">
                  <p class="mb0 mt-sm"><?php echo count($config) ?> / <?php echo $total ?> </p>
               </div>
            </div>
            <div class="panel b">
               <div class="panel-body">
                  <div class="table-responsive" style="height: 400px; overflow: auto; position: relative;">
                     <table id="datatable1" class="table" >
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Codigo</th>
                              <th>Modulo</th>
                              <th>Descripcion</th>
                              <th>Componente</th>
                              <th>Estatus</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $cont =1;
                           if($config){
                           foreach ($config as $c) {
                              ?>
                              <tr>
                                 <td>
                                    <?php echo $cont ?>
                                 </td>
                                 <td>
                                    <div class="badge bg-gray-lighter">
                                       <?php echo $c->codigo_modulo ?>
                                    </div>
                                 </td>
                                 <td>
                                    <small><?php echo $c->nombre_modulo ?></small>
                                 </td>
                                 <td><?php echo $c->componente_conf ?></td>
                                 <td>
                                    <?php
                                    if($c->valor_conf == 1){
                                       ?>
                                       <div data-toggle="tooltip" data-title="<?php echo $c->valor_conf ?>" class="circle circle-lg circle-success"></div>
                                       <?php
                                    }else{
                                        ?>
                                       <div data-toggle="tooltip" data-title="<?php echo $c->valor_conf ?>" class="circle circle-lg circle-sucess"></div>
                                       <?php
                                    }
                                    ?>
                                    
                                 </td>
                                 <td>
                                    <?php
                                    if($c->estado_conf == 1){
                                       ?><div class="inline wd-xxs label label-success">Activo</div><?php
                                    }else{
                                       ?><div class="inline wd-xxs label label-danger">Inactivo</div><?php
                                    }
                                    ?>
                                    
                                 </td>
                                 <td>
                                    <span class="btn btn-info btn_conf" name="<?php echo $c->id_conf; ?>"><i class="icon-pencil"></i></span>
                                 </td>
                              </tr>
                              <?php
                              $cont +=1;
                           }}
                           ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Modal Large UPDATE CONFIG MODAL-->
   <div id="editar_param_modal" tabindex="-1" role="dialog" aria-labelledby="editar_param_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="panel-header" style="background: #535D67; color: white;height: 50px;">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title" style="text-align: center;"> Editar Parametro </h4>
            </div>
            <div class="modal-body">  
               <form name="update_params" id="update_params" class="update_params">
                  <input type="hidden" name="id_conf" value="" id="id_conf">
                  <div class="row">
                     <div class="col-md-4">Modulo</div>
                     <div class="col-md-8">
                       <span class="modulo_conf"></span>
                     </div>
                  </div>   <br> 
                  <div class="row">
                     <div class="col-md-4">Componente</div>
                     <div class="col-md-8">
                        <input type="text" name="componente_conf" id="componente_conf" value="" class="form-control">
                     </div>
                  </div><br>
                  <div class="row">
                     <div class="col-md-4">Valor Configuracion</div>
                     <div class="col-md-8">
                         <input type="number" name="valor_conf" id="valor_conf" min="0" max="1" value="1" class="form-control">
                     </div>
                  </div><br>
                  <div class="row">
                     <div class="col-md-4">Descripcion</div>
                     <div class="col-md-8">
                        <textarea class="form-control" id="descripcion_conf" name="descripcion_conf"></textarea>
                     </div>
                  </div>    <br>
                  <div class="row">
                     <div class="col-md-4">Estado</div>
                     <div class="col-md-8">
                           <span class="estado_conf"></span>
                     </div>
                  </div>   
               </form>                 

            </div>
            <div class="modal-footer">
               <button type="button" style="float: left;" data-dismiss="modal" class="btn btn-danger save_params" id="delete_params" name="update_params" delete="">Eliminar</button>
               <button type="button" data-dismiss="modal" class="btn btn-info save_params" id="update_params" name="update_params">Guardar</button>
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

<!-- Modal Large CREAR CONFIG MODAL-->
   <div id="param_modal" tabindex="-1" role="dialog" aria-labelledby="param_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="panel-header" style="background: #535D67; color: white;height: 50px;">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title" style="text-align: center;"> Crear Nuevo Parametro </h4>
            </div>
            <div class="modal-body">  
               <form name="param_form" id="save_params" >
                  <div class="row">
                     <div class="col-md-4">Modulo</div>
                     <div class="col-md-8">
                        <select name="modulo_conf" class="form-control">
                              <?php
                              foreach ($modulo as $mo) {
                                 ?>
                                 <option value="<?php echo $mo->id_modulo ?>"><?php echo $mo->nombre_modulo ?></option>
                                 <?php
                              }
                              ?>
                           </select>
                     </div>
                  </div>   <br> 
                  <div class="row">
                     <div class="col-md-4">Componente</div>
                     <div class="col-md-8">
                        <input type="text" name="componente_conf" value="" class="form-control">
                     </div>
                  </div><br>
                  <div class="row">
                     <div class="col-md-4">Valor Configuracion</div>
                     <div class="col-md-8">
                         <input type="number" name="valor_conf" min="0" max="1" value="1" class="form-control">
                     </div>
                  </div><br>
                  <div class="row">
                     <div class="col-md-4">Descripcion</div>
                     <div class="col-md-8">
                        <textarea class="form-control" name="descripcion_conf"></textarea>
                     </div>
                  </div>    <br>
                  <div class="row">
                     <div class="col-md-4">Estado</div>
                     <div class="col-md-8">
                         <select name="estado_conf" class="form-control">
                              <option value="1">Activo</option>
                              <option value="0">Inactivo</option>
                           </select>
                     </div>
                  </div>   
               </form>                 

            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-info save_params" id="save_params" name="save_params">Guardar</button>
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

<!-- Modal Large CREAR MODULOS MODAL-->
   <div id="modulo_modal" tabindex="-1" role="dialog" aria-labelledby="modulo_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="panel-header" style="background: #535D67; color: white;height: 50px;">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title" style="text-align: center;"> Crear Nuevo Modulo </h4>
            </div>
            <div class="modal-body">  
               <form name="param_form" id="save_modulo" class="save_modulo">
                  <div class="row">
                     <div class="col-md-4">Modulo</div>
                     <div class="col-md-8">
                       <input type="text" name="nombre_modulo" class="form-control" value="">
                     </div>
                  </div>   <br> 
                  <div class="row">
                     <div class="col-md-4">Codigo</div>
                     <div class="col-md-8">
                        <input type="text" name="codigo_modulo" value="" class="form-control">
                     </div>
                  </div><br>
                  <div class="row">
                     <div class="col-md-4">Precio</div>
                     <div class="col-md-8">
                         <input type="text" name="precio_modulo" value="" class="form-control">
                     </div>
                  </div><br>
                  <div class="row">
                     <div class="col-md-4">Descripcion</div>
                     <div class="col-md-8">
                        <textarea class="form-control" name="descripcion_modulo"></textarea>
                     </div>
                  </div>    <br>
                  <div class="row">
                     <div class="col-md-4">Estado</div>
                     <div class="col-md-8">
                         <select name="estado_modulo" class="form-control">
                              <option value="1">Activo</option>
                              <option value="0">Inactivo</option>
                           </select>
                     </div>
                  </div>   
               </form>                 

            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-info save_params" id="save_modulo" name="save_modulo">Guardar</button>
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

<!-- Modal Large EDITAR MODULOS MODAL-->
   <div id="edit_modulo_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modulo_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="panel-header" style="background: #535D67; color: white;height: 50px;">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title" style="text-align: center;"> Editar Modulo </h4>
            </div>
            <div class="modal-body">  
               <form name="param_form" id="update_modulo" class="update_modulo">
                  <input type="hidden" name="id_modulo" id="id_modulo" value="">
                  <div class="row">
                     <div class="col-md-4">Modulo</div>
                     <div class="col-md-8">
                       <input type="text" name="nombre_modulo" id="nombre_modulo" class="form-control" value="">
                     </div>
                  </div>   <br> 
                  <div class="row">
                     <div class="col-md-4">Codigo</div>
                     <div class="col-md-8">
                        <input type="text" name="codigo_modulo" id="codigo_modulo" class="form-control">
                     </div>
                  </div><br>
                  <div class="row">
                     <div class="col-md-4">Precio</div>
                     <div class="col-md-8">
                         <input type="text" name="precio_modulo" id="precio_modulo" class="form-control">
                     </div>
                  </div><br>
                  <div class="row">
                     <div class="col-md-4">Descripcion</div>
                     <div class="col-md-8">
                        <textarea class="form-control" id="descripcion_modulo" name="descripcion_modulo"></textarea>
                     </div>
                  </div>    <br>
                  <div class="row">
                     <div class="col-md-4">Estado</div>
                     <div class="col-md-8">
                        <span id="estado_modulo"></span>
                     </div>
                  </div>   
               </form>                 

            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-info save_params" id="update_modulo" name="update_modulo">Guardar</button>
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->