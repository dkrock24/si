<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

    <script>
        window.print();
    </script>

</head>

<body>
    
    <?php
        //printer_list();
        //echo exec("lpstat -d -p",$o);
        //print_r($o);
        print_r( function_exists("print_file") );

        //var_dump( printer_list(PRINTER_ENUM_LOCAL | PRINTER_ENUM_SHARED) );
    ?>
</body>

</html>