<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Pais</button> </a> 
                <a href="../dep/<?php echo $dep;  ?>" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" style="position: relative;" class="mb-sm btn btn-info btn-outline">Departamento</button></a>
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Ciudad</button>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div id="panelDemo10" class="panel menu_title_bar"> 
                               
                        <div class="panel-heading menuTop">Nueva Ciudad </div>
                             <div class="panel-body menuContent">
                                 <div class="row">
                                    <div class="col-lg-6">
                                        <form class="form-horizontal" action='../crear_ciu' method="post">
                                            <input type="hidden" value="<?php echo $dep; ?>" name="id_departamento">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nombre_ciu" name="nombre_ciu" placeholder="Nombre Ciudad" value="">
                                                    
                                                </div>
                                            </div>                                           


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                        <label>
                                                            <select name="estado_ciu" class="form-control">
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
