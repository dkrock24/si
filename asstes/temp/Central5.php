                               
<br>

<div style="height:100px"> </div>

<table width="100%" border=0>
<tr>
<td >

  <table  width="100%" border=1>
     <tr>
          <td style="background:none;width:100px">CLIENTE:</td>
          <td colspan="6"> <?php echo $cliente[0]->nombre_empresa_o_compania ?> </td>
    </tr>

      <tr>
              <td>DIRECCION:</td>
              <td colspan="6"> <?php echo $cliente[0]->direccion_cliente ?> </td>
       </tr>

           <tr>
                <td>MUNICIPIO:</td>
               <td width="100px"> * </td>
               <td> DEPTO </td>
               <td width="100px"> * </td>
                <td> N/R No </td>
              <td width="100px"> $resol_num_caja </td>
         </tr>

         <tr>
             <td>GIRO:</td>
            <td colspan=3>   <?php echo $encabezado[0]->giro ?>  </td>

                <td>FECHA</td>
              <td>  $resol_fecha_caja </td>
      </tr>
  </table>

</td>

<td>

   <table  width="100%" border=1>
     <tr>
          <td style="background:none;width:100px">FECHA: <?php echo date("Y-m-d"); ?> </td>

    </tr>
  <tr>
          <td style="background:none;width:100px">N.R.C:   <?php echo  $encabezado[0]->nrc_cli ?> </td>

    </tr>
  <tr>
          <td style="background:none;width:100px">N.I.T: <?php echo  $encabezado[0]->nit_cliente ?></td>

    </tr>
  <tr>
          <td style="background:none;width:100px">CON.DEPAGO: <?php //echo $modo_pago[0]->nombre_metodo_pago ?> </td>

    </tr>
 </table>

</td>

</tr>

<tr>
<td colspan="2">

   <table  width="100%" border=1>
<tr>
          <td rowspan="2" width=40px>CL </td>
          <td rowspan="2">DESCRIPCION </td>
          <td rowspan="2" width=50px>CANT </td>
          <td rowspan="2" width=70px>P. UNIDAD </td>
          <td colspan="2">VENTAS </td>
          <td rowspan=2 width=120px >VENTAS GRAVADAS</td>
</tr>
     <tr>
          <td width=50px>V EXENTAS  </td>
          <td width=50px>V. NO SUJETAS</td>

    </tr>
<?php
$var_total=0;
$cesc=0.00;
$vns=0.00;
$gravado=0.00;
$exento=0.00;
$sub_total=0.00;
$productos_total=0; 
foreach($detalle as $value){
?>

  <tr style="">
          <td><?php echo (int) $value->cantidad ?></td>
          <td> <?php echo $value->descripcion ?></td>
          <td><?php echo  $value->cantidad ?></td>
         <td><?php echo number_format($value->precioUnidad,2) ?></td>
          <td></td>
          <td></td>
          <td><?php echo number_format($value->precioUnidad*$value->cantidad,2) ?></td>
    </tr>

<?php
$var_total += $value->total ;
$productos_total+= $value->cantidad ; 
}

?>

  <tr style="height:50px">
          <td colspan=3>SON:</td>
          <td colspan=3 rowspan=2>
SUMAS<br>
IVA<br>
SUB-TOTAL<br>
FOVIAL<br>
CONTRANS<br>
AD-VALOREM<br>
VTAS.EXENTAS<br>
VTAS.NOSUJETAS<br>
(+)IVA PERCIBIDO<br>
VENTA TOTAL<br>
            </td>
          <td rowspan=2>
                   <?php echo number_format($value->precioUnidad*$value->cantidad,2) ?>
                     <br><br>
                     <?php
                     foreach($impuestos as $value){
                              echo number_format($value->ordenImpTotal,2); echo "<br>";
                     }
                    ?>
                    <br><br><br><br>
                   <?php echo number_format($encabezado[0]->total_doc,2) ?>
           </td>
    </tr>

    <tr style="height:50px">
          <td colspan=3>
                    <table width="100%">
                           <tr>
                               <td>NOMBRE <br> D:U:I / N:I:T </td>
                              <td>NOMBRE <br> D:U:I / N:I:T </td>
                               </tr>
                   </table>
         </td>
    </tr>

 </table>
</td>
</tr>

</table>
<?php                                       