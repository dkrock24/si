
<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Menus</button> </a> 
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Sub Menu</button>
                </h3>
            <div class="panel panel-default">
                <div class="panel-heading"> <?php echo $submenus[0]->nombre_menu; ?></div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Url</th>
                                <th>Icono</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>
                                     <div class="btn-group">
                                       <button type="button" class="btn btn-default">Opcion</button>
                                       <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-default">
                                          <span class="caret"></span>
                                          <span class="sr-only">default</span>
                                       </button>
                                       <ul role="menu" class="dropdown-menu">
                                          <li><a href="../nuevo_submenu/<?php echo $submenus[0]->id_menu; ?>">Nuevo</a>                </li>
                                          <li><a href="#">Exportar</a>              </li>
                                          <li class="divider"></li>
                                          <li><a href="#">Otros</a>
                                          </li>
                                       </ul>
                                    </div>
                                </th>                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $contado=1;

                            foreach ($submenus as $sub) {
                                //var_dump($sub);
                                    
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $contado; ?></th>
                                        <td><?php echo $sub->nombre_submenu; ?></td>
                                        <td><?php echo $sub->url_submenu; ?></td>
                                        <td><i class="<?php echo $sub->icon_submenu; ?>"></i> <?php echo $sub->icon_submenu; ?></td>
                                        <td>
                                            <?php 
                                                if($sub->estado_submen==1){
                                                    ?>
                                                    <span class="label label-success">Activo</span>
                                                    <?php
                                                }?></td>
                                        <td><?php echo $sub->titulo_submenu; ?></td>
                                        <td>
                                                                      
                                                <div class="btn-group mb-sm">
                                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-primary btn-xs">Opcion
                              <span class="caret"></span>
                           </button>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a href="../editar_sub_menu/<?php echo $sub->id_submenu; ?>">Editar</a></li>
                                                        <li><a href="../delete_sub_menu/<?php echo $sub->id_submenu; ?>">Eliminar</a></li>
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

