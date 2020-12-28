<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* Call this file 'hello-world.php' */
require __DIR__ . '../../../vendor/autoload.php';

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\Printer;

class ReceiptPrint
{

  private $CI;
  private $connector;
  private $printer;

  // TODO: printer settings
  // Make this configurable by printer (32 or 48 probably)
  private $printer_width = 32;

  function __construct()
  {
    $this->CI = &get_instance(); // This allows you to call models or other CI objects with $this->CI->... 
  }

  function connect($ip_address, $port)
  {

    //$this->connector = new NetworkPrintConnector($ip_address, $port);
    //$this->connector = new FilePrintConnector("/dev/usb/lp0");
    //$this->connector = new WindowsPrintConnector("smb://192.168.0.6/POS-80");
    //$this->connector = new CupsPrintConnector("POS-80");
    //$this->printer = new Printer($this->connector);
    /* Close printer */

    /*$this->connector = new FilePrintConnector("php://stdout");
    $this->printer = new Printer($this->connector);
  */

      try {
        //$this->connector = new CupsPrintConnector("POS-80C");
        $this->connector = new WindowsPrintConnector("POSS-80");
        
        /* Print a "Hello world" receipt" */
        $this->printer = new Printer($this->connector);
        //$this->printer -> text("TE AMO MCUHO MI VIDA..!\n");
        //$this->printer -> cut();
        
        /* Close printer */
        //$this->printer -> close();
    } catch (Exception $e) {
        echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }
  }

  private function check_connection()
  {
    if (!$this->connector or !$this->printer or !is_a($this->printer, 'Mike42\Escpos\Printer')) {
      throw new Exception("Tried to create receipt without being connected to a printer.");
    }
  }

  public function close_after_exception()
  {
    if (isset($this->printer) && is_a($this->printer, 'Mike42\Escpos\Printer')) {
      $this->printer->close();
    }
    $this->connector = null;
    $this->printer = null;
    $this->emc_printer = null;
  }

  // Calls printer->text and adds new line
  private function add_line($text = "", $should_wordwrap = true)
  {
    $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
    $this->printer->text($text . "\n");
  }


  public function print_test_receipt($text = "")
  {
    
    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("TESTING");
    $this->add_line("Receipt Print");
    $this->printer->selectPrintMode();
    $this->add_line(); // blank line
    $this->add_line($text);
    $this->add_line(); // blank line
    $this->add_line(date('Y-m-d H:i:s'));
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->close();
  }

  public function ticket($data){

    $this->check_connection();

    $orden 		= $data['orden'][0];
    $detalle 	= $data['detalle'];
    $moneda 	= $data['moneda'][0]->moneda_simbolo;
    $pagos		= $data['pagos'];
    $impuestos	= $data['impuestos'];

	$fecha_autotizacion = date_create($orden->resol_fecha_caja);
	/** TITULOS TIQUETE */	  
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer -> setEmphasis(true);
    $this->printer -> text($orden->nombre_comercial."\n");
    $this->printer -> setEmphasis(false);
    $this->printer -> text("DIRECCION : "	. $orden->direccion ."\n");
    $this->printer -> text("GIRO : " 		. $orden->nombre_giro ."\n");
    $this->printer -> text("NIT : " 		. $orden->nit ."\n");
    $this->printer -> text("NRC : " 		. $orden->nrc ."\n");
    $this->printer -> text("RES # : " 		. $orden->resol_num_caja."\n");
    $this->printer -> text("RES AUT : " 	. date_format($fecha_autotizacion,"Y/m/d")."\n");
    $this->printer -> text("Serie : " 		. $orden->numero_de_serire ."\n");
    $this->printer -> text("Del " 			. $orden->valor_inical. " AL ".$orden->valor_final."\n");

    /** INFORMACION TIENDA Y TICKET */
    $this->printer -> text("SUCURSAL :" . $orden->nombre_sucursal."\n");
    $this->printer -> text("CAJERO :" . $orden->alias."\n");
    $this->printer -> text("CAJA : " . $orden->cod_interno_caja."\n");
    $this->printer -> text("TIQUETE : " . $orden->numero_de_serire." ".$orden->num_correlativo."\n");
    $this->printer -> text("INTERNO :" . $orden->id ."\n");
    $this->printer -> text($orden->fecha ."\n");
    $this->add_line();
    $total;
    $this->printer -> text("===============================================" ."\n");
    $this->printer->setJustification(Printer::JUSTIFY_LEFT);
    $this->printer->text($this->addSpaces('Cant', 10) . $this->addSpaces('Descripcion', 15) . $this->addSpaces('P.Unidad', 15) . $this->addSpaces('Total', 2) . $moneda. "\n");
    $this->printer -> text("===============================================" ."\n");
    $this->add_line();
  
  /** Productos */
  $total    = 0.00;
  $ns       = 0.00;
  $exento   = 0.00;
  $gravado  = 0.00;
  $sub_total= 0.00;
  $descuento= 0.00;
  $productos_cantidad = 0;
    foreach( $detalle as $value )
    {
    $prod_tipo = substr( $value->gen,0,1);
    
    if ( $prod_tipo =='G') {
      $gravado +=  $value->total;
    }else{
      $exento += $value->total;
    }
    $total += $value->total ;
    $productos_cantidad += $value->cantidad; 
    $descuento = $value->descuento_calculado;

    $this->printer -> text(substr( $value->descripcion,0,40)."\n");

    $items   = [];
    $items[] = [
      'cantidad'=> (int) $value->cantidad,
      'unidad'  => number_format($value->precioUnidad*$value->presentacionFactor,2),
      'total'   => number_format($value->total,2),
    ];

    $cantidad_lines;
    $unidad_lines;
    $total_lines;

    foreach ($items as $item) {

      $total_lines    = $this->addSpaces($item['unidad'], 10);

      $cantidad_lines = str_split($item['cantidad']."   X", 5);
      foreach ($cantidad_lines as $k => $l) {
        $l = trim($l);
        $cantidad_lines[$k] = $this->addSpaces($l, 25);
      }

      $unidad_lines = str_split($item['unidad'], 15);
      foreach ($unidad_lines as $k => $l) {
        $l = trim($l);
        $unidad_lines[$k] = $this->addSpaces($l, 15);
      }

      $total_lines = str_split($item['total'].$prod_tipo, 8);
      foreach ($total_lines as $k => $l) {
        $l = trim($l);
        $total_lines[$k] = $this->addSpaces($l, 2);
      }
    }

    $counter = 0;
    $temp = [];
    $temp[] = count($cantidad_lines);
    $temp[] = count($unidad_lines);
    $temp[] = count($total_lines);
    $counter = max($temp);

    for ($i = 0; $i < $counter; $i++) {
      $line = '';
      if (isset($cantidad_lines[$i])) {
        $line .= ($cantidad_lines[$i]);
      }
      if (isset($unidad_lines[$i])) {
        $line .= ($unidad_lines[$i]);
      }
      if (isset($total_lines[$i])) {
        $line .= ($total_lines[$i]);
      }
      $this->printer->text($line . "\n");
    }
  }

  $this->printer -> text("==============================================" ."\n");

  $gravado = number_format($gravado,2);
  $exento  = number_format($exento,2);
  $ns		 = number_format($ns,2);
  $descuento = number_format($descuento,2);
  
    $this->add_line();
    $this->printer -> text("G=GRAVADO | E=EXENTO | NS=NO SUJETO\n");
    $this->printer->setJustification(Printer::JUSTIFY_RIGHT);
    $this->printer->text(new item("SubTotal Exento",$moneda.$exento));
    $this->printer->text(new item("SubTotal Gravado",$moneda.$gravado));
  $this->printer->text(new item("SubTotal No Sujeto",$moneda.$ns));
  if ( $impuestos ) {
    foreach( $impuestos as $impuesto ) {
       if ( 
         ($impuesto->ordenImpName == 'IVA'  &&  $impuesto->ordenSimbolo !='E') || 
         ($impuesto->ordenImpName !='IVA'  )) 
      {
        //$valor_impuesto = number_format($impuesto->ordenImpTotal,2);
           //$this->printer->text(new item($impuesto->ordenImpName ,$moneda.$valor_impuesto));
         } 
      if ( $impuesto->ordenImpName != 'IVA'  ) {
        $valor_impuesto = number_format($impuesto->ordenImpTotal,2);
           $this->printer->text(new item($impuesto->ordenImpName ,$moneda.$valor_impuesto));
        $total = $total +$impuesto->ordenImpTotal;
      }
     }
   }
   $total   = number_format($total,2);

	$this->printer->text(new item("Descuento",$moneda.$descuento));
	$this->printer->text(new item("TOTAL",$moneda.$total));

	foreach($pagos as $pago) { 
		$this->printer -> text( new item( $pago->nombre_metodo_pago, $moneda.$pago->valor_metodo_pago));  
	}
	$this->printer -> text( new item('CAMBIO', $moneda.number_format($orden->dinero_cambio,2)));

	$this->printer -> text("===============================================" ."\n");
	$this->printer->text(new item("Cantidad Productos",$productos_cantidad));
  
	/** PIE DEL TICKET */
	$this->add_line();
	$this->printer ->setJustification(Printer::JUSTIFY_CENTER);
	$this->printer ->text("GRACIAS POR SU COMPRA"."\n");
	$this->printer ->text("www.ibs.pos.com"."\n");
	$this->printer ->text("Servicio Al cliente TEL: 72616977"."\n");
	$this->printer ->text("Para reclamos presentar este Ticket y su Documento de identidad Persona"."\n");

  	$this->printer -> cut();
  	$this->printer->pulse();
	$this->printer->close();
  }

  public function addSpaces($string = '', $valid_string_length = 0) {
    if (strlen($string) < $valid_string_length) {
        $spaces = $valid_string_length - strlen($string);
        for ($index1 = 1; $index1 <= $spaces; $index1++) {
            $string = $string . ' ';
        }
    }

    return $string;
  }



}

class item
{
    private $cantidad;
    private $name;
    private $precio;
    private $total;
    private $dollarSign;

    public function __construct($name = '', $total = '', $dollarSign = false)
    {
        $this -> name     = $name;
        $this -> total    = $total;
        $this -> dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols  = 38;

        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name .' '. $this->precio, $leftCols) ;

        $sign = ($this -> dollarSign ? '$ ' : '');
        $right = str_pad($sign . $this -> total, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}