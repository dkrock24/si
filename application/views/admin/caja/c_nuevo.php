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
                <button type="button" class="mb-sm btn btn-success"> Caja</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">

                <div id="panelDemo10" class="panel menu_title_bar">    
                                        
                    <div class="panel-heading menuTop"><h4><i class="fa fa-desktop"></i> Crear Nueva Caja</h4>  <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                     <div class="menuContent">        
                    
                     <div class="b">
                        <div class="panel-heading">                                   
                        </div>
                            <form class="form-horizontal" enctype="multipart/form-data" id="crear" name="caja" action='crear' method="post">
                                <input type="hidden" name="Empresa" value="<?php echo $this->session->empresa[0]->id_empresa ?>">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-9">
                                                <input type="text" required class="form-control" id="nombre_caja" name="nombre_caja" placeholder="Nombre" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Codigo Interno</label>
                                            <div class="col-sm-9">
                                                <input type="text" required class="form-control" id="cod_interno_caja" name="cod_interno_caja" placeholder="Codigo" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Documento</label>
                                            <div class="col-sm-9">
                                                <select name="pred_id_tpdoc" class="form-control">
                                                    <?php
                                                    foreach ($doc as  $d) {
                                                        ?>
                                                        <option value="<?php echo $d->id_temp_suc ?>"><?php echo $d->nombre." - ".$d->nombre_sucursal ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Fecha Operación</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="fecha_oper_caja" name="fecha_oper_caja" placeholder="Serie" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Num. Resolución</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="resol_num_caja" name="resol_num_caja" placeholder="Resolucion" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Fecha Resolución</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="resol_fecha_caja" name="resol_fecha_caja" placeholder="Ubicacion" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Número Ticket Resolución</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="resol_num_tiq_caja" name="resol_num_tiq_caja" placeholder="Numero Ticket Resolucion" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Fecha Ticket Resolución</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="resol_fec_tiq_caja" name="resol_fec_tiq_caja" placeholder="Cajero" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">CTB</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="cod_ctb_caja" name="cod_ctb_caja" placeholder="CTB" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Abrir Caja</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="abrir_caja" name="abrir_caja" placeholder="Abrir Caja" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Impresion Journ</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="impr_journ" name="impr_journ" placeholder="Impresion" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Puerto Dos</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="impr_puerto_DOS" name="impr_puerto_DOS" placeholder="Puerto Dos" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Puerto Win</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="impr_puerto_WIN" name="impr_puerto_WIN" placeholder="Puerto Win" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Es Pos</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="es_pos" name="es_pos" placeholder="Es Pos" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Número Turnos</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="num_turnos" name="num_turnos" placeholder="Numero" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Código</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="pred_cod_cajr" name="pred_cod_cajr" placeholder="Codigo" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Sucursal</label>
                                            <div class="col-sm-9">
                                                <select name="pred_cod_sucu" class="form-control">
                                                    <?php
                                                    foreach ($suc as  $s) {
                                                        ?>
                                                        <option value="<?php echo $s->id_sucursal ?>"><?php echo $s->nombre_sucursal ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>                                        
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                
                                                <label>
                                                    <select name="estado_caja" class="form-control">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                        
                            <div class="panel-footer text-right">
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" id="btn_save" class="btn btn-danger">Guardar</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                    </div>
                                                    
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