<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moneda extends CI_Controller {

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
		$this->load->helper('seguridad/url_helper');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('accion/Accion_model');	
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Terminal_model');
		$this->load->model('admin/Giros_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/ModoPago_model');
		$this->load->model('admin/Correlativo_model');
		$this->load->model('admin/Empresa_model');
		$this->load->model('admin/Moneda_model');
		$this->load->model('producto/Producto_model');				
		$this->load->model('producto/Orden_model');
	}

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
		
		$total_row = $this->Moneda_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/moneda/index");
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
		$vista_id = 6; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['registros'] = $this->Moneda_model->getMoneda(  $config["per_page"], $page  );
		$data['contador_tabla'] = $contador_tabla;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'template/lista_template';
		$data['title'] = "Monedas";

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/moneda/moneda_nuevo';
		$data['title'] = "Crear Moneda";

		$this->parser->parse('template', $data);
	}

	public function save(){

		if(isset($_POST)){
			$data = $this->Moneda_model->save( $_POST );

			if($data){
				$this->session->set_flashdata('success', "Moneda Fue Creado");
			}else{
				$this->session->set_flashdata('danger', "Moneda No Fue Creado");
			}
		}

		redirect(base_url()."admin/moneda/index");
	}

	public function editar( $moneda_id ){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['monedas'] = $this->Moneda_model->getMonedaId($moneda_id);
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'admin/moneda/moneda_editar';
		$data['title'] = "Editar Moneda";

		$this->parser->parse('template', $data);
	}

	public function update(){
		if(isset($_POST)){
			$data = $this->Moneda_model->update( $_POST );

			if($data){
				$this->session->set_flashdata('warning', "Moneda Fue Actualizado");
			}else{
				$this->session->set_flashdata('danger', "Moneda No Fue Actualizado");
			}
		}

		redirect(base_url()."admin/moneda/index");
	}

	public function eliminar($id){
		$data = $this->Moneda_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('danger', "Moneda Fue Eliminado");
		}else{
			$this->session->set_flashdata('warning', "Moneda No Fue Eliminado");
		}
		redirect(base_url()."admin/moneda/index");
	}

	public function column(){

		$column = array(
			'Nombre','Simbolo','Alias','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'moneda_nombre','moneda_simbolo','moneda_alias','estado'
		);
		
		$fields['id'] = array('id_moneda');
		$fields['estado'] = array('moneda_estado');
		$fields['titulo'] = "Moneda Lista";

		return $fields;
	}
}
