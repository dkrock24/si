<?php

?>

<style>
    .impresion_parametros{
        background:white;
        padding:10px;
    }
    .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top: none;
    }
</style>

<div class="col-lg-12 col-md-12" style="font-size:24px;text-align:right;margin-top:0px;">
    Impresion <i class="fa fa-print"></i>
</div>
<form action="" method="post" id="impresor_parametros">
    <table class="table impresion_parametros">
        <tr>
            <td>Copias</td>
            <td><input type="number" value="<?php echo $orden[0]->copias; ?>" name="copias" class="form-control"></td>
        </tr>
        <tr>
            <td>Impresora</td>
            <td>
                <select class="form-control">
                    <?php foreach($impresion as $i): ?>
                        <option value="<?php echo $i->impresor_nombre ?>"><?php echo $i->impresor_nombre ." ". $i->impresor_marca ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Location</td>
            <td>
                <?php
                    echo $i->impresor_url;
                ?>
            </td>
        </tr>
    </table>
</form>