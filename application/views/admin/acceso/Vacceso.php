
   <div class="content-wrapper">
      <h3 style=""><i class="icon-arrow-right"></i> <?php echo $titulo; ?></h3><br><br><br><br><br><br>

      <div class="row">
         <div class="col-lg-4">
            <div id="panelDemo10" class="panel panel-info menu_title_bar">
               <div class="panel-heading">Acceso Menu Roles</div>
               <div class="panel-body">
                  <p>
                     <form id="form_filtro">
                        <select class="form-control" name="role">
                           <?php
                           if (isset($this->session->r)) {
                              foreach ($roles as $role) {
                                 if ($role->id_rol == $this->session->r) {
                                    ?>
                                    <option value="<?php echo $role->id_rol; ?>"><?php echo $role->role; ?></option>
                                    <?php
                                 }
                              }
                           } 
                           foreach ($roles as $role) {
                              if ($role->id_rol != $this->session->r) {
                                 ?>
                                 <option value="<?php echo $role->id_rol; ?>"><?php echo $role->role; ?></option>
                                 <?php
                              }
                           }
                           ?>
                        </select><br>

                        <select class="form-control" name="menu">
                           <?php
                           if (isset($this->session->m)) {
                              foreach ($menus as $menu) {
                                 if ($menu->id_menu == $this->session->m) {
                                 ?>
                                 <option value="<?php echo $menu->id_menu; ?>"><?php echo $menu->nombre_menu; ?></option>
                                 <?php
                                 }
                              }
                           }
                           if (!isset($this->session->m)) {
                              $cero = 0;
                           }

                           foreach ($menus as $menu) {
                              if ($this->session->m != $menu->id_menu) {
                              ?>
                              <option value="<?php echo $menu->id_menu; ?>"><?php echo $menu->nombre_menu; ?></option>
                              <?php
                              }
                           }
                           ?>
                        </select>
                        <br>
                        <input type="button" name="<?php echo base_url() ?>admin/acceso/index" data="form_filtro" class="btn btn-primary enviar_data form-control" value="Filtrar Accesos">

                        <br><br><br>

                        <label>Roles / Accesos </label>
                        <br>
                        <input type="button" name="<?php echo base_url() ?>admin/acceso/sincAccionesRoles" data="form_filtro" class="btn btn-warning enviar_data form-control" value="Sincronizar">
                     </form>
                  </p>
               </div>
               <div class="panel-footer">Administrar Menus Por Rol</div>
            </div>            
         </div>

         <!-- Permitir Accesos al usuarios a menus visibles -->
         <div class="col-lg-8">
            <div id="panelDemo10" class="panel panel-info menu_title_bar">
               <div class="panel-heading panel-heading-collapsed"><h4>Menus Principales</h4>
                  <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                     <em class="fa fa-plus"></em>
                  </a>
               </div>
               <div class="panel-wrapper ">
                  <?php if (isset($accesos)) { ?>
                     <form id="acceso_guardar">
                        <div class="">
                           <table id="table-ext-1" class="table table-bordered table-hover">
                              <thead>
                                 <tr style="background:#e3f3f6;">
                                    <th>ID</th>
                                    <th>SubMenu Principal</th>
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
                                          if ($value->submenu_acceso_estado == 1) {
                                          ?>
                                             <div class="label label-success">Activo</div>
                                          <?php
                                          } else {
                                          ?>
                                             <div class="label label-warning">Inactivo</div>
                                          <?php
                                          }
                                          ?>

                                       </td>

                                       <td>
                                          <div class="checkbox c-checkbox">
                                             <label>
                                                <?php
                                                      $check = "";
                                                      if ($value->submenu_acceso_estado == 1) {
                                                         $check = "checked";
                                                      } else {
                                                         $check = "unchecked";
                                                      }

                                                      ?>
                                                <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_submenu_acceso; ?>">
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
                        </div>
                        <!-- END table-responsive-->
                        <div class="panel-footer">
                           <div class="row">

                              <div class="col-lg-10"></div>
                              <div class="col-lg-2">
                                 <span class=" pull-right">
                                    <input type="hidden" name="id_role" value="<?php echo $accesos[0]->id_rol; ?>">
                                    <input type="hidden" name="id_menu" value="<?php echo $accesos[0]->id_menu; ?>">
                                    <input type="button" name="<?php echo base_url() ?>admin/acceso/acceso_guardar" data="acceso_guardar" class="btn btn-sm btn-info enviar_data" value="Guardar">
                                 </span>
                              </div>
                           </div>
                        </div>
                     </form>
                  <?php } ?>
               </div>
            </div>

            <div id="panelDemo10" class="panel panel-info">
               <div class="panel-heading panel-heading-collapsed"><h4>Menus Internos</h4>
                  <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                     <em class="fa fa-plus"></em>
                  </a>
               </div>
               <div class="panel-wrapper">

                     <?php if (isset($accesos_menus_internos)) { ?>
                        <form id="accesos_menus_internos">
                           <div class="">
                              <table id="table-ext-1" class="table table-bordered table-hover">
                                 <thead>
                                    <tr style="background:#e3f3f6;">
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
                                       $contador = 1;
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
                                                   if ($value->submenu_acceso_estado == 1) {
                                                      ?>
                                                <div class="label label-success">Activo</div>
                                             <?php
                                                   } else {
                                                      ?><div class="label label-warning">Inactivo</div><?php } ?>

                                          </td>

                                          <td>
                                             <div class="checkbox c-checkbox">
                                                <label>
                                                   <?php
                                                         $check = "";
                                                         if ($value->submenu_acceso_estado == 1) {
                                                            $check = "checked";
                                                         } else {
                                                            $check = "unchecked";
                                                         }

                                                         ?>
                                                   <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_submenu_acceso; ?>">
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
                           </div>
                           <!-- END table-responsive-->
                           <div class="panel-footer">
                              <div class="row">

                                 <div class="col-lg-10"></div>
                                 <div class="col-lg-2">
                                    <span class=" pull-right">
                                       <input type="hidden" name="id_role" value="<?php echo $accesos_menus_internos[0]->id_rol; ?>">
                                       <input type="hidden" name="id_menu" value="<?php echo $accesos_menus_internos[0]->id_menu; ?>">
                                       <button name="<?php echo base_url() ?>admin/acceso/accesos_menus_internos" data="accesos_menus_internos" class="btn btn-sm btn-info enviar_data">Guardar</button>
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </form>
                     <?php
                     } else {
                        echo "No Existen Datos";
                     }
                     ?>
               </div>
            </div>

            <div id="panelDemo10" class="panel panel-info">
               <div class="panel-heading panel-heading-collapsed"><h4>Menu Componentes Vista</h4>
                  <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right">
                     <em class="fa fa-plus"></em>
                  </a>
               </div>
               <div class="panel-wrapper">
                  <?php if (isset($vista_componentes)) { ?>
                     <form id="accesos_componenes">
                        <div class="">
                           <table id="table-ext-1" class="table table-bordered table-hover">
                              <thead>
                                 <tr style="background:#e3f3f6;">
                                    <th>ID</th>
                                    <th>Menu</th>
                                    <th>Vista</th>
                                    <th>Componente</th>
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
                                    $contador = 1;
                                    foreach ($vista_componentes as $value) {
                                       ?>
                                    <tr>
                                       <td><?php echo $contador; ?></td>
                                       <td class="" width="">
                                          <div class="">
                                             <?php echo $value->nombre_menu; ?>
                                          </div>
                                       </td>
                                       <td class="" width="">
                                          <div class="">
                                             <?php echo $value->vista_nombre; ?>
                                          </div>
                                       </td>
                                       <td class="" width="">
                                          <div class="">
                                             <?php echo $value->accion_nombre; ?>
                                          </div>
                                       </td>
                                       <td class="" width="">
                                          <div class="">
                                             <?php echo $value->accion_nombre; ?>
                                          </div>
                                       </td>

                                       <td class="text-center">
                                          <?php
                                                if ($value->vista_acceso_estado == 1) {
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
                                                      if ($value->vista_acceso_estado == 1) {
                                                         $check = "checked";
                                                      } else {
                                                         $check = "unchecked";
                                                      }

                                                      ?>

                                                <input type="checkbox" <?php echo $check; ?> name="<?php echo $value->id_vista_acceso; ?>">
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
                        </div>
                        <!-- END table-responsive-->
                        <div class="panel-footer">
                           <div class="row">

                              <div class="col-lg-10"></div>
                              <div class="col-lg-2">
                                 <span class=" pull-right">
                                    <input type="hidden" name="id_role" value="<?php echo $r; ?>">
                                    <input type="hidden" name="id_menu" value="<?php echo $m; ?>">
                                    <button name="<?php echo base_url() ?>admin/acceso/accesos_componenes" data="accesos_componenes" class="btn btn-sm btn-info enviar_data">Guardar</button>
                                 </span>
                              </div>
                           </div>
                        </div>
                     </form>
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

