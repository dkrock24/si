<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursal extends MY_Controller {

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

		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('admin/Empresa_model');
		$this->load->model('admin/Ciudad_model');
	}

// Start  **********************************************************************************

	public function index(){

		$model 		= "Sucursal_model";
		$url_page 	= "admin/sucursal/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 31);		

		$data['menu'] 		= $this->session->menu;
		$data['links'] 		= $pag['links'];
		$data['filtros'] 	= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] 		= $this->Sucursal_model->getAllSucursal( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Sucursales";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['Vista']  	= $data['title'];
		$_SESSION['registros']  = $data['registros'];

		$this->parser->parse('template', $data);

	}

	public function nuevo(){

		$data['menu'] 	= $this->session->menu;		
		$data['empresa']= $this->Empresa_model->getEmpresaOnly();
		$data['ciudad'] = $this->Ciudad_model->getCiudad();
		$data['title'] 	= "Nueva Sucursal";
		$data['home'] 	= 'admin/sucursal/sucursal_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){

		$data = $this->Sucursal_model->crear_sucursal( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Sucursal Fue Creada");
		}else{
			$this->session->set_flashdata('danger', "Sucursal No Fue Creada : ". $data['message']);
		}	

		redirect(base_url()."admin/sucursal/index");
	}

	public function editar( $sucursla_id ){
		
		$data['menu'] 		= $this->session->menu;		
		$data['sucursal'] 	= $this->Sucursal_model->getSucursalId( $sucursla_id );
		$data['empresa'] 	= $this->Empresa_model->getEmpresaOnly();
		$data['ciudad'] 	= $this->Ciudad_model->getCiudad();
		$data['title'] 		= "Editar Sucursal";
		$data['home'] 		= 'admin/sucursal/sucursal_editar';

		$this->general->editar_valido($data['sucursal'], "admin/sucursal/index");

		$this->parser->parse('template', $data);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/sucursal/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Sucursal_model->getSucursalId( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/sucursal/index");
		}
	}

	public function update(){

		$data = $this->Sucursal_model->actualizar( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Sucursal Fue Actualizada");
		}else{
			$this->session->set_flashdata('danger', "Sucursal No Fue Actualizada : ". $data['message']);
		}
		redirect(base_url()."admin/sucursal/index");
	}

	public function eliminar($id){
		$data = $this->Sucursal_model->delete( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Sucursal Fue Eliminada");
		}else{
			$this->session->set_flashdata('danger', "Sucursal No Fue Eliminada : ". $data['message']);
		}
		redirect(base_url()."admin/sucursal/index");
	}

	public function column(){

		$column = array(
			'Empresa','Pais','Sucursal','Departamento','Municipio','Direccion','Telefono','Celular','Encargado','Codigo','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_comercial' => 'Empresa'],
			['nombre_pais' 		=> 'Pais'],
			['nombre_sucursal' 	=> 'Sucursal'],
			['nombre_departamento' => 'Departamento'],
			['nombre_ciudad' 	=> 'Municipio'],
			['direct' 			=> 'Dirección'],
			['tel' 				=> 'Telefono'],
			['cel' 				=> 'Celular'],
			['encargado_sucursal' => 'Encargado'],
			['codigo_sucursal' => 'Codigo'],
			['orden_estado_nombre'=> 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_sucursal');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Sucursales Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
	

}

?>
