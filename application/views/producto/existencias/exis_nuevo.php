<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script src="<?php echo base_url(); ?>../asstes/js/generalAlert.js"></script>
<script>
    var _orden = {};
    var _productos = {};
    var _productos_precio = [];
    var _productos_lista;
    var contador_productos = 0;
    var contador_tabla = 1;
    var total_msg = 0.00;
    var factor_precio = 0;
    var factor_total = 0;
    var producto_cantidad_linea = 1;
    var sucursal = 0;
    var interno_sucursal = 0;


    $(document).ready(function() {

        $('.dataSelect').hide();
        $('.dataSelect2').hide();
        $(".producto_buscar").focus();

        /* 1 - Input Buscar Producto */
        $(document).on('keypress', '.producto_buscar', function(e) {
       
            if ( e.keyCode == 13 ) {
                search_texto(this.value);
                
            }
            
        });

        /* 2 - Filtrado del texto a buscar en productos */
        function search_texto(texto) {            
            
            var contador_precios = 1;
            var table_tr = "";
                
            $.ajax({
                type: "POST",
                url: "get_productos_lista",
                datatype: 'json',
                cache: false,
                data:{texto:texto},

                success: function(data) {
                    var datos       = JSON.parse(data);
                    var productos   = datos["productos"];
                    var producto_id = 0;
                    _productos_lista= productos;
                    var producto_id = 0;
                                        
                    if(productos==0){

                        var type = "info";
                        var title = "El Producto No Existe";
                        var mensaje = "Error en Parametros : search_texto";
                        var boton = "info";
                        var  finalMessage = "Gracias..."

                        generalAlert(type , mensaje , title , boton, finalMessage);
                                               
                    }else{

                        if(productos.length == 1){
                            get_producto_completo(productos[0].id_entidad);

                        }else{
                            $('.dataSelect').show();  
                            $.each(productos, function(i, item) {

                                var name = item.name_entidad.toUpperCase();
                                var cod_barra = item.cod_barra;
                                
                                    producto_id = item.id_entidad;
                                    var precio = 0;

                                    table_tr += '<option value="' + item.id_entidad + '">' + item.name_entidad +" " +item.nombre_marca +" " +item.precio_venta + '</option>';
                                    contador_precios++;
                                
                                });
                            }

                            $(".dataSelect").html(table_tr);
                            $(".dataSelect").css("height","300px");
                        }

                },
                error: function() {}
            });
            
        }
        $(".producto_buscar").focus();

        /* 3 - Selecionado Producto de la lista y precionando ENTER */
        $(document).on('keypress', '.dataSelect', function() {

            if (event.which == 13) {

                get_producto_completo(this.value);
                event.preventDefault();
                $('#dataSelect').hide();
                $('.dataSelect').hide();
                $(".producto_buscar").focus();
                $(".producto_buscar").empty();

                $("#producto_buscar").val(this.value);

                $(".producto_buscar").val("");
            }

        });

        $(document).on('keydown', '.producto_buscar', function() {
            if (event.keyCode == 40) {
                $('.dataSelect').focus();
                document.getElementById('dataSelect').selectedIndex = 0;
            }

        });

        /* 4 - Buscar producto por Id para agregarlo a la linea */
        function get_producto_completo(producto_id) {

            $("#grabar").attr('disabled');
            var codigo, presentacion, tipo, precioUnidad, descuento, total

            $.ajax({
                url: "get_producto_completo/" + producto_id,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var contador = 1;
                    var existencias_total = 0;
                    var html = '';

                    $("#nombre_producto").text("[ Codigo " + datos['producto'][0].codigo_barras +" ] [ Producto "+ datos['producto'][0].name_entidad +" ]");

                    $.each(datos['producto'], function(i, item) {

                        existencias_total += parseInt(item.Cantidad);
                        html += '<tr>';
                        html += '<td>' + contador + '</td>';
                        html += '<td>' + item.nombre_sucursal + '</td>';
                        html += '<td>' + item.nombre_bodega + '</td>';
                        html += '<td>' + item.Cantidad + '</td>';
                        html += '<td>' + item.moneda_simbolo + " "+  item.precio + '</td>';
                        html += '<td>' + 0.00 + '</td>';
                        html += '</tr>';
                        contador++;
                    });
                    html += '<tr><td colspan="3"></td><td>' + existencias_total + '</td><td colspan="4"></td></tr>'
                    $('.uno').html(html);

                },
                error: function() {}
            });
        }
    });
</script>

<style type="text/css">
    .border-left {
        border-left: 1px solid grey;
    }

    .border-right {
        border-right: 1px solid grey;
    }

    .border-input {
        border: 1px solid grey;
    }

    .border-table-left {
        border-left: 1px solid grey;
    }

    .border-table-right {
        border-right: 1px solid grey;
    }

    .dataSelect,
    .dataSelect2 {
        float: left;
        display: none;
        position: absolute;
        
    }
</style>
<title><?php echo $title; ?></title>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; ">Existencias </h3>

        <div class="panel-heading menuTop menu_title_bar" style="color: white;">
            <div class="row">

                <div class="col-lg-6 col-md-6">
                    <div class="input-group m-b" style="position: relative;">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input type="text" placeholder="Buscar Producto" name="producto_buscar" class="form-control producto_buscar" autocomplete="off">
                        
                    </div>
                    
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="pull-right">

                        <a href="<?php echo base_url() . 'producto/producto/nuevo' ?>" style='float: right;' class="btn btn-info"><i class="fa fa-arrow-left"></i> Producto</a>
                        <span id="nombre_producto" style="position: relative;float: right;margin-right: 50px;font-size: 20px;color:black;"></span>
                        <a href="export" style="position: relative;float: right;margin-right: 50px;font-size: 20px;color:black;"> <i class="fa fa-file-excel-o"> </i> Xls </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="table-responsive" style="height: 500px;">
            <table class="table table-sm table-hover">
                <div class="col-lg-4">

                    <select multiple="" class="form-control dataSelect" id="dataSelect">

                    </select>

                    <select multiple="" class="form-control dataSelect2">

                    </select>
                </div>

                <thead class="menuTop linea_superior" style="color: black;">
                    <tr>
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Bodega</th>
                        <th>Existencia</th>
                        <th>Precio</th>
                        <th>Precio Anterior</th>
                    </tr>
                </thead>
                <tbody class="uno" style="border-bottom: 3px solid grey">

                </tbody>
                <tbody class="producto_agregados" style="border-top:  3px solid black">

                </tbody>
            </table>
        </div>

    </div>
</section>

<style type="text/css">
    .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .modal-content {
        height: auto;
        min-height: 100%;
        border-radius: 0;
    }
</style>