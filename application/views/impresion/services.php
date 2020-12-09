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
            <td>COPIAS</td>
            <td><input type="number" value="<?php echo $orden[0]->copias; ?>" id="copias" name="copias" class="form-control"></td>
        </tr>
        <tr>
            <td>IMPRESORA</td>
            <td>
                <select class="form-control" name="impresor" id="impresor">
                    <?php foreach($impresion as $i): ?>
                        <option value="<?php echo $i->impresor_nombre ?>"><?php echo $i->impresor_nombre ." - ". $i->impresor_marca ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>URL</td>
            <td>
                <input type="hidden" name="url" id="url" value="<?php echo $i->impresor_url; ?>" />
                <?php
                    echo $i->impresor_url;
                ?>
            </td>
        </tr>
    </table>
</form>