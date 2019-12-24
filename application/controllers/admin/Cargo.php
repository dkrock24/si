<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargo extends MY_Controller {

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

		$model = "Cargos_model";
		$url_page = "admin/cargo/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 30);
		
		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] = $this->Cargos_model->get_all_cargo( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']);
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

	public function eliminar($id){
		
		$data = $this->Cargos_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('success', "Cargo Fue Eliminado");
		}else{
			$this->session->set_flashdata('warning', "Cargo Fue Eliminado");
		}

		redirect(base_url()."admin/cargo/index");
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
