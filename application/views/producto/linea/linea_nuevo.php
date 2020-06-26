<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">                
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-success"> Lista Linea</button> 
        </a> 
        <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Nuevo</button>
        </h3>        

        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar"> 
                    <div class="panel-heading menuTop">Nueva Linea </div>

                    <div class="panel-body menuContent">    
                        <div class="row">
                            <div class="col-lg-6">                                    
                                <form class="form-horizontal" action='save_linea' method="post">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tipo</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="tipo_producto" name="tipo_producto" value="<?php //echo $roles[0]->role ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="descripcion_tipo_producto" name="descripcion_tipo_producto" value="<?php //echo $roles[0]->pagina ?>">
                                        </div>
                                    </div>                                     

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <label>
                                                <select name="estado_linea" class="form-control">
                                                    <option value="0">Inactivo</option>
                                                    <option value="1">Activo</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-info">Guardar</button>
                                        </div>
                                    </div>
                                </form>                                    
                            </div>
                        </div>
                    </div>                          
                </div>
            </div>
        </div>
    </div>
</section>
