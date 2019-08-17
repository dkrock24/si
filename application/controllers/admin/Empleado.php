<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleado extends CI_Controller {

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

	}

// Start  **********************************************************************************

	public function index(){

		//Paginacion
		$contador_tabla;
		$_SESSION['per_page'] = "";
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Empleado_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/empleado/index");
		$this->pagination->initialize($config);
		if($this->uri->segment(4)){
			if($_SESSION['per_page']!=0){
				$page = ($this->uri->segment(4) - 1 ) * $_SESSION['per_page'];
				$contador_tabla = $page+1;
			}else{
				$page = 0;
				$contador_tabla =1;
			}
		}else{
			$page = 0;
			$contador_tabla =1;
		}

		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );

		// paginacion End

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		//parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id =33; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['registros'] = $this->Empleado_model->getAllEmpleados( $config["per_page"], $page );
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['cargos']	= $this->Cargos_model->get_cargos();
		$data['empresa']	= $this->Empresa_model->getEmpresas();
		$data['sucursal_lista']	= $this->Empresa_model->getEmpresasWithSucursal2(1);
		
		$data['home'] = 'admin/empleado/e_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		$data = $this->Empleado_model->crear( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Empleado Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Empleado No Fue Creado");
		}	
		redirect(base_url()."admin/empleado/index");
	}

	public function editar($empleado_id){
		$sucursales = array();

		$data['empleado'] = $this->Empleado_model->getEmpleadoId( $empleado_id );

		$data['menu'] = $this->session->menu;
		$data['cargos']	= $this->Cargos_model->get_cargos();
		$data['empresa']	= $this->Empresa_model->getEmpresas();
		$data['sucursal']	= $this->Empresa_model->getEmpresasWithSucursal( $empleado_id);
		
		foreach ($data['sucursal'] as $value) {
			$sucursales[] = $value->id_sucursal;
		}

		$data['sucursal_lista']	= $this->Empresa_model->getEmpresasWithSucursal2($sucursales);
		$data['home'] = 'admin/empleado/e_editar';

		$this->general->editar_valido($data['empleado'], "admin/empleado/index");
		$this->parser->parse('template', $data);
	}

	public function update(){
		if(isset($_POST)){
			$data = $this->Empleado_model->update( $_POST );

			if($data){
				$this->session->set_flashdata('success', "Empleado Fue Actualizado");
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
			'Apellido','Nombre','Horas','Turno','Alias','Seccion', 'Puesto', 'Encargado','Sucursal','Cargo', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'primer_apellido_persona','primer_nombre_persona','horas_laborales_mensuales_empleado','turno','alias','seccion','puesto','encargado','nombre_sucursal','cargo_laboral','estado'
		);
		
		$fields['id'] = array('id_empleado');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Empleado Lista";

		return $fields;
	}
	

}

?>
