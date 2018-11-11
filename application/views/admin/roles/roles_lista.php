<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Roles </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Lista Roles</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre Rol</th>
                                <th>Pagina</th>
                                <th>Creacion</th>
                                <th>Actualizacion</th>
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
            	           foreach ($roles as $role) {
            	                    		
            	           ?>
            	           <tr>
            			         <th scope="row"><?php echo $contado; ?></th>
            			         <td><?php echo $role->role; ?></td>
            			         <td><?php echo $role->pagina; ?></td>            			
            			         <td><?php echo $role->fecha_creacion; ?></td>
                                <td><?php echo $role->fecha_actualizacion; ?></td>
                                <td>
                                    <?php
                                    if($role->estado_rol==1){
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
            				                <button type="button" class="btn btn-primary dropdown-toggle left btn-xs" data-toggle="dropdown" aria-expanded="false">Action <span class="caret"></span></button>
            				                <ul class="dropdown-menu">    
            				                    <li><a href="editar_role/<?php echo $role->id_rol; ?>">Editar</a></li>
            				                    <li><a data-target="#ver" href="delete/<?php echo $role->id_rol; ?>">Eliminar</a></li>
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
    </section>

