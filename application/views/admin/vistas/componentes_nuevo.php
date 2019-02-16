<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="../componentes/<?php echo $vista_id; ?>" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Componentes</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
            
                    <div class="col-lg-6">

                        <div id="panelDemo10" class="panel panel-info">    
                                                
                            <div class="panel-heading">Nuevo Componente : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                             <div class="panel-body">        
                            <p> 
                            <form class="form-horizontal" action='../componente_crear' method="post">
                                <input type="hidden" value="<?php echo $vista_id; ?>" name="vista_id">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Accion Nombre</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="accion_nombre" name="accion_nombre" placeholder="" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Btn Nombre</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="accion_btn_nombre" name="accion_btn_nombre" placeholder="" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Btn Css</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="accion_btn_css" name="accion_btn_css" placeholder="" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Btn Icon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="accion_btn_icon" name="accion_btn_icon" placeholder="" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Btn Url</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="accion_btn_url" name="accion_btn_url" placeholder="" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Btn Codigo</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="accion_btn_codigo" name="accion_btn_codigo" placeholder="" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Btn Desc.</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="accion_descripcion" name="accion_descripcion" placeholder="" value="<?php //echo $onMenu[0]->titulo_submenu ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Btn valor</label>
                                    <div class="col-sm-9">

                                        <select name="accion_valor" class="form-control">
                                            <option value="btn_superior">btn_superior</option>
                                            <option value="btn_medio">btn_medio</option>
                                            <option value="btn_inferior">btn_inferior</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        
                                            <label>
                                                <select name="accion_estado" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
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
