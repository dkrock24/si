<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a name="admin/turnos/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Turnos</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
        </h3>

        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">    
                                                
                    <div class="panel-heading menuTop"><i class="fa fa-bars" style="font-size: 20px;"></i> Crear Turno<?php //echo $onMenu[0]->nombre_submenu ?> </div>
                    <div class="panel-body menuContent">        
                        <p> 
                        <form class="form-horizontal" id="turnos" method="post">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Otro -->
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="nombre_modo_pago" name="nombre_turno" placeholder="Nombre" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Hora Inicio</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="codigo_modo_pago" name="hora_inicio" placeholder="Codigo" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Hora Fin</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="descripcion_modo_pago" name="hora_fin" placeholder="Descripcion" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            
                                            <label>
                                                <select name="estado_turno" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="button" name="<?php echo base_url() ?>admin/turnos/crear" data="turnos" class="btn btn-success enviar_data" value="Guardar">
                                        </div>
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
</section>
