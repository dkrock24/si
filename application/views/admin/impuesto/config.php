
<script type="text/javascript">

var columna1 = 'Impuesto';

    $(document).ready(function(){

        var table_intermedia = 'pos_impuesto_categoria';
        
        var field = 'nombre_categoria';

        var tabla_destino = 'categoria';
        var columna2 = 'Categoria';
        var columna3 = 'id_categoria';

        $(function() {   

            $('#filtro').change(function() {
                var texto = $(this).val().toUpperCase();
                $(".datos td.col1:contains('" + texto + "')").parent().show();


                $(".datos td.col1:not(:contains('" + texto + "'))").parent().hide();
            });
            
        });

        getData( table_intermedia, tabla_destino, columna1 , columna2, columna3 , field);

        $('.menu').click(function(){
            var menu = $(this).attr('id');
            if(menu == 'Categoria'){ // Categorias
                $(".title").text(menu);
                table_intermedia = 'pos_impuesto_categoria';
                tabla_destino   = 'categoria';
                columna2        = 'Categoria';
                columna3        = 'id_categoria';
                field = 'nombre_categoria';

                getData( table_intermedia, tabla_destino, columna1 , columna2, columna3 , field);
            }
            if(menu == 'Cliente'){ // Cliente
                $(".title").text(menu);
                table_intermedia = 'pos_impuesto_cliente';
                tabla_destino   = 'pos_cliente';
                columna2        = 'Cliente';
                columna3        = 'id_cliente';
                field = 'nombre_empresa_o_compania';

                getData( table_intermedia, tabla_destino, columna1 , columna2, columna3, field );
            }
            if(menu == 'Documento'){ // Cliente
                $(".title").text(menu);
                table_intermedia = 'pos_impuesto_documento';
                tabla_destino   = 'pos_tipo_documento';
                columna2        = 'Documento';
                columna3        = 'id_tipo_documento';
                field = 'nombre';

                getData( table_intermedia, tabla_destino, columna1 , columna2, columna3, field );
            }
            if(menu == 'Proveedor'){ // Cliente
                $(".title").text(menu);
                table_intermedia = 'pos_impuesto_proveedor';
                tabla_destino   = 'pos_proveedor';
                columna2        = 'Proveedor';
                columna3        = 'id_proveedor';
                field = 'empresa_proveedor';

                getData( table_intermedia, tabla_destino, columna1 , columna2, columna3, field );
            }
            
        });

        $(".addCategoria").click(function(){
            
            var idCliente = $("#subcategoria").val();
            var impuestoCliente = $(".ivaCategoria").val();
            var tabla = 'pos_impuesto_categoria';
            var column = 'Categoria';
            
            if(impuestoCliente != 'Todos'){
                var data = {id:idCliente, tabla:tabla, impuesto:impuestoCliente, columna: column};
                var metodo = "asociar";
                asociarImpuesto(data, metodo);
            }else{
                alert("Selecione Impuesto");
            }
        });

        $(".clienteId").click(function(){
            
            var idCliente = $(this).attr('name');
            var impuestoCliente = $(".ivaCliente").val();
            var tabla = 'pos_impuesto_cliente';
            var column = 'Cliente';

            if(impuestoCliente != 'Todos'){
                var data = {id:idCliente, tabla:tabla, impuesto:impuestoCliente, columna: column};
                var metodo = "asociar";
                asociarImpuesto(data, metodo);
            }else{
                alert("Selecione Impuesto");
            }
        });

        $(".documentId").click(function(){
            
            var idCliente = $(this).attr('name');
            var impuestoCliente = $(".ivaDocumento").val();
            var tabla = 'pos_impuesto_documento';
            var column = 'Documento';

            if(impuestoCliente != 'Todos'){
                var data = {id:idCliente, tabla:tabla, impuesto:impuestoCliente, columna: column};
                var metodo = "asociar";
                asociarImpuesto(data, metodo);
            }else{
                alert("Selecione Impuesto");
            }
        });

        $(".proveedorId").click(function(){
            
            var idCliente = $(this).attr('name');
            var impuestoCliente = $(".ivaProveedor").val();
            var tabla = 'pos_impuesto_proveedor';
            var column = 'Proveedor';

            if(impuestoCliente != 'Todos'){
                var data = {id:idCliente, tabla:tabla, impuesto:impuestoCliente, columna: column};
                var metodo = "asociar";
                asociarImpuesto(data, metodo);
            }else{
                alert("Selecione Impuesto");
            }
        });

        $("#categoria").change(function(){
            
            var id_categoria = $(this).val();

            getSubCategoria(id_categoria);
            
        });

        function getSubCategoria(id_categoria){
            $.ajax({
                url: "<?php echo base_url().'admin/impuesto/' ?>get_sub_categoria/"+id_categoria,
                datatype: 'json',      
                cache : false,                

                success: function(data){
                    var datos = JSON.parse(data);
                    var html='';

                        $.each(datos['subcategoria'], function(i, item) { 
                            html += "<option value='"+item.id_categoria+"'>"+item.nombre_categoria+"</option>";
                        });
                    
                        $('#subcategoria').html(html);
                    

                },
                error:function(){
                }
            });
        }

    });

    function drawTable(datos,entidad, table_intermedia){

        var tabla = table_intermedia;
        var data;
        var num =1;
        var html='<thead style="background:#cfdbe2"><tr><th scope="col"></th><th>Cod</th><th>Entidad</th> <th>Impuesto</th> <th>Porcentaje</th> <th>SRN</th> <th>A_P</th> <th>A_C</th> <th>A_P</th> <th>A_GBE</th><th>Es</th><th>Ex</th><th>Co</th><th>Valor</th><th>Estado</th> <th>Opciones</th> </tr></thead>';
        $.each(datos['impuesto_option'], function(i, item) { 
            
            html += "<tr class='line'>";  
            html += "<td>"+num+"</td>";   
            html += "<td>"+item.eId+"</td>";    
            html += "<td class='col1'>"+item.valor_field.toUpperCase()+"</td>";                      
            html += "<td>"+item.nombre +"</td>";
            html += "<td>"+item.porcentage +"</td>";
            html += "<td>"+item.suma_resta_nada +"</td>";
            html += "<td>"+item.aplicar_a_producto +"</td>";
            html += "<td>"+item.aplicar_a_cliente +"</td>";
            html += "<td>"+item.aplicar_a_proveedor +"</td>";
            html += "<td>"+item.aplicar_a_grab_brut_exent +"</td>";
            html += "<td>"+item.especial +"</td>";
            html += "<td>"+item.excluyente +"</td>";
            html += "<td>"+item.condicion +"</td>";
            html += "<td>"+item.condicion_valor +"</td>";
            html += "<td><span>"+item.estado+"</span></td>";

            data = {"entidad":item.eId , "impuesto":item.iId, "columna":entidad, "tabla":tabla};
            
            html += "<td><button type='button' class='btn btn-info' onclick='disable("+JSON.stringify(data)+")'><i class='fa fa-pencil'></i></button> <button type='button' class='btn btn-warning' onclick='myFunction("+JSON.stringify(data)+")'><i class='fa fa-trash'></i></button> </td> ";
            
            html += "</tr>";
            num++;
        });

        $('.datos').html(html);
    }

    function getData(table_intermedia , tabla_destino , columna1, columna2 , columna3 , field){ 
        $('.datos').html('');
        $.ajax({
            url: "<?php echo base_url().'admin/impuesto/' ?>getImpuestoDatos/"+table_intermedia+"/"+tabla_destino+"/"+columna1+"/"+columna2+"/"+columna3+"/"+field,
            datatype: 'json',      
            cache : false,                

            success: function(data){

                var datos = JSON.parse(data);                    
                drawTable(datos, columna2, table_intermedia);

            },
            error:function(e){
                console.log(e);
            }
        });
    }

    function asociarImpuesto(data, metodo){
        var fun = data;
        
        $.ajax({
            url: "<?php echo base_url().'admin/impuesto/' ?>"+metodo,
            datatype: 'json',      
            cache : false,                
            data: data,

            success: function(data){    

                if(fun.columna=='Categoria'){
                    
                    Categoria();
                }                
                if(fun.columna=='Cliente'){
                    
                    Cliente();
                }
                if(fun.columna=='Documento'){
                    
                    Documento();
                }
                if(fun.columna=='Proveedor'){
                    
                    Proveedor();
                }
            },
            error:function(){
            }
        });
    }

    function myFunction(data){
        var metodo = "deleteImpuesto";
        asociarImpuesto( data, metodo );
    }

    function disable(data){
        var metodo = "updateImpuesto";
        asociarImpuesto( data, metodo );
    }

    function Categoria(){

        table_intermedia = 'pos_impuesto_categoria';
        tabla_destino   = 'categoria';
        columna2        = 'Categoria';
        columna3        = 'id_categoria';
        field = 'nombre_categoria';

        getData( table_intermedia, tabla_destino, columna1 , columna2, columna3, field );
    }

    function Cliente(){
        table_intermedia = 'pos_impuesto_cliente';
        tabla_destino   = 'pos_cliente';
        columna2        = 'Cliente';
        columna3        = 'id_cliente';
        field = 'nombre_empresa_o_compania';

        getData( table_intermedia, tabla_destino, columna1 , columna2, columna3, field );
    }

    function Documento(){
        table_intermedia = 'pos_impuesto_documento';
        tabla_destino   = 'pos_tipo_documento';
        columna2        = 'Documento';
        columna3        = 'id_tipo_documento';
        field = 'nombre';

        getData( table_intermedia, tabla_destino, columna1 , columna2, columna3, field );
    }

    function Proveedor(){
        table_intermedia = 'pos_impuesto_proveedor';
        tabla_destino   = 'pos_proveedor';
        columna2        = 'Proveedor';
        columna3        = 'id_proveedor';
        field = 'empresa_proveedor';

        getData( table_intermedia, tabla_destino, columna1 , columna2, columna3, field );
    }
</script>

<style>
    .cliente:hover{
        background: #0f4871;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }
    .line:hover{
        background: red;
        color:black;
    }
</style>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Impuesto</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Configuracion</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                
                                
                            <div class="row">

                              <div class="col-md-12">

                                 <div class="tab-content p0 b0">
                                    <div id="tabSetting1" class="tab-pane active">
                                       <div class="panel b menu_title_bar">
                                          

                                        <div role="tabpanel">
                                            <!-- Nav tabs-->
                                            <ul role="tablist" class="nav nav-tabs">
                                                <li role="presentation" class="active categoria menu" id="Categoria"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Categoria</a>
                                                </li>
                                                <li role="presentation" class="cliente menu" id="Cliente"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Cliente</a>
                                                </li>
                                                <li role="presentation" class="documento menu" id="Documento"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Documento</a>
                                                </li>
                                                <li role="presentation" class="proveedor menu" id="Proveedor"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Proveedor</a>
                                                </li>
                                            </ul>
                                            <!-- Tab panes-->
                                            <div class="tab-content">
                                                <div id="home" role="tabpanel" class="tab-pane active">
                                                    <!-- Categoria 0-->
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <select class="form-control" id="categoria">
                                                                <option value="0">Categoria</option>
                                                                <?php
                                                                foreach ($categoria as $value) {
                                                                    ?>
                                                                    <option value="<?php echo $value->id_categoria; ?>"><?php echo $value->nombre_categoria; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select class="form-control" id="subcategoria">
                                                                <option value="0">Sub Categoria</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <select class="form-control ivaCategoria" name="ivaCategoria">
                                                                <option >Todos</option>
                                                                <?php
                                                                foreach ($impuesto as $value) {
                                                                    ?>
                                                                    <option value="<?php echo $value->id_tipos_impuestos; ?>"><?php echo $value->nombre; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <button class="btn btn-info addCategoria">Agregar</button>                                                            
                                                        </div>

                                                    </div>
                                                    <!-- Categoria 1-->

                                                </div>

                                                <div id="profile" role="tabpanel" class="tab-pane">
                                                    <!-- Cliente 0-->
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <select class="form-control ivaCliente" name="ivaCliente" id="ivaCliente">
                                                                <option >Todos</option>
                                                                <?php
                                                                foreach ($impuesto as $value) {
                                                                    ?>
                                                                    <option value="<?php echo $value->id_tipos_impuestos; ?>"><?php echo $value->nombre; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <?php
                                                         $contador =1;
                                                        foreach($clientes as $cliente){
                                                            ?>
                                                            
                                                            <div class="col-lg-3 clienteId" name="<?php echo $cliente->id_cliente ?>" >
                                                                <div class="row row-table row-flush">
                                                                    <div class="col-xs-12 text-center cliente" style="text-align: left; padding: 5px;">
                                                                        
                                                                        <h5 class="mt0"><?php  echo $contador.' - '. $cliente->nombre_empresa_o_compania ?>:</h5>
                                                                        
                                                                    </div>
                                                                   
                                                                </div>                
                                                            </div>                                        
                                                            <?php
                                                             $contador++;
                                                        }
                                                        ?>      
                                                    </div>    
                                                    <!-- Cliente 1-->                                          
                                                </div>

                                                <div id="messages" role="tabpanel" class="tab-pane">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <select class="form-control ivaDocumento" name="ivaDocumento" id="ivaDocumento">
                                                                <option >Todos</option>
                                                                <?php
                                                                foreach ($impuesto as $value) {
                                                                    ?>
                                                                    <option value="<?php echo $value->id_tipos_impuestos; ?>"><?php echo $value->nombre; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        
                                                        <?php
                                                        $contador =1;
                                                        foreach ($documentos as $documento) {
                                                            ?>
                                                            
                                                            <div class="col-lg-3 documentId" name="<?php echo $documento->id_tipo_documento ?>" >

                                                                <div class="row ">
                                                                    <div class="col-xs-12 text-center cliente" style="text-align: left; padding: 5px;">
                                                                        
                                                                        <h5 class="mt0"><?php echo $contador.' - '.$documento->nombre ?></h5>
                                                                    
                                                                    </div>
                                                                </div>                
                                                            </div>                                        
                                                            <?php
                                                            $contador++;
                                                        }
                                                        ?>      
                                                        
                                                    </div>  
                                                </div>
                                                <div id="settings" role="tabpanel" class="tab-pane">
                                                    
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <select class="form-control ivaProveedor" name="ivaProveedor" id="ivaProveedor">
                                                                <option >Todos</option>
                                                                <?php
                                                                foreach ($impuesto as $value) {
                                                                    ?>
                                                                    <option value="<?php echo  $value->id_tipos_impuestos; ?>"><?php echo $value->nombre; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <?php
                                                        $contador =1;
                                                        foreach ($proveedor as $p) {
                                                            ?>
                                                            
                                                            <div class="col-lg-3 proveedorId" name="<?php echo $p->id_proveedor ?>" >
                                                                <div class="row row-table row-flush">
                                                                    <div class="col-xs-12 text-center cliente" style="text-align: left; padding: 5px;">
                                                                        <h5 class="mt0"><?php echo $contador.' - '. $p->empresa_proveedor ?></h5>

                                                                    </div>
                                                                    
                                                                </div>                
                                                            </div>                                        
                                                            <?php
                                                            $contador++;
                                                        }
                                                        ?>      
                                                    </div>  

                                                </div>
                                            </div>
                                        </div>

                                       </div>

                                       <div class="panel b">
                                           
                                            
                                        <div class="panel-heading text-bold" style="background: #0f4871; color: white;">

                                            <div class="row" >
                                                <div class="col-lg-1" >
                                                    <i class="fa fa-list"></i>  Impuestos
                                                </div>
                                                <div class="col-lg-3" style="background: #0f4871; color: white;">
                                                    <input type="text" name="filtro" id="filtro" value="" class="form-control" placeholder="Buscar por Entidad" />
                                                </div>
                                            </div>
                                                

                                        </div>                                          
                                          
                                        <table class="table table-sm table-striped table-condensed table-hover datos">
                                            
                                        </table>                                            
                                          
                                       </div>

                                    </div>
                            
                                    
                                 </div>
                              </div>

                           </div>
                                                          
                        </div>
                 
    </div>
</section>
