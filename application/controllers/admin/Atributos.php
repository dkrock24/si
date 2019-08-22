<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atributos extends CI_Controller {

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
		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
	}

// Start PAIS **********************************************************************************

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
		
		$total_row = $this->Atributos_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/atributos/index");
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


		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$id_rol = $this->session->roles[0];
		$vista_id = 10; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['registros'] = $this->Atributos_model->get_atributos(  $config["per_page"], $page );
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['title'] = "Atributos";
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['title'] = "Nuevo Atributo";	
		$data['home'] = 'admin/atributos/atributos_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert pais
		$this->Atributos_model->crear_atributo( $_POST );

		redirect(base_url()."admin/atributos/index");
	}

	public function editar( $id_prod_atributo ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;		
		$data['atributo'] = $this->Atributos_model->get_atributo_id( $id_prod_atributo );
		$data['title'] = "Editar Atributo";	
		$data['home'] = 'admin/atributos/atributos_editar';

		$this->parser->parse('template', $data);
	}

	public function eliminar($id){
		$data['atributo'] = $this->Atributos_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('warning', "Atributo Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Atributo No Fue Eliminado");
		}	
		redirect(base_url()."admin/atributos/index");
	}

	public function actualizar(){
		// Insert pais
		$data['atributos'] = $this->Atributos_model->actualizar_atributo( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Atributo Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Atributo No Fue Actualizado");
		}

		redirect(base_url()."admin/atributos/index");
	}

	public function column(){

		$column = array(
			'Nombre','Tipo','Creado','Actualizado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nam_atributo','tipo_atributo','creado_atributo','actualizado_atributo','estado'
		);
		
		$fields['id'] = array('id_prod_atributo');
		$fields['estado'] = array('estado_atributo');
		$fields['titulo'] = "Atributos Lista";

		return $fields;
	}

}

?>
