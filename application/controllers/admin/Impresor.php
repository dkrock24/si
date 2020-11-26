<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impresor extends MY_Controller {

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
		$this->load->model('admin/Impresor_model');

		$this->load->model('admin/Terminal_model');
		$this->load->model('admin/Documento_model');
	}

	public function index(){

		$model 		= "Impresor_model";
		$url_page 	= "admin/impresor/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 92) ;

		// Seguridad :: Validar URL usuario	

		$data['menu'] 			= $this->session->menu;
		$data['registros'] 		= $this->Impresor_model->get_impresor(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['links'] 			= $pag['links'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['filtros'] 		= $pag['field'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol'] );
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= "Impresor";
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$data['menu'] 	= $this->session->menu;
		$data['home'] 	= 'admin/impresor/nuevo';
		$data['title'] 	= "Crear Impresor";

		$this->parser->parse('template', $data);
	}

	public function save(){

		if (isset($_POST)) {
			
			$data = $this->Impresor_model->save( $_POST );

			$documentos = $this->Documento_model->getAllDocumento();
			$terminales = $this->Terminal_model->get_terminal_lista();
			$impresores = $this->Impresor_model->get_all_impresor();

			$this->Impresor_model->procesar_impresor_terminal_documento($impresores, $documentos , $terminales);

			if($data){
				$this->session->set_flashdata('success', "Impresor Fue Creado");
			}else{
				$this->session->set_flashdata('danger', "Impresor No Fue Creado");
			}
		}

		redirect(base_url()."admin/impresor/index");
	}

	public function editar( $id_impresor ){

		$id_rol = $this->session->roles;
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] 		= $this->session->menu;
		$data['impresor'] 	= $this->Impresor_model->get_impresor_id($id_impresor);
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] 		= 'admin/impresor/editar';
		$data['title'] 		= "Editar Impresor";

		$this->parser->parse('template', $data);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/impresor/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Impresor_model->get_impresor_id( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );
				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/impresor/index");
		}
	}

	public function update(){

		if(isset($_POST)){
			$data = $this->Impresor_model->update( $_POST );

			if($data){
				$this->session->set_flashdata('info', "Impresor Fue Actualizado");
			}else{
				$this->session->set_flashdata('danger', "Impresor No Fue Actualizado");
			}
		}

		redirect(base_url()."admin/impresor/index");
	}

	public function eliminar($id){

		$data = $this->Impresor_model->eliminar( $id );

		$params = array(
			'impresor_id' => $id,
		);

		$this->Impresor_model->eliminar_impresor_terminar( $params );

		if($data){
			$this->session->set_flashdata('warning', "Impresor Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Impresor No Fue Eliminado");
		}
		redirect(base_url()."admin/impresor/index");
	}

	public function column(){

		$column = array(
			'Nombre','Descripcion','Color','Modelo','Marca','Url','Estado'
		);
		return $column;
	}

	public function fields(){
		
		$fields['field'] = array(
			['impresor_nombre' => 'Nombre'],
			['impresor_descripcion' => 'Descripcion'],
            ['impresor_color' => 'Color'],
            ['impresor_modelo' => 'Modelo'],
            ['impresor_marca' => 'marca'],
            ['impresor_url' => 'Url'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_impresor');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Impresor Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
}
