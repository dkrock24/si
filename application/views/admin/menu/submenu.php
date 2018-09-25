

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h3 class="panel-title"> <a href="../index"><i class="fa fa-arrow-left"></i> Lista Menu </a> / <?php echo $submenus[0]->nombre_menu; ?></h3>
                <div class="panel-tools">
                    <a class="tools-action" href="#" data-toggle="collapse">
                        <i class="pe-7s-angle-up"></i>
                    </a>
                    <a class="tools-action" href="#" data-toggle="dispose">
                        <i class="pe-7s-close"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed table-hover">
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
                    		
                    		$contado=1;

	                    	foreach ($submenus as $sub) {
                                //var_dump($sub);
                            		
	                    			?>
	                    			<tr>
			                            <th scope="row"><?php echo $contado; ?></th>
			                            <td><?php echo $sub->nombre_submenu; ?></td>
			                            <td><?php echo $sub->url_submenu; ?></td>
			                            <td><i class="<?php echo $sub->icon_submenu; ?>"></i> <?php echo $sub->icon_submenu; ?></td>
			                            <td>
			                            	<?php 
			                            		if($sub->estado_submen==1){
			                            			?>
			                            			<span class="label label-success">Activo</span>
			                            			<?php
			                            		}?></td>
			                            <td><?php echo $sub->titulo_submenu; ?></td>
			                            <td>
			                            	<div class="input-group">                                
				                                <div class="input-group-btn">
				                                    <button type="button" class="btn btn-primary dropdown-toggle left" data-toggle="dropdown" aria-expanded="false">Action <span class="caret"></span></button>
				                                    <ul class="dropdown-menu">
				                                        <li><a href="../editar_sub_menu/<?php echo $sub->id_submenu; ?>">Editar</a></li>
				                                        <li><a href="../editar_sub_menu/<?php echo $sub->id_submenu; ?>">Eliminar</a></li>
				                                    </ul>
				                                </div>
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

