    
<br>

<div style="height:100px"> </div>

<table width="100%" border=0>
<tr>
<td >

  <table  width="100%" border=1>
     <tr>
          <td style="background:none;width:100px">CLIENTE:</td>
          <td colspan="6"> *$nombre_empresa_o_compania </td>
    </tr>

      <tr>
              <td>DIRECCION:</td>
              <td colspan="6"> $direccion_cliente </td>
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
            <td colspan=3>  $encabezado[0]->giro </td>

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
          <td style="background:none;width:100px">N.R.C:  $nrc_cli</td>

    </tr>
  <tr>
          <td style="background:none;width:100px">N.I.T:  $nit_cliente</td>

    </tr>
  <tr>
          <td style="background:none;width:100px">CON.DEPAGO: </td>

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
          <td><?php echo (int) $value->cantidad ?></td>
         <td><?php echo number_format($value->precioUnidad,2) ?></td>
          <td></td>
          <td></td>
          <td><?php echo number_format($value->precioUnidad*$value->presentacionFactor,2) ?></td>
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
          <td rowspan=2></td>
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

<table width="100%">
	<tr style="border-top:1px dashed black;">
	<td><b><?php echo $encabezado[0]->nombre_comercial ?></b></td>
	</tr>

	<tr>
	<td><b>Direccion: <?php echo $encabezado[0]->direccion ?></b></td>
	</tr>

	<tr>
	<td><b>Giro : <?php echo $encabezado[0]->giro ?></b></td>
	</tr>


</table><br>

<br>
<table width="100%">
	<tr style="border-top:1px dashed black;">
	<td><b> Fecha: </b></td>
	<td><b><?php echo date(" Y/m/d h:i:s A ") ?></b></td>
	</tr>
	
	<tr>
	<td><b>Sucursal: </b></td>
	<td><b> <?php echo $encabezado[0]->nombre_sucursal; ?></b></td>
	</tr>

	<tr>
	<td><b>Cajero:</b>  </td>
	<td> <b><?php echo $encabezado[0]->alias; ?></b> </td>
	</tr>

	<tr>
	<td><b>Terminal:</b>  </td>
	<td> <b><?php echo $terminal[0]->nombre." ". $terminal[0]->numero; ?></b> </td>
	</tr>

</table><br>

<table width="100%"><tr  style="border-top:1px dashed black; border-bottom:1px dashed black; text-align:center;"><td>Cantidad</td><td>Descripcion</td><td>Precio</td><td>Total <?php echo $moneda[0]->moneda_simbolo; ?></td></tr>
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
<tr><td><?php echo (int) $value->cantidad ?></td>
<td> <?php echo $value->descripcion ?></td>
<td><?php echo number_format($value->precioUnidad*$value->presentacionFactor,2) ?></td>
<td><?php echo number_format($value->total,1) ?></td></tr>
<?php
$var_total += $value->total ;
$productos_total+= $value->cantidad ; 
}

?>

<tr  style="border-top:1px dashed black;" >
<td colspan="3"></td>
<td colspan="1"> <?php echo number_format($var_total,2) ?> </td>
</tr>

</table>

<table>
    <tr>
      <td>G=GRAVADO || E=EXENTO</td>
      <td></td>
    </tr>
    <tr>
      <td>SUB TOTAL <?php echo $moneda[0]->moneda_simbolo; ?></td>
      <td> <?php echo number_format($var_total,2) ; ?> </td>
    </tr>
    <tr>
      <td>EXENTO <?php echo $moneda[0]->moneda_simbolo; ?></td>
      <td> <?php echo number_format($exento,2);   ?> </td>
    </tr>
    <tr>
      <td>GRAVADO <?php echo $moneda[0]->moneda_simbolo; ?></td>
      <td> <?php echo number_format($var_total,2);   ?> </td>
    </tr>
    <tr>
      <td>VENTAS NO SUJETAS <?php echo $moneda[0]->moneda_simbolo; ?></td>
      <td> <?php echo number_format($vns,2);   ?> </td>
    </tr>
    <tr>
      <td>CESC <?php echo $moneda[0]->moneda_simbolo; ?></td>
      <td> <?php echo number_format($cesc,2);   ?> </td>
    </tr>
    <tr>
      <td>TOTAL A PAGAR <?php echo $moneda[0]->moneda_simbolo; ?></td>
      <td> <?php echo number_format($var_total,2);   ?> </td>
    </tr>

   <tr  style="border-top:1px dashed black;" >
      <td>Numero de prodcutos </td>
      <td> <?php echo $productos_total; ?> </td>
    </tr>

<tr>
  <td colspan="2" style="text-align:center">
	<br>
	GRACIAS POR SU COMPRA<br>
	www.ibs.pos.com <br>
	Servicio Al cliente TEL: 72616977 <br>
	Para reclamos presentar este Ticket y su Documento de identidad Personal
 </td>
</tr>
  </table>
<?php            