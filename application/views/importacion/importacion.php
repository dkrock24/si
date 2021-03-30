
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style=""><i class="icon-arrow-right"></i> <?php echo $titulo; ?></h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel menu_title_bar">

                    <div class="panel-heading menuTop">Importar Datos:</div>
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
                                                    <option value="<?php echo $t ?>"><?php echo $t ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Relaciones</label>
                                        <input type="radio" name="relaciones" value="SET FOREIGN_KEY_CHECKS=0" />
                                        Set 0<br>
                                        <input type="radio" name="relaciones" value="SET FOREIGN_KEY_CHECKS=1" />
                                        Set 1<br>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Opciones</label>
                                        <input type="radio" name="tipo_insert" value="TRUNCATE" /> Truncate Table<br>
                                        <input type="radio" name="tipo_insert" value="" /> Nuevas Entradas <hr>
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

                            <div class="col-lg-6">
                                <form action="generar_impuestos_categorias" name="procesar" method="post">
                                CONFIGURAR IMPUESTOS <hr>

                                <div class="row">
                                    <div class="col-lg-3">
                                    CATEGORIAS
                                        <select name="categoria" class="form-control">
                                            <option value="-"> - </option>
                                            <option value="0">Todas</option>
                                            <?php
                                            foreach ($categorias as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id_categoria'] ?>"> <?php echo $value['nombre_categoria'] ?></option>
                                                <?php
                                            }
                                            ?>                                        
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                    CLIENTES
                                        <select name="cliente" class="form-control">
                                            <option value="-"> - </option>
                                            <option value="0">Todas</option>
                                            <?php
                                            foreach ($clientes as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->id_cliente ?>"> <?php echo $value->nombre_empresa_o_compania ?></option>
                                                <?php
                                            }
                                            ?>                                        
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                    DOCUMENTOS
                                        <select name="documento" class="form-control">
                                            <option value="-"> - </option>
                                            <option value="0">Todas</option>
                                            <?php
                                            foreach ($documentos as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->id_tipo_documento ?>"> <?php echo $value->nombre ?></option>
                                                <?php
                                            }
                                            ?>                                        
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                    PROVEEDOR
                                        <select name="proveedor" class="form-control">
                                            <option value="-"> - </option>
                                            <option value="0">Todas</option>
                                            <?php
                                            foreach ($proveedor as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->id_proveedor ?>"> <?php echo $value->empresa_proveedor ?></option>
                                                <?php
                                            }
                                            ?>                                        
                                        </select>
                                    </div>
                                
                                </div>
                                
                                

                                <br>

                                IMPUESTOS
                                <select name="impuesto" class="form-control">
                                    <?php
                                    foreach ($impuestos as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->id_tipos_impuestos ?>"> <?php echo $value->nombre ?></option>
                                        <?php
                                    }
                                    ?>
                                    
                                </select>

                                <br>


                                IMPUESTO ACTIVO / INACTIVO
                                <select name="activo" class="form-control">
                                    <option value="0">Inactivo</option>
                                    <option value="1">Activo</option>
                                </select>

                                <br>

                                Actualizar CONFIGURACION
                                <select name="actualizar" class="form-control">
                                    <option value="0">Inactivo</option>
                                    <option value="1">Activo</option>
                                </select>

                                <br>
                                <input type="submit" name="enviar" value="Procesar" class="btn btn-info" />

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
