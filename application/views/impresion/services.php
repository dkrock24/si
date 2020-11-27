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

<div class="col-lg-12 col-md-12" style="font-size:24px;text-align:left;margin-top:0px;">
    Impresion
</div>
<table class="table impresion_parametros">
    <tr>
        <td>Copias</td>
        <td><input type="number" value="<?php echo 1; ?>" name="copias" class="form-control"></td>
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
        <td>Impresora</td>
        <td>
            <?php
                echo $orden[0]->id;
            ?>
        </td>
    </tr>
</table>