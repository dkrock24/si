<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-success"> Moneda</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
            
                    <div class="col-lg-12">

                        <div id="panelDemo10" class="panel panel-info">    
                                                
                            <div class="panel-heading">Nueva Moneda : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                             <div class="panel-body">        
                            <p> 
                            <form class="form-horizontal" name="moneda" action='save' method="post">
                                <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <?php
                                            foreach ($temp as $t) {
                                                $data = $t->factura_template;
                                                eval($data);
                                            }

                                        ?>
                                    </div>
                                </div>
                                
                            
                            </form>
                            </p>                                    
                        </div>
                        </div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>
</section>
