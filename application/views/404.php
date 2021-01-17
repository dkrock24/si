<div class="">
      <div class="abs-center wd-xl">
         <!-- START panel-->
         <div class="text-center mb-xl">
            <div class="text-lg mb-lg">404</div>
            <p class="lead m0">No pudimos encontrar la página</p>
            <p>La página que estas buscando no existe.</p>
         </div>
         <form action="<?php echo base_url() ?>admin/home/buscar" method="post" role="search">
         <div class="input-group mb-xl">            
            
               <input type="text" name="buscar"  placeholder="Buscar Nuevamente" class="form-control">
               <span class="input-group-btn">
                  <input type="submit" class="btn btn-info" value="Buscar">
                     <em class="fa fa-search"></em>
                  </input>
               </span>         
            
         </div>
         </form>
         <ul class="list-inline text-center text-sm mb-xl">
            <li><a href="<?php echo base_url()."admin/home/index" ?>" class="text-muted">Inicio</a>
            </li>
    
            <li class="text-muted">|</li>
            <li><a href="<?php echo base_url()."login/logout" ?>" class="text-muted">Salir</a>
            </li>
         </ul>
         <div class="p-lg text-center">
            <span>&copy;</span>
            <span>2021</span>
            <span>-</span>
            <span>IBS</span>
            <br>
            <span>Intelligence Business Solution</span>
         </div>
      </div>
   </div>