<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends My_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    @$this->load->library('session');	 
	     $this->load->library('pagination');     

		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

        $this->load->model('admin/Reporte_model');  
		$this->load->model('admin/Turnos_model');  
		$this->load->model('admin/Sucursal_model');  
        $this->load->model('admin/Usuario_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Caja_model');
		$this->load->model('accion/Accion_model');
	}

// Start Report **********************************************************************************

	public function index(){

        $data['turno'] 		= $this->Turnos_model->getTurnos();
		$data['cajero'] 	= $this->Usuario_model->get_cajeros('Cajero');
		$data['sucursal'] 	= $this->Sucursal_model->getSucursal();

        if( isset( $_POST['fecha_i'])){
            
            $filters = array(
                'fh_inicio' => $_POST['fecha_i'],
                'fh_fin'    => $_POST['fecha_f'],
				'sucursal'  => $_POST['sucursal'],
				'turno'     => $_POST['turno'],
				'cajero'    => $_POST['cajero'],
				'caja'		=> $_POST['caja']
			);
			$data['filters'] 	= $filters;    
			$info 			= $this->Reporte_model->filtrar_venta($filters);
			$data['registros']  = $info;

			if ($info) {
				$this->session->set_flashdata('reporte', "Reporte Generado");
			} else {
				$this->session->set_flashdata('reporte', "Reporte Sin Registros : ");
			}

        } else {
			$data['registros'] 	= 1;
			$data['filters'] 	= array(
				'fh_inicio' => date('Y-m-d'),
				'fh_fin'    => date('Y-m-d'),
				'sucursal'  => 0,
				'turno'     => 0,
				'cajero'    => 0,
				'caja'		=> 0,
			);
		}

		$data['fields']	= $this->fields();
		$data['column']	= $this->column();
		$data['menu'] 	= $this->session->menu;
		$data['moneda'] = $this->session->empresa[0]->moneda_simbolo;
        $data['title'] 	= 'Reportes';
		$data['home'] 	= 'admin/reporte/index';
		
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$data = $this->load->view('admin/reporte/index',$data, TRUE);
		echo $data;
	}

	public function change_caja($sucursal){
		$data['caja'] = $this->Caja_model->getCajaSucursal($sucursal);
		echo json_encode($data);
	}

	public function concentrado(){

		$data['turno'] 		= $this->Turnos_model->getTurnos();
		$data['cajero'] 	= $this->Usuario_model->get_cajeros('Cajero');
		$data['sucursal'] 	= $this->Sucursal_model->getSucursal();

        if( isset( $_POST['fecha_i'])){
            
            $filters = array(
                'fh_inicio' => $_POST['fecha_i'],
                'fh_fin'    => $_POST['fecha_f'],
				'sucursal'  => $_POST['sucursal'],
				'turno'     => $_POST['turno'],
				'cajero'    => $_POST['cajero'],
				'caja'		=> 0,
			);
			$data['filters'] = $filters;
    
            $data['registros'] = $this->Reporte_model->concentrado($filters);
        }else{
			$data['registros'] = 1;

			$data['filters'] = array(
				'fh_inicio' => date('Y-m-d'),
				'fh_fin'    => date('Y-m-d'),
				'sucursal'  => 0,
				'turno'     => 0,
				'cajero'    => 0,
				'caja'		=> 0,
			);
		}

		$data['fields']	= $this->fields();
		$data['menu'] 	= $this->session->menu;
		$data['moneda'] = $this->session->empresa[0]->moneda_simbolo;
        $data['title'] 	= 'Reportes';
		$data['home'] 	= 'admin/reporte/concentrado';
		
		$_SESSION['Vista']     = $data['title'];
		$_SESSION['registros'] = $data['registros'];

		$data = $this->load->view('admin/reporte/concentrado',$data, TRUE);
		echo $data;
	}
	
	public function cortez(){

		if(!isset($_SESSION['corteUnico'])){
			$_SESSION['corteUnico'] = 0;
		}

		$data['turno'] 		= $this->Turnos_model->getTurnos();
		$data['cajero'] 	= $this->Usuario_model->get_cajeros('Cajero');
		$data['sucursal'] 	= $this->Sucursal_model
								->getSucursalByEmployee($this->session->usuario[0]->Empleado);

		$cortar = false;
		$data['corteUnico'] = $_SESSION['corteUnico'];
		if(isset($_POST['corteValido'])){
			//if($_SESSION['corteUnico'] == 0){
				$_SESSION['corteUnico'] = 1;
				$cortar = true;
				$data['corteUnico'] = $_SESSION['corteUnico'];
			//}
		}
		
		$data['showModal'] = 0;
		
        if( isset( $_POST['fecha_i'])){
            
            $filters = array(
                'fh_inicio' => $_POST['fecha_i'],
                'fh_fin'    => $_POST['fecha_f'],
				'sucursal'  => $_POST['sucursal'],
				'turno'     => $_POST['turno'],
				'cajero'    => $_POST['cajero'],
				'caja'		=> $_POST['caja'],
			);
			$data['filters'] = $filters;
    
			$data['registros'] = $this->Reporte_model->concentrado($filters);

			//Si hay data a cortar, que realize el corte
			if($data['registros'])
			{
				$corte = $this->Reporte_model->concentrado_corte( $filters, $cortar );

				unset($corte->logo_empresa);
				unset($corte->img);
				unset($corte->img_empleado);
				$data['corte'] = (array) $corte;

				//var_dump($data['corte']['corteId']);
				//die;

				if(isset($data['corte']['corteId'])){
					$data['showModal'] = 1;

					$data['detalle'] 	= $this->Reporte_model->corte_detalle($corte->corteId);
					//var_dump($data['detalle']);
					//die;
					$data['temp'] 		= $this->Reporte_model->template( $corte );
					$name 		  		= $corte->Sucursal.'_'.$corte->Caja;
					$data['file'] 		= $name;
					$data['msj_title'] 	= "Corte Procesado";
					$data['msj_orden'] 	= "Su número de transacción es: # ". $corte->num_correlativo;
					$this->generarDocumento( $name , $data['temp'][0]->factura_template );
				}
			}
			
        }else{
			$data['registros'] = 1;

			$data['filters'] = array(
				'fh_inicio' => date('Y-m-d'),
				'fh_fin'    => date('Y-m-d'),
				'sucursal'  => 0,
				'turno'     => 0,
				'cajero'    => 0,
				'caja'		=> 0,
			);
		}

		$data['fields'] 	= $this->fields();
		$data['menu'] = $this->session->menu;
		$data['moneda'] = $this->session->empresa[0]->moneda_simbolo;
		$data['title'] 	= 'Reportes';
		$data['home'] 	= 'admin/reporte/cortez';
		$data = $this->load->view('admin/reporte/cortez',$data, TRUE);
		echo $data;
	}

	public function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );
	}

	public function export2(){

		$column = array(
			'Nombre','Inicial','Final','C. Devolucion','Σ Devolucion',
			'Descuento','Monto','Σ Efectivo','Σ TCredito','Σ Cheque','Credito'
		);

		$fields = $this->fields();

		$original_registros = $_SESSION['registros'];

		$suma_cheque            =0.00;
		$suma_credito           =0.00;
		$suma_tcredito          =0.00;
		$suma_efectivo          =0.00;
		$suma_descuento         =0.00;
		$suma_devolucion        =0.00;
		$total_devolucion       =0;
		$cantidad_devolucion    =0.00;

		if( $_SESSION['registros'] != 1 ) {
			
			foreach ($_SESSION['registros'] as $key => $value) {
				$cantidad_devolucion    += $value->total_devolucion;
				$total_devolucion       += $value->total_devolucion;
				$suma_devolucion        += number_format($value->sum_devolucion,2) * (-1);
				$suma_descuento         += number_format($value->descuento,2);
				$suma_efectivo          += $value->efectivo;
				$suma_tcredito          += number_format($value->tcredito,2);
				$suma_cheque            += number_format($value->cheque,2);
				$suma_credito           += number_format($value->cheque,2);
			}
			
			$total_registros = array(
				"id" 				=> "" ,
				"num_correlativo" 	=> "",
				"fh_inicio" 		=> "",
				"id_cliente" 		=> "",
				"total_doc" 		=> "",
				"nombre" 			=> "TOTALES",
				"inicio" 			=> "",
				"fin" 				=> "",
				"total_devolucion"  => $total_devolucion,
				"sum_devolucion" 	=> $suma_devolucion,
				"descuento" 		=> $suma_descuento,
				"efectivo" 			=> $suma_efectivo,
				"tcredito" 			=> $suma_tcredito,
				"cheque" 			=> $suma_cheque,
				"credito" 			=> $suma_credito,
				"nombre_empresa_o_compania" => "",
				"nombre_metodo_pago" 		=> "",
				"orden_estado_nombre" 		=> ""
			);
			$original_registros[] = (object) $total_registros;

			$this->xls( $original_registros , $_SESSION['Vista'] ,$column, $fields  );
		}
	}

	public function column(){

		$column = array(
			'Id','Sucursal','Nombre','Correlativo','Empresa','Cliente','Pago','Fecha','Total','Estado'
		);
		return $column;
	}
	
	public function fields(){
		
		$fields['field'] = array(
			['nombre'	=> 'Documento'],
			['inicio'	=> 'Inicio'],
			['fin' 		=> 'Fin'],
			['total_devolucion' => 'Total Devolucion'],
			['sum_devolucion' 	=> 'Suma Devolucion'],
			['descuento'=>'Descuento'],
			['descuento'=> 'Descuento'],
			['efectivo' => 'Efectivo'],
			['tcredito' => 'T.Credito'],
			['cheque' 	=> 'Cheque'],
			['credito' 	=> 'Crdito']
		);
		
		$fields['id'] 		= array('id');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Reporte - Ventas";

		return $fields;
	}

	public function cleanCorte(){
		unset($_SESSION['corteUnico']);
		var_dump($_SESSION['corteUnico']);
	}
}
