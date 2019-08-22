<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {

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
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Persona_model');
		$this->load->model('admin/Proveedor_model');
		$this->load->model('producto/Linea_model');
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
		
		$total_row = $this->Proveedor_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/proveedor/index");
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
		$vista_id = 32; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['registros'] = $this->Proveedor_model->get_proveedor( $config["per_page"], $page );
		$data['title'] = "Proveedores";
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;		
		$data['linea'] = $this->Linea_model->getAllLinea();
		$data['persona'] = $this->Persona_model->getAllPersona();
		$data['title'] = "Nuevo Proveedor";
		$data['home'] = 'admin/proveedor/proveedor_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		
		$data = $this->Proveedor_model->crear( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Proveedor Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Proveedor No Fue Creado");
		}	

		redirect(base_url()."admin/proveedor/index");
	}

	public function editar( $proveedor_id ){
		
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;		
		$data['proveedor'] = $this->Proveedor_model->get_proveedor_id( $proveedor_id );
		$data['linea'] = $this->Linea_model->getAllLinea();
		$data['persona'] = $this->Persona_model->getAllPersona();
		$data['title'] = "Editar Proveedor";
		$data['home'] = 'admin/proveedor/proveedor_editar';

		$this->general->editar_valido($data['proveedor'], "admin/proveedor/index");

		$this->parser->parse('template', $data);
	}

	public function update(){
		
		$data = $this->Proveedor_model->update( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Proveedor Fue Actualizado");
		}else{
			$this->session->set_flashdata('warning', "Proveedor No Fue Actualizado");
		}

		redirect(base_url()."admin/proveedor/index");
	}

	public function column(){

		$column = array(
			'EMPRESA','TITULAR','NRC','GIRO','TEL','CEL', 'LINEA','NOMBRE','APELLIDO', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'empresa','titular_proveedor','nrc','giro','tel_empresa','cel_empresa','tipo_producto','primer_nombre_persona','primer_apellido_persona','estado'
		);
		
		$fields['id'] = array('id_proveedor');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Proveedor Lista";

		return $fields;
	}
	

}

?>
