<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Ordenes </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Ordenes</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Correlativo</th> 
                                <th>Sucursal</th>
                                <th>Terminal</th>
                                <th>Cliente</th>
                                <th>F. Pago</th>
                                <th>Tipo Doc.</th>
                                <th>Cajero</th>                                                   
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
                                if($ordenes){
            	               foreach ($ordenes as $orden) {
            	               ?>
            	                    			<tr>
            			                            <th scope="row"><?php echo $contado; ?></th>
                                                    <td><?php echo $orden->num_correlativo; ?></td>
                                                    <td><?php echo $orden->nombre_sucursal; ?></td>
                                                    <td><?php echo $orden->num_caja; ?></td>
                                                    <td><?php echo $orden->nombre_empresa_o_compania; ?></td>
                                                    <td><?php echo $orden->nombre_modo_pago; ?></td>
                                                    
                                                    
                                                    <td><?php echo $orden->tipo_documento; ?></td>
                                                    <td><?php echo $orden->nombre_usuario; ?></td>
            			                                      			                            
                                                    <td><?php $date = new DateTime($orden->fecha); echo $date->format('M-d-Y / H:i');   ?></td>
                                                    <td><?php $date = new DateTime($orden->modi_el); echo $date->format('M-d-Y / H:i'); ?></td>
                                                    <td>
                                                        <?php 
                                                            if($orden->anulado==0){
                                                                ?>
                                                                <span class="label label-success">Activo</span>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <span class="label label-warning">Anulado</span>
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
                                                                        <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $orden->id; ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                                                        <?php
                                                                        }
                                                                        if($value->accion_valor == 'btn_medio' && $value->accion_nombre == 'Eliminar') {
                                                                        ?>
                                                                        <li class="divider"></li>
                                                                        <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $orden->id; ?>"><?php echo $value->accion_nombre;  ?></a></li>
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

