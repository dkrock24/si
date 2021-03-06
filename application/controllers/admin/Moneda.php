<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moneda extends MY_Controller {

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
		$this->load->model('admin/Moneda_model');					
		$this->load->model('producto/Orden_model');
	}

	public function index(){

		$model 		= "Moneda_model";
		$url_page 	= "admin/moneda/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 6) ;

		// Seguridad :: Validar URL usuario	

		$data['menu'] 			= $this->session->menu;
		$data['registros'] 		= $this->Moneda_model->getMoneda(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
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
		$data['title'] 			= "Monedas";
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] 	= $this->session->menu;
		$data['home'] 	= 'admin/moneda/moneda_nuevo';
		$data['title'] 	= "Crear Moneda";

		echo $this->load->view('admin/moneda/moneda_nuevo',$data, TRUE);
	}

	public function crear(){

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

		$id_rol = $this->session->roles;
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] 		= $this->session->menu;
		$data['monedas'] 	= $this->Moneda_model->getMonedaId($moneda_id);
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] 		= 'admin/moneda/moneda_editar';
		$data['title'] 		= "Editar Moneda";

		echo $this->load->view('admin/moneda/moneda_editar',$data, TRUE);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/moneda/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Moneda_model->getMonedaId( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );
				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/moneda/index");
		}
	}

	public function update(){

		if(isset($_POST)){
			$data = $this->Moneda_model->update( $_POST );

			if($data){
				$this->session->set_flashdata('info', "Moneda Fue Actualizado");
			}else{
				$this->session->set_flashdata('danger', "Moneda No Fue Actualizado");
			}
		}

		redirect(base_url()."admin/moneda/index");
	}

	public function eliminar($id){

		$data = $this->Moneda_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('warning', "Moneda Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Moneda No Fue Eliminado");
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
			['moneda_nombre' => 'Nombre'],
			['moneda_simbolo' => 'Simbolo'],
			['moneda_alias' => 'Alias'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_moneda');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Moneda Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
}
