<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    
    $(document).on("change","#total_pagina",function(){
        $.ajax({
            type: "post",
            url: "",
            success: function() {
                //location.reload();
                $('#pagina_x').submit();
            }
        });
    });

</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/css/css_general.css" />

<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; "><i class="icon-arrow-right"></i> <?php echo $fields['titulo']; ?>   
            <?php $this->load->view('notificaciones/success'); ?>
            </h3>
           

            
            <div class="panel panel-default">
                <!-- START table-responsive-->
                <div class="dataList">
                    <table id="datatable1" class="table table-striped table-hover" width="100%">

                        <thead class="" style="">
                            <tr>
                                <th width="5%">
                                    
                                        <form method="post" id="pagina_x" name="data">
                                        <select class="form-control" id="total_pagina" name="total_pagina">
                                            <option class="0">-</option>
                                            <option class="10">10</option>
                                            <option class="15">15</option>
                                            <option class="20">20</option>
                                            <option class="50">50</option>
                                            <option class="100">100</option>
                                        </select>
                                        </form>
                                    
                                </th>
                              <?php
                              
                              foreach ($column as $key => $combo) {
                                ?>
                                <th style="color: black;"><?php echo $combo; ?></th>
                                <?php
                              }
                              ?>
                                
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
                                            $url = base_url();
                                            $num = is_numeric(substr($_SERVER['PATH_INFO'], -1, 1));

                                            if($num){
                                                $url = $url.'\..'.$_SERVER['PATH_INFO'].'\../../'.$value->accion_btn_url;
                                            }else{
                                                $url = $value->accion_btn_url;
                                            }   
                                                    
                                            if($value->accion_valor == 'btn_superior'){
                                            ?>
                                            <li><a href="<?php echo $url;  ?>"><?php echo $value->accion_nombre;  ?></a></li>
                                            <?php
                                        }}}
                                        ?>
                                          <li class="divider"></li>
                                          <li><a href="#">Otros</a>               </li>
                                          <li><a href="#" class="listar_giros" id="<?php //echo $giros->id_giro; ?>" data-toggle="modal" data-target="#ModalEmpresa">Empresa</a></li>
                                       </ul>
                                    </div>
                                </th>                            
                            </tr>
                        </thead>
                        <tbody>
                       
                        <?php
                            $contador = $contador_tabla;
                            if($registros){
                                foreach ($registros as $table) {
                                    $id =  $fields['id'][0];
                                ?>
                                <tr >
                                    <th scope="row"><?php echo $contador; ?></th>
                                    <?php
                                    foreach ($fields['field'] as $key => $field) {

                                    if($field != 'estado'){
                                        
                                    ?>
                                      <td><?php
                                      $a = substr($table->$field, 0,1);
        
                                         echo $table->$field;  

                                       ?>                                           
                                       </td>
                                    <?php
                                    }
                                        if($field == 'estado'){
                                            $estado = $fields['estado'][0];
                                            ?>
                                            <td>
                                                <?php 
                                                    if($table->$estado == 1){
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
                                            
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                
                                <td>
                                                                  
                                    <div class="btn-group mb-sm">
                                        <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-xs" style="background: #dde6e9">Opcion
                                                <span class="caret"></span>
                                            </button>
                                        <ul role="menu" class="dropdown-menu">
                                                <?php

                                                if($acciones){

                                                foreach ($acciones as $key => $value) {

                                                    $url = base_url();
                                                    $num = is_numeric(substr($_SERVER['PATH_INFO'], -1, 1));

                                                    if($num){
                                                        $url = $url.'\..'.$_SERVER['PATH_INFO'].'\../../'.$value->accion_btn_url;
                                                    }else{
                                                        $url = $value->accion_btn_url;
                                                    }                                                
                                                    $vista = $value->Vista;
                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre != 'Eliminar') {
                                                    ?>

                                                    <li><a href="<?php echo  $url;  ?>/<?php echo $table->$id; ?>"><i class="<?php echo $value->accion_btn_icon; ?>"></i> <?php echo $value->accion_nombre;  ?></a></li>
                                                    
                                                    <?php
                                                    }

                                                    if($value->accion_valor == 'btn_medio' && $value->accion_nombre == 'Eliminar') {
                                                    ?>

                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo $url;  ?>/<?php echo $table->$id; ?>">
                                                        <i class="<?php echo $value->accion_btn_icon; ?>"></i> 
                                                        <?php echo $value->accion_nombre;  ?></a></li>
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
                            $contador+=1;
                        }
                        }
                      ?>                       
                            
                        </tbody>
                        
                    </table>               
                </div>
                    
                    <div class="text-right  panel-footer bg-gray-light">
                        <ul class="pagination pagination-md">
                           <?php foreach ($links as $link) {
                            echo "<li class='page-item '>". $link ."</li>";
                        } ?>
                        </ul>
                    </div>

                
                
            </div>
        </div>


    </div>
</section>
