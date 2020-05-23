<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends MY_Controller {

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

		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Roles_model');
		$this->load->model('admin/Empleado_model');
	}

// Start  **********************************************************************************

	public function index(){

		$model = "Usuario_model";
		$url_page = "admin/usuario/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 2);

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
		$data['registros'] 		= $this->Usuario_model->get_usuarios( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['title'] 			= "Usuarios";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$data['menu'] 	= $this->session->menu;	
		$data['roles']	= $this->Roles_model->getAllRoles();
		$data['home'] 	= 'admin/usuario/u_nuevo';
		$data['title'] 	= "Nuevo Usuario";

		$this->parser->parse('template', $data);
	}

	function get_empleado(){
		$data['empleado'] = $this->Empleado_model->get_empleados2();
		echo json_encode($data);
	}

	public function crear(){
		// Insert Nuevo Usuario
		$data = $this->Usuario_model->crear_usuario( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Usuario Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Usuario No Fue Creado");
		}	
		redirect(base_url()."admin/usuario/index");
	}

	public function validar_usuario( $id_empleado ){

		$data = 0;
		$data = $this->Usuario_model->validar_usuario( $id_empleado );
		if($data){
			$data = 1;
		}
		echo $data;
	}

	public function editar( $usuario_id ){
		
		$data['title'] 			= "Editar Usuario";
		$data['menu'] 			= $this->session->menu;	
		$data['home'] 			= 'admin/usuario/u_editar';
		$data['roles']			= $this->Roles_model->getAllRoles();	
		$data['usuario_roles']	= $this->Usuario_model->get_usuario_roles2($usuario_id);
		$data['usuario'] 		= $this->Usuario_model->get_usuario_id( $usuario_id );		

		$this->general->editar_valido($data['usuario'], "admin/usuario/index");

		$this->parser->parse('template', $data);
	}

	public function update(){
		if(isset($_POST)){
			$data = $this->Usuario_model->update( $_POST );

			if($data){
				$this->session->set_flashdata('success', "Usuario Fue Actualizado");
			}else{
				$this->session->set_flashdata('warning', "Usuario No Fue Actualizado");
			}
		}
		redirect(base_url()."admin/usuario/index");
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/usuario/index");
		}

		$data['title']= "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Usuario_model->get_usuario_id( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/cargo/index");
		}
	}
	
	public function column(){

		$column = array(
			'Usuario','Password','Hora Inicio','Hora fin','Encargado', 'Rol','Id' ,'Empleado', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_usuario','contrasena_usuario','hora_inicio','hora_salida','usuario_encargado','role','Empleado','alias','estado'
		);
		
		$fields['id'] 		= array('id_usuario');
		$fields['estado'] 	= array('estado');
		$fields['titulo'] 	= "Usuario Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );
	}
}

?>
