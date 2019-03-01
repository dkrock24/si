<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">

    var productos = {};
    var contador = 0;
    
    $(document).on("change","#producto",function(){
        var val = $(this).val();
        if(val != 0 ){
            $(".producto_combo").show();
            $("#produto_principal").val($(this).val());
        }else{
            $(".producto_combo").hide();
            $("#produto_principal").val();
            
        }
    });
    
    function producto(descripcion){
         var html = "<span>";
         
          
            html += '<div class="form-group" id="total'+descripcion+'">';
            html +='<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Producto</label>';
            html +='<div class="col-sm-4">';html += descripcion;  html +='</div>';
            html +='<div class="col-sm-4">';html += "<input type='text' name='"+descripcion+"'/>";  html +='</div>';
            html +='<div class="col-sm-2">';html += "<a href='#' class='btn btn-warning borrar' id='"+descripcion+"'>Borrar</a>";  html +='</div>';
                            
            html +='</div>';
        
        html += "</span>";
        contador++;
        $("#lista_productos").prepend(html);
        
    }

    $(document).on("click","#btn_agregar",function(){

        $(".producto_combo").val();
        var id = $(".producto_combo").val();

        producto(id);
        $(".producto_combo").val("");
    });

    $(document).on("click",".borrar",function(){
        var id = $(this).attr("id");
        $("#total"+id).remove();

    });

    
</script>

<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista Cod Barra</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Nuevo</button>
            </h3>
            <div class="panel panel-default">
                <div class="panel-heading">Nuevo Combo</div>
                <!-- START table-responsive-->
                <div class="">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-white">

                                <div class="panel-body">
                                    <div class="col-lg-6">
                                        <div id="" class="panel panel-info">
                                            <div class="panel-heading">Combo Formulario : <?php //echo $roles[0]->role ?> </div>
                                            <p>
      
                                            <div class="panel-body">
                                                
                                                    
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Producto</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="producto" id="producto" readonly>
                                                                <option value="<?php echo $codbarra[0]->Producto; ?>"><?php echo $codbarra[0]->name_entidad; ?></option>
                                                                <?php
                                                                foreach ($productos as $key => $value) {
                                                                    if($codbarra[0]->Producto != $value->id_entidad ){
                                                                    ?>
                                                                    <option value="<?php echo $value->id_entidad ?>"><?php echo $value->name_entidad ?></option>
                                                                    <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                   

                                                   
                                                    
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Agregar</label>
                                                        <div class="col-sm-10">
                                                            
                                                             <input type="text" class="form-control producto_combo" name="producto_combo">                                                           
                                                        </div>
                                                    </div> 
                                                                                    
                                                    <br><br>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" class="btn btn-primary" id="btn_agregar">Agregar</button>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div id="" class="panel panel-info">
                                            <div class="panel-heading">Productos en Combo : <?php //echo $roles[0]->role ?> </div>
                                            <p>
      
                                            <div class="panel-body">
                                                <form class="form-horizontal" action='../update' method="post" id="lista_productos">
                                                    
                                                    <?php
                                                    if($codbarra){
                                                        
                                                    foreach ($codbarra as $key => $value) {
                                                        ?>
                                                        <div class="form-group" id="total<?php echo $value->nombre ?>">
                                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Producto</label>
                                                            <div class="col-sm-4"><?php echo $value->nombre ?></div>
                                                            <div class="col-sm-4"><input type='text' name='<?php echo $value->nombre ?>' value="<?php echo $value->code_barr ?>" /></div>
                                                            <div class="col-sm-2"><a href='#' class='btn btn-warning borrar' id='<?php echo $value->nombre ?>'>Borrar</a></div>
                                                        </div>
                                                        <?php
                                                    }
                                                    }
                                                    ?>
                                                    
                                                        <input type="hidden" id="produto_principal" name="produto_principal" value="<?php echo $codbarra[0]->Producto ?>">
                                                     <input type='submit' class='btn btn-default' value='Actualizar'>   
                                                </form>
                                            </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
