<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">


        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel menu_title_bar">

                    <div class="panel-heading menuTop">Importar Datos: <?php //echo  $onMenu[0]->nombre_submenu; 
                                                                        ?> </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" action='importFile' method="post" enctype="multipart/form-data">
                                    
                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tablas</label>
                                        <div class="col-sm-9">
                                            <select name="tables" class="form-control">
                                                <?php
                                                foreach ($list_tablas as $t) {
                                                    ?>
                                                    <option value=""><?php echo $t ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Opciones</label>
                                        <input type="radio" name="tipo_insert" value="" /> Truncate Table<br>
                                        <input type="radio" name="tipo_insert" value="" /> Nuevas Entradas <br>

                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Archivo</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" id="uploadFile" name="uploadFile" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input type="submit" class="btn btn-info" name="submit" value="Upload" />
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