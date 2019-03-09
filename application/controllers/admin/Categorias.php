<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

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

		$this->load->model('admin/Categorias_model');  
		$this->load->model('admin/Empresa_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
	}

// Start PAIS **********************************************************************************

	public function index(){

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
		
		$total_row = $this->Categorias_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/categorias/index");
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
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['registros'] = $this->Categorias_model->get_categorias(  $config["per_page"], $page );
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['categorias']	= $this->Categorias_model->get_categorias_padres();
		$data['empresa'] = $this->Empresa_model->getEmpresas();
		$data['home'] = 'admin/categorias/categorias_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){

		// Crear Categoria y Sub Categoria
		$this->Categorias_model->crear_categoria( $_POST );
		redirect(base_url()."admin/categorias/index");
	}

	public function editar( $id_categoria ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;		
		$data['categorias'] = $this->Categorias_model->get_categoria_id( $id_categoria );
		$data['categorias_padres']	= $this->Categorias_model->get_categorias_padres();
		$data['empresa'] = $this->Empresa_model->getEmpresas();
		$data['home'] = 'admin/categorias/categorias_editar';

		$this->parser->parse('template', $data);
	}

	public function actualizar(){
		// Insert pais
		$this->Categorias_model->actualizar_categoria( $_POST );

		redirect(base_url()."admin/categorias/index");
	}
	public function column(){

		$column = array(
			'#','Nombre','Imagen','Padre','Empresa','Creado', 'Actualizado', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_categoria','img_cate','cat_padre','nombre_comercial','creado_categoria','actualizado_categoria','estado'
		);
		
		$fields['id'] = array('id_categoria');
		$fields['estado'] = array('categoria_estado');
		$fields['titulo'] = "Categoria Lista";

		return $fields;
	}
	

}

?>
