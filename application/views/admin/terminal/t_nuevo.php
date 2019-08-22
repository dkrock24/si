<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
    });      
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
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Terminales</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                
            
                    

                        <div id="panelDemo10" class="panel">    
                                                
                            <div class="panel-heading menuTop">Nueva Terminal <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                             <div class="panel-body menuContent">        
                            <p> 
                            <form class="form-horizontal" enctype="multipart/form-data" id="crear" name="terminales" action='crear' method="post">
                                <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Numero</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="numero" name="numero" placeholder="Numero" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Modelo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Serie</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="series" name="series" placeholder="Serie" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Marca</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Ubicacion</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ubicacion" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Apertura</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="apertura" name="apertura" placeholder="Apertura" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Cajero</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="cajero" name="cajero" placeholder="Cajero" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Ubicacion</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ubicacion" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                
                                                <label>
                                                    <select name="estado" class="form-control">
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
                                        <!-- Otro -->
                                        
                                    
                                        


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

<!-- Modal Large CLIENTES MODAL-->
   <div id="persona_modal" tabindex="-1" role="dialog" aria-labelledby="persona_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Buscar Persona</h4>
            </div>
            <div class="modal-body">
                <p class="cliente_lista_datos">
                    
                </p>                                 
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->


<!-- Modal Large CLIENTES MODAL-->
   <div id="error" tabindex="-1" role="dialog" aria-labelledby="error"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header bg-info-dark">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title"><i class="fa fa-warning fa-fw"></i> Notificación</h4>
            </div>
            <div class="modal-body">
               <p style="text-align: center; font-size: 18px;" class="notificacion_texto"></p>
            </div>
            <div class="modal-footer bg-gray">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->