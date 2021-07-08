<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nodos extends MY_Controller {

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

		$this->load->model('admin/Nodos_model');
		$this->load->model('admin/Sucursal_model');
	}

	public function index(){

		$model 		= "Nodos_model";
		$url_page 	= "admin/nodos/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 6) ;

		// Seguridad :: Validar URL usuario	

		$data['menu'] 			= $this->session->menu;
		$data['registros'] 		= $this->Nodos_model->getNodos(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
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
		$data['title'] 			= "Nodos";
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] 	= $this->session->menu;
		$data['sucursal'] = $this->Sucursal_model->getSucursal();
		$data['home'] 	= 'admin/nodo/nuevo';
		$data['title'] 	= "Crear Nodos";

		echo $this->load->view('admin/nodo/nuevo',$data, TRUE);
	}

	public function crear(){

		if(isset($_POST)){
			$data = $this->Nodos_model->save( $_POST );

			if($data){
				$this->session->set_flashdata('success', "Nodo Fue Creado");
			}else{
				$this->session->set_flashdata('danger', "Nodo No Fue Creado");
			}
		}

		redirect(base_url()."admin/nodos/index");
	}

	public function editar( $nodo ){

		$id_rol = $this->session->roles;
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] 		= $this->session->menu;
		$data['sucursal']   = $this->Sucursal_model->getSucursal();
		$data['categorias'] = $this->Categorias_model->get_categorias_padres();
		$nodo 				= $this->Nodos_model->getNodoId($nodo);
		$data['nodo'] 		= $nodo[0];
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] 		= 'admin/nodos/nodos_editar';
		$data['title'] 		= "Editar Nodo";
		$categorias = $this->Nodos_model->getNodoCategoriaByNodo($nodo[0]->id_nodo);
		$categorias = $this->convertCategoriaSingleArray($categorias);

		$data['nodo_categoria'] = $categorias;

		$sucursalLista = $data['sucursal'];
		$sucursal = array_filter($sucursalLista , function($key) use ($data, $sucursalLista){

			if ($sucursalLista[$key]->id_sucursal == $data['nodo']->Sucursal) {
				return $sucursalLista[$key];
			}
		}, ARRAY_FILTER_USE_KEY);

		unset($data['sucursal'][key($sucursal)]);

		$data['sucursal'] = array_merge($sucursal, (array) $data['sucursal']);

		echo $this->load->view('admin/nodo/editar',$data, TRUE);
	}

	private function convertCategoriaSingleArray($categorias)
	{
		$cat = [];
		foreach ($categorias as $key => $categoria) {
			$cat[] = (int) $categoria['id_categoria'];
		}
		return $cat;
	}

	public function asociarNodoCategoria()
	{
		if ($_GET['nodo']) {
			$this->Nodos_model->asociarNodoCategoria($_GET);
		}
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/nodos/index");
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
			$data = $this->Nodos_model->update( $_POST );

			if($data){
				$this->session->set_flashdata('info', "Nodos Fue Actualizado");
			}else{
				$this->session->set_flashdata('danger', "Nodos No Fue Actualizado");
			}
		}

		redirect(base_url()."admin/nodos/index");
	}

	public function eliminar($nodo){

		$data = $this->Nodos_model->eliminar( $nodo );

		if($data){
			$this->session->set_flashdata('warning', "Nodos Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Nodos No Fue Eliminado");
		}
		redirect(base_url()."admin/nodos/index");
	}

	public function column(){

		$column = array(
			'Sucursal','Nombre','Ubicacion','Key','Estilo','Tiempo','Url','Estado'
		);
		return $column;
	}

	public function fields(){
		
		$fields['field'] = array(
			['nombre_sucursal' => 'Sucursal'],
			['nodo_nombre' => 'Nombre'],
			['nodo_ubicacion' => 'Ubicación'],
			['nodo_key' => 'Key'],
			['nodo_estilo' => 'Estilo'],
			['nodo_tiempo' => 'Tiempo'],
			['nodo_url' => 'Url'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_nodo');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Nodos Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
}
