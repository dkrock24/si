<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">

    var productos = {};
    var contador = 0;
    
    $(document).ready(function(){
        $(".producto_combo").hide();
    });

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
    
    function producto(){
         var html = "<span>";
         console.log("Agregando",productos);
         $.each(productos, function(i, item) { 
            html += '<div class="form-group" id="total'+item.id_entidad+'">';
            html +='<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Producto</label>';
            html +='<div class="col-sm-4">';html += item.name_entidad;  html +='</div>';
            html +='<div class="col-sm-4">';html += "<input type='text' name='"+item.id_entidad+"'/>";  html +='</div>';
            html +='<div class="col-sm-2">';html += "<a href='#' class='btn btn-warning borrar' id='"+item.id_entidad+"'>Borrar</a>";  html +='</div>';
                            
            html +='</div>';
        }); 
        html += "</span>";
        contador++;
        $("#lista_productos").prepend(html);
        
    }

    $(document).on("click","#btn_agregar",function(){

        $(".producto_combo").val();
        var id = $(".producto_combo").val();

        $.ajax({
            url: "get_productos_id/"+id,
            datatype: 'json',      
            cache : false,                

            success: function(data){
                var datos = JSON.parse(data);
                var p = {};
                p = datos["productos"];              
                
                productos = p;
                producto();            
            },
            error:function(){
            }
        });
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
                <a href="index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Lista Combo</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Nuevo</button>
            </h3>

            <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">    
                <!-- START table-responsive-->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div id="" class="panel">
                                            <div class="panel-heading menuTop">Combo Formulario : <?php //echo $roles[0]->role ?> </div>
                                                  
                                            <div class="panel-body menuContent">
                                                
                                                    
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Producto</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="producto" id="producto" readonly>
                                                                <option value="0">Selecionar</option>
                                                                <?php
                                                                foreach ($productos_combo as $key => $value) {
                                                                    ?>
                                                                    <option value="<?php echo $value->id_entidad ?>"><?php echo $value->name_entidad ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                   

                                                   
                                                    
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Agregar</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control producto_combo" name="producto_combo">
                                                                <option value="0">Selecionar</option>
                                                                <?php
                                                                foreach ($productos as $key => $value) {
                                                                    ?>
                                                                    <option value="<?php echo $value->id_entidad ?>"><?php echo $value->name_entidad ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                                                                                        
                                                        </div>
                                                    </div> 

                                                    <br><br>

                                                    
                                                                                    
                                                    <br><br>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" class="btn btn-primary" id="btn_agregar">Agregar</button>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div id="" class="panel">
                                            <div class="panel-heading menuTop">Productos en Combo : <?php //echo $roles[0]->role ?> </div>
                                            
      
                                            <div class="panel-body menuContent">
                                                <form class="form-horizontal" action='save' method="post" id="lista_productos">                                                    

                                                        <input type="hidden" id="produto_principal" name="produto_principal" value="">
                                                     <input type='submit' class='btn btn-default' value='Crear'>   
                                                </form>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
        
    </section>
