<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">

   $(document).ready(function(){
      
   });   
</script>

<section>
   <!-- Page content-->
   <div class="content-wrapper">
      <h3>Venta Detalle</h3>
      <div class="row menu_title_bar">
         <div class="col-md-8">

            <!-- Aside panel-->
            
               <div class="panel-body linea_superior">
                  <p><h4>VENTA : <?php $date=date_create($venta[0]->fecha);  ?><span class="label label-success"><?php echo date_format($date,"M-d Y H:i a"); ?></span></h4></p>
  
               </div>
               <table class="table">
                   
                  <tbody>

                        <tr>
                            <td>CORRELATIVO</td>
                           <td>
                            <strong><?php echo $venta[0]->num_correlativo; ?></strong>
                           </td>
                           <td>CAJA</td>
                           <td> <strong><?php echo $venta[0]->num_caja ?></strong></td>
                         
                        </tr>

                        <tr>
                            <td>CLIENTE</td>
                           <td>
                            <strong><?php echo $venta[0]->nombre_empresa_o_compania; ?></strong>
                           </td>
                           <td>SUCURSAL</td>
                           <td> <strong><?php echo $venta[0]->nombre_sucursal ?></strong></td>
                          
                        </tr>

                        <tr>
                        <td>DOCUMENTO</td>
                           <td>
                            <strong><?php echo $venta[0]->tipo_documento; ?></strong>
                           </td>
                           <td>MODO PAGO</td>
                           <td> <strong><?php echo $venta[0]->nombre_modo_pago ?></strong></td>
                         
                        </tr>

                        <tr>
                        <td>ESTADO</td>
                           <td>
                            <strong><?php echo $venta[0]->orden_estado_nombre; ?></strong>
                           </td>
                           <td>USUARIO</td>
                           <td> <strong><?php echo $venta[0]->nombre_usuario ?></strong></td>
                           
                        </tr>
                      
                  </tbody>
               </table>
            <!-- end Aside panel-->
         </div>

         <div class="col-md-4">
            <div class="panel-body linea_superior">
                <p><h4>PAGO : <?php //echo $venta[0]->fecha ?></h4></p>
            </div>
            <table id="" class="table table-striped">
                    
                    <thead class="menuContent">
                    <tr>
                        <th>#</th>
                        <th>Metodo Pago</th>
                        <th>Valor</th>
                        <th>Estado</th>

                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cnt = 1;
                        foreach ($venta_pagos as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $cnt ?></td>
                                <td><?php echo $value->nombre_metodo_pago ?></td>
                                <td><?php echo $value->valor_metodo_pago ?></td>
                                <td><?php if($value->estado_venta_pago == 1){ echo "Cancelado"; }else{ echo "Pendiente"; }   ?></td>
                            </tr>
                            <?php
                            $cnt++;
                        }
                        ?>                          
                    </tbody>
                </table>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">

            <div class="panel-body linea_superior">
                <p><h4>ARTICULOS </h4></p>
  
            </div>
                    
            <div class="table-responsive" style="height: 400px; overflow: auto; position: relative;">
                <table id="" class="table table-striped">
                    
                    <thead class="menuContent">
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Modelo</th>
                        <th>Bodega</th>
                        <th>Presentacion</th>
                        <th>Precio</th>                              
                        <th>Factor</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Inc.Iva</th>

                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cnt = 1;
                        foreach ($venta_detalle as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $cnt ?></td>
                                <td><?php echo $value->codigo_producto ?></td>
                                <td><?php echo $value->name_entidad ?></td>
                                <td><?php echo $value->descripcion ?></td>
                                <td><?php echo $value->modelo ?></td>
                                <td><?php echo $value->nombre_bodega ?></td>
                                <td><?php echo $value->presentacion ?></td>
                                <td><?php echo $value->precio_venta ?></td>                                    
                                <td><?php echo $value->factor ?></td>
                                <td><?php echo $value->cantidad ?></td>
                                <td><?php echo $value->total ?></td>
                                <td><?php echo $value->incluye_iva ?></td>

                            </tr>
                            <?php
                            $cnt++;
                        }
                        ?>                          
                    </tbody>
                </table>
        
            </div>

         </div>
      </div>
   </div>
</section>

