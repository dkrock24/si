<link rel="stylesheet" media="print" href="<?php echo base_url(); ?>../asstes/css/print.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/print.css">
<!--
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/pos.css" />
-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<link rel="stylesheet" src="<?php echo base_url(); ?>../asstes/css/print.css" type="text/css" />

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">

<style>
    @page {
        margin-top: 2cm;
        margin-bottom: 2cm;
        margin-left: 2cm;
        margin-right: 2cm;

        background: red;
        font: 12pt Georgia, "Times New Roman", Times, serif;
        line-height: 1.3;
    }

    @media print {

        .abc {
            background: red;
            font-size: 20px;
        }

        table {
            border-collapse: collapse;
        }

        #space {
            height: 750px;
        }

    }

    .border-total-0 {
        border: 0px dashed black;
    }

    .border-total-1 {
        border: 1px dashed black;
    }

    .border-top {
        border-top: 1px dashed black;
    }

    .border-bottom {
        border-top: 1px solid black;
        padding: 5px;
        margin: 10px;
    }

    .border-left {
        border-left: 1px dashed black;
    }

    .border-right {
        border-right: 1px dashed black;
    }

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .font-family {
        font-family: monospace;
    }

    .padding-1 {
        padding: 1px;
    }

    .padding-2 {
        padding: 2px;
    }

    .padding-3 {
        padding: 3px;
    }

    .padding-4 {
        padding: 4px;
    }

    .padding-5 {
        padding: 5px;
    }

    .padding-6 {
        padding: 6px;
    }

    .padding-7 {
        padding: 7px;
    }

    .padding-8 {
        padding: 8px;
    }

    .padding-9 {
        padding: 9px;
    }

    .padding-left-1 {
        padding-left: 1px;
    }

    .padding-left-2 {
        padding-left: 2px;
    }

    .padding-left-3 {
        padding-left: 3px;
    }

    .padding-left-4 {
        padding-left: 4px;
    }

    .padding-left-5 {
        padding-left: 5px;
    }

    .padding-left-6 {
        padding-left: 6px;
    }

    .padding-left-7 {
        padding-left: 7px;
    }

    .padding-left-8 {
        padding-left: 8px;
    }

    .padding-left-9 {
        padding-left: 9px;
    }

    .padding-right-1 {
        padding-right: 1px;
    }

    .padding-right-2 {
        padding-right: 2px;
    }

    .padding-right-3 {
        padding-right: 3px;
    }

    .padding-right-4 {
        padding-right: 4px;
    }

    .padding-right-5 {
        padding-right: 5px;
    }

    .padding-right-6 {
        padding-right: 6px;
    }

    .padding-right-7 {
        padding-right: 7px;
    }

    .padding-right-8 {
        padding-right: 8px;
    }

    .padding-right-9 {
        padding-right: 9px;
    }

    .padding-top-1 {
        padding-top: 1px;
    }

    .padding-top-2 {
        padding-top: 2px;
    }

    .padding-top-3 {
        padding-top: 3px;
    }

    .padding-top-4 {
        padding-top: 4px;
    }

    .padding-top-5 {
        padding-top: 5px;
    }

    .padding-top-6 {
        padding-top: 6px;
    }

    .padding-top-7 {
        padding-top: 7px;
    }

    .padding-top-8 {
        padding-top: 8px;
    }

    .padding-top-9 {
        padding-top: 9px;
    }

    #formato{
        font-family: 'Roboto Mono', monospace;
        color: grey;
        font-weight: 100;
        font-size: 12px;
        padding:20px;
        background:white;
    }

</style>


<?php

$linea = "";
$border = "";
if ($temp[0]->imprimir_lineas_documento) {
    $linea = "border-bottom";
    $border = "border='1'";
}

include("asstes/temp/" . $file . ".php");

//$this->load->library('html2pdf');

$CI = &get_instance();
$CI->load->library('html2pdf');

$CI->html2pdf->folder('./asstes/printer_files/');
$CI->html2pdf->filename($orden[0]->documento_numero . '.pdf');
//Set the paper defaults
$CI->html2pdf->paper('a4', 'portrait');

//Load html view
$CI->html2pdf->html($this->load->view("producto/print/print2", $file, true));

if ($CI->html2pdf->create('save')) {
    //echo 'PDF saved';
    //$response = file_get_contents('http://localhost:8080/restApi/api/printer?name=HP_Color_LaserJet_MFP_M477fnw_4564C7_@NPI4564C7.local&path=/Desktop/demo/si/asstes/printer_files/&file=DSA000178.pdf&copies=3');


    //echo file('http://localhost:8080/restApi/api/printer');

    /*$covidJsonResponse = CallAPI("POST","http://localhost:8080/restApi/api/printer?name=HP_Color_LaserJet_MFP_M477fnw_4564C7_@NPI4564C7.local&path=/Desktop/demo/si/asstes/printer_files/&file=DSA000178.pdf&copies=3");
        //$covidJsonResponse = CallAPI("GET","http://localhost:8080/restApi/api/printer");
        $covidIndiaObject = json_decode($covidJsonResponse);
        $lastCovidUpdateInfo = end($covidIndiaObject);
        var_dump($covidJsonResponse);*/

    // kvstore API url
    $url = 'http://localhost:8080/restApi/api/printer?name=HP_Color_LaserJet_MFP_M477fnw_4564C7_@NPI4564C7.local&path=/Desktop/demo/si/asstes/printer_files/&file=DSA000178.pdf&copies=3';
}

?>
<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var printContents       = document.getElementById('formato').innerHTML;
        var originalContents    = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        // Printing HTML to Image
        var element = $("#formato"); // global variable
        var getCanvas; // global variable

        html2canvas(element, {
            backgroundColor :null,
            onrendered: function(canvas) {
                
                var img = canvas.toDataURL("image/png");
                //$("#previewImage").append(img);
                //getCanvas = canvas;

                $.ajax({
                method: 'POST',
                url: '../photo_upload',
                data: 
                    {photo:img}
                });
            }  ,   
            background: '#fff'       
        });        

        $("#btn-Convert-Html2Image").on('click', function() {
            //var imgageData = getCanvas.toDataURL("image/png");
            // Now browser starts downloading it instead of just showing it
            //var newData = imgageData.replace(/^data:image\/jpg/, "data:application/octet-stream");
            //$("#btn-Convert-Html2Image").attr("download", "ticket_1.jpeg").attr("href", newData);

            //var newData = imgageData.replace(/^data:image\/jpg/, "data:application/octet-stream");
            //$("#btn-Convert-Html2Image").attr("download", "ticket_1.png").attr("href", formData);
            var photo = getCanvas.toDataURL("image/png",1.0);                
            $.ajax({
                method: 'POST',
                url: '../photo_upload',
                data: 
                    {photo:photo}
                
            });
        });
    });
</script>

    <input id="btn-Preview-Image" type="button" value="Preview"/>
    <a id="btn-Convert-Html2Image" href="#">Download</a>
    <br/>
    <h3>Preview :</h3>
    <div id="previewImage">
