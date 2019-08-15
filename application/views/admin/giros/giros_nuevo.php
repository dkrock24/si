<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Giros</button> </a> 
                
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Nuevo</button></a>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div id="panelDemo10" class="panel">  
                               

                        <div class="panel-heading menuTop">Nueva Giro </div>
                            <div class="panel-body menuContent">
                                <div class="row">
                                    <div class="col-lg-6">
                                        
                                        <form class="form-horizontal" action='crear' method="post">
                                            
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nombre_giro" name="nombre_giro" placeholder="Nombre" value="">
                                                    
                                                </div>
                                            </div>   
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tipo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tipo_giro" name="tipo_giro" placeholder="Tipo" value="">
                                                    
                                                </div>
                                            </div>    

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="descripcion_giro" name="descripcion_giro" placeholder="Descripcion" value="">
                                                    
                                                </div>
                                            </div>  

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="codigo_giro" name="codigo_giro" placeholder="Codigo" value="">
                                                    
                                                </div>
                                            </div>                                       


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                        <label>
                                                            <select name="estado_giro" class="form-control">
                                                                        <option value="1">Activo</option>
                                                                        <option value="0">Inactivo</option>              
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
        </div>
    </section>
