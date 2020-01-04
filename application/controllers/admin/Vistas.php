<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vistas extends MY_Controller {

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
		$this->load->model('admin/Roles_model');
		$this->load->model('accion/Accion_model');
	}

	public function index()
	{

		$model = "Vistas_model";
		$url_page = "admin/vistas/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 22);


		if(isset($_POST['role']) and isset($_POST['menu'])){

			$data['accesos'] =  $this->Acceso_model->get_menu_acceso( $_POST['role'] , $_POST['menu'] , NULL );
			$data['accesos_menus_internos'] =  $this->Acceso_model->get_menu_internos( $_POST['role'] , $_POST['menu'] );
			$data['vista_componentes'] =  $this->Acceso_model->get_vista_componentes( $_POST['role'] , $_POST['menu']);
			//$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
			$data['roles'] =  $this->Acceso_model->getRoles();
			$data['menus'] =  $this->Menu_model->lista_menu();	


		}else{

			$data['roles'] =  $this->Acceso_model->getRoles();	
			$data['menus'] =  $this->Menu_model->lista_menu();
		}		
			
		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		
		$data['registros'] =  $this->Vistas_model->get_vistas( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol']  );
		$data['title'] = "Vistas";
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;
		$data['title'] = "Nueva Vista";
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
		$data['title'] = "Editar Vista";
		$data['home'] = 'admin/vistas/vistas_editar';

		$this->parser->parse('template', $data);
	}

	public function update(){
		
		$this->Vistas_model->update($_POST);
		redirect(base_url()."admin/vistas/index");
	}

	public function column(){

		$column = array(
			'Nombre','Codigo','Metodo','Url','Descripcion', 'Botones','Estado'
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

	/* Funciones para la seccion de componentes de vistas - CRUD */

	public function componentes( $vista_id ){
		$vista_id;
		//Paginacion
		$contador_tabla = 0;
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}

		$total_row = $this->Vistas_model->record_count_componente($vista_id);
		
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/vistas/componentes");
		$this->pagination->initialize($config);
		if($this->uri->segment(4)){
			if($_SESSION['per_page']!=0){
				$page = ($this->uri->segment(4) - 1 ) * $_SESSION['per_page'];
				//$contador_tabla = $page+1;
				$contador_tabla =1;
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

		$id_rol = $this->session->roles;

		$data['menu'] = $this->session->menu;
		$data['registros'] = $this->Vistas_model->vistas_componente_by_id( $vista_id ,  $config["per_page"], $page);
		//$data['home'] = 'admin/vistas/componentes_lista';
		$data['column'] = $this->columnC();
		$data['fields'] = $this->fieldsC();
		$data['total_pagina'] = 0;
		$data['total_records'] 	= 0;
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( 23 , $id_rol );
		$data['home'] = 'template/lista_template';
		$data['vista_id'] = $vista_id;


		$this->parser->parse('template', $data);
	}

	public function componentes_nuevo( $vista_id ){

		$data['menu'] = $this->session->menu;
		$data['componentes'] = $this->Vistas_model->get_all_componentes();
		$data['roles'] = $this->Roles_model->getAllRoles();
		$data['home'] = 'admin/vistas/componentes_nuevo';

		//$vista_id = $this->Vistas_model->getVistaId($vista_id);
		$data['vista_id'] = $vista_id;//$vista_id[0]->Vista;

		$this->parser->parse('template', $data);
	}

	public function componente_crear(){
		$this->Vistas_model->componente_crear($_POST);
		$data['vista_id'] = $_POST['vista_id'];
		redirect(base_url()."admin/vistas/componentes/".$data['vista_id']  );
	}

	public function componente_eliminar( $componente_vista_id ){

		$Vista_id = $this->Vistas_model->componente_eliminar($componente_vista_id);
		redirect(base_url()."admin/vistas/componentes/". $Vista_id  );
	}

	public function copiar( $id , $componente_id ){

		$id_rol = $this->session->roles;

		$this->Vistas_model->copiar_componente($id , $componente_id , $id_rol );
		redirect(base_url()."admin/vistas/componentes/".  $id );

	}

	public function columnC(){

		$column = array(
			'Vista','Accion','btn Nombre','btn Css','btn Icon', 'btn Url','btn Codigo','btn Posicion','Estado'
		);
		return $column;
	}

	public function fieldsC(){
		$fields['field'] = array(
			'vista_nombre','accion_nombre','accion_btn_nombre','accion_btn_css','accion_btn_icon','accion_btn_url','accion_btn_codigo','accion_valor','estado'
		);
		
		$fields['id'] = array('id');
		$fields['estado'] = array('accion_estado');
		$fields['titulo'] = "Componente Lista";

		return $fields;
	}
}