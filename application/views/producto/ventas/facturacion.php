<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script type="text/javascript">
    var path = "../";

    var _orden = [];
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
    var interno_bodega = 0;
    var producto_escala;
    var clientes_lista;
    var combo_total = 0.00;
    var combo_descuento = 0.00;
    var _conf = [];
    var _impuestos = [];

    jQuery(document).ready(function() {

        const segments = new URL(window.location.href).pathname.split('/');
        const last = segments.pop();

        $("#" + last).css("background", "#2c71b5");
        $("#" + last).css("color", "#fff");

        $(document).keypress(function(e) {
            identificador = e.key;

            var venta = $(":input[name=" + identificador + "]").val();

            if (venta) {
                window.location.href = venta;
            }
        });
    });
</script>
<script src="<?php echo base_url(); ?>../asstes/general.js"></script>

<?php
include("asstes/pos_funciones.php");
include("asstes/pos_orden.php");
?>
<script>



</script>
<script src="<?php echo base_url(); ?>../asstes/js/generalAlert.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/pos.css" />

<script>
    $(document).ready(function() {

        setTimeout(function() {
            $("#m_orden_creada").modal();
            //$("#imprimir").modal(); 
        }, 1000);

        $(".printer").click(function() {

            $("#m_orden_creada").modal();

        });

        $("#prin").click(function() {
            var id = $(this).attr('name');
            var strWindowFeatures = "location=yes,height=670,width=820,scrollbars=yes,status=yes";
            var URL = "../print_venta/" + id;
            var win = window.open(URL, "_blank", strWindowFeatures);
            //window.open('http://localhost:8080/index.php/producto/traslado/print_traslado/11');
        });

        $("#persona_modal").appendTo("body");

        $("#printer").click(function() {

            var printContents = document.getElementById('formato').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

        });

        jQuery(document).ready(function(e) {
            document.onkeydown = function(e) {
                if (e.keyCode == 13) {
                    $("#nuevo")[0].click();
                }
                if (e.key == 'F2') {
                    $("#prin")[0].click();
                }
            }
        });
    });

    // facturacion vista. Accesos para nueva order,imprimir.
</script>

<style>
    .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
        padding-left: 10%;
    }

    .modal-content {
        height: auto;
        min-height: 100%;
        border-radius: 5;
    }

    .border-total-0{
        border:0px dashed black;
    }

    .border-total-1{
        border:1px dashed black;
    }

    .border-top{
        border-top:1px dashed black;
    }
    .border-bottom{
        border-bottom:1px dashed black;
    }
    .border-left{
        border-left:1px dashed black;
    }
    .border-right{
        border-right:1px dashed black;
    }
    .text-center{
        text-align:center;
    }
    .text-left{
        text-align:left;
    }
    .text-right{
        text-align:right;
    }
</style>

<div id="m_orden_creada" tabindex="-1" role="dialog" aria-labelledby="m_orden_creada" class="modal flip">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="background:#f1f1f1;">
            <div class="modal-header" style="background: #2c71b5;color: white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; ">Documento : <?= $temp[0]->documento_nombre ?> | Formato : <?= $temp[0]->factura_nombre ?> </span>

            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <?php include("asstes/temp/" . $file . ".php"); ?>
                    </div>
                    <div class="col-lg-4 col-md-4" style="border-left:1px dashed black;height:900px;position: relative;float:right;margin:0px;">

                        <div class="row">
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <?php echo $msj_title ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <h1>
                                    <?php echo $msj_orden ?>
                                </h1>
                            </div>
                        </div>

                        <div class="row">
                            <hr style="border-bottom:1px dashed black">
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <h1>
                                    Opciones
                                </h1>
                            </div>

                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <?php
                                $vista_id  = $orden[0]->venta_vista_id;
                                $vista_url = "../../orden/venta_rapida";

                                if ($vista_id == 13) {
                                    $vista_url = "../../orden/nuevo";
                                } else if ($vista_id == 38) {
                                    $vista_url = "../../orden/venta_rapida";
                                }
                                ?>

                                <a href="<?php echo $vista_url; ?>" class="btn btn-default printer" id="nuevo">
                                    <h3> <i class="icon-plus"></i> Nueva <i class="icon-arrow-left"></i>Intro<i class="icon-arrow-right"></i></h3>
                                </a>
                                <a href="#" id="prin" name="<?php echo $orden[0]->id ?>" class="btn btn-info" style="color:black">
                                    <h3> <i class="icon-printer"></i> Imprimir <i class="icon-arrow-left"></i>F2<i class="icon-arrow-right"></i></h3>
                                </a>

                            </div>
                        </div>
                        <?php if (count($ids_ventas) > 1) : ?>
                            <div class="row" style="border-bottom: 1px dashed black;">


                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                    <h1>
                                        Documentos
                                    </h1>
                                </div>
                                <?php
                                $contador = 1;
                                foreach ($ids_ventas as $key => $id) {
                                ?>
                                    <input type="hidden" name="<?php echo $contador; ?>" value="<?php echo $id; ?>">
                                    <a href="<?php echo $id; ?>" class="btn btn-default printer <?php echo $contador; ?>" id="<?php echo $id; ?>" style="background:#f1f1f1;border-radius: 10px 10px 10px 10px;">
                                        <h3><i class="icon-arrow-left"></i><?php echo $contador; ?><i class="icon-arrow-right"></i> # <?php echo $id; ?></h3>
                                    </a><br>
                                <?php
                                    $contador++;
                                }
                                ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->