<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista de Atributos </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Atributos</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Tipo</th>                               
                                <th>Creado</th>
                                <th>Actualizado</th>
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
                                $contado=1;
            	               foreach ($lista_atributos as $atributo) {
            	               ?>
            	                    			<tr>
            			                            <th scope="row"><?php echo $contado; ?></th>
            			                            <td><?php echo $atributo->nam_atributo; ?></td>
            			                            <td><?php echo $atributo->tipo_atributo; ?></td>
            			                            <td><?php echo $atributo->creado_atributo; ?></td>
                                                    <td><?php echo $atributo->actualizado_atributo; ?></td>
            			                            <td>
            			                            	<?php 
            			                            		if($atributo->estado_atributo==1){
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
            				                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-primary btn-xs">Opcion
                                                                    <span class="caret"></span>
                                                                </button>
            				                                    <ul role="menu" class="dropdown-menu">                                                                    
            				                                        <li><a href="edit/<?php echo $atributo->id_prod_atributo; ?>">Editar</a></li>
                                                                    
                                                                    <li class="divider"></li>
            				                                        <li><a href="delete/<?php echo $atributo->id_prod_atributo; ?>">Eliminar</a></li>

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

