<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Empresas </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Empresas</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead class="bg-info-dark">
                            <tr>
                                <th style="color: white;">#</th>
                                <th style="color: white;">Nombre</th> 
                                <th style="color: white;">NRC</th>
                                <th style="color: white;">NIT</th>
                                <th style="color: white;">Cliente</th>
                                <th style="color: white;">Giro</th>
                                <th style="color: white;">Tel</th>
                                <th style="color: white;">Moneda</th>                                                   
                                <th style="color: white;">Creado</th>                                
                                <th style="color: white;">Actualizado</th>
                                <th style="color: white;">Estado</th>
                                
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
                                if($empresas){
            	               foreach ($empresas as $empresa) {
            	               ?>
                    			<tr>
		                            <th scope="row"><?php echo $contado; ?></th>
                                    <td><?php echo $empresa->nombre_razon_social; ?></td>
                                    <td><?php echo $empresa->nrc; ?></td>
                                    <td><?php echo $empresa->nit; ?></td>
                                    <td><?php echo $empresa->giro; ?></td>
                                    <td><?php echo $empresa->tel; ?></td>
                                    
                                    
                                    <td><?php //echo $empresa->tipo_documento; ?></td>
                                    <td><?php echo $empresa->moneda_nombre; ?></td>
		                                      			                            
                                    <td><?php $date = new DateTime($empresa->empresa_creado); echo $date->format('M-d-Y');   ?></td>
                                    <td><?php $date = new DateTime($empresa->empresa_actualizado); echo $date->format('M-d-Y'); ?></td>
                                    <td>
                                        <?php 
                                            if($empresa->empresa_estado==1){
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
                                                        <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $empresa->id_empresa; ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                                        <?php
                                                        }
                                                        if($value->accion_valor == 'btn_medio' && $value->accion_nombre == 'Eliminar') {
                                                        ?>
                                                        <li class="divider"></li>
                                                        <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $empresa->id_empresa; ?>"><?php echo $value->accion_nombre;  ?></a></li>
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

                    <div class="text-right  panel-footer bg-gray-light">
                        <ul class="pagination pagination-md">
                          
                        </ul>
                    </div>

                </div>
            </div>
        </div>


    </div>
</section>

