
<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Administrar Roles </h3>
           
                <!-- START table-responsive-->
                <div class="row">
                    <div class="col-lg-4">
                      <!-- START panel-->
                      <div id="panelDemo10" class="panel panel-info">
                         <div class="panel-heading">Acceso Menu Roles</div>
                         <div class="panel-body">
                            <p>
                                <form action="index" method="post">
                                <select class="form-control" name="role">
                                    <option value="0"> Seleciona Role</option>
                                    <?php
                                        foreach ( $roles as $role) {
                                            ?>
                                            <option value="<?php echo $role->id_rol; ?>"><?php echo $role->role; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select><br>

                                <select class="form-control" name="menu">
                                    <option value="0"> Seleciona Menu</option>
                                    <?php
                                        foreach ( $menus as $menu) {
                                            ?>
                                            <option value="<?php echo $menu->id_menu; ?>"><?php echo $menu->nombre_menu; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <br>
                                <input type="submit" name="" class="btn btn-primary" class="form-control" value="Buscar">
                                </form>
                            </p>
                        </div>
                        <div class="panel-footer">Administrar Menus Por Rol</div>
                        </div>
                      <!-- END panel-->
                    </div>

                    <!-- Permitir Accesos al usuarios a menus visibles -->
                    <div class="col-lg-8">
                        <div id="panelDemo10" class="panel panel-info">
                            <div class="panel-heading panel-heading-collapsed">Accesos Menus
                                <a href="#" data-tool="panel-dismiss" data-toggle="tooltip" title="Close Panel" class="pull-right">
                                <em class="fa fa-times"></em>
                                </a>
                                <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                                    <em class="fa fa-plus"></em>
                                </a>
                            </div>
                            <div class="panel-wrapper collapse">                            

                                <div class="panel-body">
                                    <?php if(isset($accesos)){ ?>
                                        <!-- Main section-->
                                  <section>
                              

                                        <!-- START panel-->
                                        <div class="panel panel-default">
                                           <div class="panel-heading">Actualizar Permiso : [ <?php echo $accesos[0]->role; ?> ] Menu : [ <?php echo $accesos[0]->nombre_menu; ?> ]</div>
                                           <!-- START table-responsive-->
                                           <form action="acceso_guardar" method="post">
                                           <div class="">
                                              <table id="table-ext-1" class="table table-bordered table-hover">
                                                 <thead>
                                                    <tr>
                                                       <th>ID</th>
                                                       <th>Nombre Menu</th>
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
                                                    foreach ($accesos as $value) {
                                                        ?>
                                                        <tr>
                                                           <td><?php echo $contador; ?></td>
                                                           <td class="" width="50%">
                                                              <div class="">
                                                                 <?php echo $value->nombre_submenu; ?>
                                                              </div>
                                                           </td>
                                                           
                                                           <td class="text-center">
                                                            <?php 
                                                                if($value->estado_menu == 1){
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
                                                                    if($value->submenu_acceso_estado == 1){
                                                                        $check = "checked";
                                                                    }else{
                                                                        $check="unchecked";
                                                                    }
                                                                    
                                                                    ?>
                                                                    <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_submenu_acceso; ?>">
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
                                                        <input type="hidden" name="id_role" value="<?php echo $accesos[0]->id_rol; ?>">
                                                        <input type="hidden" name="id_menu" value="<?php echo $accesos[0]->id_menu; ?>">
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
                            <div class="panel-heading panel-heading-collapsed">Accesos Menus Internos
                                <a href="#" data-tool="panel-dismiss" data-toggle="tooltip" title="Close Panel" class="pull-right">
                                <em class="fa fa-times"></em>
                                </a>
                                <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                                    <em class="fa fa-plus"></em>
                                </a>
                            </div>
                            <div class="panel-wrapper collapse">                            

                                <div class="panel-body">
                                    <?php if(isset($accesos_menus_internos)){ ?>
                                        <!-- Main section-->
                                    <section>
                                        <!-- START panel-->
                                        <div class="panel panel-default">
                                           <div class="panel-heading">Actualizar Permiso : [ <?php echo $accesos_menus_internos[0]->role; ?> ] Menu : [ <?php echo $accesos_menus_internos[0]->nombre_menu; ?> ]</div>
                                           <!-- START table-responsive-->
                                           <form action="accesos_menus_internos" method="post">
                                           <div class="">
                                              <table id="table-ext-1" class="table table-bordered table-hover">
                                                 <thead>
                                                    <tr>
                                                       <th>ID</th>
                                                       <th>Nombre Menu</th>
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
                                                    foreach ($accesos_menus_internos as $value) {
                                                        ?>
                                                        <tr>
                                                           <td><?php echo $contador; ?></td>
                                                           <td class="" width="50%">
                                                              <div class="">
                                                                 <?php echo $value->nombre_submenu; ?>
                                                              </div>
                                                           </td>
                                                           
                                                           <td class="text-center">
                                                            <?php 
                                                                if($value->estado_menu == 1){
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
                                                                    if($value->submenu_acceso_estado == 1){
                                                                        $check = "checked";
                                                                    }else{
                                                                        $check="unchecked";
                                                                    }
                                                                    
                                                                    ?>
                                                                    <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_submenu_acceso; ?>">
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
                                                        <input type="hidden" name="id_role" value="<?php echo $accesos_menus_internos[0]->id_rol; ?>">
                                                        <input type="hidden" name="id_menu" value="<?php echo $accesos_menus_internos[0]->id_menu; ?>">
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

                        <div id="panelDemo10" class="panel panel-info">
                            <div class="panel-heading panel-heading-collapsed">Permisos Vistas Componentes
                                <a href="#" data-tool="panel-dismiss" data-toggle="tooltip" title="Close Panel" class="pull-right">
                                <em class="fa fa-times"></em>
                                </a>
                                <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                                    <em class="fa fa-plus"></em>
                                </a>
                            </div>
                            <div class="panel-wrapper collapse">                            

                                <div class="panel-body">
                                    <?php if(isset($vista_componentes)){ ?>
                                        <!-- Main section-->
                                    <section>
                                        <!-- START panel-->
                                        <div class="panel panel-default">
                                           <div class="panel-heading">Actualizar Permiso : [ <?php echo $vista_componentes[0]->role; ?> ] Menu : [ <?php echo $vista_componentes[0]->nombre_menu; ?> ]</div>
                                           <!-- START table-responsive-->
                                           <form action="accesos_menus_internos" method="post">
                                           <div class="">
                                              <table id="table-ext-1" class="table table-bordered table-hover">
                                                 <thead>
                                                    <tr>
                                                       <th>ID</th>
                                                       <th>Cod</th>
                                                       <th>Nombre</th>
                                                       <th>Url</th>
                                                        <th>Permiso En</th>
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
                                                    foreach ($vista_componentes as $value) {
                                                        ?>
                                                        <tr>
                                                           <td><?php echo $contador; ?></td>
                                                           <td class="" width="">
                                                             <div class="">
                                                                 <?php echo $value->vista_codigo; ?>                                                                 
                                                              </div>
                                                           </td>
                                                           <td class="" width="">
                                                             <div class="">
                                                                 <?php echo $value->vista_nombre; ?>                                                                 
                                                              </div>
                                                           </td>
                                                           <td class="" width="">
                                                             <div class="">
                                                                 <?php echo $value->vista_url; ?>                                                                 
                                                              </div>
                                                           </td>
                                                           <td class="" width="">
                                                              <div class="">
                                                                 <?php echo $value->accion_nombre; ?>                                                                 
                                                              </div>
                                                           </td>
                                                           
                                                           <td class="text-center">
                                                            <?php 
                                                                if($value->vista_acceso_estado == 1){
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
                                                                    if($value->vista_acceso_estado == 1){
                                                                        $check = "checked";
                                                                    }else{
                                                                        $check="unchecked";
                                                                    }
                                                                    
                                                                    ?>
                                                                    <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_vista_acceso; ?>">
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
                                                        <input type="hidden" name="id_role" value="<?php echo $accesos_menus_internos[0]->id_rol; ?>">
                                                        <input type="hidden" name="id_menu" value="<?php echo $accesos_menus_internos[0]->id_menu; ?>">
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

