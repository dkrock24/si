<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<?php
require __DIR__ . '../../../../../vendor/autoload.php';

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\Printer;
?>

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
<link rel="stylesheet"
      src="<?php echo base_url(); ?>../asstes/css/print.css"
      type="text/css" />

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
            var id       = $(this).attr('name');
            var copias   = $("#copias").val();
            console.log("Copias" + copias);
            var impresor = $("#impresor").val();
            var location = $("#url").val();
            var strWindowFeatures = "location=yes,height=670,width=820,scrollbars=yes,status=yes";
            var URL = "../print_venta/" + id + "?c=" + copias + "&&i=" + impresor + "&&l=" + location;
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
                if (e.key == "$") {
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
        /*padding-left: 10%;*/
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
    .font-family{
        font-family: monospace;
    }

    .padding-1 { padding: 1px;}
    .padding-2 { padding: 2px;}
    .padding-3 { padding: 3px;}
    .padding-4 { padding: 4px;}
    .padding-5 { padding: 5px;}
    .padding-6 { padding: 6px;}
    .padding-7 { padding: 7px;}
    .padding-8 { padding: 8px;}
    .padding-9 { padding: 9px;}

    .padding-left-1 { padding-left: 1px;}
    .padding-left-2 { padding-left: 2px;}
    .padding-left-3 { padding-left: 3px;}
    .padding-left-4 { padding-left: 4px;}
    .padding-left-5 { padding-left: 5px;}
    .padding-left-6 { padding-left: 6px;}
    .padding-left-7 { padding-left: 7px;}
    .padding-left-8 { padding-left: 8px;}
    .padding-left-9 { padding-left: 9px;}

    .padding-right-1 { padding-right: 1px;}
    .padding-right-2 { padding-right: 2px;}
    .padding-right-3 { padding-right: 3px;}
    .padding-right-4 { padding-right: 4px;}
    .padding-right-5 { padding-right: 5px;}
    .padding-right-6 { padding-right: 6px;}
    .padding-right-7 { padding-right: 7px;}
    .padding-right-8 { padding-right: 8px;}
    .padding-right-9 { padding-right: 9px;}

    .padding-top-1 { padding-top: 1px;}
    .padding-top-2 { padding-top: 2px;}
    .padding-top-3 { padding-top: 3px;}
    .padding-top-4 { padding-top: 4px;}
    .padding-top-5 { padding-top: 5px;}
    .padding-top-6 { padding-top: 6px;}
    .padding-top-7 { padding-top: 7px;}
    .padding-top-8 { padding-top: 8px;}
    .padding-top-9 { padding-top: 9px;}

    #formato{
        float:right;
        font-family: sans-serif !important;
        color: black;
        font-weight: 100;
        font-size: 12px;
        padding:20px;
    }



</style>

<div id="m_orden_creada" tabindex="-1" role="dialog" aria-labelledby="m_orden_creada" class="modal flip">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="background:#e6e7e8;">
            <div class="modal-header" style="background: #9c9c9c;color: white;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span style="font-size: 20px; font-family: ticket; ">COMPROBANTE DE PAGO : 
                    <span style="float:right;"><i class="icon-arrow-left"></i> Documento <?= $temp[0]->documento_nombre ?><i class="icon-arrow-right"></i>
                    <i class="icon-arrow-left"></i> Formato <?= $temp[0]->factura_nombre ?> <i class="icon-arrow-right"></i> </span>
                </span>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-8 col-lg-8 abcd">
                        <?php
                            $linea = "border-bottom";
                            $border = "border='1'";
                            if($temp[0]->imprimir_lineas_documento){
                                $linea = "border-bottom";
                                $border = "border='1'";
                            }

                          /*  try {
                            $connector = new WindowsPrintConnector("POSS-80");

                            $printer = new Printer($connector);

                            if (!$connector or !$printer or !is_a($printer, 'Mike42\Escpos\Printer')) {
                                throw new Exception("Tried to create receipt without being connected to a printer.");
                            }

                            
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $printer -> text($orden[0]->nit ."\n");
    $printer->cut(Printer::CUT_PARTIAL);
    $printer->close();

                        } catch (Exception $e) {
                            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
                        }*/
                            
                        
                            ?>
                        <?php include("asstes/temp/" . $file . ".php"); ?>
                        <?php

                        ?>
                    </div>
                    <div class="col-md-4 col-lg-4" 
                        style="border-left:1px black;
                        height:900px;
                        position: relative;
                        float:right;
                        margin:0px;
                        background: white;
                        margin-top: -15px;">

                        <div class="row">
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <?php //echo $msj_title ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12" style="font-size:24px;text-align:center;margin-top:0px;">
                                <h1>
                                    Número de Transacción : # <br>
                                    <?php echo $orden[0]->documento_numero ?>
                                </h1>
                            </div>
                        </div>

                        <div class="row" style="bottom:0px;padding:0px;">

                            <div class="col-lg-6 col-md-6" style="font-size:24px;background:#5d9cec;">
                                <?php
                                $vista_id  = $orden[0]->venta_vista_id;
                                $vista_url = "../../orden/venta_rapida";

                                if ($vista_id == 13) {
                                    $vista_url = "../../orden/nuevo";
                                } else if ($vista_id == 38) {
                                    $vista_url = "../../orden/venta_rapida";
                                }
                                ?>

                                <a href="<?php echo $vista_url; ?>" class="btn btn-primary printer" id="nuevo" style="margin-top:0px;background:#5d9cec">
                                    <h3> <i class="icon-plus"></i> Nueva <i class="icon-arrow-left"></i> $ <i class="icon-arrow-right"></i></h3>
                                </a>

                            </div>
                            <div class="col-lg-6 col-md-6" style="font-size:24px;background:#2b957a;">
                                <a href="#" id="prin" name="<?php echo $orden[0]->id ?>" class="btn btn-info" style="background:#2b957a;color:black;margin-top:0px;color:white;">
                                    <h3> <i class="icon-printer"></i> Imprimir <i class="icon-arrow-left"></i>F2<i class="icon-arrow-right"></i></h3>
                                </a>
                            </div>
                            <span id="cmd">Convertir</span>
                        </div>
                        <?php if (count($ids_ventas) > 1) : ?>
                            <div class="row" style="border-bottom: 1px black;">


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
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <input type="hidden" name="<?php echo $contador; ?>" value="<?php echo $id; ?>">
                                            <a href="<?php echo $id; ?>" class="btn btn-default printer <?php echo $contador; ?>" id="<?php echo $id; ?>" style="background:#f1f1f1;border-radius: 10px 10px 10px 10px;">
                                                <h3><i class="icon-arrow-left"></i><?php echo $contador; ?><i class="icon-arrow-right"></i> # <?php echo $id; ?></h3>
                                            </a>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="text" class="form-control" name="correlativo" value="" />
                                        </div>
                                    </div>
                                    
                                <?php
                                    $contador++;
                                }
                                ?>
                            </div>
                        <?php endif ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12" style="border-top:1px black;position: relative;float:right;margin-top:20px;">
                                <?php if($configuracion[0]->valor_conf == 1): ?>

                                    <?php
                                        $data = array(
                                            $impresion,
                                            $orden
                                        );
                                        $this->view('impresion/services.php',$data);
                                    ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->