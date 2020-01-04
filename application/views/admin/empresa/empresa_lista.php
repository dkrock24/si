<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Empresas 
                <?php $this->load->view('notificaciones/success'); ?>
            </h3>
            <div class="panel menu_title_bar">
  
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead class="linea_superior">
                            <tr>
                                <th style="color: black;">#</th>
                                <th style="color: black;">Nombre</th> 
                                <th style="color: black;">NRC</th>
                                <th style="color: black;">NIT</th>
                                <th style="color: black;">Giro</th>
                                <th style="color: black;">Tel</th>
                                <th style="color: black;">Moneda</th>
                                <th style="color: black;">Codigo</th>                  
                                <th style="color: black;">Creado</th>
                                <th style="color: black;">Estado</th>
                                
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
                                    <td><?php echo $empresa->moneda_nombre; ?></td>
                                    <td><?php echo $empresa->codigo; ?></td>
		                                      			                            
                                    <td><?php $date = new DateTime($empresa->empresa_creado); echo $date->format('M-d-Y');   ?></td>
                                    
                                    <td>
                                        <?php 
                                            if($empresa->empresa_estado==1){
                                                ?>
                                                <span class="label label-success" style="background: #39b2d6">Activo</span>
                                                <?php
                                            }else{
                                                ?>
                                                <span class="label label-warning" style="background: #d26464">Inactivo</span>
                                                <?php
                                            }
                                        ?>
                                    </td>
		                            
		                            <td>
		                            	                                
			                                <div class="btn-group mb-sm">
			                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-xs" style="background: #dde6e9; color: black;">Opcion
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

