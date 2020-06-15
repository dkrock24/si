<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends My_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

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

			if($info){
				$this->session->set_flashdata('reporte', "Reporte Generado");
			}else{
				$this->session->set_flashdata('reporte', "Reporte Sin Registros : ");
			}

        }else{
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
		$data['menu'] 	= $this->session->menu;
		$data['moneda'] = $this->session->empresa[0]->moneda_simbolo;
        $data['title'] 	= 'Reportes';
		$data['home'] 	= 'admin/reporte/index';
		
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
	}

	public function change_caja($sucursal){
		$data['caja']		= $this->Caja_model->getCajaSucursal($sucursal);
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

		$data['fields'] 	= $this->fields();
		$data['menu'] = $this->session->menu;
		$data['moneda'] = $this->session->empresa[0]->moneda_simbolo;
        $data['title'] = 'Reportes';
		$data['home'] = 'admin/reporte/concentrado';
		
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];

		$this->parser->parse('template', $data);
	}

	public function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );
	}

	public function column(){

		$column = array(
			'id','nombre','num_correlativo','nombre_empresa_o_compania','orden_estado_nombre'
		);
		return $column;
	}
	
	public function fields(){
		
		$fields['field'] = array(
			'id','nombre','num_correlativo','nombre_empresa_o_compania','orden_estado_nombre'
		);
		
		$fields['id'] 		= array('id');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Reporte - Ventas";

		return $fields;
	}
}
?>
