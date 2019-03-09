<?php include_once 'template/libraries.php'; ?>


 <div class="wrapper">
   <div style="text-align: center"><?php include_once 'notificaciones/success.php'; ?></div>
      <div class="block-center mt-xl wd-xl">
         <!-- START panel-->
         <div class="panel panel-dark panel-flat">

            <div class="panel-heading text-center">
               <h1 style="margin-top: 0px; color: white;">IBS</h1>
            </div>
            <div class="panel-body">
               <p class="text-center pv">Login.</p>
               <form action="login" method="post" class="mb-lg">
                  <div class="form-group has-feedback">
                     <input id="exampleInputEmail1" type="text" placeholder="Usuario" name="usuario" autocomplete="off" required class="form-control">
                     <span class="fa fa-envelope form-control-feedback text-muted"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <input id="exampleInputPassword1" type="password" placeholder="Password" name="passwd" required class="form-control">
                     <span class="fa fa-lock form-control-feedback text-muted"></span>
                  </div>
                  <div class="clearfix">

                     <div class="pull-right"><a href="recover.html" class="text-muted">Olvide Password?</a>
                     </div>
                  </div>
                  
                  <input type="submit" class="btn btn-block btn-primary mt-lg" value="Login">
               </form>

            </div>
         </div>
         <!-- END panel-->
         <div class="p-lg text-center">
            <span>&copy;</span>
            <span>2019</span>
            <span>-</span>
            <span>Sistema IBS Integrado</span>
            <br>
            <span>Todos Los Derechos Reservados</span>
         </div>
      </div>
   </div>



