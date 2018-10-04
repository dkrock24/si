
<!-- Main section-->
      <section>
         <!-- Page content-->
         <div class="content-wrapper">
            <h3>Lista Menus
               <small>Lista Menus</small>
            </h3>
            <div class="panel panel-default">
               <div class="panel-heading">Demo Table #1</div>
               <!-- START table-responsive-->
               <div class="table-responsive">
                            <table id="datatable1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Url</th>
                                        <th>Icono</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>                            
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php
                                		$id_menu = 0;
                                		$contado=1;
            	                    	foreach ($menu as $menus) {
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
            			                            <td><?php echo $menus->nombre_menu; ?></td>
            			                            <td>
            			                            	<div class="input-group">                                
            				                                <div class="input-group-btn">
            				                                    <button type="button" class="btn btn-primary dropdown-toggle left" data-toggle="dropdown" aria-expanded="false">Action <span class="caret"></span></button>
            				                                    <ul class="dropdown-menu">
                                                                    <li><a href="submenu/<?php echo $menus->id_menu; ?>">Ver</a></li>
            				                                        <li><a href="editar_menu/<?php echo $menus->id_menu; ?>">Editar</a></li>
            				                                        <li><a data-toggle="modal" data-target="#ver" href="#">Eliminar</a></li>
            				                                    </ul>
            				                                </div>
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
         

<div id="ver" class="modal modal-message modal-default fade" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="pe-7s-bell"></i>
                    </div>
                    <div class="modal-title">Title</div>

                    <div class="modal-body">Some message for you!</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
                <!-- / .modal-content -->
            </div>
            <!-- / .modal-dialog -->
        </div>

    </div>
</section>