<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/menu/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Menu</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                
                <!-- START table-responsive-->
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead class="linea_superior">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Url</th>
                                <th>Icono</th>                                
                                <th>Estado</th>
                                <th>Class</th>
                                <th>
                                    <div class="btn-group">
                                       <button type="button" class="btn btn-default">Opcion</button>
                                       <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-default">
                                          <span class="caret"></span>
                                          <span class="sr-only">default</span>
                                       </button>
                                       <ul role="menu" class="dropdown-menu">
                                          <li><a name="admin/menu/nuevo" class="holdOn_plugin">Nuevo</a>                </li>
                                          <li><a name="#">Exportar</a>              </li>
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
                                $id_menu = 0;
                                $contado=1;
            	                foreach ($lista_menu as $menus) {
            	                    if($id_menu != $menus->id_menu)
                                    {
                                        $id_menu = $menus->id_menu;
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $contado; ?></th>
                                            <td><?php echo $menus->nombre_menu; ?></td>
                                            <td><?php echo $menus->url_menu; ?></td>
                                            <td><i class="<?php echo $menus->icon_menu; ?>"></i> <?php echo $menus->icon_menu; ?></td>
                                            <td>
                                                <?php 
                                                    if($menus->estado_menu==1){
                                                        ?>
                                                        <span class="label label-success" style="background: #39b2d6">Activo</span>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <span class="label label-warning">Inactivo</span>
                                                        <?php
                                                    }?></td>
                                            <td><?php echo $menus->class_menu; ?></td>
                                            <td>
                                                <div class="btn-group mb-sm">
                                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-primary btn-xs" style="background: #dde6e9; color: black;">Opcion
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a class="holdOn_plugin" name="admin/menu/submenu/<?php echo $menus->id_menu; ?>">Ver</a></li>
                                                        <li><a class="holdOn_plugin" name="admin/menu/editar_menu/<?php echo $menus->id_menu; ?>">Editar</a></li>
                                                        <li><a class="holdOn_plugin" name="admin/menu/nuevo_submenu/<?php echo $menus->id_menu; ?>">Nuevo</a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="holdOn_plugin" name="admin/menu/delete/<?php echo $menus->id_menu; ?>">Eliminar</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $contado+=1;
                                    }	
                                }
                            ?>                                   
                        </tbody>                                
                    </table>

                <div class="text-right  panel-footer bg-gray-light">
                    <ul class="pagination pagination-md">
                        
                    </ul>
                </div>
            </div>
        </div>
</section>

