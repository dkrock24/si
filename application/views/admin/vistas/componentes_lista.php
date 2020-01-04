<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
                <h3 style="height: 50px; font-size: 13px;">  
                        <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                            <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Vistas</button> 
                        </a>    
                         <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Componentes</button>                     
            </h3>
            <div class="panel panel-default">
                <div class="panel-heading">
                    
                </div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vista</th>
                                <th>Accion</th>                               
                                <th>btn Nombre</th>
                                <th>btn Css</th>
                                <th>btn Icon</th>
                                <th>btn Url</th>
                                <th>btn Codigo</th>
                                <th>btn Descrip</th>
                                <th>btn Posicion</th>                                
                                <th>btn Estado</th>
                                <th>
                                    <div class="btn-group">
                                       <button type="button" class="btn btn-default">Opcion</button>
                                       <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-default">
                                          <span class="caret"></span>
                                          <span class="sr-only">default</span>
                                       </button>
                                       <ul role="menu" class="dropdown-menu">
                                          <li><a href="../componentes_nuevo/<?php echo $vista_id; ?>">Nuevo</a>                </li>
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
            	               foreach ($componentes as $compo) {
            	               ?>
                    			<tr>
		                            <th scope="row"><?php echo $contado; ?></th>
		                            <td><?php echo $compo->vista_nombre; ?></td>
		                            <td><?php echo $compo->accion_nombre; ?></td>
		                            <td><?php echo $compo->accion_btn_nombre; ?></td>
                                    <td><?php echo $compo->accion_btn_css; ?></td>
                                    <td><?php echo $compo->accion_btn_icon; ?></td>

                                    <td><?php echo $compo->accion_btn_url; ?></td>
                                    <td><?php echo $compo->accion_btn_codigo; ?></td>
                                    <td><?php echo $compo->accion_descripcion; ?></td>

                                    <td><?php echo $compo->accion_valor; ?></td>

                                    
		                            <td>
	                            	<?php 
	                            		if($compo->accion_estado == 1){
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
		                                        <li><a href="edit/<?php echo $compo->id_vista_componente; ?>">Editar</a></li>
                                                <li><a href="componentes/<?php echo $compo->id_vista_componente; ?>">Componentes</a></li>
                                                
                                                <li class="divider"></li>
		                                        <li><a href="delete/<?php echo $compo->id_vista_componente; ?>">Eliminar</a></li>

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

