<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        
        $("#departamento").change(function(){
            $("#ciudad").empty();
            var html_option;
            var departamento = $(this).val();

            $.ajax({
                url: "getCiudadId/"+departamento,
                datatype: 'json',      
                cache : false,                

                success: function(data){
                    var datos = JSON.parse(data);
                    var ciudad = datos["ciudad"];

                   $.each(ciudad, function(i, item) { 
                    html_option += "<option>"+item.nombre_ciudad+"</option>";
                   });
                    $("#ciudad").html(html_option);           
                },
                error:function(){
                }
            });           
        });
    });
</script>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
        <a href="../../cliente/index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-success"> Clientes</button>
            </a>
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn  btn-primary btn-outline"> Clientes Tipo</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
        

                        <div id="panelDemo10" class="panel menu_title_bar">    
                                                
                            <div class="panel-heading menuTop">Nuevo Cliente : <?php //echo $cliente[0]->nombre_submenu ?> </div>
                             <div class="panel-body menuContent">        
                            <p> 
                            <form class="form-horizontal" enctype="multipart/form-data" name="cliente" action='../update' method="post">
                                <input type="hidden" value="<?php echo $cliente[0]->id_cliente_tipo; ?>" name="id_cliente_tipo">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Nombre Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nombre_cliente_tipo" name="nombre_cliente_tipo" placeholder="" value="<?php echo $cliente[0]->nombre_cliente_tipo ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Codigo Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="codigo_cliente_tipo" name="codigo_cliente_tipo" placeholder="" value="<?php echo $cliente[0]->codigo_cliente_tipo ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Signo Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="signo_cliente_tipo" name="signo_cliente_tipo" placeholder="" value="<?php echo $cliente[0]->signo_cliente_tipo ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Porcentaje Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="porcentaje_cliente_tipo" name="porcentaje_cliente_tipo" placeholder="" value="<?php echo $cliente[0]->porcentaje_cliente_tipo ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Descuento Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                
                                                <select id="aplica_impuestos" name="descuento_cliente_tipo" class="form-control">

                                                <?php
                                                if($cliente[0]->descuento_cliente_tipo == 1)
                                                {
                                                    ?>
                                                    <option value="1">Si</option>
                                                    <option value="0">No</option>                                                    
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                    <?php
                                                }
                                                ?>
                                                    

                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">TP Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="tp_cliente_tipo" name="tp_cliente_tipo" placeholder="" value="<?php echo $cliente[0]->tp_cliente_tipo ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Correlativo Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="correlativo_cliente_tipo" name="correlativo_cliente_tipo" placeholder="" value="<?php echo $cliente[0]->correlativo_cliente_tipo ?>">

                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">CTA Ingreso Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="cta_ingreso_cliente_tipo" name="cta_ingreso_cliente_tipo" placeholder="" value="<?php echo $cliente[0]->cta_ingreso_cliente_tipo ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">CTA CXC Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="cta_cxc_cliente_tipo" name="cta_cxc_cliente_tipo" placeholder="" value="<?php echo $cliente[0]->cta_cxc_cliente_tipo ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Estado Cliente Tipo</label>
                                            <div class="col-sm-9">
                                                
                                                <select id="estado_cliente_tipo" name="estado_cliente_tipo" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>

                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-info">Guardar</button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                    </div>
                                </div>
                                
                            
                            </form>
                            </p>                                    
                        </div>
                       
            
                </div>
            </div>
        </div>
    </div>
</section>
