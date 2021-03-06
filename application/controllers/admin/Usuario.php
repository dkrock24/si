<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends MY_Controller {

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

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] 	= $this->session->menu;	
		$data['roles']	= $this->Roles_model->getAllRoles();
		$data['home'] 	= 'admin/usuario/u_nuevo';
		$data['title'] 	= "Nuevo Usuario";

		echo $this->load->view('admin/usuario/u_nuevo', $data, TRUE);
	}

	function get_empleado(){
		$data['empleado'] = $this->Empleado_model->get_empleados2();
		echo json_encode($data);
	}

	public function crear(){
		// Insert Nuevo Usuario
		$data = $this->Usuario_model->crear_usuario( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Usuario Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Usuario No Fue Creado: ". $data['message']);
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
		$data['usuario_roles2']	= $this->Usuario_model->get_usuario_roles3($usuario_id);
		$data['usuario'] 		= $this->Usuario_model->get_usuario_id( $usuario_id );		

		$this->general->editar_valido($data['usuario'], "admin/usuario/index");

		echo $this->load->view('admin/usuario/u_editar', $data, TRUE);
	}

	public function get_usuario_rol($usuario_id)
	{
		$data = $this->Usuario_model->get_usuario_roles2($usuario_id);
		echo json_encode($data);
	}

	public function agregar_remover_rol()
	{
		if (isset($_GET)) {
			$this->Usuario_model->agregar_remover_rol( $_GET );
			$data = $this->Usuario_model->get_usuario_roles2($_GET['usuario']);
			echo json_encode($data);
		}
	}

	public function update(){
		if(isset($_POST)){
			$data = $this->Usuario_model->update( $_POST );

			if(!$data['code']){
				$this->session->set_flashdata('info', "Usuario Fue Actualizado");
			}else{
				$data = $this->db_error_format($data);
				$this->session->set_flashdata('danger', "Usuario No Fue Actualizado : ". $data['message']);
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
	
			echo $this->load->view('template/ver_general', $data, TRUE);

		}else{
			redirect(base_url()."admin/cargo/index");
		}
	}
	
	public function column(){

		$column = array(
			'Sucursal','Empleado','Id' ,'Usuario','Encargado','Rol','Hora Inicio','Hora fin',  'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_sucursal' => 'Sucursal'],
			['alias' => 'Empleado'],
			['Empleado' => 'Id'],
			['nombre_usuario' => 'Usuario'],
			['usuario_encargado' => 'Encargado'],
			['role' => 'Rol'],
			['hora_inicio' => 'Hora Inicio'],
			['hora_salida' => 'Hora fin'],
			['orden_estado_nombre' => 'Estado'],
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_usuario');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Usuarios Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );
	}
}

?>
