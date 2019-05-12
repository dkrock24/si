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
        <?php

            $url = base_url();
            $num = is_numeric(substr($_SERVER['PATH_INFO'], -1, 1));

            if($num){
                $last_part      = substr(strrchr($_SERVER['PATH_INFO'], "/"), 1);
                $last_part_cantidad =  strlen($last_part);
                $string_lenght  = strlen($_SERVER['PATH_INFO']);
                $strin_final    = substr($_SERVER['PATH_INFO'], 0 , ($string_lenght - ($last_part_cantidad + 1) ) );
                $url = $url.$strin_final;
            }else{
              $url = $url.$_SERVER['PATH_INFO'];
            }
        ?>
            <h3 style="height: 50px; ">
             <a href="<?php echo $url; ?>/../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista</button> 
              </a> 

              <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Template Sucursales</button>
            </h3>
           
                <!-- START table-responsive-->
                <div class="row">
                    <div class="col-lg-4">
                      <!-- START panel-->
                      <div id="panelDemo10" class="panel panel-info">
                         <div class="panel-heading">Filtros</div>
                         <div class="panel-body">
                            <p>
                                <form action="<?php echo $url ?>" method="post">
                                <select class="form-control" name="factura_id">
                                    <option value="0"> Formato Documento</option>
                                    <?php
                                        foreach ( $template as $t) {
                                            ?>
                                            <option value="<?php echo $t->id_factura; ?>"><?php echo $t->factura_nombre; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <br>
                                <select class="form-control" name="documento">
                                    <option value="0"> Tipo Documento</option>
                                    <?php
                                        foreach ( $documento as $d) {
                                            ?>
                                            <option value="<?php echo $d->id_tipo_documento; ?>"><?php echo $d->nombre; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <br>
                                <input type="submit" name="" class="btn btn-primary" class="form-control" value="Buscar">
                                </form>
                            </p>
                        </div>
                        <div class="panel-footer"> 
                          <table class="table">
                            <tr>
                              <td>Formato Documento Id</td>
                              <td>:<?php echo $factura_id;  ?></td>
                            </tr>
                            <tr>
                              <td>Tipo Documento Id</td>
                              <td>: <?php echo $documento_id;  ?></td>
                            </tr>
                          </table>                           
                        </div>
                        </div>
                      <!-- END panel-->
                    </div>

                    <!-- Permitir Accesos al usuarios a menus visibles -->
                    <div class="col-lg-8">
                        <div id="panelDemo10" class="panel panel-info">
                            <div class="panel-heading panel-heading-collapsed">
                             
                            Sucursales / Formato Documento
                                <a href="#" data-tool="panel-dismiss" data-toggle="tooltip" title="Close Panel" class="pull-right">
                                <em class="fa fa-times"></em>
                                </a>
                                <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                                    <em class="fa fa-plus"></em>
                                </a>
                            </div>
                            <div class="panel-wrapper collapse ">                            

                                <div class="panel-body">
                                    <?php if(isset($template)){ ?>
                                        <!-- Main section-->
                                  <section>
                              

                                <!-- START panel-->
                                                                   
                                   <!-- START table-responsive-->
                                   <?php if($result){ ?>

                                   <form action="activacion" method="post">
                                    <input type="hidden" name="documento_id" value="<?php echo $documento_id ?>">
                                    <input type="hidden" name="factura_id" value="<?php echo $factura_id ?>">
                                   
                                      <table id="table-ext-1" class="table table-bordered table-hover">
                                         <thead class="bg-info-dark">
                                            <tr>
                                              <th style="color: white;">ID</th>
                                              <th style="color: white;">Documento</th>
                                              <th style="color: white;">Formato</th>
                                              <th style="color: white;">Descripcion</th>                                              
                                              <th style="color: white;">Sucursal</th>                                              
                                              <th style="color: white;">Estado</th>
                                              <th data-check-all style="color: white;">
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
                                           
                                            foreach ($result as $value) {

                                                ?>
                                                <tr>
                                                   <td><?php echo $contador; ?></td>
                                                   <td class="" width="">
                                                      <div class="">
                                                         <?php echo $value->nombre; ?>
                                                      </div>
                                                   </td>
                                                   <td class="" width="20%">
                                                      <div class="">
                                                         <?php echo $value->factura_nombre; ?>
                                                      </div>
                                                   </td>
                                                   
                                                   <td class="" width="20%">
                                                      <div class="">
                                                         <?php echo $value->factura_descripcion; ?>
                                                      </div>
                                                   </td>
                                                   <td class="" width="25%">
                                                      <div class="">
                                                         <?php echo $value->nombre_sucursal; ?>
                                                      </div>
                                                   </td>
                                                   
                                                   
                                                   <td class="text-center">
                                                    <?php 
                                                        if($value->estado_suc_tem == 1){
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
                                                            if($value->estado_suc_tem == 1){
                                                                $check = "checked";
                                                            }else{
                                                                $check="unchecked";
                                                            }
                                                            
                                                            ?>
                                                            <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->Sucursal; ?>">
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
                                   
                                   <!-- END table-responsive-->
                                   <div class="panel-footer bg-gray-light">
                                      <div class="row ">

                                         <div class="col-lg-10"></div>
                                         <div class="col-lg-2">                                                  
                                               <span class=" pull-right">
                                                <input type="hidden" name="id_temp_suc" value="<?php echo $result[0]->id_temp_suc; ?>">                                                
                                                <button class="btn btn-sm btn-info">Guardar</button>
                                               </span>
                                         </div>
                                      </div>
                                   </div>
                                    </form> 
                                  <?php } ?>
                                
                                <!-- END panel-->                                      
                          
                                  </section>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div id="panelDemo10" class="panel panel-info">
                            <div class="panel-heading panel-heading-collapsed"> Lista Sucursales
                                <a href="#" data-tool="panel-dismiss" data-toggle="tooltip" title="Close Panel" class="pull-right">
                                <em class="fa fa-times"></em>
                                </a>
                                <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                                    <em class="fa fa-plus"></em>
                                </a>
                            </div>
                            <div class="panel-wrapper collapse">                            

                                <div class="panel-body">
                                    <?php if(isset($sucursales)){ ?>
                                        <!-- Main section-->
                                    <section>
                                        <!-- START panel-->
                                        
                                           
                                           <!-- START table-responsive-->
                                           <form action="associar_sucursal" method="post">
                                            <input type="hidden" name="documento_id" value="<?php echo $documento_id ?>">
                                            <input type="hidden" name="factura_id" value="<?php echo $factura_id ?>">
                                           <div class="">
                                              <table id="table-ext-1" class="table table-bordered table-hover">
                                                 <thead class="bg-info-dark">
                                                    <tr>
                                                       <th style="color: white;">ID</th>
                                                       <th style="color: white;">Sucursal</th>
                                                       <th style="color: white;">Direccion</th>
                                                       <th style="color: white;">Estado</th>
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
                                                    foreach ($sucursales as $value) {
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
                                                                 <?php echo $value->direct; ?>
                                                              </div>
                                                           </td>
                                                           
                                                           <td class="text-center">
                                                            <?php 
                                                                if($value->estado == 1){
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
                                                                    if($value->estado == 1){
                                                                        $check = "unchecked";
                                                                    }else{
                                                                        $check="unchecked";
                                                                    }
                                                                    
                                                                    ?>
                                                                    <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_sucursal; ?>">
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
                                           <div class="panel-footer bg-gray-light">
                                              <div class="row">

                                                 <div class="col-lg-10"></div>
                                                 <div class="col-lg-2">                                                  
                                                       <span class=" pull-right">
                                                        <input type="hidden" name="sucursal" value="<?php echo $sucursales[0]->id_sucursal; ?>">
                                                        
                                                          <button class="btn btn-sm btn-info">Guardar</button>
                                                       </span>
                                                 </div>
                                              </div>
                                           </div>
                                            </form> 
                                        
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

