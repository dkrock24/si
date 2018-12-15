<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('.removeInput').click(function(){
            var id = $(this).attr('id');
            $("#"+id).remove();
        });

        if($("#tipo_atributo").val() == 'text'){
            $(".agregar").hide();
        }       

        $("#tipo_atributo").change(function(){
            clearOption();

            var valueInput = $(this).val();
            if(valueInput == 'text'){
                $(".agregar").hide();
            }else{
                $(".agregar").show();
            }

            typeInput(valueInput);

        });

        function typeInput(valueInput){
            switch(valueInput){
                case 'select' : drawSelect( valueInput );
                break;
                case 'check' : drawSelect( valueInput );
                break;
                case 'radio' : drawSelect( valueInput );
                break;
            }
        }

        $(".agregar").click(function(){
            var tipo = $(".agregar").attr('name');
            typeInput(tipo);
        });
        
        cont = $(".contadorInputs").attr('id');
        //cont +=1;
        function drawSelect( valueInput ){            

            $(".agregar").attr('name', valueInput);
            var inputValue = "<div class='form-group'><div class='col-sm-2'>Opcion "+cont+"</div><div class='col-sm-9'><input type='text' name='"+cont+"' value='' class='form-control'/></div><div class='col-sm-1'><a href='#' class='removeInput'><i class='fa fa-remove'></i></a></div>";
            var inputValue2 = "</div>";
            $("#atributosOptios").append( inputValue + inputValue2 );
            cont++;
        }

    });
</script>
<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Atributos</button> </a> 
                <a href="../dep/<?php //echo $dep;  ?>" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info btn-outline">/ Editar</button></a>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <form class="form-horizontal" action='../actualizar' method="post">
                        
                            <div class="col-lg-6">
                               
                                <div id="" class="panel panel-info">
                                    <div class="panel-heading">Editar Atributo </div>
                                        <p>
                                        
                                            <input type="hidden" value="<?php echo $atributo[0]->id_prod_atributo; ?>" name="id_prod_atributo">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nam_atributo" name="nam_atributo" value="<?php echo $atributo[0]->nam_atributo; ?>" placeholder="Nombre" value="">
                                                    <p class="help-block">Nombre Atributo.</p>
                                                </div>
                                            </div>   
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tipo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tipo_atributo" name="tipo_atributo" value="<?php echo $atributo[0]->tipo_atributo; ?>" placeholder="Tipo" value="">
                                                    <p class="help-block">Tipo Atributo.</p>
                                                </div>
                                            </div>                                          


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                        <label>
                                                            <select name="estado_atributo" class="form-control">
                                                               <?php 
                                                                    if( $atributo[0]->estado_atributo ==1 ){ 
                                                                        ?>
                                                                        <option value="1">Activo</option>
                                                                        <option value="0">Inactivo</option>
                                                                        <?php
                                                                    } else{
                                                                         ?>
                                                                        <option value="0">Inactivo</option>
                                                                        <option value="1">Activo</option>
                                                                        <?php
                                                                    }
                                                                ?>          
                                                            </select>
                                                        </label>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </div>
                                        
                                        </p>
                                </div>
                              
                            </div>

                            <div class="col-lg-6">
                                <div id="" class="panel panel-info">
                                    <div class="panel-heading">Editar Opciones <span class='btn btn-default agregar' name="<?php echo $atributo[0]->tipo_atributo; ?>">Agregar</span> </div>
                                    <div class="panel-body">
                                        <div id="atributosOptios">
                                            <?php
                                            $contador = 1;
                                            if(isset($atributo[0]->id_attr_opcion)){
                                            foreach ($atributo as $optiones) {
                                                ?>
                                                <div class='form-group' id="<?php echo $optiones->id_attr_opcion; ?>">
                                                    <div class='col-sm-2'>Opcion <?php echo $contador; ?></div>
                                                    <div class='col-sm-9'>
                                                        <input type='text' name='<?php echo $contador; ?>' value='<?php echo $optiones->attr_valor; ?>' class='form-control'/>
                                                    </div>
                                                    <div class='col-sm-1'><a href='#' class='removeInput' id="<?php echo $optiones->id_attr_opcion; ?>" name="">
                                                        <i class='fa fa-remove'></i></a>
                                                    </div>
                                                </div>
                                                <?php
                                                $contador+=1;
                                            }}
                                            ?> 
                                            <i class="contadorInputs" id="<?php  echo $contador; ?>"></i>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
