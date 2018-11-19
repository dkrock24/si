<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Productos </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Productos</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th> 
                                <th>Categoria</th>
                                <th>Sub Categoria</th>
                                <th>Giro</th>                                                              
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
                                          <li><a href="nuevo">Nuevo Producto</a></li>
                                          <li><a href="nuevo">Nueva Categoria</a></li>
                                          <li><a href="nuevo">Nueva Atributo</a></li>
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
                                if($prod){
            	               foreach ($prod as $p) {
            	               ?>
            	                    			<tr>
            			                            <th scope="row"><?php echo $contado; ?></th>
                                                    <td><?php echo $p->name_entidad; ?></td>
                                                    <td><?php echo $p->nombre_categoria; ?></td>
                                                    <td><?php echo $p->SubCategoria; ?></td>
                                                    <td><?php echo $p->nombre_giro; ?></td>
            			                                      			                            
                                                    <td><?php echo $p->creado_producto; ?></td>
                                                    <td><?php //echo $p->pro_estado; ?></td>
            			                            <td>
            			                            	<?php 
            			                            		if($p->producto_estado==1){
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
                                                                    <li><a href="dep/<?php //echo $p->id_entidade; ?>">Ver</a></li>
            				                                        <li><a href="editar/<?php echo $p->id_entidad; ?>">Editar</a></li>
                                                                    
                                                                    <li class="divider"></li>
            				                                        <li><a href="delete/<?php //echo $p->id_pais; ?>">Eliminar</a></li>

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
