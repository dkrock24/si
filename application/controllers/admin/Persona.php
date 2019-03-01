<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');
		$this->load->model('accion/Accion_model');	

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
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['persona'] = $this->Persona_model->getPersona();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'admin/persona/persona_lista';

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
		$data['ciudad'] = $this->Ciudad_model->getCiudad();

		$data['home'] = 'admin/persona/persona_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){

		$this->Persona_model->crear( $_POST );

		redirect(base_url()."admin/persona/index");
	}

	public function editar( $persona_id ){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		//$id_rol = $this->session->roles[0];
		//$vista_id = 8; // Vista Orden Lista
		//$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );

		$data['menu'] 	= $this->session->menu;		
		$data['persona']= $this->Persona_model->getPersonaId( $persona_id );
		$data['sexo'] 	= $this->Sexo_model->getSexo();
		$data['ciudad'] = $this->Ciudad_model->getCiudad();
		$data['ciudad2'] = $this->Ciudad_model->getCiudadId( $data['persona'][0]->id_departamento );

		$data['home'] 	= 'admin/persona/persona_editar';

		$this->parser->parse('template', $data);
	}

	public function update(){

		$data['bodegas'] = $this->Persona_model->update( $_POST );

		redirect(base_url()."admin/persona/index");
	}

	public function getCiudadId( $departamento_id ){

		$data['ciudad'] = $this->Ciudad_model->getCiudadId( $departamento_id );
		echo json_encode($data);
	}
}