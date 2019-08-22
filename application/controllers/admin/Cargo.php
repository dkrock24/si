<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargo extends CI_Controller {

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

		$this->load->model('admin/Cargos_model');  
		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Roles_model');
		$this->load->model('admin/Persona_model');
		$this->load->model('admin/Empleado_model');
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
		
		$total_row = $this->Cargos_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/cargo/index");
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
		$vista_id = 30; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['registros'] = $this->Cargos_model->get_all_cargo( $config["per_page"], $page );
		$data['title'] = "Cargos Laborales";
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['title'] = "Nuevo Cargo Laboral";
		$data['home'] = 'admin/cargo/c_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert Nuevo Usuario
		$data = $this->Cargos_model->crear_cargo( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Cargo Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Cargo No Fue Creado");
		}	
		redirect(base_url()."admin/cargo/index");
	}


	public function editar( $cargo_id ){
		
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		
		$data['cargo'] = $this->Cargos_model->get_cargo_id( $cargo_id );
		$data['title'] = "Editar Cargo Laboral";
		$data['home'] = 'admin/cargo/c_editar';

		$this->general->editar_valido($data['cargo'], "admin/cargo/index");

		$this->parser->parse('template', $data);
	}

	public function update(){
		if(isset($_POST)){
			$data = $this->Cargos_model->update( $_POST );
			if($data){
				$this->session->set_flashdata('success', "Cargo Fue Actualizado");
			}else{
				$this->session->set_flashdata('warning', "Cargo No Fue Actualizado");
			}
		}
		redirect(base_url()."admin/cargo/index");
	}

	public function actualizar(){
		// Actualizar Giro 
		$data = $this->Giros_model->actualizar_giro( $_POST );

		if($data){
			$this->session->set_flashdata('info', " !");
		}else{
			$this->session->set_flashdata('warning', "El Registro No Fue Actualizado");
		}

		redirect(base_url()."admin/giros/index");
	}

	public function eliminar($id){
		// Actualizar Giro 
		$data = $this->Cargos_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('success', "Cargo Fue Eliminado");
		}else{
			$this->session->set_flashdata('warning', "Cargo Fue Eliminado");
		}

		redirect(base_url()."admin/cargo/index");
	}

	public function get_atributos( $id_giro ){

		$data['atributos'] = $this->Atributos_model->geAllAtributos();
		$data['atributos_total'] = $this->Atributos_model->get_atributos_total();
		$data['giro'] = $this->Giros_model->get_giro_id( $id_giro );
		$data['plantilla'] = $this->Giros_model->get_plantilla( $id_giro );
		$data['plantilla_giro_total'] = $this->Giros_model->get_total_plantilla_giro( $id_giro );

		echo json_encode( $data );
		//echo json_encode( $giro );
	}

	public function guardar_giro_atributos(){

		$this->Giros_model->insert_plantilla( $_POST );

		$data['plantilla'] = $this->Giros_model->get_plantilla( $_POST['giro'] );
		$data['plantilla_giro_total'] = $this->Giros_model->get_total_plantilla_giro( $_POST['giro']  );
		
		echo json_encode( $data );
		
	}

	public function eliminar_giro_atributos(){
		$this->Giros_model->eliminar_plantilla( $_POST );

		$data['plantilla'] = $this->Giros_model->get_plantilla( $_POST['giro'] );
		$data['plantilla_giro_total'] = $this->Giros_model->get_total_plantilla_giro( $_POST['giro']  );
		
		echo json_encode( $data );
	}

	// GIROS EMPRESA

	public function listar_giros(){
		$data['lista_giros'] = $this->Giros_model->getAllgiros();
		$data['lista_empresa'] = $this->Giros_model->get_empresa2();

		echo json_encode( $data );
	}

	public function guardar_giro_empresa(){
		$this->Giros_model->insert_giro_empresa( $_POST );
	}

	public function get_empresa_giro( $id_empresa ){
		$data['lista_giros'] = $this->Giros_model->get_empresa_giro( $id_empresa );
		$data['empresa_giro_total'] = $this->Giros_model->get_total_empresa_giro( $id_empresa );

		echo json_encode( $data );
	}

	public function eliminar_giro_empresa(){
		$this->Giros_model->eliminar_giro_empresa( $_POST );

		$data['lista_giros'] = $this->Giros_model->get_empresa_giro( $_POST['empresa']  );
		$data['empresa_giro_total'] = $this->Giros_model->get_total_empresa_giro( $_POST['empresa'] );
		
		echo json_encode( $data );
	}

	public function column(){

		$column = array(
			'Cargo','Descripcion','Salario','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'cargo_laboral','descripcion_cargo_laboral','salario_mensual_cargo_laboral','estado'
		);
		
		$fields['id'] = array('id_cargo_laboral');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Cargos Laborales Lista";

		return $fields;
	}
	

}

?>
