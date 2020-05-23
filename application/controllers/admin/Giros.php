<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Giros extends MY_Controller {

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

		$this->load->model('admin/Giros_model');  
		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
	}

// Start  **********************************************************************************

	public function index(){

		$model 		= "Giros_model";
		$url_page 	= "admin/giros/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 19);

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );	
		$data['registros'] 		= $this->Giros_model->get_giros( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= 'Lista Giros';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] 	= $this->session->menu;		
		$data['home'] 	= 'admin/giros/giros_nuevo';
		$data['title'] 	= 'Nuevo Giros';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert Nuevo Giro
		$data = $this->Giros_model->crear_giro( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Giro Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Giro No Fue Creado");
		}	

		redirect(base_url()."admin/giros/index");
	}

	public function editar( $id_giro ){
		
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] 	= $this->session->menu;		
		$data['giros'] 	= $this->Giros_model->get_giro_id( $id_giro );
		$data['home'] 	= 'admin/giros/giros_editar';
		$data['title'] 	= 'Editar Giros';

		$this->parser->parse('template', $data);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/giros/index");
		}

		$data['title'] 	= "Ver";
		$data['home'] 	= 'template/ver_general';
		$data['menu'] 	= $this->session->menu;
		$data['data'] 	= $this->Giros_model->get_giro_id( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/giros/index");
		}

	}

	public function actualizar(){
		// Actualizar Giro 
		$data = $this->Giros_model->actualizar_giro( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Giro Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Giro No Fue Creado");
		}

		redirect(base_url()."admin/giros/index");
	}

	public function eliminar($id){
		
		$data = $this->Giros_model->eliminar_giro( $id );
		
		if($data){
			$this->session->set_flashdata('warning', "Giro Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Giro No Fue Eliminado");
		}

		redirect(base_url()."admin/giros/index");
	}

	public function get_atributos( $id_giro ){

		$data['giro'] 			= $this->Giros_model->get_giro_id( $id_giro );
		$data['atributos'] 		= $this->Atributos_model->geAllAtributos();
		$data['plantilla'] 		= $this->Giros_model->get_plantilla( $id_giro );
		$data['atributos_total']= $this->Atributos_model->get_atributos_total();
		$data['plantilla_giro_total'] = $this->Giros_model->get_total_plantilla_giro( $id_giro );

		echo json_encode( $data );
		//echo json_encode( $giro );
	}

	public function guardar_giro_atributos(){

		$this->Giros_model->insert_plantilla( $_POST );

		$data['plantilla'] 				= $this->Giros_model->get_plantilla( $_POST['giro'] );
		$data['plantilla_giro_total'] 	= $this->Giros_model->get_total_plantilla_giro( $_POST['giro']  );
		
		echo json_encode( $data );
		
	}

	public function eliminar_giro_atributos(){
		$this->Giros_model->eliminar_plantilla( $_POST );

		$data['plantilla'] 				= $this->Giros_model->get_plantilla( $_POST['giro'] );
		$data['plantilla_giro_total'] 	= $this->Giros_model->get_total_plantilla_giro( $_POST['giro']  );
		
		echo json_encode( $data );
	}

	// GIROS EMPRESA

	public function listar_giros(){
		$data['lista_giros'] 	= $this->Giros_model->getAllgiros();
		$data['lista_empresa'] 	= $this->Giros_model->get_empresa2();

		echo json_encode( $data );
	}

	public function guardar_giro_empresa(){
		$this->Giros_model->insert_giro_empresa( $_POST );
	}

	public function get_empresa_giro( $id_empresa ){
		$data['lista_giros'] 		= $this->Giros_model->get_empresa_giro( $id_empresa );
		$data['empresa_giro_total'] = $this->Giros_model->get_total_empresa_giro( $id_empresa );

		echo json_encode( $data );
	}

	public function eliminar_giro_empresa(){
		$this->Giros_model->eliminar_giro_empresa( $_POST );

		$data['lista_giros'] 		= $this->Giros_model->get_empresa_giro( $_POST['empresa']  );
		$data['empresa_giro_total'] = $this->Giros_model->get_total_empresa_giro( $_POST['empresa'] );
		
		echo json_encode( $data );
	}

	public function column(){

		$column = array(
			'Nombre','Tipo','Descripcion','Codigo','Creado', 'Actualizado', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_giro','tipo_giro','descripcion_giro','codigo_giro','fecha_giro_creado','fecha_giro_actualizado','estado'
		);
		
		$fields['id'] 		= array('id_giro');
		$fields['estado'] 	= array('estado_giro');
		$fields['titulo'] 	= "Giros Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );
	}

}

?>
