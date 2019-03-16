<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; ">Lista Combos </h3>
            <div class="panel panel-default">
                <div class="panel-heading"><h2 style="display: inline-block;"><i class="fa fa-home"></i></h2>Combos</div>
                <!-- START table-responsive-->
                <div class="">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead class="bg-info-dark">
                            <tr>
                                <th style="color: white;">#</th>
                                <th style="color: white;">Producto</th> 
                                <th style="color: white;">Agregados</th>
                                <th style="color: white;">Cantidad</th>
                                
                                <th style="color: white;">
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
                                if($combos){
            	               foreach ($combos as $combo) {
            	               ?>
                    			<tr>
		                            <th scope="row"><?php echo $contado; ?></th>
                                    <td><?php echo $combo->uno; ?></td>
                                    <td><?php echo $combo->dos; ?></td>		
                                    <td><?php echo $combo->cantidad; ?></td>
		                            
		                            <td>
		                            	                                
		                                <div class="btn-group mb-sm">
		                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-primary btn-xs bg-gray-dark">Opcion
                                                <span class="caret"></span>
                                            </button>
		                                    <ul role="menu" class="dropdown-menu">
                                                <?php
                                                if($acciones){
                                                foreach ($acciones as $key => $value) {
                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre != 'Eliminar') {
                                                    ?>
                                                    <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $combo->Producto_Combo; ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                                    <?php
                                                    }
                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre == 'Eliminar') {
                                                    ?>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $combo->Producto_Combo; ?>"><?php echo $value->accion_nombre;  ?></a></li>
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

