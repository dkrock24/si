<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleado extends MY_Controller {

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
		$this->load->library('../controllers/general');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Giros_model');  
		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Roles_model');
		$this->load->model('admin/Persona_model');
		$this->load->model('admin/Empleado_model');
		$this->load->model('admin/Empresa_model');
		$this->load->model('admin/Cargos_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('admin/Turnos_model');	

	}

// Start  **********************************************************************************

	public function index(){

		$this->abc();

		$model 		= "Empleado_model";
		$url_page 	= "admin/empleado/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 33);
		
		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] 		= $this->Empleado_model->getAllEmpleados( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Empleados";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		//$this->parser->parse('template', $data);
		$data = $this->load->view('template/lista_template',$data, TRUE);
		echo $data;
	}

	function abc(){
		return 5;
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['cargos']	= $this->Cargos_model->get_cargos();
		$data['empresa']	= $this->Empresa_model->getEmpresaOnly();
		$data['sucursal_lista']	= $this->Empresa_model->getEmpresasWithSucursal2(0);
		$data['turnos'] = $this->Turnos_model->getTurnos();
		$data['title'] = "Crear Empleado";
		$data['home'] = 'admin/empleado/e_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		$data = $this->Empleado_model->crear( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Empleado Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Empleado No Fue Creado");
		}
		redirect(base_url()."admin/usuario/nuevo");
	}

	public function editar($empleado_id){
		$sucursales = array();

		$data['empleado'] = $this->Empleado_model->getEmpleadoId( $empleado_id );
		$this->general->editar_valido($data['empleado'], "admin/empleado/index");
		$data['encargado'] = $this->Empleado_model->getEncargado( $data['empleado'][0]->encargado );

		$data['menu'] = $this->session->menu;
		$data['cargos']	= $this->Cargos_model->get_cargos();
		$data['empresa']	= $this->Empresa_model->getEmpresaOnly();
		$data['sucursal']	= $this->Empresa_model->getEmpresasWithSucursal( $empleado_id);
		$data['title'] = "Editar Empleado";
		if($data['sucursal']){
			foreach ($data['sucursal'] as $value) {
				$sucursales[] = $value->id_sucursal;
			}
		}
		
		if($sucursales){
			$data['sucursal_lista']	= $this->Empresa_model->getEmpresasWithSucursal2($sucursales);
		}else{
			$data['sucursal_lista']	= $this->Empresa_model->getEmpresasWithSucursal2(1);
		}
		
		$data['home'] = 'admin/empleado/e_editar';

		$this->general->editar_valido($data['empleado'], "admin/empleado/index");
		$this->parser->parse('template', $data);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/empleado/index");
		}

		$data['title'] = "Ver";

		$data['home'] = 'template/ver_general';

		$data['menu'] = $this->session->menu;		

		$data['data'] = $this->Empresa_model->getEmpresasWithSucursal( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );
				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/empleado/index");
		}

	}

	public function update(){
		if(isset($_POST)){
			$data = $this->Empleado_model->update( $_POST );

			if(!$data['code']){
				$this->session->set_flashdata('info', "Empleado Fue Actualizado");
			}else{
				$this->session->set_flashdata('danger', "Empleado No Fue Actualizado");
			}
		}
		redirect(base_url()."admin/empleado/index");
	}

	public function get_persona(){
		$data['persona']	= $this->Persona_model->getAllPersona();
		echo json_encode($data);
	}

	public function validar_persona( $id_persona ){

		$data = 0;
		$data = $this->Empleado_model->validar_persona( $id_persona );
		if($data){
			$data = 1;
		}
		echo $data;
	}

	public function get_sucursal( $id_empresa ){
		$data['sucursal']	= $this->Sucursal_model->getSucursalEmpresa($id_empresa);
		echo json_encode($data);
	}

	public function column(){

		$column = array(
			'Sucursal','Apellido','Nombre','Cargo','Horas','Turno','Alias','Seccion', 'Puesto','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_sucursal' => 'Sucursal'],
			['primer_apellido_persona' => 'Apellido'],
			['primer_nombre_persona' => 'Nombre'],
			['cargo_laboral' => 'Cargo'],
			['horas_laborales_mensuales_empleado' => 'Horas'],
			['turno' => 'Turno'],
			['alias' => 'Alias'],
			['seccion' => 'Seccion'],
			['puesto' => 'Puesto'],
			//['encargado' => 'Encargado'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_empleado');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Empleado Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
	

}

?>
