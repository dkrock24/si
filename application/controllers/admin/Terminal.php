<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terminal extends MY_Controller {

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
	    $this->load->library('../controllers/general');
		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Terminal_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('accion/Accion_model');	
		$this->load->model('admin/Caja_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/Impresor_model');
	}

// Start  **********************************************************************************

	public function index(){

		$model = "Terminal_model";
		$url_page = "admin/terminal/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 34);

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );
		$data['registros'] 		= $this->Terminal_model->get_all_terminal( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Terminales";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$data['title'] 		= "Nueva Terminal";
		$data['menu'] 		= $this->session->menu;	
		$data['home'] 		= 'admin/terminal/t_nuevo';
		$data['caja'] 		= $this->Caja_model->get_caja_empresa();
		$data['sucursal'] 	= $this->Sucursal_model->getAllSucursalEmpresa();
		$data['usuario'] 	= $this->Usuario_model->get_usuarios_sucursal();

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert Nuevo Usuario
		$data = $this->Terminal_model->crear( $_POST );

		$documentos = $this->Documento_model->getAllDocumento();
		$terminales = $this->Terminal_model->get_terminal_lista();
		$impresores = $this->Impresor_model->get_all_impresor();

		$this->Impresor_model->procesar_impresor_terminal_documento($impresores, $documentos , $terminales);

		if(!$data['code']){
			$this->session->set_flashdata('success', "Terminal Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Terminal No Fue Creado : ". $data['message']);
		}	
		redirect(base_url()."admin/terminal/index");
	}


	public function editar( $terminal_id ){
		
		$data['menu'] 		= $this->session->menu;
		$data['caja'] 		= $this->Caja_model->get_caja_empresa();
		$data['sucursal'] 	= $this->Sucursal_model->getAllSucursalEmpresa();
		$data['usuario'] 	= $this->Usuario_model->get_usuarios_sucursal();		
		$data['terminal'] 	= $this->Terminal_model->get_terminal( $terminal_id );
		$data['title'] 		= "Editar Terminal";
		$data['home'] 		= 'admin/terminal/t_editar';

		//$this->general->editar_valido($data['cargo'], "admin/cargo/index");

		$this->parser->parse('template', $data);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/terminal/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Terminal_model->get_terminal( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/terminal/index");
		}

	}

	public function update(){

		if(isset($_POST)){
			$data = $this->Terminal_model->update( $_POST );
			
			if(!$data['code']){
				$this->session->set_flashdata('info', "Terminal Fue Actualizado");
			}else{
				$data = $this->db_error_format($data);
				$this->session->set_flashdata('danger', "Terminal No Fue Actualizado : ". $data['message']);
			}
		}
		redirect(base_url()."admin/terminal/index");
	}

	public function eliminar($id){
		
		$data = $this->Terminal_model->eliminar( $id );

		$params = array(
			'terminal_id' => $id,
		);

		$this->Impresor_model->eliminar_impresor_terminar( $params );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Terminal Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Terminal No Fue Eliminado : ". $data['message']);
		}

		redirect(base_url()."admin/terminal/index");
	}

	public function asociar( $id_terminal ){

		$data['menu'] 		= $this->session->menu;
		$data['terminal'] 	= $this->Terminal_model->get_terminal( $id_terminal );
		$data['terminal_usuario'] = $this->Terminal_model->get_terminal_users( $id_terminal );
		$data['impresores']	= $this->Impresor_model->get_impresor_terminal();
		$data['usuario'] 	= $this->Terminal_model->get_users( );		
		$data['title'] 		= "Terminal Usuarios";
		$data['home'] 		= 'admin/terminal/t_asociar';

		$this->parser->parse('template', $data);
	}

	public function agregar(){
		$data = $this->Terminal_model->agregar_usuario( $_POST );
	}

	public function impresor_estado() {
		$data = $this->Impresor_model->impresor_estado( $_POST );
		echo $data;
	}

	public function impresor_principal() {
		$data = $this->Impresor_model->impresor_principal( $_POST );
		echo $data;
	}

	public function inactivar(){		
		$data = $this->Terminal_model->eliminar_usuario( $_POST );
	}

	public function column(){
		$column = array(
			'Sucursal','Nombre','Caja','Numero','Ubicacion','Modelo','Serie','Marca','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_sucursal' => 'Sucursal'],
			['nombre' => 'Nombre'],
			['nombre_caja' => 'Caja'],
			['numero' => 'Número'],
			['ubicacion' => 'Ubicación'],
			['modelo' => 'Modelo'],
			['series' => 'Serie'],
			['marca' => 'Marca'],
			['orden_estado_nombre' => 'Estado'],
		);
		
		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_terminal');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Terminal Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'], $_SESSION['Vista'] ,$column, $fields  );

	}
}

?>
