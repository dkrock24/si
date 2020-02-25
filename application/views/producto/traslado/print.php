<?php

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