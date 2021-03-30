<script type="text/javascript">
    $(document).ready(function(){

        $('.removeInput').click(function(){
            //$(this).remove();
            alert(1);
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
        
        cont = 1;
        function drawSelect( valueInput ){
            $(".agregar").attr('name', valueInput);
            var inputValue = "<div class='form-group'><div class='col-sm-2'>Opcion "+cont+"</div><div class='col-sm-9'><input type='text' name='option"+cont+"' value='' class='form-control'/></div><div class='col-sm-1'><a href='#' class='removeInput'><i class='fa fa-remove'></i></a></div>";
            var inputValue2 = "</div>";
            $("#atributosOptios").append( inputValue + inputValue2 );
            cont++;
        }

        function clearOption(){
            $("#atributosOptios").empty();
            cont=1;
        }
    });
</script>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">            
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/atributos/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Atrributos </button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
        </h3>
        <div class="row">
            <form class="form-horizontal" id='atributo' method="post">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-6">
                        <!-- START panel-->
                        <div id="panelDemo10" class="panel menu_title_bar">
                            <div class="panel-heading menuTop">Nueva Atributo </div>
                            <div class="panel-body menuContent">
                                <p>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nam_atributo" name="nam_atributo" placeholder="Nombre" value="">
                                            <p class="help-block">Nombre Atributo.</p>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>   
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tipo</label>
                                        <div class="col-sm-9">                                                    
                                            
                                            <select class="form-control" id="tipo_atributo" name="tipo_atributo">
                                                <option value="text">Text</option>
                                                <option value="radio">Radio</option>                                                        
                                                <option value="select">Select</option>
                                                <option value="check">Check</option>
                                                <option value="file">File</option>
                                            </select>

                                            <p class="help-block">Tipo Atributo.</p>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>                                          

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <label>
                                                <select name="estado_atributo" class="form-control">
                                                            <option value="1">Activo</option>
                                                            <option value="0">Inactivo</option>              
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="button" name="<?php echo base_url() ?>admin/atributos/crear" data="atributo" class="btn btn-success enviar_data" value="Guardar">
                                        </div>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <!-- START panel-->
                        <div id="panelDemo10" class="panel">
                            <div class="panel-heading menuTop">Opciones <span class='btn btn-default agregar' name="">Agregar</span> </div>
                            <div class="panel-body menuContent">
                                <div id="atributosOptios"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>