<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona extends MY_Controller {

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

		$model = "Persona_model";
		$url_page = "admin/persona/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 36);

		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();

		$data['registros'] = $this->Persona_model->getPersona( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']);
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );
		$data['home'] = 'template/lista_template';
		$data['title'] = 'Lista Personas';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles;
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

		redirect(base_url()."admin/empleado/nuevo");
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