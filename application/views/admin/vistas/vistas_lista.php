<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Vistas </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Vistas</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Codigo</th>                               
                                <th>Metodo</th>
                                <th>Url</th>
                                <th>Descripcion</th>
                                <th>Botones</th>
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
            	               foreach ($vistas as $vista) {
            	               ?>
                    			<tr>
		                            <th scope="row"><?php echo $contado; ?></th>
		                            <td><?php echo $vista->vista_nombre; ?></td>
		                            <td><?php echo $vista->vista_codigo; ?></td>
		                            <td><?php echo $vista->vista_accion; ?></td>
                                    <td><?php echo $vista->vista_url; ?></td>
                                    <td><?php echo $vista->vista_descripcion; ?></td>

                                    
                                    <td>
                                        <?php
                                        if($vista->total != 0){
                                            ?>
                                            <div class="pull-right label label-success"><?php echo $vista->total; ?></div>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="pull-right label label-danger"><?php echo $vista->total; ?></div>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td><?php $date = new DateTime($vista->vista_creado); echo $date->format("M d-y"); ?></td>
                                    <td><?php $date = new DateTime($vista->vista_actualizado); echo $date->format("M d-y"); ?></td>
		                            <td>
	                            	<?php 
	                            		if($vista->vista_estado==1){
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
		                                        <li><a href="edit/<?php echo $vista->id_vista; ?>">Editar</a></li>
                                                <li><a href="componentes/<?php echo $vista->id_vista; ?>">Componentes</a></li>
                                                
                                                <li class="divider"></li>
		                                        <li><a href="delete/<?php echo $vista->id_vista; ?>">Eliminar</a></li>

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

