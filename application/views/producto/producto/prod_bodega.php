<script type="text/javascript">
   $(document).on('click', '.btn_cantidad', function() {

      $('.cantidad_input').css("display", "line");
   });
</script>

<style type="text/css">

</style>
<!-- Main section-->
<section>
   <!-- Page content-->
   <div class="content-wrapper">
      <h3 style="height: 50px; ">
         <a name="producto/producto/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
            <button type="button" class="mb-sm btn btn-success"> Productos</button>
         </a>
         <span style="top: -12px;position: relative; text-decoration: none">Producto Bodega</span> </h3>

      <!-- START table-responsive-->
      <div class="row menu_title_bar">
         <div class="col-lg-4">
            <!-- START panel-->
            <div id="panelDemo10" class="panel ">
               <div class="panel-heading menuTop">Filtros</div>
               <div class="panel-body">
                  <p>
                     <form id="bodega" method="post">
                        <input type="text" class="form-control" name="producto" placeholder="Codigo" value="<?php echo $producto; ?>">

                        <br>
                        <input type="button" name="<?php echo base_url() ?>producto/producto/bodega" data="bodega" class="btn btn-success enviar_data" value="Guardar">
                     </form>
                  </p>
               </div>
               <div class="panel-footer"> - </div>
            </div>
            <!-- END panel-->
         </div>

         <!-- Permitir Accesos al usuarios a menus visibles -->
         <div class="col-lg-8">
            <div id="panelDemo10" class="panel">
               <div class="panel-heading menuTop panel-heading-collapsed">Bodegas
                  <a href="#" data-tool="panel-dismiss" data-toggle="tooltip" title="Close Panel" class="pull-right">
                     <em class="fa fa-times" style="color:black;"></em>
                  </a>
                  <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                     <em class="fa fa-plus" style="color:black;"></em>
                  </a>
               </div>
               <div class="panel-wrapper ">


                  <?php if (isset($prod_bodega)) { ?>
                     <!-- Main section-->
                     <section>


                        <!-- START panel-->
                      

                           <!-- START table-responsive-->
                           <form id="producto_activar" method="post">

                           <input type="hidden" class="form-control" name="producto" value="<?php echo $producto; ?>">

                              
                                 <table id="table-ext-1" class="table table-bordered table-hover">
                                    <thead class="" style="color: black;">
                                       <tr>
                                          <th>ID</th>
                                          <th>Producto</th>
                                          <th>Cantidad</th>
                                          <th>Sumar</th>
                                          <th>Sucursal</th>
                                          <th>Bodega</th>
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
                                    <tbody>

                                       <?php
                                       $contador = 1;
                                       foreach ($prod_bodega as $value) {
                                       ?>
                                          <tr>
                                             <td><?php echo $contador; ?></td>
                                             <td class="" width="40%">
                                                <div class="">
                                                   <?php echo $value->name_entidad; ?>
                                                </div>
                                             </td>
                                             <td class="" width="10%">
                                                <div class="">
                                                   <input type="number" class="cantidad_input" readonly style="width:80px;" name="cantidad<?php echo $value->id_pro_bod; ?>">
                                                </div>
                                             </td>
                                             <td class="" width="10%">
                                                <div class="">
                                                   <?php echo $value->Cantidad; ?>
                                                </div>
                                             </td>
                                             <td class="" width="25%">
                                                <div class="">
                                                   <?php echo $value->nombre_sucursal; ?>
                                                </div>
                                             </td>
                                             <td class="" width="">
                                                <div class="">
                                                   <?php echo $value->nombre_bodega; ?>
                                                </div>
                                             </td>

                                             <td class="text-center">
                                                <?php
                                                if ($value->pro_bod_estado == 1) {
                                                ?>
                                                   <div class="label label-success">Activo</div>
                                                <?php
                                                } else {
                                                ?><div class="label label-warning">Inactivo</div><?php
                                                                                                               }
                                                                                                                  ?>

                                             </td>

                                             <td>
                                                <div class="checkbox c-checkbox">
                                                   <label>
                                                      <?php
                                                      $check = "";
                                                      if ($value->pro_bod_estado == 1) {
                                                         $check = "checked";
                                                      } else {
                                                         $check = "unchecked";
                                                      }

                                                      ?>
                                                      <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_pro_bod; ?>">
                                                      <span class="fa fa-check"></span>
                                                   </label>
                                                </div>
                                             </td>
                                          </tr>
                                       <?php
                                          $contador += 1;
                                       }
                                       ?>


                                    </tbody>
                                 </table>
                              
                              <!-- END table-responsive-->
                              <div class="panel-footer bg-gray-light">
                                 <div class="row ">

                                    <div class="col-lg-10"></div>
                                    <div class="col-lg-2">
                                       <span class=" pull-right">
                                          <input type="hidden" name="producto_id" value="<?php echo $prod_bodega[0]->Producto; ?>">
                                          <input type="button" name="<?php echo base_url() ?>producto/producto/producto_activar" data="producto_activar" class="btn btn-success enviar_data" value="Guardar">
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </form>
                   
                        <!-- END panel-->

                     </section>
                  <?php } ?>

               </div>
            </div>

            <div id="panelDemo10" class="panel">
               <div class="panel-heading menuTop panel-heading-collapsed"> Vincular Producto [ Sucursal - Bodega ]
                  <a href="#" data-tool="panel-dismiss" data-toggle="tooltip" title="Close Panel" class="pull-right">
                     <em class="fa fa-times" style="color:black;"></em>
                  </a>
                  <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                     <em class="fa fa-plus" style="color:black;"></em>
                  </a>
               </div>
               <div class="panel-wrapper collapse">

                  <?php if (isset($bodega)) { ?>
                     <!-- Main section-->
                     <section>

                        <form id="associar_bodega" method="post">

                           <table id="table-ext-1" class="table table-bordered table-hover">
                              <thead class="" style="color:black;">
                                 <tr>
                                    <th>ID</th>
                                    <th>Sucursal</th>
                                    <th>Nombre Bodega</th>
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
                              <tbody>

                                 <?php
                                 $contador = 1;
                                 foreach ($bodega as $value) {
                                 ?>
                                    <tr>
                                       <td><?php echo $contador; ?></td>
                                       <td class="" width="25%">
                                          <div class="">
                                             <?php echo $value->nombre_sucursal; ?>
                                          </div>
                                       </td>
                                       <td class="" width="25%">
                                          <div class="">
                                             <?php echo $value->nombre_bodega; ?>
                                          </div>
                                       </td>

                                       <td class="text-center">
                                          <?php
                                          if ($value->bodega_estado == 1) {
                                          ?>
                                             <div class="label label-success">Activo</div>
                                          <?php
                                          } else {
                                          ?><div class="label label-warning">Inactivo</div><?php
                                                                                                                  }
                                                                                                                     ?>

                                       </td>

                                       <td>
                                          <div class="checkbox c-checkbox">
                                             <label>
                                                <?php

                                                $check = "";
                                                if ($value->bodega_estado == 1) {
                                                   $check = "unchecked";
                                                } else {
                                                   $check = "unchecked";
                                                }

                                                ?>
                                                <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_bodega; ?>">
                                                <span class="fa fa-check"></span>
                                             </label>
                                          </div>
                                       </td>
                                    </tr>
                                 <?php
                                    $contador += 1;
                                 }
                                 ?>

                              </tbody>
                           </table>

                           <div class="panel-footer bg-gray-light">
                              <div class="row">

                                 <div class="col-lg-10"></div>
                                 <div class="col-lg-2">
                                    <span class=" pull-right">
                                       <input type="hidden" name="producto" value="<?php echo $producto_id; ?>">

                                       <input type="button" name="<?php echo base_url() ?>producto/producto/associar_bodega" data="associar_bodega" class="btn btn-success enviar_data" value="Guardar">
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </form>

                     </section>
                  <?php
                  } else {
                     echo "No Existen Datos";
                  }
                  ?>

               </div>
            </div>



         </div>
      </div>
   </div>

</section>