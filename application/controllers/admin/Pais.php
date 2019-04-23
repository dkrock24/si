<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pais extends CI_Controller {

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
		
		$total_row = $this->Pais_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/pais/index");
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

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		//parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 2; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['registros'] = $this->Pais_model->get_pais(  $config["per_page"], $page  );
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}
	
	public function nuevo(){
		// NUEVO PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['moneda'] = $this->Pais_model->get_moneda();
		$data['home'] = 'admin/pais/pais_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert pais
		$this->Pais_model->crear_pais( $_POST );

		redirect(base_url()."admin/pais/index");
	}

	public function editar( $id_pais ){
		// EDITAR PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['pais'] = $this->Pais_model->edit_pais( $id_pais );
		$data['moneda'] = $this->Pais_model->get_moneda();
		$data['home'] = 'admin/pais/pais_edit';

		$this->parser->parse('template', $data);
	}
	
	public function update( ){
		// UPDATE PAIS //
		$data['pais'] = $this->Pais_model->update_pais( $_POST );
		
		redirect(base_url()."admin/pais/index");
	}
	
	public function delete( $id_pais ){
		// DELETE PAIS //
		$data['pais'] = $this->Pais_model->pais_delete( $id_pais );
		
		redirect(base_url()."admin/pais/index");
	}

// End PAIS

// Start Departamento **********************************************************************************

	public function dep( $pais_id ){
		// Get Departamentos

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['depart'] = $this->Pais_model->get_dep( $pais_id );
		$data['id_departamento'] = $pais_id;
		$data['home'] = 'admin/pais/dep';

		$this->parser->parse('template', $data);
	}

	public function nuevo_dep( $id_pais ){
		// Mostrar formulario para crear nuevo departamento

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['id_pais'] = $id_pais;
		$data['home'] = 'admin/pais/dep_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear_dep(){
		// Guardar el nuevo departamento

		$this->Pais_model->crear_dep( $_POST );

		redirect(base_url()."admin/pais/dep/".$_POST['id_pais']);
	}

	public function editar_dep( $id_dep ){
		// Editar Departamento

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['dep'] = $this->Pais_model->editar_dep( $id_dep );
		$data['home'] = 'admin/pais/dep_editar';

		$this->parser->parse('template', $data);
	}

	public function update_dep(){

		$this->Pais_model->update_dep( $_POST );
		
		redirect(base_url()."admin/pais/dep/".$_POST['id_pais']);
	}

// End Departamento

// Start Ciudad **********************************************************************************

	public function ciu($id_dep){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['ciu']  = $this->Pais_model->get_ciu_by( $id_dep );
		$data['home'] = 'admin/pais/ciu';

		$this->parser->parse('template', $data);
	}

	public function nuevo_ciu( $id_dep ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['dep']  =  $id_dep;
		$data['home'] = 'admin/pais/ciu_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear_ciu(){

		$this->Pais_model->crear_ciu( $_POST );
		
		redirect(base_url()."admin/pais/ciu/".$_POST['id_departamento']);
	}

	public function editar_ciu( $id_ciu ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['ciu']  =  $this->Pais_model->get_ciu( $id_ciu );
		$data['home'] = 'admin/pais/ciu_editar';

		$this->parser->parse('template', $data);
	}

	public function update_ciu(){

		$this->Pais_model->update_ciu( $_POST );
		
		redirect(base_url()."admin/pais/ciu/".$_POST['departamento']);
	}

	public function column(){

		$column = array(
			'#','Nombre','Codigo','Moneda','Simbolo','Creado', 'Actualizado', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_pais','zip_code','moneda_nombre','moneda_simbolo','fecha_creacion_pais','fecha_actualizacion_pais','estado'
		);
		
		$fields['id'] = array('id_pais');
		$fields['estado'] = array('estado_pais');
		$fields['titulo'] = "Pais Lista";

		return $fields;
	}

}

?>
