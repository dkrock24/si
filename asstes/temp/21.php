 <div id="formato">                 
 <table width="100%" style="border:0px dashed black;">


 <tr>
              <td>EMPRESA:</td>
              <td colspan=""> <?= $traslado[0]->nombre_razon_social ?> </td>
       </tr>

     <tr>
          <td style="background:none; width:400px">SUCURSAL:</td>
          <td colspan=""> <?= $traslado[0]->nombre_sucursal ?> </td>
    </tr>

         <tr>
                <td>CORRELATIVO: <?= $traslado[0]->correlativo_tras ?> </td>
                  <td> </td>
         </tr>
        <tr>
               <td> ENVIA : <?= $traslado[0]->envia ?>   </td>
                <td> RECIBE :  <?= $traslado[0]->recibe ?> </td>
         </tr>

         <tr>
             <td>SALIDA:  <?= $traslado[0]->fecha_salida ?> </td>
                <td>LLEGADA : <?= $traslado[0]->fecha_llegada ?></td>
        </tr>
</table>        
<br> 
   <table  width="100%" border=1 style="border:1px dashed black;">
<tr>
          <td rowspan="1" style="padding:5px;" ># </td>
          <td rowspan="1">CODIGO </td>
          <td rowspan="1" >CANTIDAD </td>
          <td rowspan="1" >MODELO</td>
          <td rowspan="1"> DESCRIPCION</td>
</tr>
  
<?php

$contador=1;
foreach($detalle as $value){
?>

  <tr style="border:1px dashed black;">
          <td style="padding:15px;"><?php echo $contador; ?></td>
          <td> <?php echo $value->codigo_barras ?></td>
          <td><?php echo $value->cantidad_product_tras ?></td>
         <td><?php echo $value->modelo ?></td>
          <td><?php echo $value->descripcion_producto ?></td>

    </tr>

<?php
$contador++;
}

?>
 </table>
</div>
                                