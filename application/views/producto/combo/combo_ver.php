<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; "><i class="icon-arrow-right"></i>  Lista Combos </h3>
            
             <div class="col-lg-6 col-md-6">
                  <div class="panel b menu_title_bar">
                     <div class="panel-heading">
                        <div class="pull-right">
                           <div class="label label-info">Detalle.</div>
                        </div>
                        <h4 class="m0">Combo :  <?php echo $combos[0]->uno; ?></h4>
                        
                     </div>
                    
                     <table class="table">
                        <tbody>

                            <tr>
                                <td>Producto</td>
                                <td>Cantidad</td>
                                <td style="text-align: center;">Precio Combo</td>
                            </tr>

                            <?php
                            //var_dump($precio);
                            $contado=1;
                            
                            if($combos){
                                foreach ($combos as $combo) {                                    
                                    ?>

                                    <tr>
                                      <td>
                                        <em class="fa fa-fw fa-check mr"></em>
                                         <strong><?php echo $combo->dos; ?></strong>
                                      </td>
                                      <td>
                                         <span><?php echo $combo->cantidad; ?></span>
                                      </td>
                                      <td>
                                         <h2 class=" btn btn-purple pull-right"><?php echo $moneda[0]->moneda_simbolo." ". $precio[0]->precio; ?></h2>
                                      </td>
                                   </tr>

                                   
                                    <?php
                                    $contado+=1;
                                }
                            }
                            
                            
                                                            
                            $id_producto = $combo->Producto_Combo;
                        ?>

                        </tbody>
                     </table>
                     <div class="panel-footer text-center">
                        <a href="../index"><button type="button" class="btn btn-info">Regresar</button></a>
                        <a href="../editar/<?php echo $combos[0]->Producto_Combo ?>" ><button type="button" class="btn btn-danger">Editar</button></a>
                     </div>
                  </div>
               </div>







    </div>
</section>

