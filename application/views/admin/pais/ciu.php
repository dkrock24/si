<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Pais</button> </a> 
                <a href="../dep/<?php echo $ciu[0]->id_departamento;  ?>" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info btn-outline">/ Depart</button></a>
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Ciudades</button>
                </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Lista Ciudades</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pais</th>
                                <th>Departamento</th>
                                <th>Ciudad</th>
                                                              
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
                                          <li><a href="../nuevo_ciu/<?php  echo $ciu[0]->id_departamento; ?>">Nuevo</a>                </li>
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
            	               foreach ($ciu as $ciudad) {
            	               ?>
            	                    			<tr>
            			                            <th scope="row"><?php echo $contado; ?></th>
            			                            <td><?php echo $ciudad->nombre_pais; ?></td>
            			                            <td><?php echo $ciudad->nombre_departamento; ?></td>
            			                            <td><?php echo $ciudad->nombre_ciudad; ?></td>                                                    
                                                    <td><?php echo $ciudad->fecha_ciudad_creacion; ?></td>
                                                    <td><?php echo $ciudad->fecha_ciudad_actualizacion; ?></td>
            			                            <td>
            			                            	<?php 
            			                            		if($ciudad->estado_ciudad==1){
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
            				                                        <li><a href="../editar_ciu/<?php echo $ciudad->id_ciudad; ?>">Editar</a></li>
                                                                    <li class="divider"></li>
            				                                        <li><a href="delete/<?php echo $ciudad->id_ciudad; ?>">Eliminar</a></li>

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

