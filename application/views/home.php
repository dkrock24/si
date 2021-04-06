
   <!-- Page content-->
   <div class="content-wrapper">
   <h3 style=""><i class="icon-arrow-right"></i> <?php echo $titulo; ?></h3><br>
      <!-- START widgets box-->   
      <div class="row">
         <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-primary">
               <div class="row row-table">
                  <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                     <em class="fa fa-clone fa-3x"></em>
                  </div>
                  <div class="col-xs-8 pv-lg">
                     <div class="h2 mt0"><?php echo $data['ordenes']; ?></div>
                     <div class="text-uppercase">Ordenes Diarias</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-purple">
               <div class="row row-table">
                  <div class="col-xs-4 text-center bg-purple-dark pv-lg">
                     <em class="fa fa-shopping-cart fa-3x"></em>
                  </div>
                  <div class="col-xs-8 pv-lg">
                     <div class="h2 mt0"><?php echo $data['ventas']; ?>
                     </div>
                     <div class="text-uppercase">Ventas Diarias</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- START widget-->
            <div class="panel widget bg-green">
               <div class="row row-table">
                  <div class="col-xs-4 text-center bg-green-dark pv-lg">
                     <em class="fa fa-desktop fa-3x"></em>
                  </div>
                  <div class="col-xs-8 pv-lg">
                     <div class="h2 mt0"><?php echo $data['cajas']; ?></div>
                     <div class="text-uppercase">Cajas Activas</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- START date widget-->
            <div class="panel widget">
               <div class="row row-table">
                  <div class="col-xs-4 text-center bg-green pv-lg">
                     <!-- See formats: https://docs.angularjs.org/api/ng/filter/date-->
                     <em class="fa fa-bar-chart fa-3x"></em>
                  </div>
                  <div class="col-xs-8 pv-lg">

                     <div class="h2 mt0">
                        <a href="#" class="btn btn-default">Reportes</a>
                     </div>

                     <div class="text-uppercase">Ir a Modulo Reporte</div>
                  </div>

               </div>
            </div>
            <!-- END date widget-->
         </div>
      </div>
      <!-- END widgets box-->
      <div class="row">

         <div class="col-lg-8">
            <!-- START widget-->
            <div class="panel widget">
               <div class="panel-body">
                  <div class="clearfix">
                     <h3 class="pull-left text-muted mt0"><?php echo $data['ordenes_suma'] ?></h3>
                     <em class="pull-right text-muted fa fa-shopping-cart fa-2x"></em>
                  </div>
                  <div data-sparkline="" data-type="line" data-height="80" data-width="100%" data-line-width="2" data-line-color="#7266ba" data-spot-color="#888" data-min-spot-color="#7266ba" data-max-spot-color="#7266ba" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="3" data-values="<?php echo $data['ordenes_mes']; ?>" data-resize="true" class="pv-lg"></div>
                  <p>
                     <small class="text-muted">Ordenes </small>
                  </p>
                  <div class="progress progress-xs">
                     <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%" class="progress-bar progress-bar-info progress-bar-striped">
                        <span class="sr-only">80% Complete</span>
                     </div>
                  </div>
               </div>
            </div>
            <!-- END widget-->
         </div>
         <aside class="col-lg-4">
            <!-- START messages and activity-->
            <div class="panel widget">
               <div class="panel-heading">
                  <div class="panel-title">Usuarios Actividad</div>
               </div>
               <!-- START list group-->
               <div class="list-group" data-height="280" data-scrollable="">
                  <!-- START list group item-->
                  <?php
                  if($data['usuario_actividad']){
                  foreach ($data['usuario_actividad'] as $key => $usuarios) {
                  ?>
                     <div class="list-group-item">
                        <div class="media-box">
                           <div class="pull-left">
                              <span class="fa-stack">
                                 <em class="fa fa-circle fa-stack-2x <?php echo $usuarios->color_login ?>"></em>
                                 <em class="fa fa-user fa-stack-1x fa-inverse text-white"></em>
                              </span>
                           </div>
                           <div class="media-box-body clearfix">
                              <small class="text-muted pull-right ml"><a href="#">
                                    <?php
                                    $date = new DateTime($usuarios->creado_login);
                                    echo  $date->format("Y/m/d h:i A") ?>
                              </small>
                              <div class="media-box-heading"><a href="#" class="text-purple m0"><?php echo $usuarios->nombre_usuario; ?> / <?php echo $usuarios->role ?></a>
                              </div>
                              <p class="m0">
                                 <small><a href="#"><?php echo $usuarios->nombre_sucursal ?></a>
                                 </small>
                              </p>
                           </div>
                        </div>
                     </div>
                  <?php
                  }}
                  ?>

                  <!-- END list group item-->
               </div>
               <!-- END list group-->
               <!-- START panel footer-->
               <div class="panel-footer clearfix">
                  <a href="#" class="pull-left">
                     <small>Logins</small>
                  </a>
               </div>
               <!-- END panel-footer-->
            </div>
            <!-- END messages and activity-->
         </aside>
      </div>
   </div>