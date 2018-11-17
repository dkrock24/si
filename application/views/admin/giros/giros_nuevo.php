<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Giros</button> </a> 
                <a href="" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info btn-outline">/ Nuevo</button></a>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-white">

                        <div class="panel-body">
                            <div class="col-lg-6">
                               
                                <div id="" class="panel panel-info">
                                    <div class="panel-heading">Nueva Giro </div>
                                        <p>
                                        <form class="form-horizontal" action='crear' method="post">
                                            
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nombre_giro" name="nombre_giro" placeholder="Nombre" value="">
                                                    <p class="help-block">Nombre Giro.</p>
                                                </div>
                                            </div>   
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tipo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tipo_giro" name="tipo_giro" placeholder="Tipo" value="">
                                                    <p class="help-block">Tipo Giro.</p>
                                                </div>
                                            </div>    

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descri.</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="descripcion_giro" name="descripcion_giro" placeholder="Tipo" value="">
                                                    <p class="help-block">Descripcion Giro.</p>
                                                </div>
                                            </div>  

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="codigo_giro" name="codigo_giro" placeholder="Tipo" value="">
                                                    <p class="help-block">Codigo Giro.</p>
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
