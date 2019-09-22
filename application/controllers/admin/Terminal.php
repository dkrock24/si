<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terminal extends CI_Controller {

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
		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Roles_model');
		$this->load->model('admin/Persona_model');
		$this->load->model('admin/Empleado_model');
		$this->load->model('admin/Caja_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('admin/Usuario_model');
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
		
		$total_row = $this->Terminal_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/terminal/index");
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
		$data['registros'] = $this->Terminal_model->get_all_terminal( $config["per_page"], $page );
		$data['title'] = "Terminales";
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['caja'] = $this->Caja_model->get_caja_empresa( );
		$data['sucursal'] = $this->Sucursal_model->getAllSucursalEmpresa( );
		$data['usuario'] = $this->Usuario_model->get_usuarios_sucursal( );
		$data['title'] = "Nueva Terminal";
		$data['home'] = 'admin/terminal/t_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert Nuevo Usuario
		$data = $this->Terminal_model->crear( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Terminal Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Terminal No Fue Creado");
		}	
		redirect(base_url()."admin/terminal/index");
	}


	public function editar( $terminal_id ){
		
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	

		$data['caja'] = $this->Caja_model->get_caja_empresa( );
		$data['sucursal'] = $this->Sucursal_model->getAllSucursalEmpresa( );
		$data['usuario'] = $this->Usuario_model->get_usuarios_sucursal( );
		
		$data['terminal'] = $this->Terminal_model->get_terminal( $terminal_id );
		$data['title'] = "Editar Terminal";
		$data['home'] = 'admin/terminal/t_editar';

		//$this->general->editar_valido($data['cargo'], "admin/cargo/index");

		$this->parser->parse('template', $data);
	}

	public function update(){

		if(isset($_POST)){
			$data = $this->Terminal_model->update( $_POST );
			if($data){
				$this->session->set_flashdata('success', "Terminal Fue Actualizado");
			}else{
				$this->session->set_flashdata('warning', "Terminal No Fue Actualizado");
			}
		}
		redirect(base_url()."admin/terminal/index");
	}

	public function eliminar($id){
		// Actualizar Giro 
		$data = $this->Terminal_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('success', "Terminal Fue Eliminado");
		}else{
			$this->session->set_flashdata('warning', "Terminal Fue Eliminado");
		}

		redirect(base_url()."admin/terminal/index");
	}

	public function column(){

		$column = array(
			'Sucursal','Nombre','Numero','Ubicacion','Modelo','Serie','Marca','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_sucursal','nombre','numero','ubicacion','modelo','series','marca','estado'
		);
		
		$fields['id'] = array('id_terminal');
		$fields['estado'] = array('estado_terminal');
		$fields['titulo'] = "Terminal Lista";

		return $fields;
	}
	

}

?>
