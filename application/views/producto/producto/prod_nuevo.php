<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script src="<?php echo base_url(); ?>../asstes/js/producto/producto.js"></script>


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
        width: 100%;
    }
    .alenado-left{
        float: right;
    }
    .link_btn{
        text-decoration: none;
    }
    .deletePrecio{
        background: #0f4871;
    }

    #AgregarPrecios{
        background:#82b74b;
        color:black;
    }

    
</style>
<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-success"> Producto</button> </a> 
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Nuevo</button>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    

                        <!-- INICIO MENU IZQUIERDO -->
                        <div class="col-lg-3">
                            <div id="" class="panel" style="height: 550px;margin-top: 100px;">
                                <div class="panel-heading menuTop">Nuevo Producto :  </div>
                                <div class="panel-body menuContent">
                                <div class="row">
                                <?php
                                $contador_break=0;
                            if($acciones){
                                foreach ($acciones as $key => $value) {
                                    ?>
                                    <div class="col-sm-6 menu-cuadro " id="<?php echo $value->accion_btn_css; ?>">
                                        <a href="<?php echo base_url().$value->accion_btn_url; ?>" class="link_btn">
                                        <h1 class="icon-center">
                                             <i class="<?php echo $value->accion_btn_icon; ?>"></i>
                                        </h1>
                                        </a>
                                        <span class="icon-center">
                                            <?php echo $value->accion_nombre; ?>
                                        </span>
                                        
                                    </div>
                                    <?php
                                }
                            }else{
                                ?>                                   
                                        
                                    <div style="text-align:center">
                                        <h2 >
                                            <i class="fa fa-exclamation-triangle"></i>
                                            
                                        </h2>
                                        <label>Necesita permiso para ver esta sección.</label>
                                    </div>  
                                        
                                    
                                <?php
                            }
                                ?>
                                </div></div>  

                                <div class="row">
                                    <br>
                                    <hr>
                                    <br>
                                    <div class="col-sm-12">
                                        <img src="" name="" id="" class="preview_producto" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- FIN MENU IZQUIERDO -->

                        <form class="form-horizontal" enctype="multipart/form-data" action='crear' name='producto_formulario' id="producto_formulario" method="post" >

                        <!-- INICIO PRODUCTO ENCABEZADO -->
                        <div class="col-lg-9">
                           
                            <div id="" class="panel producto_creacion" style="margin-top: 100px;">
                                <div class="panel-heading menuTop">Producto General:  </div>
                                    <div class="panel-body menuContent">  
                                    
                                        <input type="hidden" name="empresa" value="" id="id_empresa">
                                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Nombre</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="name_entidad" required name="name_entidad" placeholder="Nombre Producto" value="">
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div> 
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Empresa</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="empresa" name="empresa" required>
                                                            
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
                                                        <select class="form-control" id="giro" name="giro" required>
                                                           
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
                                                        <select class="form-control" id="categoria" name="categoria" required>
                                                          <option value="0">Seleccione</option>
                                                            <?php
                                                            foreach ($categorias as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_categoria; ?>"><?php echo $value->nombre_categoria; ?>     
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
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Sub Categoria</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="sub_categoria" name="sub_categoria" required>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Marca</label>
                                                    <div class="col-sm-8">                                                        
                                                        <select class="form-control" id="Marca" name="Marca">   
                                                            <?php
                                                            foreach ($marcas as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_marca; ?>"><?php echo $value->nombre_marca; ?>     
                                                                </option>
                                                                <?php
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
                                                        <select class="form-control" id="proveedor1" name="proveedor1" required>   
                                                            <?php
                                                            foreach ($proveedor as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_proveedor; ?>"><?php echo $value->empresa_proveedor; ?>     
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
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Proveedor2</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="proveedor2" name="proveedor2" required>   
                                                            <?php
                                                            foreach ($proveedor as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_proveedor; ?>"><?php echo $value->empresa_proveedor; ?>     
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
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Estado</label>
                                                    <div class="col-sm-8">
                                                        
                                                        <label>
                                                            <select name="producto_estado" class="form-control" required>
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
                                                     <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Linea</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="Linea" name="Linea" required>   
                                                            <?php
                                                            foreach ($lineas as $value) {
                                                                ?>
                                                                <option value="<?php echo  $value->id_linea; ?>"><?php echo $value->tipo_producto; ?>     
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
                                                     <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Relacion</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="procuto_asociado" id="procuto_asociado" class="form-control" value="">
                                                        
                                                        
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                
                                                    <div class="col-sm-offset-1 col-sm-3" style="display:flex">
                                                        Escala 
                                                        <span class="inline checkbox c-checkbox">
                                                            <label>
                                                            <input type='checkbox' id="todo-item-1" name="escala" class="">
                                                            <span class="fa fa-check"></span>
                                                             </label>
                                                        </span>

                                                        Combo
                                                        <span class=" checkbox c-checkbox">
                                                            <label>
                                                            <input type='checkbox' id="todo-item-1" name="combo" class="">
                                                            <span class="fa fa-check"></span>
                                                             </label>
                                                        </span>

                                                    </div>
                                                    
                                                
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Codigo</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="codigo_barras" value="" id="codigo_barras" class="form-control">
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Modelo</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="modelo" value="" id="modelo" class="form-control">
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-offset-0 col-sm-3 control-label no-padding-right">Costo</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="costo" value="" id="costo" class="form-control">
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Minimos</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="minimos" value="" id="minimos" class="form-control">
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Medios</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="medios" value="" id="medios" class="form-control">
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-offset-0 col-sm-3 control-label no-padding-right">Maximos</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="maximos" value="" id="maximos" class="form-control">
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Ubicación</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="almacenaje" value="" id="almacenaje" class="form-control">
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Desc. %</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="descuento_limite" value="" id="descuento_limite" class="form-control">
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-offset-0 col-sm-3 control-label no-padding-right">Pre. Venta</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="precio_venta" value="" id="precio_venta" class="form-control">
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Iva</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" name="iva" id="iva">
                                                            <option value="Gravados">Gravados</option>
                                                            <option value="Exentos">Exentos</option>
                                                            <option value="No Sujeto">No Sujeto</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Incluye</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" name="incluye_iva" id="incluye_iva">
                                                            <option value="1">Si</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-3">
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    
                                    </div>
                            </div>
                          
                        </div>
                        <!-- FIN PRODUCTO ENCABEZADO -->

                        <!-- INICIO PRODUCTO ATRIBUTOS -->
                        <div class="col-lg-9">
                           
                            <div id="" class="panel">
                                <div class="panel-heading menuTop">Producto Atributos:  </div>
                                <div class="panel-body menuContent">  
                                <div class="row">
                                    <p class="form-horizontal giro_atributos">
                                    </p>
                                </div>
                                </div>
                            </div>
                          
                        </div>
                        <!-- FIN PRODUCTO ATRIBUTOS -->

                        <!-- INICIO PRODUCTO PRECIOS -->
                        <div class="col-lg-9 alenado-left">
                           
                            <div id="" class="panel">
                                <div class="panel-heading menuTop">Producto Precios :  </div>
                                <div class="panel-body menuContent"> 
                                <div class="row">
                                    <div class="col-lg-12">

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
                                                        
                                                            <span id="AgregarPrecios" class="btn btn-info"><i class="fa fa-plus-circle"></i></span>
                                                      
                                                        </div>
                                                    </th>
                                                 </tr>
                                              </thead>
                                              <tbody class="preciosTable">
                                                                                                 
                                              </tbody>
                                           </table>
                                        </div>
                                      
                                   </div>
                                </div>
                                </div>
                            </div>
                          
                        </div>
                        <!-- FIN PRODUCTO PRECIOS -->

                        </form>

                    
                </div>
            </div>
        </div>
    </section>


<!-- Modal Large-->
   <div id="producto_asociado_modal" tabindex="-1" role="dialog" aria-labelledby="producto_asociado_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Lista de Productos</h4>
            </div>
            <div class="modal-body">
                <p class="productos_lista_datos"></p>                                 
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
   <!-- Modal Small-->
