<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Menus </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Lista Menus</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
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
            			                            			<span class="label label-success">Activo</span>
            			                            			<?php
            			                            		}?></td>
            			                            <td><?php echo $menus->class_menu; ?></td>
            			                            <td>
            			                            	                                
            				                                <div class="btn-group mb-sm">
            				                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-primary btn-xs">Opcion
                                                                    <span class="caret"></span>
                                                                </button>
            				                                    <ul role="menu" class="dropdown-menu">
                                                                    <li><a href="submenu/<?php echo $menus->id_menu; ?>">Ver</a></li>
            				                                        <li><a href="editar_menu/<?php echo $menus->id_menu; ?>">Editar</a></li>
                                                                    <li><a href="nuevo_submenu/<?php echo $menus->id_menu; ?>">Nuevo</a></li>
                                                                    <li class="divider"></li>
            				                                        <li><a href="delete/<?php echo $menus->id_menu; ?>">Eliminar</a></li>

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
                        </div>
                    </div>
                </div>


    </div>
</section>

