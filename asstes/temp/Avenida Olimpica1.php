<?php     
         $limit_documento = $temp[0]->factura_lineas;
        $cnt = count($orden_detalle);
        $limit = 0;

        if( $cnt % $limit_documento ==0 ){
             $limit = $cnt / $limit_documento;
        }else{
             $limit = (int) ($cnt / $limit_documento)+1;
        }

$actual = 1;
        for ($i=0; $i < $limit ; $i++) { 
            $contador = 1; 

 ?>
<br>
<div class="documento">
<a href="#" class="btn btn-danger" style="float:right"><i class="fa fa-print"></i> Imprimir</a>
<table width="100%">
	<tr style="border-top:1px dashed black;">
	<td><b><?php echo $orden[0]->nombre_comercial ?></b></td>
	</tr>

	<tr>
	<td><b>Direccion: <?php echo $orden[0]->direccion ?></b></td>
	</tr>

	<tr>
	<td><b>Giro : <?php echo $orden[0]->giro ?></b></td>
	</tr>

       <tr>
	<td><b>Orden N° : <?php echo $orden[0]->num_correlativo ?></b></td>
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
	<td><b> <?php echo $orden[0]->nombre_sucursal; ?></b></td>
	</tr>

	<tr>
	<td><b>Cajero:</b>  </td>
	<td> <b><?php echo $orden[0]->primer_nombre_persona." ".$orden[0]->segundo_nombre_persona; ?></b> </td>
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
foreach($orden_detalle as $key => $value){

$key = $key+1;
                if ( $key >= $actual && $contador <= $limit_documento ){

                 $actual = $key+1;
                 
                    $contador++;

?>
<tr><td><?php echo (int) $value->cantidad ?></td>
<td> <?php echo $value->descripcion ?></td>
<td><?php echo number_format($value->precioUnidad*$value->presentacionFactor,2) ?></td>
<td><?php echo number_format($value->total,1) ?></td></tr>
<?php
$var_total += $value->total ;
$productos_total+= $value->cantidad ; 
}
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
</div>
 
<?php

}
?>