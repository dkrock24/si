<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    
</script>
<!-- Main section-->
<style type="text/css">
    .preview_producto{
        width: 50%;
    }
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Correlativos</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">

                <div id="panelDemo10" class="panel menu_title_bar">    
                                        
                    <div class="panel-heading menuTop">Nuevo Correlativo : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                    <div class="panel-body menuContent">        
                    
                        <form class="form-horizontal" enctype="multipart/form-data" id="save" name="correlativo" action='save' method="post">
                        <input type="hidden" value="" name="id_submenu">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">N° Inicial</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="valor_inical" name="valor_inical" placeholder="Inicial" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">N° Final</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="valor_final" name="valor_final" placeholder="Final" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">N° Siguiente</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="siguiente_valor" name="siguiente_valor" placeholder="Siguiente" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Prefix</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="prefix" name="prefix" placeholder="Prefix" value="">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">N° Serie</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="numero_de_serire" name="numero_de_serire" placeholder="Numero de Serie" value="">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Sucursal</label>
                                    <div class="col-sm-9">
                                        <select id="Sucursal" name="Sucursal" class="form-control">
                                            <?php
                                            if(isset($sucursal)){
                                                foreach ($sucursal as $key => $p) {
                                                    ?>
                                                    <option value="<?php echo $p->id_sucursal; ?>"><?php echo $p->nombre_sucursal; ?></option>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                <option value="">No Hay Sucursal</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Documento</label>
                                    <div class="col-sm-9">
                                        <select id="TipoDocumento" name="TipoDocumento" class="form-control">
                                            <?php
                                            if(isset($documento)){
                                                foreach ($documento as $key => $p) {
                                                    ?>
                                                    <option value="<?php echo $p->id_tipo_documento; ?>"><?php echo $p->nombre; ?></option>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                <option value="">No Hay Documento</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        
                                        <label>
                                            <select name="correlativo_estado" class="form-control">
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" id="btn_save" class="btn btn-info">Guardar</button>
                                    </div>
                                </div>

                                
                            </div>


                            <div class="col-lg-6">
                              
                               


                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




