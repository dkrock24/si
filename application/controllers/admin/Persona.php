<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');    

		$this->load->helper('url');
		$this->load->library('../controllers/general');
		$this->load->helper('seguridad/url_helper');
		$this->load->model('accion/Accion_model');	
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Terminal_model');
		$this->load->model('admin/Giros_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/ModoPago_model');
		$this->load->model('admin/Ciudad_model');
		$this->load->model('admin/Sexo_model');
		$this->load->model('admin/Persona_model');
		$this->load->model('producto/Producto_model');				
		$this->load->model('producto/Orden_model');
		$this->load->model('producto/Bodega_model');
	}

	public function index()
	{
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
		
		$total_row = $this->Persona_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/persona/index");
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

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 2; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['contador_tabla'] = $contador_tabla;
		$data['registros'] = $this->Persona_model->getPersona( $config["per_page"], $page );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'template/lista_template';
		$data['title'] = 'Lista Personas';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['sexo'] = $this->Sexo_model->getSexo();
		$data['ciudad'] = $this->Ciudad_model->getDepartamento();
		$data['home'] = 'admin/persona/persona_nuevo';
		$data['title'] = 'Crear Personas';

		$this->parser->parse('template', $data);
	}

	public function crear(){

		$data = $this->Persona_model->crear( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Persona Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Persona No Fue Creado");
		}

		redirect(base_url()."admin/persona/index");
	}

	public function editar( $persona_id ){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$data['menu'] 	= $this->session->menu;		
		$data['persona']= $this->Persona_model->getPersonaId( $persona_id );
		$data['sexo'] 	= $this->Sexo_model->getSexo();
		$data['ciudad'] = $this->Ciudad_model->getCiudad();
		$data['ciudad2'] = $this->Ciudad_model->getCiudadId( $data['persona'][0]->id_departamento );
		$data['title'] = 'Editar Personas';

		$data['home'] 	= 'admin/persona/persona_editar';

		$this->general->editar_valido($data['persona'], "admin/persona/index");

		$this->parser->parse('template', $data);
	}

	public function update(){

		$data['bodegas'] = $this->Persona_model->update( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Persona Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Persona No Fue Actualizado");
		}

		redirect(base_url()."admin/persona/index");
	}

	function eliminar($id){

		$data['bodegas'] = $this->Persona_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('warning', "Persona Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Persona No Fue Eliminado");
		}

		redirect(base_url()."admin/persona/index");
	}

	public function getCiudadId( $departamento_id ){

		$data['ciudad'] = $this->Ciudad_model->getCiudadId( $departamento_id );
		echo json_encode($data);
	}

	public function column(){

		$column = array(
			'P.Nombre','S.Nombre','P.Apellido','S.Apellido','DUI','NIT','Direccion','Tel', 'Whatsapp' ,'Sexo','Ciudad', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'primer_nombre_persona','segundo_nombre_persona','primer_apellido_persona','segundo_apellido_persona','dui','nit','direccion_residencia_persona1','tel','whatsapp','sexo','nombre_ciudad','estado'
		);
		
		$fields['id'] = array('id_persona');
		$fields['estado'] = array('persona_estado');
		$fields['titulo'] = "Persona Lista";

		return $fields;
	}
}