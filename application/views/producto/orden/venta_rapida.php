<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script type="text/javascript">
    var _orden = [];
    var _productos = {};
    var _productos_precio = [];
    var _productos_lista;
    var contador_productos = 0;
    var contador_tabla =1;
    var total_msg = 0.00;
    var factor_precio = 0;
    var factor_total = 0;
    var producto_cantidad_linea = 1;
    var sucursal = 0;
    var interno_sucursal=0;
    var interno_bodega= 0;
    var producto_escala;
    var clientes_lista;
    var combo_total = 0.00;
    var combo_descuento = 0.00;
    var _conf = [];
    var _impuestos = [];
</script>
<script src="<?php echo base_url(); ?>../asstes/general.js"></script>

<?php 
        
    include ("asstes/pos_funciones.php");
?>

<?php $this->load->view('styles_files.php'); ?>
<title><?php echo $title; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/pos.css" />

<script type="text/javascript">

    jQuery(document).ready(function(){

        var currCell = $('tr').first();
        var editing = false;

        $(document).on("click","tr",function(){
           $('tr').css('background','none');
           $('tr').css('color','black');

           $(this).css('background','#0f4871');
           $(this).css('color','#fff');
        
            currCell = $(this);
            currCell.focus();
            var producto_imagen_id = $(this).attr('id');
            imagen(producto_imagen_id);
        });

        function imagen(producto_imagen_id){
            getImagen(producto_imagen_id);
        }

        document.onkeydown = function(e) {
            var c = "";
            if (e.keyCode == 39) {
                // Right Arrow
                c = currCell.next();
            } else if (e.keyCode == 37) { 
                // Left Arrow
                c = currCell.prev();
            } else if (e.keyCode == 38) { 
                // Up Arrow
                c = currCell.closest('tr').prev().find('td:eq(' + 
                  currCell.index() + ')');

                $('tr').css('background','none');
                $('tr').css('color','black');

                if($(currCell.closest('tr')).attr('id')){
                    imagen($(currCell.closest('tr').prev()).attr('id'));
                }
                

            } else if (e.keyCode == 40) { 
                // Down Arrow
                c = currCell.closest('tr').next().find('td:eq(' + 
                  currCell.index() + ')');

                $('tr').css('background','none');
                $('tr').css('color','black');

                if($(currCell.closest('tr')).attr('id')){
                    imagen($(currCell.closest('tr').next()).attr('id'));
                }

            } else if (!editing && (e.keyCode == 13 || e.keyCode == 32)) { 
                // Enter or Spacebar - edit cell
                //e.preventDefault();
                //edit();
            } else if (!editing && (e.keyCode == 9 && !e.shiftKey)) { 
                // Tab
                e.preventDefault();
                c = currCell.next();
            } else if (!editing && (e.keyCode == 9 && e.shiftKey)) { 
                // Shift + Tab
                e.preventDefault();
                c = currCell.prev();
            } 
            
            // If we didn't hit a boundary, update the current cell
            if (c.length > 0) {
                currCell.parent().css('background','none');
                currCell.parent().css('color','#131e26');

                //$('tr').css('color','#131e26');
                currCell = c;
                console.log(currCell.parent().index());
                var x = currCell.parent().index();
                currCell.focus();
                
                currCell.parent().css('background','#0f4871');
                currCell.parent().css('color','#fff');
            }
        }

        $('#edit').keydown(function (e) {
            if (editing && e.which == 27) { 
                 editing = false;
                $('#edit').hide();
                currCell.toggleClass("editing");
                currCell.focus();
            }
        });

    });
</script>

<!-- Main section-->


<section>

    <div class="row">
        <div class="col-lg-9 col-md-9">
           
            <div class="row">
                <div class="col-lg-12 col-md-12">
                  <!-- Team Panel-->
                    <div class="panel panel-default" style="height: 70px; width: 100%; background: white;text-align: center;color: white;font-size: 30px;">
                        <div class="panel-heading" style="background: #2D3B48; color: white;">
                            <div class="row">

                                <div class="col-lg-4">
                               
                                    <div class="input-group m-b">
                                        <span class="input-group-addon btn-pre"><i class="fa fa-search"></i></span>
                                        <input type="text" placeholder="Buscar Producto" autocomplete="off" name="producto_buscar" class="form-control producto_buscar">
                                    </div>

                                    <select multiple="" class="form-control dataSelect" id="dataSelect">

                                    </select>

                                    <select multiple="" class="form-control dataSelect2" id="dataSelect2" style="display: inline-block;">

                                    </select>
                                </div>

                                <div class="col-lg-8">
                                    <button type="button" class="btn btn-pre" name="" id="grabar" value=""><span class='btn-label'><i class='icon-plus'></i></span>[ . ]</button>

                                    <button type="button" class="btn btn-pre guardar" name="1" id="../venta/guardar_venta" value=""><span class='btn-label'><i class='fa fa-save'></i></span></button>

                                    <a href="#" class="btn btn-pre" id="btn_existencias" data-toggle='modal' data-target='#existencias'><i class="icon-menu"></i> Existencias</a>                            
                                    
                                    <div class="btn-group">
                                       <button type="button" class="btn btn-pre">Opcion</button>
                                       <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-pre">
                                          <span class="caret"></span> 
                                          <span class="sr-only">default</span>
                                       </button>
                                       <ul role="menu" class="dropdown-menu">
                                         <li><a href="#" class="btn btn-warning" id="btn_impuestos" data-toggle='modal'><i class="fa fa-money"></i> Impuestos</a></li>

                                            <li><a href="#" class="btn btn-warning" id="btn_en_proceso" data-toggle='modal' data-target='#en_proceso'><i class="fa fa-key"></i> En Espera</a></li>
                                          
                                          <li class="divider"></li>
                                          <li>
                                            <li><a href="#" class="btn btn-warning" id="btn_en_reserva" data-toggle='modal' data-target='#en_reserva'><i class="icon-cursor"></i> En Reserva</a>
                                          </li>
                                       </ul>
                                    </div>

                                    <div class="pull-right">
                                        <div class="" style="font-size: 20px;">  <?php echo Date("Y-m-d"); ?>  </div>
                                        <?php //echo gethostbyaddr($_SERVER['REMOTE_ADDR'])  ; ?>
                                    </div>
                                </div>  
                            </div>                            
                        </div>
                     
                    <!-- START table-responsive-->
                        <div class="table-responsive" style="width: 100%;">
                           <table class="table table-sm table-hover" >
                            
                            
                            
                              <thead class="bg-info-dark" style="background: #cfdbe2;">
                                 <tr>
                                    <th style="color: black;">#</th>
                                    <th style="color: black;">Producto</th>
                                    <th style="color: black;">Descripción</th>
                                    <th style="color: black;">Cantidad</th>
                                    <th style="color: black;">Presentación</th>
                                    <th style="color: black;">Factor</th>
                                    <th style="color: black;">Unidad</th>
                                    <th style="color: black;">Descuento</th>
                                    <th style="color: black;">Total</th>
                                    <th style="color: black;">Bodega</th>
                                    <th style="color: black;"><!--<input type="button" class="form-control border-input btn btn-default guardar" name="1" id="" value="Guardar"/>--></th>
                                 </tr>
                              </thead>
                              <tbody class="uno bg-gray-light" style="border-bottom: 0px solid grey">
                                <tr style="border-bottom: 1px dashed grey">
                                    <td colspan="2">
                                        <input type="text" name="producto_buscar" class="form-control border-input" id="producto_buscar" readonly="1" style="width: 100px;">
                                    </td>
                                    <td><input type="text" class="form-control border-input" id="descripcion" name="descripcion" readonly="1"></td>
                                    <td><input type="number" class="form-control border-input" id="cantidad" name="cantidad" size="1px" value="1" min="1" max="1000" style="width: 80px;"></td>
                                    <td><input type="text" class="form-control border-input" id="presentacion" name="presentacion" size="3px" readonly="1"></td>
                                    <td><input type="text" class="form-control border-input" id="factor" name="factor" size="2px" readonly="1" style="width: 50px;"></td>
                                    <td><input type="text" class="form-control border-input" id="precioUnidad" name="precioUnidad" size="2px" readonly="1" style="width: 70px;"></td>
                                    <td><input type="text" class="form-control border-input" id="descuento" name="descuento" size="2px" style="width: 80px;"></td>
                                    <td><input type="text" class="form-control border-input" id="total" name="total" size="2px" readonly="1"></td>
                                    <td><input type="text" class="form-control border-input" id="bodega" name="bodega" size="5px" readonly="1"></td>
                                    <td><button type="button" id="btn_delete" class="btn btn-labeled btn-pre" name="1"><span class='btn-label'><i class='fa fa-trash'></i></span></button></td>
                                    
                                 </tr>
                              </tbody>
                              <tbody class="producto_agregados" style="border-top:  0px solid black; background: white;" >

                              </tbody>
                            
                           </table>
                           <div class="col-lg-12 col-md-12 paper_cut">
                            </div>
                        </div>
                    <!-- END table-responsive-->
                     
                  </div>
                  <!-- end Team Panel-->
               </div>
            </div>
            
        </div>
        <div class="col-lg-3 col-md-3">
            <div style="border:0px solid black">
                <form name="encabezado_form" id="encabezado_form" method="post" action="">

                <!-- Campos de la terminal -->
                <input type="hidden" name="terminal_id" value="<?php echo $terminal[0]->id_terminal; ?>"/>
                <input type="hidden" name="terminal_numero" value="<?php echo $terminal[0]->numero; ?>"/>
                <!-- Fin Campos de la terminal -->

                <!-- Campos del cliente -->
                <input type="hidden" name="impuesto" value="" id="impuesto" />
                <!-- Fin Campos del cliente -->

                

                <div class="row">
                    <div class="col-lg-12 col-md-12" style="width: 100%; background: #0f4871;text-align: center;color: white;">
                        
                        <span style="font-size: 50px;">
                            <?php echo $moneda[0]->moneda_simbolo; ?> <span class="total_msg">0.00</span>
                        </span>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12" style="width: 100%; background: white;">

                        <table class="table table-sm table-hover">
                            <tr>
                                <td style="color:#0f4871"><b>Sub total</b></td>
                                <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="sub_total_tabla"></span></td>
                            </tr>
                            <tr>
                                <td><b>Iva</b></td>
                                <td><span class="iva_valor"></span></td>
                            </tr>
                            <tr>
                                <td><span class="impuestos_nombre"></span></td>
                                <td><span class="impuestos_total"></span></td>
                            </tr>
                            <tr>
                                <td style="color:#0f4871"><b>Total</b></td>
                                <td><?php echo $moneda[0]->moneda_simbolo; ?><span class="total_tabla"></span></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-lg-12 col-md-12 paper_cut">
                    </div>
                </div><br>

                <div class="row">
                
                <div id="panelDemo1" class="panel panel-default">

                    <div class="panel-heading">Facturacion
                       <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="Collapse Panel" class="pull-right btn-pre">
                          <em class="fa fa-minus"></em>
                       </a>
                    </div>


                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                        <label>Tipo Documento</label>
                                        <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">
                                        <?php
                                        foreach ($tipoDocumento as $documento) {
                                            ?>
                                            <option value="<?php echo $documento->id_tipo_documento; ?>"><?php echo $documento->nombre; ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>                    
                                <div class="col-lg-6 col-md-6">

                                    <div class="form-group has-success">
                                        <label>Cliente Codigo</label>
                                        <input type="text" name="cliente_codigo" class="form-control cliente_codigo" id="cliente_codigo" value="<?php echo $cliente[0]->id_cliente ?>">
                                   </div>
                                                                
                                </div>                    
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                        <label>Forma Pago</label>
                                        <select class="form-control" id="modo_pago_id" name="modo_pago_id">
                                        <?php
                                        foreach ($modo_pago as $value) {
                                            ?><option value="<?php echo $value->id_modo_pago; ?>"><?php echo $value->nombre_modo_pago; ?></option><?php
                                        }
                                        ?>      
                                        </select>
                                   </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                      <div class="form-group has-success">
                                          <label>Cliente Nombre</label>
                                         <input type="text" name="cliente_nombre" class="form-control cliente_nombre" id="cliente_nombre" value="<?php echo $cliente[0]->nombre_empresa_o_compania ?>">
                                         <input type="hidden" name="cliente_direccion" class="form-control direccion_cliente" id="direccion_cliente" value="<?php echo $cliente[0]->direccion_cliente ?>">
                                       </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                      <label>Sucursal Destino</label>
                                      <select class="form-control" name="sucursal_destino" id="sucursal_id">
                                        <?php
                                        $id_sucursal=0;
                                        
                                        foreach ($empleado as $sucursal) {
                                            $id_sucursal = $sucursal->id_sucursal; 
                                            ?>
                                            <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                            <?php
                                        }

                                        foreach ($sucursales as $sucursal) {
                                            if($sucursal->id_sucursal != $id_sucursal){
                                                ?>
                                                <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                   </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                        <label>Bodega</label>
                                        <select class="form-control" name="bodega" id="bodega_select">
                                        <?php
                                            foreach ($bodega as $b) {
                                                if($b->Sucursal == $id_sucursal){
                                        ?>
                                        <option value="<?php echo $b->id_bodega; ?>"><?php echo $b->nombre_bodega; ?></option>
                                        <?php
                                                }   
                                            }
                                        ?>
                                        </select>
                                   </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                   <div class="form-group has-success">
                                      <label>Fecha</label>
                                     <input type="date" name="fecha" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                                   </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-success">
                                        <label>Sucursal Origin</label>
                                        <select class="form-control" name="sucursal_origin" id="sucursal_id2">
                                        <?php
                                        $id_sucursal=0;
                                        $id_sucursal = $empleado[0]->id_sucursal;
                                        foreach ($empleado as $sucursal) {
                                             
                                            ?>
                                            <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                            <?php
                                        }

                                        foreach ($sucursales as $sucursal) {
                                            if($sucursal->id_sucursal != $id_sucursal){
                                                ?>
                                                <option value="<?php echo $sucursal->id_sucursal; ?>"><?php echo $sucursal->nombre_sucursal; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                   </div>
                                   <?php
                                                                      
                                      foreach ($correlativo as $key => $value) {
                                        
                                          if($id_sucursal == $value->id_sucursal ){
                                            $secuencia = $value->siguiente_valor;
                                          }
                                      }
                                      ?>
                                      <input type="hidden" name="numero" value="<?php echo $secuencia; ?>" class="form-control" id="c_numero">
                                </div>
                            </div>

                            <input type="hidden" name="vendedor" id="vendedor1" value="<?php echo $empleado[0]->id_empleado; ?>">
                            <div class="label bg-gray"><a href="#" class="vendedores_lista1" id="<?php echo $empleado[0]->id_sucursal; ?>"><?php echo $empleado[0]->primer_nombre_persona." ".$empleado[0]->primer_apellido_persona; ?></a></div>

                        </div>
                    </div>
                </div>

                </div>

                <!--
                <div class="row">
                    <div class="col-lg-12 col-md-12" style="width: 100%; background: white;">
                        Imagen
                      <div class="panel b m0">
                       
                         <div class="panel-body">
                            <p>
                               <a href="#">
                                  <span class="producto_imagen"></span>
                               </a>
                            </p>
                            
                         </div>
                      </div>
                    </div>
                </div>
                -->
                
            </div>
        </form>
        </div>
    </div>
</section>



<!-- Modal Large CLIENTES MODAL-->
   <div id="cliente_modal" tabindex="-1" role="dialog" aria-labelledby="cliente_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="panel-header" style="background: #535D67; color: white;">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabelLarge" class="modal-title">Buscar Cliente</h4>
            </div>
            <div class="modal-body">
                <p class="cliente_lista_datos">
                    
                </p>                                 
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

<!-- Modal Large PRODUCTOS MODAL-->
   <div id="existencias" tabindex="-1" role="dialog" aria-labelledby="existencias"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <div class="input-group m-b">
                    <span class="input-group-addon btn-pre"><i class="fa fa-search"></i></span>
                    <input type="text" placeholder="Buscar Exsitencia" name="existencia_buscar" class="form-control existencia_buscar">
                </div>

                <select multiple="" class="form-control 1dataSelect" id="1dataSelect">

                </select>

                <select multiple="" class="form-control 1dataSelect2" style="display: inline-block;">

                </select>

            </div>
            <div class="modal-body">
                <table class="table table-sm table-hover">
                    <thead>
                     <tr style="">
                        <th style="color: black;">#</th>
                        <th style="color: black;">Sucursal</th>
                        <th style="color: black;">Bodega</th>
                        <th style="color: black;">Existencia</th>
                        <th style="color: black;">Costo</th>
                        <th style="color: black;">Costo Anterior</th>
                        <th style="color: black;">Costo utilidad</th>
                        <th style="color: black;">Cod ubicacion</th>                                    
                     </tr>
                      </thead>
                      <tbody class="dos" style="border-bottom: 3px solid grey">
                        
                      </tbody>
                </table>                                
               
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default btn-pre">Close</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

<!-- Modal Large PRODUCTOS MODAL-->
   <div id="en_proceso" tabindex="-1" role="dialog" aria-labelledby="en_proceso"  class="modal fade">
      <div class="modal-dialog modal-sm">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               Notificacion
            </div>
            <div class="modal-body">
                Cambiar Orden a Espera ?
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-success guardar btn-pre" name="5">Si</button>               
               <button type="button" data-dismiss="modal" class="btn btn-warning">No</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->


<!-- Modal Large PRODUCTOS MODAL-->
   <div id="en_reserva" tabindex="-1" role="dialog" aria-labelledby="en_reserva"  class="modal fade">
      <div class="modal-dialog modal-sm">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               Notificacion
            </div>
            <div class="modal-body">
                Cambiar Orden a Reservado ?
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-success guardar btn-pre" name="2">Si</button>               
               <button type="button" data-dismiss="modal" class="btn btn-warning">No</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

<!-- Modal Large PRODUCTOS MODAL-->
   <div id="procesar_venta" tabindex="-1" role="dialog" aria-labelledby="procesar_venta"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header" style="background: #dde6e9">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <span style="font-size: 20px; ">Detalle Compra</span>
              
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4" style="border-right: 1px solid #e5e5e5; height: 50%;">
                        <div class="row">
                            <?php
                                $a = 1;
                                $count = count($modo_pago);
                                foreach ($modo_pago as $value) {
                                ?>
                                <div class="col-lg-4 col-md-4">
                                    <?php echo $value->nombre_modo_pago; ?>
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <input type='text' count='<?php echo $count; ?>' name='pagoInput<?php echo $a; ?>' id='<?php echo $value->nombre_modo_pago; ?>' class='form-control metodo_pago_input'>
                                </div>
                                <?php
                                $a++;
                                }
                            ?>     
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8">
                        <div class="row">
                            <div class="col-lg-4 col-md-4" style="color: white; background: #0f4871">
                                
                                <span style="font-size: 20px;">PAGAR</span>
                                <h1><?php echo $moneda[0]->moneda_simbolo; ?> <span id="compra_venta"></span></h1>
                            </div>
                            
                            <div class="col-lg-4 col-md-4 label-primary" style="color: white;background: #556271">
                                <span style="font-size: 20px;">RESTANTE</span>
                                <h1><?php echo $moneda[0]->moneda_simbolo; ?> <span id="restante_venta"></span> </h1>
                            </div>    

                            <div class="col-lg-4 col-md-4 label-primary" style="color: white;">
                                <span style="font-size: 20px;">CAMBIO</span>
                                <h1><?php echo $moneda[0]->moneda_simbolo; ?> <span id="cambio_venta"></span> </h1>
                            </div>                    
                        </div>
                    </div>
                   
                </div>
                <div class="row">
                    
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6" id="metodo_pago_lista">

                    </div>
                </div>

            <div class="modal-footer">
               <button type="button" data-dismiss="modal" id="procesar_btn" class="btn btn-success guardar" name="2">Procesar</button>               
               <button type="button" data-dismiss="modal" class="btn btn-warning">Cancelar</button>               
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->


<?php $this->load->view('scripts_files.php'); ?>