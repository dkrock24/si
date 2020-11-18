
<link rel="stylesheet" media="print" href="<?php echo base_url(); ?>../asstes/css/print.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/print.css">

<?php

    $linea = "";
    $border = "";
    if($temp[0]->imprimir_lineas_documento){
        $linea = "border-bottom";
        $border = "border='1'";
    }

include("asstes/temp/" . $file . ".php");

?>
<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        var printContents = document.getElementById('formato').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        
    });

</script>