
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
            <a name="admin/terminal/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Terminales</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">

                <div id="panelDemo10" class="panel menu_title_bar">    
                                        
                    <div class="panel-heading menuTop">Nueva Terminal <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                     <div class="menuContent">
                     <div class="b">    
                        <div class="panel-heading"></div>
                    <p> 
                    <form class="form-horizontal" enctype="multipart/form-data" id="terminal" name="terminales" method="post">
                        
                        <div class="row">

                            <div class="col-lg-4">

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Caja</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="Caja">
                                            <?php
                                            foreach ($caja as $c) {
                                                ?>
                                                <option value="<?php echo $c->id_caja; ?>"><?php echo $c->nombre_caja; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Nombre</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Codigo</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="codigo" name="codigo" placeholder="Codigo" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Sistema Estado</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="sistema_estado" name="sistema_estado" placeholder="Sistema Estado" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Numero</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="numero" name="numero" placeholder="Numero" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Comentario</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="comentario" name="comentario" placeholder="Comentarios" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Fecha Creado</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" id="fecha_creado" name="fecha_creado" value="<?php echo date("Y-m-d") ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Ult Cod Emp</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="ult_cod_empr" name="ult_cod_empr" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Ult Cod Suc</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="ult_cod_sucur" name="ult_cod_sucur" value="">
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Ult Cod Usu</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="ult_usuario" name="ult_usuario" value="">
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-4" style="border-left:1px solid grey;border-right:1px solid grey">

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">IP/MACk</label>
                                    <div class="col-sm-9">
                                        <?php echo $_SERVER['REMOTE_ADDR']; ?>
                                        <input type="text" required class="form-control" id="ip_o_mack" name="ip_o_mack" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Sis. Operativo</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="sist_operativo" name="sist_operativo" value="">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Dispositivo</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="dispositivo" name="dispositivo" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Navegador</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="navegador" name="navegador" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Autorizado</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="sys_autorz" name="sys_autorz" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Emp Estado</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="emp_estado" name="emp_estado" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Emp Autorz</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="emp_autorz" name="emp_autorz" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">F. Inicio</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" id="fh_inicio" name="fh_inicio" value="<?php echo date("Y-m-d") ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Modelo</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="modelo" name="modelo" placeholder="Modelo" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-4">

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Serie</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="series" name="series" placeholder="Serie" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Marca</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="marca" name="marca" placeholder="Marca" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Licencia</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="licencia" name="licencia" placeholder="Licencia" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Ubicacion</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" id="ubicacion" name="ubicacion" placeholder="Ubicacion" value="<?php //echo $onMenu[0]->icon_submenu ?>">
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
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Sucursal</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="Sucursal">
                                            <?php
                                            foreach ($sucursal as $s) {
                                                ?>
                                                <option value="<?php echo $s->id_sucursal; ?>"><?php echo $s->nombre_sucursal; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Usuario</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="Usuario">
                                            <?php
                                            foreach ($usuario as $u) {
                                                ?>
                                                <option value="<?php echo $u->id_usuario; ?>"><?php echo $u->primer_nombre_persona.' '.$u->primer_apellido_persona; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        
                                        <label>
                                            <select name="estado_terminal" class="form-control">
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer text-right">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                <input type="button" name="<?php echo base_url() ?>admin/terminal/crear" data="terminal" class="btn btn-warning enviar_data" value="Guardar">                    
                                </div>
                            </div>
                        </div>
                    </form>
                    </p>  
                    </div>
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