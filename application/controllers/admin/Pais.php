<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pais extends MY_Controller {

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

		$this->load->model('admin/Pais_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
	}

// Start PAIS **********************************************************************************

	public function index(){

		$model 		= "Pais_model";
		$url_page 	= "admin/pais/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 5) ;

		// GET PAIS
		//$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] 			= $this->session->menu;
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] 		= $this->Pais_model->get_pais(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= 'Paises';

		$this->parser->parse('template', $data);
	}
	
	public function nuevo(){
		// NUEVO PAIS

		$data['menu'] 	= $this->session->menu;
		$data['moneda'] = $this->Pais_model->get_moneda();
		$data['title'] 	= "Nuevo Pais";	
		$data['home'] 	= 'admin/pais/pais_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert pais
		$data['info'] = $this->Pais_model->crear_pais( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Pais Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Pais No Fue Creado");
		}

		redirect(base_url()."admin/pais/index");
	}

	public function editar( $id_pais ){
		// EDITAR PAIS

		$data['menu'] = $this->session->menu;
		$data['pais'] = $this->Pais_model->edit_pais( $id_pais );
		$data['moneda'] = $this->Pais_model->get_moneda();
		$data['home'] = 'admin/pais/pais_edit';
		$data['title'] = 'Editar Pais';

		$this->parser->parse('template', $data);
	}
	
	public function update( ){
		// UPDATE PAIS //
		$data['pais'] = $this->Pais_model->update_pais( $_POST );

		if($data){
			$this->session->set_flashdata('info', "Pais Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Pais No Fue Actualizado");
		}
		
		redirect(base_url()."admin/pais/index");
	}
	
	public function eliminar( $id_pais ){
		// DELETE PAIS //
		$data['pais'] = $this->Pais_model->pais_delete( $id_pais );

		if($data){
			$this->session->set_flashdata('warning', "Pais Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Pais No Fue Eliminado");
		}		
		
		redirect(base_url()."admin/pais/index");
	}

// End PAIS

// Start Departamento **********************************************************************************

	public function dep( $pais_id ){
		// Get Departamentos

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] 			= $this->session->menu;
		$data['depart'] 		= $this->Pais_model->get_dep( $pais_id );
		$data['id_departamento']= $pais_id;
		$data['home'] 			= 'admin/pais/dep';
		$data['title'] 			= 'Departamento';

		$this->parser->parse('template', $data);
	}

	public function nuevo_dep( $id_pais ){
		// Mostrar formulario para crear nuevo departamento

		$data['menu'] 		= $this->session->menu;
		$data['id_pais'] 	= $id_pais;
		$data['home'] 		= 'admin/pais/dep_nuevo';
		$data['title'] 		= 'Nuevo Departamento';

		$this->parser->parse('template', $data);
	}

	public function crear_dep(){
		// Guardar el nuevo departamento

		$data['info'] = $this->Pais_model->crear_dep( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Departamento Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Departamento No Fue Creado");
		}

		redirect(base_url()."admin/pais/dep/".$_POST['id_pais']);
	}

	public function editar_dep( $id_dep ){
		// Editar Departamento

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] 	= $this->session->menu;
		$data['title'] 	= 'Editar Departamento';
		$data['home'] 	= 'admin/pais/dep_editar';
		$data['dep'] 	= $this->Pais_model->editar_dep( $id_dep );

		$this->parser->parse('template', $data);
	}

	public function update_dep(){

		$data['info'] = $this->Pais_model->update_dep( $_POST );

		if($data){
			$this->session->set_flashdata('info', "Departamento Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Departamento No Fue Actualizado");
		}

		redirect(base_url()."admin/pais/dep/".$_POST['id_pais']);
	}

	public function eliminar_dep($id_dep , $id_pais){
		$data['info'] = $this->Pais_model->eliminar_dep( $id_dep );

		if($data){
			$this->session->set_flashdata('success', "Departamento Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Departamento No Fue Eliminado");
		}
		
		redirect(base_url()."admin/pais/dep/".$id_pais);
	}

// End Departamento

// Start Ciudad **********************************************************************************

	public function ciu($id_dep){

		$data['title']= 'Lista Ciudad';
		$data['home'] = 'admin/pais/ciu';
		$data['menu'] = $this->session->menu;
		$data['ciu']  = $this->Pais_model->get_ciu_by( $id_dep );

		$this->parser->parse('template', $data);
	}

	public function nuevo_ciu( $id_dep ){

		$data['menu'] = $this->session->menu;
		$data['dep']  =  $id_dep;
		$data['home'] = 'admin/pais/ciu_nuevo';
		$data['title']= 'Nueva Ciudad';

		$this->parser->parse('template', $data);
	}

	public function crear_ciu(){

		$data['info'] = $this->Pais_model->crear_ciu( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Ciudad Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Ciudad No Fue Creado");
		}
		
		redirect(base_url()."admin/pais/ciu/".$_POST['id_departamento']);
	}

	public function editar_ciu( $id_ciu ){

		$data['menu'] = $this->session->menu;
		$data['ciu']  =  $this->Pais_model->get_ciu( $id_ciu );
		$data['home'] = 'admin/pais/ciu_editar';

		$this->parser->parse('template', $data);
	}

	public function update_ciu(){

		$data['info'] = $this->Pais_model->update_ciu( $_POST );

		if($data){
			$this->session->set_flashdata('info', "Ciudad Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Ciudad No Fue Actualizado");
		}
		
		redirect(base_url()."admin/pais/ciu/".$_POST['departamento']);
	}

	public function eliminar_ciu($id_ciu , $id_dep){
		$data['info'] = $this->Pais_model->eliminar_ciu( $id_ciu );

		if($data){
			$this->session->set_flashdata('warning', "Ciudad Fue Eliminada");
		}else{
			$this->session->set_flashdata('danger', "Ciudad No Fue Eliminada");
		}
		
		redirect(base_url()."admin/pais/ciu/".$id_dep);
	}

	public function column(){

		$column = array(
			'Nombre','Codigo','Moneda','Simbolo','Creado', 'Actualizado', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_pais' => 'Nombre'],
			['zip_code' => 'Codigo'],
			['moneda_nombre' => 'Moneda'],
			['moneda_simbolo' => 'Simbolo'],
			['fecha_creacion_pais' => 'Creado'],
			['fecha_actualizacion_pais' => 'Actualizado'],
			['estado_pais'=> 'Estado']
		);
		
		$fields['id'] = array('id_pais');
		$fields['estado'] = array('estado_pais');
		$fields['titulo'] = "Pais Lista";

		return $fields;
	}

}

?>
