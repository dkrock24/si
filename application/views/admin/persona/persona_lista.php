<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Persona </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Persona</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th> 
                                <th>DUI</th>
                                <th>NIT</th>
                                <th>Direccion</th>
                                <th>Tel</th>
                                <th>cel</th>
                                <th>whatsapp</th>                                                   
                                <th>Sexo</th>                                
                                <th>Ciudad</th>
                                <th>Estado</th>
                                
                                <th>
                                    <div class="btn-group">
                                       <button type="button" class="btn btn-default">Opcion</button>
                                       <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-default">
                                          <span class="caret"></span>
                                          <span class="sr-only">default</span>
                                       </button>
                                       <ul role="menu" class="dropdown-menu">
                                        <?php
                                        if($acciones){
                                        foreach ($acciones as $key => $value) {
                                            if($value->accion_valor == 'btn_superior'){
                                            ?>
                                            <li><a href="<?php echo $value->accion_btn_url;  ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                            <?php
                                        }}}
                                        ?>
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
                                if($persona){
            	               foreach ($persona as $personas) {
            	               ?>
                    			<tr>
		                            <th scope="row"><?php echo $contado; ?></th>
                                    <td><?php echo $personas->primer_nombre_persona." ".$personas->primer_apellido_persona; ?></td>
                                    <td><?php echo $personas->dui; ?></td>
                                    <td><?php echo $personas->nit; ?></td>
                                    <td><?php echo $personas->direccion_residencia_persona1; ?></td>
                                    <td><?php echo $personas->tel; ?></td>                                  
                                    <td><?php echo $personas->cel; ?></td>

                                    <td><?php echo $personas->whatsapp; ?></td>
                                    <td><?php echo $personas->sexo; ?></td>
                                    <td><?php echo $personas->nombre_ciudad; ?></td>
		                                      			                            
                                    
                                    <td>
                                        <?php 
                                            if($personas->persona_estado==1){
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
                                                <?php
                                                if($acciones){
                                                foreach ($acciones as $key => $value) {
                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre != 'Eliminar') {
                                                    ?>
                                                    <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $personas->id_persona; ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                                    <?php
                                                    }
                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre == 'Eliminar') {
                                                    ?>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $personas->id_persona; ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                                    <?php
                                                    }
                                                }}
                                                ?>                                                                    
                                                <li class="divider"></li>            				                                        

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

