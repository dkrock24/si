<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script>
  $(document).ready(function(){

    $("#categoria").change(function(){
          $("#sub_categoria").empty();
          var id = $(this).val();
          $.ajax({
            url: "sub_categoria_byId/"+id,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  //console.log(data);
                  $.each(JSON.parse(data), function(i, item) {                    
                    $("#sub_categoria").append('<option value='+item.id_categoria+'>'+item.nombre_categoria+'</option>');
                });
                
                },
                error:function(){
                }
            });
    });

    $("#empresa").change(function(){
          $("#giro").empty();
          var id = $(this).val();
          $.ajax({
            url: "get_giros_empresa/"+id,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  
                var datos = JSON.parse(data);
                  
                $("#id_empresa").val(datos[0].Empresa);
                $("#giro").append('<option value="0">Selecione Giro</option>');
                $.each(JSON.parse(data), function(i, item) {                    
                    $("#giro").append('<option value='+item.id_giro_empresa+'>'+item.nombre_giro+'</option>');
                });
                
                },
                error:function(){
                }
            });
    });

    // Busca el Giro para dibujar los inputs del producto
    $("#giro").change(function(){
          var id = $(this).val();
          $.ajax({
            url: "get_empresa_giro_atributos/"+id,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                
                    var datos = JSON.parse(data);
                    var plantilla = datos["plantilla"];
                    $(".giro_atributos").empty();
                    
                    //$(".giro_atributos").append('<div class="col-sm-3">' );
                    var id_producto = 0;
                    $.each(plantilla, function(i, item) {  

                        if(id_producto != item.id_prod_atributo){
                            if(item.tipo_atributo == 'text' ||  item.tipo_atributo == 'file'){                            
                                $(".giro_atributos").append( html_template_text(item) );
                            }
                            if(item.tipo_atributo == 'select'){
                                $(".giro_atributos").append(html_template_select(item.id_prod_atributo , plantilla));
                            }
                            id_producto = item.id_prod_atributo;
                        }
                        
                    });

                   // $(".giro_atributos").append( '</div>' );
                
                },
                error:function(){
                }
            });
    });

    function html_template_text(item){
        var html_template ="";
        html_template = '<div class="col-sm-3">'+
                            '<div class="form-group">'+
                            '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">'+item.nam_atributo+'</label><br>'+
                            '<div class="col-sm-offset-1 col-sm-11">'+
                                '<input type="'+item.tipo_atributo+'" name="'+item.id_prod_atributo+'"  class="form-control '+item.nam_atributo+'">'+
                            '</div>'+
                            '<span class="col-sm-1 control-label no-padding-right"></span>'+
                            '</div>'+
                            '</div>';
        return html_template;
    }
    
    function html_template_select(id , plantilla){
        
        var opciones="";
        var nombre =  "";
        
        $.each(plantilla, function(i, item) {
            
            if(id == item.id_prod_atributo){
                nombre = item.nam_atributo
                opciones += '<option>'+item.attr_valor+'</option>';    
            }            
        });

        var html_template ="";
        html_template = '<div class="col-sm-3">'+
                            '<div class="form-group">'+
                            '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">'+ nombre +'</label><br>'+
                            '<div class="col-sm-offset-1 col-sm-11">'+
                                '<select name="'+id+'" class="form-control '+nombre+'">'+opciones+'</select>'+
                            '</div>'+
                            '<span class="col-sm-1 control-label no-padding-right"></span>'+
                            '</div>'+
                            '</div>';
        return html_template;
    }

    $(document).on('change', '.Imagen', function()
    {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
              $('.preview_producto').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }



  });

</script>
<style type="text/css">
    .icon-center{
        text-align: center;
    }
    .menu-cuadro{
        width: 40%;
        border:0px solid black;
        text-align: center;
        margin-left: 7%;
    }
    .menu-cuadro:hover{        
        color:#23b7e5;
    }

    .preview_producto{

    }
    .alenado-left{
        float: right;
    }
</style>
<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Producto</button> </a> 
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Nuevo</button>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-white">

                        <div class="col-lg-3">
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Nuevo Producto :  </div>
                                
                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-basket icon-center"></h1>
                                        <a href="#"><span class="icon-center">Producto</span></a>
                                    </div>

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-book-open icon-center"></h1>
                                        <span class="icon-center">Categoria</span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-social-dropbox icon-center"></h1>
                                        <span class="icon-center">Cant. Producto</span>
                                    </div>

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-doc icon-center"></h1>
                                        <span class="icon-center">Sub Categoria</span>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">
                                            <i class="fa fa-barcode"></i>
                                        </h1>
                                        <span class="icon-center">Cod. Barra</span>
                                    </div>
                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">
                                            <i class="fa fa-plus-square"></i>
                                        </h1>
                                        <span class="icon-center">Combo</span>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">
                                            <i class="icon-note"></i>
                                        </h1>
                                        <span class="icon-center">Existencias</span>
                                    </div>

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">
                                            <i class="icon-note"></i>
                                        </h1>
                                        <span class="icon-center">Promociones</span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-social-dropbox icon-center"></h1>
                                        <span class="icon-center">Kit Producto</span>
                                    </div>
                                    <div class="col-sm-6 menu-cuadro">
                                        <h1 class="icon-center">                                            
                                            <i class="fa fa-cubes"></i>
                                        </h1>
                                        <span class="icon-center">Promo Detalle</span>
                                    </div>

                                </div>

                                <div class="row">
                                    <br>
                                    <hr>
                                    <br>
                                    <div class="col-sm-12">
                                        <?php

                                        if( $producto[0]->producto_img_blob ){
                                        ?>
                                            <img src="data: <?php echo $producto[0]->imageType ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode( $producto[0]->producto_img_blob ) ?>" clas="preview_producto" style="width:100%" />
                                            
                                        <?php
                                        }
   
                                        ?>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>

                        <form class="form-horizontal" action='crear' method="post">
                        
                        <div class="col-lg-9">
                           
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Nuevo Producto :  </div>
                                    <p>
                                    
                                        <input type="hidden" name="empresa" value="" id="id_empresa">
                                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Nombre</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" value="<?php echo $producto[0]->name_entidad; ?>" class="form-control" id="name_entidad" name="name_entidad" placeholder="Nombre Producto">
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div> 
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Empresa</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="empresa" name="empresa">
                                                        <option value="<?php echo $producto[0]->id_empresa ?>"><?php echo $producto[0]->nombre_razon_social ?></option>
                                                        <?php
                                                        foreach ($empresa as $value) {
                                                            ?>
                                                            <option value="<?php echo  $value->id_empresa; ?>"><?php echo $value->nombre_razon_social; ?>     
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>  
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Giro</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="giro" name="giro">
                                                       <option><?php echo $producto[0]->nombre_giro ?></option>
                                                    </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>  
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Categoria</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="categoria" name="categoria">
                                                        <option value="<?php echo $producto[0]->id_categoria; ?>"><?php echo $producto[0]->nombre_categoria; ?></option>
                                                        <?php
                                                        foreach ($categorias as $value) {
                                                            if( $producto[0]->id_categoria != $value->id_categoria ){
                                                            ?>
                                                            <option value="<?php echo $value->id_categoria; ?>"><?php echo $value->nombre_categoria; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Sub Categoria</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="sub_categoria" name="sub_categoria">
                                                            <option value="<?php echo $producto[0]->id_sub_categoria; ?>"><?php echo $producto[0]->SubCategoria; ?></option>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Marca</label>
                                                    <div class="col-sm-8">                                                        
                                                        <select class="form-control" id="marca" name="marca">   
                                                            <option value="<?php echo $producto[0]->Marca; ?>"><?php echo $producto[0]->nombre_marca; ?></option>
                                                            <?php
                                                            foreach ($marcas as $value) {
                                                                if( $producto[0]->Marca != $value->id_marca ){
                                                                ?>
                                                                <option value="<?php echo  $value->id_marca; ?>"><?php echo $value->nombre_marca; ?>     
                                                                </option>
                                                                <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Proveedor1</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="proveedor1" name="proveedor1">  
                                                            <option value="<?php echo $producto_proveedor[0]->id_proveedor; ?>"><?php echo $producto_proveedor[0]->empresa; ?></option> 
                                                            <?php
                                                            foreach ($proveedor as $value) {
                                                                if( $producto_proveedor[0]->id_proveedor != $value->id_proveedor ){
                                                                ?>
                                                                <option value="<?php echo  $value->id_proveedor; ?>"><?php echo $value->empresa; ?>     
                                                                </option>
                                                                <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Proveedor2</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="proveedor2" name="proveedor2">   
                                                                                                                        <option value="<?php echo $producto_proveedor[0]->id_proveedor; ?>"><?php echo $producto_proveedor[0]->empresa; ?></option> 
                                                            <?php
                                                            foreach ($proveedor as $value) {
                                                                if( $producto_proveedor[0]->id_proveedor != $value->id_proveedor ){
                                                                ?>
                                                                <option value="<?php echo  $value->id_proveedor; ?>"><?php echo $value->empresa; ?>     
                                                                </option>
                                                                <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Estado</label>
                                                    <div class="col-sm-8">
                                                        
                                                        <label>
                                                            <select name="producto_estado" class="form-control">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </label>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Relacion</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="procuto_asociado" id="procuto_asociado" class="form-control">
                                                        
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-7 col-sm-3">
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                    
                                    </p>
                            </div>
                          
                        </div>

                        <div class="col-lg-9">
                           
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Atributos Producto :  </div>
                                <div class="row">
                                    <p class="form-horizontal giro_atributos">
                                        <?php
                                        if(isset($atributos)){
                                            foreach ($atributos as $value) 
                                            {
                                        ?>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right"><?php echo $value->nam_atributo;  ?></label><br>
                                                <div class="col-sm-offset-1 col-sm-11">
                                                    <input type="<?php echo $value->tipo_atributo; ?>" name=""  class="form-control" value="<?php echo $value->valor; ?>">
                                                </div>
                                                <span class="col-sm-1 control-label no-padding-right"></span>
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                          
                        </div>

                        <div class="col-lg-9 alenado-left">
                           
                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Precios :  </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                      <div class="panel panel-default">
                                         
                                         <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="preciosTable">
                                                  <thead>
                                                     <tr>
                                                        <th>#</th>
                                                        <th>Presentacion</th>
                                                        <th>Factor</th>
                                                        <th>Unidad</th>
                                                        <th>Precio</th>                                                        
                                                        <th>Code Barra</th>
                                                        <th>Cliente</th>
                                                        <th>Sucursal</th>
                                                        <th>Utilidad</th>
                                                        <th>
                                                            <div class="btn-group">
                                                            
                                                                <a href="#" id="AgregarPrecios" class="btn btn-default">Agregar</a>
                                                          
                                                            </div>  
                                                        </th>
                                                     </tr>
                                                  </thead>
                                                  <tbody class="preciosTable">
                                                    <?php
                                                    $cont_table =1;
                                                    ?>
                                                       <tr>
                                                           <td><?php echo $cont_table; ?></td>
                                                           <td><input type="text" size='10' name="presentacion<?php echo $cont_table ?>" value="<?php echo $precios[0]->presentacion; ?>"></td>
                                                           <td><input type="text" size='3' name="factor<?php echo $cont_table ?>" value="<?php echo $precios[0]->factor; ?>"></td>
                                                           <td><input type="text" size='3' name="unidad<?php echo $cont_table ?>" value="<?php echo $precios[0]->unidad; ?>"></td>
                                                           <td><input type="text" size='4' name="precio<?php echo $cont_table ?>" value="<?php echo $precios[0]->precio; ?>"></td>
                                                           <td><input type="text" size='5' name="cbarra<?php echo $cont_table ?>" value="<?php echo $precios[0]->cod_barra; ?>"></td>
                                                           <td>
                                                               <select name="cliente<?php echo $cont_table ?>">
                                                                   <?php
                                                                   foreach ($clientes as $key => $value) {
                                                                        if($value->id_cliente == $precios[0]->Cliente)
                                                                        {
                                                                            ?>
                                                                           <option value="<?php echo $value->id_cliente; ?>"><?php echo $value->nombre_empresa_o_compania; ?></option>
                                                                           <?php
                                                                        }else{
                                                                            ?>
                                                                           <option value="<?php echo $value->id_cliente; ?>"><?php echo $value->nombre_empresa_o_compania; ?></option>
                                                                           <?php
                                                                        }
                                                                   }
                                                                   ?>
                                                               </select>
                                                           </td>
                                                           <td>
                                                               <select name="sucursal<?php echo $cont_table ?>">
                                                                   <?php
                                                                   foreach ($sucursal as $key => $value) {
                                                                        if($sucursal->id_sucursal == $precios[0]->Sucursal)
                                                                        {
                                                                            ?>
                                                                           <option value="<?php echo $value->id_sucursal; ?>"><?php echo $value->nombre_sucursal; ?></option>
                                                                           <?php
                                                                        }else{
                                                                            ?>
                                                                           <option value="<?php echo $value->id_sucursal; ?>"><?php echo $value->nombre_sucursal; ?></option>
                                                                           <?php
                                                                        }
                                                                   }
                                                                   ?>
                                                               </select>
                                                           </td>
                                                           
                                                            <td><input type="text" size='4' name="utilidad<?php echo $cont_table ?>" value="<?php echo $precios[0]->Utilidad; ?>"></td>
                                                            <td>
                                                                <div class='btn-group mb-sm'>
                                                                    <a href='#' class='btn btn-danger btn-sm deletePrecio' name='<?php echo $cont_table ?>'><i class='fa fa-trash'></i></a>
                                                                </div>
                                                            </td>
                                                           
                                                       </tr>      
                                                    <?php
                                                        $cont_table +=1;
                                                    ?>                                        
                                                  </tbody>
                                               </table>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                            </div>
                          
                        </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Modal Large-->
   <div id="ModalEmpresa2" tabindex="-1" role="dialog" aria-labelledby="ModalEmpresa2" aria-hidden="true" class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Giros Empresa</h4>
            </div>
            <div class="modal-body">
                
                    <!-- START panel-->
            <div class="panel panel-default">
               <div class="panel-heading" id="giro_nombre2"></div>
               <!-- START table-responsive-->
               <div class="table-responsive">
                    <div class="row">
                        <div class="col-lg-6">
                          <!-- START panel-->
                          <form action="guardar_giro_empresa" method="post" id="guardar_giro_empresa">
                            <select name="empresa" class="lista_empresa input-sm form-control">
                                      
                            </select>
                            
                          <div id="panelDemo7" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-lg-3"> Giros </div>
                                    <div class="col-lg-6">
                                        <div class="pull-right label label-danger atributos_total"></div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="button" value="Guardar" id="guardar_giro_empresa" name="" class="input-sm form-control">
                                    </div>
                                </div>
                            </div>

                             <div class="panel-body">
                                <p>
                                    <table id="table-ext-1" class="table table-bordered table-hover">
                                     <thead>
                                        <tr>
                                           <th>ID</th>
                                           <th>Giro</th>
                                           <th>Tipo</th>                           
                                           <th>Codigo</th>
                                           <th>Estado</th>
                                           <th data-check-all>
                                              <div data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox">
                                                 <label>
                                                    <input type="checkbox">
                                                    <span class="fa fa-check"></span>
                                                 </label>
                                              </div>
                                           </th>
                                        </tr>
                                     </thead>
                                     
                                     <tbody class="girosLista">
                                                             
                                     </tbody>
                                      
                                    </table>
                                </p>
                             </div>
                             <div class="panel-footer"></div>
                          </div>
                          <!-- END panel-->
                          </form>
                       </div>

                       <div class="col-lg-6">
                        <form action="giro_empresa" method="post" id="giro_empresa">
                          <select name="empresa" id="empresa_giros" class="lista_empresa input-sm form-control">
                                      
                          </select>

                            <div id="panelDemo9" class="panel panel-success">
                              <input type="hidden" class="giro_id" name="giro" value="">
                                 <div class="panel-heading">
                                  <div class="row">
                                    <div class="col-lg-4"> Empresa Giros </div>
                                    <div class="col-lg-4">
                                        <div class="pull-right label label-danger empresa_giro_total"></div>
                                    </div>
                                    <div class="col-lg-4">                                        
                                        <input type="button" value="Eliminar" id="eliminar_giro_empresa" name="" class="input-sm form-control">
                                    </div>
                                </div>
                                 </div>
                                 <div class="panel-body">
                                    <p>
                                        <table id="table-ext-1" class="table table-bordered table-hover">
                                         <thead>
                                            <tr>
                                               <th>Giro</th>
                                               <th>Atributo</th>                           
                                               <th>Label</th>
                                               <th>Estado</th>
                                               <th data-check-all>
                                              <div data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox">
                                                 <label>
                                                    <input type="checkbox">
                                                    <span class="fa fa-check"></span>
                                                 </label>
                                              </div>
                                           </th>
                                            </tr>
                                         </thead>
                                         <tbody class="girosEmpresa">
                                                                 
                                         </tbody>
                                        </table>
                                    </p>
                                 </div>
                                 
                            </div>
                          </form>
                       </div>   

                    </div>
               </div>
               <!-- END table-responsive-->
               <div class="panel-footer">
               </div>
            </div>
            <!-- END panel-->
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
   <!-- Modal Small-->

