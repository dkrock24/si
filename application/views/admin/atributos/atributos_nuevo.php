<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Atributos</button> </a> 
                <a href="../dep/<?php //echo $dep;  ?>" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info btn-outline">/ Nuevo</button></a>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-white">

                        <div class="panel-body">
                            <div class="col-lg-6">
                               
                                <div id="" class="panel panel-info">
                                    <div class="panel-heading">Nueva Atributo </div>
                                        <p>
                                        <form class="form-horizontal" action='crear' method="post">
                                            <input type="hidden" value="<?php //echo $dep; ?>" name="id_departamento">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nam_atributo" name="nam_atributo" placeholder="Nombre" value="">
                                                    <p class="help-block">Nombre Atributo.</p>
                                                </div>
                                            </div>   
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tipo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tipo_atributo" name="tipo_atributo" placeholder="Tipo" value="">
                                                    <p class="help-block">Tipo Atributo.</p>
                                                </div>
                                            </div>                                          


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                        <label>
                                                            <select name="estado_atributo" class="form-control">
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
