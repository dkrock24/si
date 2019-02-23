<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script type="text/javascript">

    $(document).on('click', '.btn_cantidad', function(){

        $('.cantidad_input').css("display","line");
    });

    
</script>

<style type="text/css">

</style>
<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Producto Bodega </h3>
           
                <!-- START table-responsive-->
                <div class="row">
                    <div class="col-lg-4">
                      <!-- START panel-->
                      <div id="panelDemo10" class="panel panel-info">
                         <div class="panel-heading">Filtros</div>
                         <div class="panel-body">
                            <p>
                                <form action="bodega" method="post">
                                <select class="form-control" name="producto">
                                    <option value="0"> Seleciona Producto</option>
                                    <?php
                                        foreach ( $prod as $producto) {
                                            ?>
                                            <option value="<?php echo $producto->id_entidad; ?>"><?php echo $producto->name_entidad; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <br>
                                <input type="submit" name="" class="btn btn-primary" class="form-control" value="Buscar">
                                </form>
                            </p>
                        </div>
                        <div class="panel-footer"> - </div>
                        </div>
                      <!-- END panel-->
                    </div>

                    <!-- Permitir Accesos al usuarios a menus visibles -->
                    <div class="col-lg-8">
                        <div id="panelDemo10" class="panel panel-info">
                            <div class="panel-heading panel-heading-collapsed">Bodegas
                                <a href="#" data-tool="panel-dismiss" data-toggle="tooltip" title="Close Panel" class="pull-right">
                                <em class="fa fa-times"></em>
                                </a>
                                <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                                    <em class="fa fa-plus"></em>
                                </a>
                            </div>
                            <div class="panel-wrapper collapse">                            

                                <div class="panel-body">
                                    <?php if(isset($prod_bodega)){ ?>
                                        <!-- Main section-->
                                  <section>
                              

                                <!-- START panel-->
                                <div class="panel panel-default">
                                   <div class="panel-heading"> </div>
                                   <!-- START table-responsive-->
                                   <form action="producto_activar" method="post">
                                   <div class="">
                                      <table id="table-ext-1" class="table table-bordered table-hover">
                                         <thead>
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
                                            $contador =1;
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
                                                         <input type="number" class="cantidad_input" style="width:80px;" name="cantidad<?php echo $contador; ?>">
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
                                                        if($value->pro_bod_estado == 1){
                                                        ?>
                                                        <div class="label label-success">Activo</div>
                                                    <?php
                                                        }else{
                                                           ?><div class="label label-warning">Inactivo</div><?php 
                                                        }
                                                    ?>
                                                      
                                                   </td>
                                                   
                                                   <td>
                                                      <div class="checkbox c-checkbox">
                                                         <label>
                                                            <?php
                                                            $check="";
                                                            if($value->pro_bod_estado == 1){
                                                                $check = "checked";
                                                            }else{
                                                                $check="unchecked";
                                                            }
                                                            
                                                            ?>
                                                            <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_pro_bod; ?>">
                                                            <span class="fa fa-check"></span>
                                                         </label>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <?php
                                                $contador+=1;
                                            }
                                            ?>   
                                                                                         

                                         </tbody>
                                      </table>
                                   </div>
                                   <!-- END table-responsive-->
                                   <div class="panel-footer">
                                      <div class="row">

                                         <div class="col-lg-10"><a href="#" class="btn btn-warning btn_cantidad">Cantidad</a></div>
                                         <div class="col-lg-2">                                                  
                                               <span class=" pull-right">
                                                <input type="hidden" name="producto_id" value="<?php echo $prod_bodega[0]->Producto; ?>">                                                
                                                <button class="btn btn-sm btn-info">Guardar</button>
                                               </span>
                                         </div>
                                      </div>
                                   </div>
                                    </form> 
                                </div>
                                <!-- END panel-->                                      
                          
                                  </section>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div id="panelDemo10" class="panel panel-info">
                            <div class="panel-heading panel-heading-collapsed"> Vincular Producto a Sucursal
                                <a href="#" data-tool="panel-dismiss" data-toggle="tooltip" title="Close Panel" class="pull-right">
                                <em class="fa fa-times"></em>
                                </a>
                                <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                                    <em class="fa fa-plus"></em>
                                </a>
                            </div>
                            <div class="panel-wrapper collapse">                            

                                <div class="panel-body">
                                    <?php if(isset($bodega)){ ?>
                                        <!-- Main section-->
                                    <section>
                                        <!-- START panel-->
                                        <div class="panel panel-default">
                                           <div class="panel-heading"> - </div>
                                           <!-- START table-responsive-->
                                           <form action="associar_bodega" method="post">
                                           <div class="">
                                              <table id="table-ext-1" class="table table-bordered table-hover">
                                                 <thead>
                                                    <tr>
                                                       <th>ID</th>
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
                                                    $contador =1;
                                                    foreach ($bodega as $value) {
                                                        ?>
                                                        <tr>
                                                           <td><?php echo $contador; ?></td>
                                                           <td class="" width="50%">
                                                              <div class="">
                                                                 <?php echo $value->nombre_bodega; ?>
                                                              </div>
                                                           </td>
                                                           
                                                           <td class="text-center">
                                                            <?php 
                                                                if($value->bodega_estado == 1){
                                                                ?>
                                                                <div class="label label-success">Activo</div>
                                                            <?php
                                                                }else{
                                                                   ?><div class="label label-warning">Inactivo</div><?php 
                                                                }
                                                            ?>
                                                              
                                                           </td>
                                                           
                                                           <td>
                                                              <div class="checkbox c-checkbox">
                                                                 <label>
                                                                    <?php

                                                                    $check="";
                                                                    if($value->bodega_estado == 1){
                                                                        $check = "unchecked";
                                                                    }else{
                                                                        $check="unchecked";
                                                                    }
                                                                    
                                                                    ?>
                                                                    <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_bodega; ?>">
                                                                    <span class="fa fa-check"></span>
                                                                 </label>
                                                              </div>
                                                           </td>
                                                        </tr>
                                                        <?php
                                                        $contador+=1;
                                                    }
                                                    ?>

                                                 </tbody>
                                              </table>
                                           </div>
                                           <!-- END table-responsive-->
                                           <div class="panel-footer">
                                              <div class="row">

                                                 <div class="col-lg-10"></div>
                                                 <div class="col-lg-2">                                                  
                                                       <span class=" pull-right">
                                                        <input type="hidden" name="producto" value="<?php echo $producto_id; ?>">
                                                        
                                                          <button class="btn btn-sm btn-info">Guardar</button>
                                                       </span>
                                                 </div>
                                              </div>
                                           </div>
                                            </form> 
                                        </div>
                                        <!-- END panel-->                                      
                                    </section>
                                    <?php 
                                    }else{
                                        echo "No Existen Datos";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
           
    </section>

