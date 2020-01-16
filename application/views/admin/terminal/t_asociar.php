<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $(".agregar").on('click',function(){

            var id_usuario = $(this).attr('name');
            var id_terminal = $(this).attr('id');

            var params = {
                usuario:id_usuario , 
                terminal:id_terminal,
                method:'agregar'
            };

            procesar(params);
        });

        $(".eliminar").on('click',function(){

            var id_usuario = $(this).attr('name');
            var id_terminal = $(this).attr('id');

            var params = {
                usuario:id_usuario , 
                terminal:id_terminal,
                method:'inactivar'
            };

            procesar(params);
        });

        


        function procesar(params){

            $.ajax({
                url: "../"+params.method,
                datatype: 'json',
                cache: false,
                type: 'POST',
                data:params,

                success: function(data) {
                    
                    location.reload();                    

                },
                error: function() {}
            });

        }

    });      
</script>
<!-- Main section-->
<section>
        <!-- Page content-->
        <div class="content-wrapper">
            
            <h3 style="height: 50px; ">
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-right btn-primary btn-outline"> Terminales</button> 
            </a> 
            
                <?php $this->load->view('notificaciones/success'); ?>
            </h3>
            <div class="panel menu_title_bar">
                <table class="table">
                    <tr>
                        <td><h3>Terminal :<?php echo $terminal[0]->nombre; ?></h3></td>
                        <td><h3>Codigo :<?php echo $terminal[0]->codigo; ?></h3></td>
                        <td><h3>Numero :<?php echo $terminal[0]->numero; ?></h3></td>
                        <td><h3>Dispositivo :<?php echo $terminal[0]->dispositivo; ?></h3></td>
                        <td><h3>SO :<?php echo $terminal[0]->sist_operativo; ?></h3></td>
                        <td><h3>Numero :<?php echo $terminal[0]->marca; ?></h3></td>
                        <td><h3>M :<?php echo $terminal[0]->modelo; ?></h3></td>
                        <td><h3>S :<?php echo $terminal[0]->series; ?></h3></td>
                    </tr>
                </table>

             
            <hr>
  
                <div class="row">

                    <div class="col-lg-6">
                        <h4>LISTA USUARIOS EMPRESA</h4>
                        <table id="datatable1" class="table table-striped table-hover">
                            <thead class="linea_superior">
                                <tr>
                                    <th style="color: black;">#</th>
                                    <th style="color: black;">Sucursal</th> 
                                    <th style="color: black;">usuario</th>                                
                                    <th style="color: black;">Apellidos</th>
                                    <th style="color: black;">Nombres</th>
                                    <th style="color: black;">Estado</th>
                                    
                                    <th>
                                       
                                    </th>                            
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $contado=1;
                                    if($usuario){
                                foreach ($usuario as $ter_usu) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $contado; ?></th>
                                        
                                        
                                        <td><?php echo $ter_usu->nombre_sucursal; ?></td>
                                        <td><?php echo $ter_usu->nombre_usuario; ?></td>
                                        <td><?php echo $ter_usu->primer_apellido_persona." ".$ter_usu->segundo_apellido_persona; ?></td>
                                        <td><?php echo $ter_usu->primer_nombre_persona." ".$ter_usu->segundo_nombre_persona; ?></td>
                                        

                                        
                                        <td>
                                            <?php 
                                                if($ter_usu->estado==1){
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
                                                                                                                        
                                            <a href="#" class="btn btn-primary btn-sm agregar" rel="" name="<?php echo $ter_usu->id_usuario; ?>" id="<?php echo $terminal[0]->id_terminal; ?>"><i class="fa fa-plus-circle" style="font-size:18px"></i></a>

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

                    <div class="col-lg-6">
                        <h4>LISTA USUARIO TERMINAL</h4>
                        <table id="datatable1" class="table table-striped table-hover">
                            <thead class="linea_superior">
                                <tr>
                                    <th style="color: black;">#</th>
                                    <th style="color: black;">Sucursal</th> 
                                    <th style="color: black;">Terminal</th>                                
                                    <th style="color: black;">Codigo</th>
                                    <th style="color: black;">usuario</th>                                
                                    <th style="color: black;">Apellidos</th>
                                    <th style="color: black;">Nombres</th>
                                    <th style="color: black;">Estado</th>
                                    
                                    <th>
                                        
                                    </th>                            
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $contado=1;
                                    if($terminal_usuario){
                                foreach ($terminal_usuario as $ter_usu) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $contado; ?></th>
                                        <td><?php echo $ter_usu->nombre_sucursal; ?></td>
                                        <td><?php echo $ter_usu->nombre; ?></td>
                                        <td><?php echo $ter_usu->codigo; ?></td>
                                        <td><?php echo $ter_usu->nombre_usuario; ?></td>
                                        <td><?php echo $ter_usu->primer_apellido_persona." ".$ter_usu->segundo_apellido_persona; ?></td>
                                        <td><?php echo $ter_usu->primer_nombre_persona." ".$ter_usu->segundo_nombre_persona; ?></td>
                                        

                                        
                                        <td>
                                            <?php 
                                                if($ter_usu->estado_terminal_cajero==1){
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
                                                                            
                                            <a href="#" name="<?php echo $ter_usu->id_usuario; ?>" id="<?php echo $terminal[0]->id_terminal; ?>" class="btn btn-warning btn-sm eliminar"><i class="fa fa-refresh" style="font-size:18px"></i></a>
                                            
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


    </div>
</section>

