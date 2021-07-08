<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a name="admin/nodos/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Nodos</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
            
        </h3>

        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">    
                                                
                    <div class="panel-heading menuTop"><i class="fa fa-bars" style="font-size: 20px;"></i> Crear Nodo <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                    <div class="panel-body menuContent">        
                        <p> 
                        <form class="form-horizontal" name="nodo" id='nodo' method="post">
                        <input type="hidden" name="id_nodo" value="<?php echo $nodo->id_nodo; ?>" />
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Otro -->
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nodo_nombre" name="nodo_nombre" placeholder="Nombre" value="<?php echo $nodo->nodo_nombre; ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Sucursal</label>
                                        <div class="col-sm-10">
                                            <select name="Sucursal" class="form-control">
                                                <?php foreach($sucursal as $suc ) : ?>
                                                <option value="<?php echo $suc->id_sucursal ?>"><?php echo $suc->nombre_sucursal ?></option>
                                                <?php endforeach ?>
                                            </select>                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Ubicación</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nodo_ubicacion" name="nodo_ubicacion" placeholder="Ubicación" value="<?php echo $nodo->nodo_ubicacion; ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Key</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" readonly id="nodo_key" name="nodo_key" placeholder="Key" value="<?php echo $nodo->nodo_key; ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Tiempo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nodo_tiempo" name="nodo_tiempo" placeholder="Key" value="<?php echo $nodo->nodo_tiempo; ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Estilo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nodo_estilo" name="nodo_estilo" placeholder="Estilo" value="<?php echo $nodo->nodo_estilo; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            
                                            <label>
                                            <select name="nodo_estado" class="form-control">
                                                <?php
                                                if($nodo->nodo_estado == 1){
                                                    ?>
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="0">Inactivo</option>
                                                    <option value="1">Activo</option>                                                           
                                                    <?php
                                                }
                                                ?>                                                
                                            </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                        <input type="button" name="<?php echo base_url() ?>admin/nodos/update" data="nodo" class="btn btn-success enviar_data" value="Guardar">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    Categorias

                                    <table class="table">
                                    <?php
                                    foreach ($categorias as $key => $categoria) {
                                        ?>
                                        <tr>
                                            <?php
                                            $check = '';
                                            if(in_array($categoria->id_categoria, $nodo_categoria)){
                                                $check = 'checked';
                                            }
                                            ?>
                                            <td><input type="checkbox" <?php echo $check; ?> name="categoria" onClick="asociarCategoria(<?php echo $nodo->id_nodo; ?>,<?php echo $categoria->id_categoria; ?>)" /></td>
                                            <td><?php echo $categoria->nombre_categoria; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </table>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nodo_nombre" name="nodo_nombre" placeholder="Nombre" value="<?php echo $nodo->nodo_nombre; ?>">
                                            
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

<script>

function asociarCategoria(nodo, categoria)
{
    data = {
        'nodo' : nodo,
        'categoria' : categoria
    };
    sendNodoCategoria(data);
}

function sendNodoCategoria(data)
{
    $.ajax({ 
        type: "GET", 
        dataType: "json", 
        data: data,
        url: "<?php echo base_url(); ?>"+'admin/nodos/asociarNodoCategoria',
        success: function(data){
            
        },
        error: function(err) {
            // do whatever you want when error occurs
        },
    });
}

$(document).ready(function(){

});
</script>
