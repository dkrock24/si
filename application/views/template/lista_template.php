
<script type="text/javascript">

    $("#opciones").appendTo('body');

    var headers = <?php echo json_encode($fields['field']); ?>;
    var records = <?php echo json_encode($registros); ?>;
    var documento_titulo = <?php echo json_encode($fields['titulo']); ?>;
    var img = [
        empresa = "<?php echo $_SESSION['empresa'][0]->nombre_comercial ?>",
    ];

    function askForRemoveItem(url,id)
    {
        //$(".remove").click(function(){
            var url = url;
            var id = id;
            //alert("Desea Eliminar el registro "+id);
            
            var type = "warning";
            var title = "Desea Eliminar Registro";
            var mensaje = "";
            var boton = "info";
            var finalMessage = "Gracias..."
            return showNotification(type, mensaje, title, boton, finalMessage, url);

        //});
    }



    $(document).ready(function() {
        $(".filtro-input").each(function() {
            //console.log($(this).val());
            if($(this).val() != ""){
                $(this).focus();
                $(this).select();
            }
        });
    });

    function showNotification( type , mensaje , title , boton , finalMessage, url) {
        var confirm = false;
        $('.cancel').focus();
        $('.cancel').css("background","red");
        swal({
            html: true,
            title: title,
            text: mensaje,
            type: type,
            showCancelButton: true,
            confirmButtonText: "Eliminar",
            //cancelButtonText: "Cancelar!",
            //closeOnConfirm: false,
            //closeOnCancel: false,
            //showLoaderOnConfirm: true,
        }, function (isConfirm) {

            if (isConfirm) {
                swal("Eliminado", finalMessage);
                confirm = true;
                //redirec("index");
                if(url != null){
                    
                    //window.location.href = url;
                    var url_accion = url;
                    url_pagina     = getCookie("url");
                    var folder     = url_pagina.split('/')[0];
                    var controller = url_pagina.split('/')[1];
                    var action     = url_pagina.split('/')[2];

                    if (action == 'index') {
                        url_accion = folder+"/"+controller+"/"+url_accion;
                    }

                    $.ajax({
                        type: "post",
                        url: "<?php echo base_url(); ?>"+url_accion,
                        success: function(result) {
                            $(".loadViews").html(result);
                        }
                    });
                }
            } else {
                swal("Salir", "Debes Hacer Login de Nuevo", "error");
            } 
        });
        return confirm;
    }

        
    $(document).on("change", "#total_pagina", function() {
        $.ajax({
            type: "post",
            url: "",
            success: function() {
                //location.reload();
                $('#pagina_x').submit();
            }
        });
    });    

    /*$(document).on('change', '.estado_filtro', function(e) {

        //if (e.which == 13) {
            $('form#filtros').submit();
            return false;
        //}
    });*/

</script>

<style>
    .sa-error-container{
        display:none;
    }
    .lista_item{
        cursor:pointer;
    }
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/css/css_general.css" />

<!-- Main section-->

    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style=""><i class="icon-arrow-right"></i> <?php echo $fields['titulo']; ?></h3>
        <div class="panel menu_title_bar">
        <?php $this->load->view('notificaciones/success'); ?>
            <!-- START table-responsive-->
            <div class="dataList" id="dataList" style="height:80vh;">
                <?php
                //var_dump( $_SESSION['empresa'][0]->nombre_comercial);
                ?>
                <table id="datatable1" class="table table-striped table-hover" width="100%">
                    <thead class="linea_superior">
                        <tr class="">
                            <th width="5%">

                                <form method="post" id="pagina_x" name="data">
                                    <select class="form-control" id="total_pagina" name="total_pagina">
                                        <option class="0">-</option>
                                        <option class="10">10</option>
                                        <option class="15">15</option>
                                        <option class="20">20</option>
                                        <option class="50">50</option>
                                        <option class="100">100</option>
                                    </select>
                                </form>
                                
                            </th>
                            <form id="filtros">
                                <?php
                                foreach ($column as $key => $combo) {
                                    //$active_filtro = array_keys($fields['field'][$key])[0];
                                    $valor_filtro = "";
                                    if(isset($filtros[key($fields['field'][$key])])){
                                        $valor_filtro = $filtros[key($fields['field'][$key])];
                                    }

                                    ?>
                                    <th style="color: black;">
                                    <?php
                                    if (isset($filtros)) {
                                        if ($combo == 'Creado' || $fields['field'][$key][key($fields['field'][$key])] == 'Creado') {
                                            ?>
                                            <input type="date" name="<?php echo key($fields['field'][$key]); ?>" autocomplete="off" value="<?php echo $valor_filtro ?>" class="form-control filtro-input" /><br>
                                            <?php
                                        } else if ($combo == 'Estado' && (isset($fields['filtro_estado']) || isset($fields['filtro_reserva_estado']) ) ) {
                                            if (isset($fields['filtro_estado'])) {
                                            ?>
                                            <select name="<?php echo key($fields['field'][$key]); ?>" class="estado_filtro form-control filtro-input">
                                                <option value=""></option>
                                                <?php foreach($fields['filtro_estado'] as $estados) : ?>
                                                <option value="<?php echo $estados->orden_estado_nombre ?>"><?php echo $estados->orden_estado_nombre ?></option>
                                                <?php endforeach ?>
                                            </select><br>
                                            <?php
                                            } else {
                                                ?>
                                                <select name="<?php echo key($fields['field'][$key]); ?>" class="estado_filtro form-control filtro-input">
                                                <option value=""></option>
                                                <?php foreach($fields['filtro_reserva_estado'] as $estados) : ?>
                                                <option value="<?php echo $estados->nombre_reserva_estados ?>"><?php echo $estados->nombre_reserva_estados ?></option>
                                                <?php endforeach ?>
                                                </select><br>
                                                <?php
                                            }
                                        } else if($combo == "Vendedor" && isset($fields['orden_vendedor'])) {
                                            ?>
                                            <select name="<?php echo key($fields['field'][$key]); ?>" class="estado_filtro form-control filtro-input">
                                                <option value=""></option>
                                                <?php foreach($fields['orden_vendedor'] as $vendedor) : ?>
                                                    <option value="<?php echo $vendedor->nombre_usuario ?>"><?php echo $vendedor->nombre_usuario ?></option>
                                                <?php endforeach ?>
                                            </select><br>
                                            <?php
                                        } else {
                                            
                                        ?>
                                        <input type="text" name="<?php echo key($fields['field'][$key]); ?>" autocomplete="off" value="<?php echo $valor_filtro ?>" class="form-control filtro-input" /><br>
                                        <?php
                                        }
                                    }
                                    ?>                                
                                        <?php echo strtoupper($combo); ?>
                                    </th>
                                <?php
                                }
                                ?>                            
                            </form>

                            <th class="alignRigth">
                                <div class="btn-group dropleft" role="group">
                                    <button type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcion</button>
                                    
                                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                        <?php
                                        if ($acciones) {
                                            foreach ($acciones as $key => $value) {
                                                $url = base_url();
                                                $num = is_numeric(substr($_SERVER['PATH_INFO'], -1, 1));

                                                if ($num) {
                                                    $url = $url . '\..' . $_SERVER['PATH_INFO'] . '\../../' . $value->accion_btn_url;
                                                } else {
                                                    $url = $value->accion_btn_url;
                                                }

                                                if($value->accion_btn_codigo){
                                                    $url = "#";
                                                    
                                                }

                                                if ($value->accion_valor == 'btn_superior') {
                                                    ?>
                                                    <li>
                                                        <a name="<?php echo $url;  ?>" onclick="<?php echo $value->accion_btn_nombre;  ?>"  class="accion_superior">
                                                            <span class="btn btn-info">
                                                                <i class='<?php echo $value->accion_btn_icon; ?>'></i>
                                                            </span>
                                                            <?php echo $value->accion_nombre;  ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <li class="divider"></li>
                                        
                                        <li>
                                            <a href="#" class="listar_giros" id="<?php ?>" data-toggle="modal" data-target="#ModalEmpresa">
                                                <span class="btn btn-warning">
                                                    <i class="fa fa-building-o"></i>
                                                </span> Empresa
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="datosLista" class="menuContent">
                        <?php
                        $contador = $contador_tabla;
                        if ($registros) {
                            foreach ($registros as $table) {
                                $id =  $fields['id'][0];
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $contador; ?></th>
                                        <?php
                                        foreach ($fields['field'] as $key => $field) {

                                            if ($field != 'estado') {
                                        ?>
                                        <td>
                                        <?php
                                        $c = key($field);
                                            $a = substr($table->$c, 0, 1);
                                            
                                            if(isset($fields['reglas'][$c]['aplicar'])){
                                                echo $fields['reglas'][$c]['valor'];
                                            }

                                            if(isset($fields['reglas'][$c]['condicion'])){
                                                
                                                if($fields['reglas'][$c]['condicion'] == 1){
                                                    
                                                    if($table->$c == 'Devolucion'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-danger'>".$table->$estado."</span></h4>";
                                                    }
                                                    else if($table->$c == 'En proceso'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-success'>".$table->$estado."</span></h4>";
                                                    }
                                                    else if($table->$c == 'Facturada'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-success'>".$table->$estado."</span></h4>";
                                                    }
                                                    else if($table->$c == 'Anulada'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-warning'>".$table->$estado."</span></h4>";
                                                    }
                                                    else if($table->$c == 'Procesada'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-info'>".$table->$estado."</span></h4>";
                                                    }
                                                    else if($table->$c == 'Creado'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-success'>".$table->$estado."</span></h4>";
                                                    }
                                                    else if($table->$c == 'Enviado'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-danger'>".$table->$estado."</span></h4>";
                                                    }else if($table->$c == 'Inactivo'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-warning'>".$table->$estado."</span></h4>";
                                                    }else if($table->$c == 'Ocupado'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-warning'>".$table->$estado."</span></h4>";
                                                    }else {
                                                        $estado = $fields['estado'][0];
                                                        echo "<h4><span class='label label-info'>".$table->$estado."</span></h4>";
                                                    }
                                                }
                                            }

                                            if(!isset($fields['reglas'][$c]['condicion'])){
                                                echo $table->$c;
                                            }
                                            
                                        ?>
                                    </td>
                                <?php
                            }
                            if ($field == 'estado') {
                                $estado = $fields['estado'][0];
                                ?>
                                    <td>
                                        <?php
                                        if ($table->$estado == 1) {
                                        ?>
                                        <span class="label label-success" style="background: #39b2d6">Activo</span>
                                        <?php
                                        } else if($table->$estado == 0) {
                                        ?>
                                        <span class="label label-warning" style="background: #d26464">Inactivo</span>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                        <span class="label label-warning" style="background: #5ad246">Completado</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                            <?php
                                }
                            }
                            ?>

                            <td class="alignRigth">
                                <div class="btn-group dropright mb-sm">
                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-xs" style="background: #dde6e9">Opcion
                                        <span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                        <?php

                                                if ($acciones) {

                                                    foreach ($acciones as $key => $value) {

                                                        $url = base_url();
                                                        $num = is_numeric(substr($_SERVER['PATH_INFO'], -1, 1));

                                                        if ($num) {
                                                            //$url = $url . '\..' . $_SERVER['PATH_INFO'] . '\../../' . $value->accion_btn_url;
                                                        } else {
                                                            $url = $value->accion_btn_url;
                                                        }
                                                        $vista = $value->Vista;
                                                        if ($value->accion_valor == 'btn_medio' && $value->accion_nombre != 'Eliminar') {
                                                        ?>

                                                        <li class="lista_item">
                                                            <a name="<?php echo  $value->accion_btn_url;  ?>/<?php echo $table->$id; ?>" class="accion_superior">
                                                                <span class="btn btn-success">
                                                                    <i class="<?php echo $value->accion_btn_icon; ?>"></i>
                                                                </span>
                                                                <?php echo $value->accion_nombre;  ?>
                                                                
                                                            </a>
                                                        </li>

                                                        <?php
                                                        }
                                                        if ($value->accion_valor == 'btn_medio' && $value->accion_nombre == 'Eliminar') {
                                                        ?>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a name="<?php echo $value->accion_btn_url;  ?>/<?php echo $table->$id; ?>" data="eliminar" class="remove accion_superior" id="<?php echo $contador; ?>">
                                                                <span class="btn btn-danger">
                                                                    <i class="<?php echo $value->accion_btn_icon; ?>"></i>
                                                                </span>
                                                                <?php echo $value->accion_nombre;  ?>
                                                            </a>
                                                        </li>
                                                    <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                        <li class="divider"></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php
                            $contador += 1;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="text-right  panel-footer bg-gray-light">
                <ul class="nav nav-pills" style="display:inline-block; color:black; float:left;">
                    <li class="nav-item">
                        <a class="nav-link active" style="color:black; padding: 0px 0px;">
                        <span class="badge badge-success" style="background:#2b957a;font-size: 16px;">  <?php echo $x_total //$total_pagina; ?></span>
                           / 
                        <span class="badge badge-success" style="background:#2b957a;font-size: 16px;">  <?php echo $total_records //$total_pagina; ?></span></a>
                    </li>
                </ul><?php // $x_total; ?>
                <ul class="pagination pagination-md">
                    <?php foreach ($links as $link) {
                        echo "<li class='page-item '>" . $link . "</li>";
                    } ?>
                </ul>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="opciones" role="dialog">
  	<div class="modal-dialog">

  		<!-- Modal content-->
  		<div class="modal-content">
  			<div class="modal-header">

  				<h3 style="color:black;"><span class="fa fa-print"></span> Lista de Campos</h3>
  			</div>
  			<div class="modal-body">
  				<form role="form" id="pdfParametros" name="pdfParametros">

  					<?php
						if (isset($fields['field'])) {
							foreach ($fields['field'] as $key => $item) {
								foreach ($item as $key => $item2) {
						?>

  								<input type="checkbox" checked="checked" name="<?php echo $key ?>" value="<?php echo $item2 ?>" />
  								<label><?php echo $item2 ?></label>
  								<br />
  					<?php
								}
							}
						}
						?>
  				</form>
  			</div>
  			<div class="modal-footer">
  				<button onclick="b()" id="pdfParametros" class="btn btn-info">Guardar</button>
  			</div>
  		</div>
  	</div>
  </div>