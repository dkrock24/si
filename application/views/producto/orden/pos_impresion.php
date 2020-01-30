
<?php
if (isset($temp)) {
    foreach ($temp as $t) {

        $data = $t->factura_template;
        try {
            //eval($data);
            //echo $data;
            // echo file_get_contents("test.txt");
            $file = fopen('temp1.php', 'w');
            fwrite($file, $data);
            fclose($file);            

        } catch (Exception $e) {
            echo "Error";
        }
    }
} else {
    echo "<h5> Documento Sin Formato Para Impresion.</h5>";
}
?>