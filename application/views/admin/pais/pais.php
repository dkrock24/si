<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Pais </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Lista Pais</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Codigo</th>
                                <th>Moneda</th>                                
                                <th>Simbolo</th>   
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
            	               foreach ($pais as $lista_pais) {
            	               ?>
            	                    			<tr>
            			                            <th scope="row"><?php echo $contado; ?></th>
            			                            <td><?php echo $lista_pais->nombre_pais; ?></td>
            			                            <td><?php echo $lista_pais->zip_code; ?></td>
            			                            <td><?php echo $lista_pais->moneda_nombre; ?></td>
                                                    <td><?php echo $lista_pais->moneda_simbolo; ?></td>
                                                    <td><?php echo $lista_pais->fecha_creacion_pais; ?></td>
                                                    <td><?php echo $lista_pais->fecha_actualizacion_pais; ?></td>
            			                            <td>
            			                            	<?php 
            			                            		if($lista_pais->estado_pais==1){
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
                                                                    <li><a href="dep/<?php echo $lista_pais->id_pais; ?>">Ver</a></li>
            				                                        <li><a href="edit/<?php echo $lista_pais->id_pais; ?>">Editar</a></li>
                                                                    
                                                                    <li class="divider"></li>
            				                                        <li><a href="delete/<?php echo $lista_pais->id_pais; ?>">Eliminar</a></li>

            				                                    </ul>
            				                                </div>
                                        				
            			                            </td>
            			                        </tr>
                                                <?php
            	                    	}

                                	?>                       
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


    </div>
</section>

