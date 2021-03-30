<!-- Main section-->
<script>

function deleteEstado(id,name){
    var id      = id;
    var vista   = name;
    var url = "<?php echo base_url() ?>admin/vistas/delete_estado/"+ id + "/" + vista;
    generalAjax(url);
}

function upAndDown(name,id,rel,alt){
    var action  = name;
    var id      = id;
    var orden   = rel;
    var vista   = alt;
    var url = "<?php echo base_url() ?>admin/vistas/update_estado/"+action+"/"+ id + "/"+ orden +"/"+ vista;
    generalAjax(url);
}

function estado_btn(id, name){
    var estado  = id;
    var vista   = name;
    var url = "<?php echo base_url() ?>admin/vistas/agregar_estado/"+ estado + "/" + vista;
    generalAjax(url);
}

function generalAjax(url){
    $.ajax({
        url: url,
        datatype: 'json',
        cache: false,

        success: function(data) {
            var datos = JSON.parse(data);
            var count = datos.length;
            var html_ = "";
            var contador = 1;
            
            $.each(datos, function(i , item){

                html_ += "<tr>";
                html_ += "<td>"+ item.orden_estado_vista +"</td>";
                html_ += "<td>"+ item.orden_estado_nombre +"</td>";
                html_ += "<td>";
                if (contador != 1) {
                    html_ += "<a href='#' onClick='upAndDown("+'"up"'+","+ item.id_estado_vista +","+ item.orden_estado_vista +","+ item.vista_id +");' >";
                    html_ += '<i class="fa fa-arrow-circle-up" style="font-size:30px;"></i>';
                    html_ += '</a> - ';
                }
                if (contador != count) {
                    html_ += "<a href='#' onClick='upAndDown("+'"down"'+","+ item.id_estado_vista +","+ item.orden_estado_vista +","+ item.vista_id +");' >";
                    html_ += '<i class="fa fa-arrow-circle-down" style="font-size:30px;"></i>';
                    html_ += '</a>';
                }
                html_ += "</td>";
                html_ += '<td><a href="#" class="btn btn-warning" onClick="deleteEstado('+ item.id_estado_vista +','+ item.vista_id +');" style="border:1px solid black;"><i class="fa fa-trash"></i></a></td>';
                html_ += "</tr>";
                contador++;
            });

            $('#estados_en_vistas').html(html_);
        },
        error: function() {}
    });
}
</script>
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a name="admin/vistas/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Vistas</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">        
            <div class="col-md-6">
                <div id="" class="panel panel-info menu_title_bar">                                    
                    <div class="panel-heading">Editar Vista :</div>
                    <br>
                    <form class="form-horizontal" id='vistas' method="post">
                        <input type="hidden" value="<?php echo $vistas[0]->id_vista; ?>" name="id_vista">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="vista_nombre" name="vista_nombre" placeholder="Nombre Vista" value="<?php echo $vistas[0]->vista_nombre ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="vista_codigo" name="vista_codigo" placeholder="Codigo Vista" value="<?php echo $vistas[0]->vista_codigo ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Accion</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="vista_accion" name="vista_accion" placeholder="Accion Vista" value="<?php echo $vistas[0]->vista_accion ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="vista_descripcion" name="vista_descripcion" placeholder="Descripcion Vista" value="<?php echo $vistas[0]->vista_descripcion ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Url</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="vista_url" name="vista_url" placeholder="Url Vista" value="<?php echo $vistas[0]->vista_url ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">                                
                                <label>
                                    <select name="vista_estado" class="form-control">
                                        <?php 
                                        if($vistas){
                                            if( $vistas[0]->vista_estado ==1 ){ 
                                                ?>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                                <?php
                                            } else{
                                                    ?>
                                                <option value="0">Inactivo</option>
                                                <option value="1">Activo</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="button" name="<?php echo base_url() ?>admin/vistas/update" data="vistas" class="btn btn-success enviar_data" value="Guardar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>     
            
            <div class="col-md-6">
                <div id="" class="panel panel-info menu_title_bar">                                    
                    <div class="panel-heading">Editar Estados por Vista : <?php //echo $vistas[0]->nombre_submenu ?> </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <td>Lista de Estados</td>
                                    </tr>
                                </thead>     
                                <tr>
                                    <td>
                                        <?php
                                        if(@$lista_estado){
                                            foreach ($lista_estado as $item) {
                                                ?>
                                                    <a href="#"
                                                    style="border:1px solid black; width:100px;color:white;font-size:16px;margin:3px;"
                                                    class="btn btn-primary estado_btn" onClick="estado_btn(<?= $item->id_orden_estado; ?>,<?= $vistas[0]->id_vista; ?>);">
                                                    <?= $item->orden_estado_nombre; ?></a>
                                                <?php                                    
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>N°</td>
                                        <td>Estados</td>
                                        <td>Orden</td>
                                        <td>Accion</td>
                                    </tr>
                                </thead>
                                <tbody id="estados_en_vistas">
                                <?php
                                $contador=1;
                                if(@$estados){
                                    $count = count($estados);
                                    foreach ($estados as $item) {
                                        ?>
                                        <tr>
                                        <td><?= $item->orden_estado_vista; ?></td>
                                        <td>
                                        <?= $item->orden_estado_nombre; ?></td>
                                        <td>
                                            
                                            <?php
                                            if($contador!=1){
                                                ?>
                                                <a href="#" name="up" onClick="upAndDown('up',<?= $item->id_estado_vista ?>,<?= $item->orden_estado_vista; ?>,<?= $item->vista_id; ?>)">
                                                <i class="fa fa-arrow-circle-up" style="font-size:30px;"></i> -
                                                </a>
                                                <?php
                                            }
                                            ?>    
                                             <?php
                                            if($contador!=$count){
                                                ?>
                                                <a href="#" name="down" onClick="upAndDown('down',<?= $item->id_estado_vista ?>,<?= $item->orden_estado_vista; ?>,<?= $item->vista_id; ?>)" >
                                                <i class="fa fa-arrow-circle-down" style="font-size:30px;"></i>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td><a href="#" class="btn btn-warning"  onClick="deleteEstado(<?= $item->id_estado_vista; ?>,<?= $item->vista_id; ?>);" name="" id="" style="border:1px solid black;"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                        <?php   
                                        $contador++;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                                                 
                </div>
            </div>
        </div>            
    </div>
</section>
