
<?php
if ($temp) {
    foreach ($temp as $t) {

        $data = $t->factura_template;
        try {
            eval($data);
        } catch (Exception $e) {
            echo "Error";
        }
    }
} else {
    echo "<h5> Documento Sin Template Para Impresion.</h5>";
}
?>