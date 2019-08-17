<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursal extends CI_Controller {

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
	    $this->load->library('../controllers/general'); 
		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Giros_model');  
		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('admin/Empresa_model');
		$this->load->model('admin/Ciudad_model');
	}

// Start  **********************************************************************************

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
		
		$total_row = $this->Sucursal_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/sucursal/index");
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

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		//parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 31; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['registros'] = $this->Sucursal_model->getAllSucursal( $config["per_page"], $page );
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;		
		$data['empresa'] = $this->Empresa_model->getEmpresas();
		$data['ciudad'] = $this->Ciudad_model->getCiudad();
		$data['home'] = 'admin/sucursal/sucursal_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){

		$data = $this->Sucursal_model->crear_sucursal( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Sucursal Fue Creada");
		}else{
			$this->session->set_flashdata('warning', "Sucursal No Fue Creada");
		}	


		redirect(base_url()."admin/sucursal/index");
	}

	public function editar( $sucursla_id ){
		
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;		
		$data['sucursal'] = $this->Sucursal_model->getSucursalId( $sucursla_id );
		$data['empresa'] = $this->Empresa_model->getEmpresas();
		$data['ciudad'] = $this->Ciudad_model->getCiudad();
		$data['home'] = 'admin/sucursal/sucursal_editar';

		$this->general->editar_valido($data['sucursal'], "admin/sucursal/index");

		$this->parser->parse('template', $data);
	}

	public function update(){
		$data = $this->Sucursal_model->actualizar_giro( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Sucursal Fue Actualizada");
		}else{
			$this->session->set_flashdata('warning', "Sucursal No Fue Actualizada");
		}
		redirect(base_url()."admin/sucursal/index");
	}

	public function column(){

		$column = array(
			'Empresa','Sucursal','Direccion','Tel','Cel','Encargado',  'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_comercial','nombre_sucursal','direct','tel','cel','encargado','estado'
		);
		
		$fields['id'] = array('id_sucursal');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Sucursales Lista";

		return $fields;
	}
	

}

?>
