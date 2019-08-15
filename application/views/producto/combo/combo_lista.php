<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; "><i class="icon-arrow-right"></i>  Lista Combos </h3>
            <div class="panel">
                
                
                
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead class="">
                            <tr>
                                <th style="color: black;">#</th>
                                <th style="color: black;">Combo</th> 
                                <th style="color: black;">Categoria</th>                                                               
                                <th style="color: black;">Sub Categoria</th>
                                <th style="color: black;">Creado</th>
                                <th style="color: black;">Estado</th>
                                
                                <th style="color: black;">
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
                                $id_producto = 0;
                                if($combos){
            	               foreach ($combos as $combo) {
                                
                                   
                                ?>
                    			<tr>
		                            <th scope="row"><?php echo $contado; ?></th>
                                    <td><?php echo $combo->name_entidad; ?></td>
                                     <td><?php echo $combo->nombre_categoria; ?></td>
                                     <td><?php echo $combo->SubCategoria; ?></td>
                                     <td><?php echo $combo->creado_producto; ?></td>
                                     <td>
                                        <?php 
                                        if($combo->producto_estado==0){
                                            ?>
                                            <span class="label label-warning">Inactivo</span>
                                            <?php
                                        }else{
                                            ?>
                                            <span class="label label-success">Activo</span>
                                            <?php
                                        }
                                    ?>
                                    </td>

		                            <td>
		                            	                                
		                                <div class="btn-group mb-sm">
		                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-primary btn-xs ">Opcion
                                                <span class="caret"></span>
                                            </button>
		                                    <ul role="menu" class="dropdown-menu">
                                                <?php
                                                if($acciones){
                                                foreach ($acciones as $key => $value) {
                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre != 'Eliminar') {
                                                    ?>
                                                    <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $combo->id_entidad; ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                                    <?php
                                                    }
                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre == 'Eliminar') {
                                                    ?>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo $value->accion_btn_url;  ?>/<?php echo $combo->id_entidad; ?>"><?php echo $value->accion_nombre;  ?></a></li>
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
</section>

