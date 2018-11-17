<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script>
  $(document).ready(function(){

    $("#categoria").change(function(){
          $("#sub_categoria").empty();
          var id = $(this).val();
          $.ajax({
            url: "../sub_categoria_byId/"+id,  
            datatype: 'json',      
            cache : false,                

                success: function(data){
                  //console.log(data);
                  $.each(JSON.parse(data), function(i, item) {                    
                    $("#sub_categoria").append('<option value='+item.id_categoria+'>'+item.nombre_categoria+'</option>');
                });
                
                },
                error:function(){
                }
            });
        });
  });
</script>

<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">            
            
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Producto</button> </a> 
                    <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Editar</button>
                </h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-white">

                        <div class="panel-body">
                            <div class="col-lg-6">
                               
                                <div id="" class="panel panel-info">
                                    <div class="panel-heading">Editar Producto :  </div>
                                        <p>
                                        <form class="form-horizontal" action='../actualizar' method="post">
                                             <input type="hidden" value="<?php echo $producto[0]->id_entidad; ?>" name="id_entidad">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" value="<?php echo $producto[0]->name_entidad; ?>" class="form-control" id="name_entidad" name="name_entidad" placeholder="Nombre Producto" value="">
                                                    <p class="help-block">Nombre Producto.</p>
                                                </div>
                                            </div>  

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Categoria</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="categoria" name="categoria">
                                                        <option value="<?php echo $producto[0]->id_categoria; ?>"><?php echo $producto[0]->nombre_categoria; ?></option>
                                                        <?php
                                                        foreach ($categorias as $value) {
                                                            if( $producto[0]->id_categoria != $value->id_categoria ){
                                                            ?>
                                                            <option value="<?php echo $value->id_categoria; ?>"><?php echo $value->nombre_categoria; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <p class="help-block">Categoria.</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Sub Categoria</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="sub_categoria" name="sub_categoria">
                                                        <option value="<?php echo $producto[0]->id_sub_categoria; ?>"><?php echo $producto[0]->SubCategoria; ?></option>
                                                    </select>
                                                    <p class="help-block">Sub Categoria.</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                    <label>
                                                        <select name="producto_estado" class="form-control">
                                                            <?php 
                                                                    if( $producto[0]->producto_estado ==1 ){ 
                                                                        ?>
                                                                        <option value="1">Activo</option>
                                                                        <option value="0">Inactivo</option>
                                                                        <?php
                                                                    } else{
                                                                         ?>
                                                                        <option value="0">Inactivo</option>
                                                                        <option value="1">Activo</option>
                                                                        <?php
                                                                    }
                                                                ?> 
                                                        </select>
                                                    </label>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
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
