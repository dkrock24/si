<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vistas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database();    

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');   

		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Acceso_model');
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Vistas_model');
	}

	public function index()
	{

		//Paginacion
		$contador_tabla;
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Vistas_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/vistas/index");
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


		// Construir Menu
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		if(isset($_POST['role']) and isset($_POST['menu'])){

			$data['accesos'] =  $this->Acceso_model->get_menu_acceso( $_POST['role'] , $_POST['menu'] , NULL );
			$data['accesos_menus_internos'] =  $this->Acceso_model->get_menu_internos( $_POST['role'] , $_POST['menu'] );
			$data['vista_componentes'] =  $this->Acceso_model->get_vista_componentes( $_POST['role'] , $_POST['menu']);
			$data['roles'] =  $this->Acceso_model->getRoles();
			$data['menus'] =  $this->Menu_model->lista_menu();	


		}else{

			$data['roles'] =  $this->Acceso_model->getRoles();	
			$data['menus'] =  $this->Menu_model->lista_menu();
		}		
		$data['menu'] = $this->session->menu;		
		$data['registros'] =  $this->Vistas_model->get_vistas(  $config["per_page"], $page );
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['contador_tabla'] = $contador_tabla;
		//$data['vistas_componentes'] =  $this->Vistas_model->get_vistas_componentes();
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/vistas/vistas_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		
		$this->Vistas_model->crear($_POST);
		redirect(base_url()."admin/vistas/index");
	}

	public function edit( $vista_id ){
		
		$data['menu'] = $this->session->menu;
		$data['vistas'] = $this->Vistas_model->vistas_by_id( $vista_id );
		$data['home'] = 'admin/vistas/vistas_editar';

		$this->parser->parse('template', $data);
	}

	public function update(){
		
		$this->Vistas_model->update($_POST);
		redirect(base_url()."admin/vistas/index");
	}

	public function componentes( $vista_id ){

		$data['menu'] = $this->session->menu;
		$data['componentes'] = $this->Vistas_model->vistas_componente_by_id( $vista_id );
		$data['home'] = 'admin/vistas/componentes_lista';
		$data['vista_id'] = $vista_id;

		$this->parser->parse('template', $data);
	}

	public function componentes_nuevo( $vista_id ){

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/vistas/componentes_nuevo';
		$data['vista_id'] = $vista_id;

		$this->parser->parse('template', $data);
	}

	public function componente_crear(){
		$this->Vistas_model->vistas_componente_crear($_POST);
		$data['vista_id'] = $_POST['vista_id'];
		redirect(base_url()."admin/vistas/componentes/".$data['vista_id']  );
	}

	public function column(){

		$column = array(
			'#','Nombre','Codigo','Metodo','Url','Descripcion', 'Botones','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'vista_nombre','vista_codigo','vista_accion','vista_url','vista_descripcion','total','estado'
		);
		
		$fields['id'] = array('id_vista');
		$fields['estado'] = array('vista_estado');
		$fields['titulo'] = "Vistas Lista";

		return $fields;
	}
}