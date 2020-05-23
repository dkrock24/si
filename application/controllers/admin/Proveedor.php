<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends MY_Controller {

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

		$this->load->model('accion/Accion_model');	
		$this->load->model('admin/Persona_model');
		$this->load->model('admin/Proveedor_model');
		$this->load->model('producto/Linea_model');
	}

// Start  **********************************************************************************

	public function index(){

		$model = "Proveedor_model";
		$url_page = "admin/proveedor/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 32);

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];

		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] 		= $this->Proveedor_model->get_proveedor( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['title'] 			= "Proveedores";
		$data['home'] 			= 'template/lista_template';

		$this->parser->parse('template', $data);

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];
	}

	public function nuevo(){

		$data['menu'] 		= $this->session->menu;		
		$data['linea'] 		= $this->Linea_model->getAllLinea();
		$data['persona'] 	= $this->Persona_model->getAllPersona();
		$data['title'] 		= "Nuevo Proveedor";
		$data['home'] 		= 'admin/proveedor/proveedor_nuevo';

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

		$data['menu'] 		= $this->session->menu;		
		$data['proveedor'] 	= $this->Proveedor_model->get_proveedor_id( $proveedor_id );
		$data['linea'] 		= $this->Linea_model->getAllLinea();
		$data['persona'] 	= $this->Persona_model->getAllPersona();
		$data['title'] 		= "Editar Proveedor";
		$data['home'] 		= 'admin/proveedor/proveedor_editar';

		$this->general->editar_valido($data['proveedor'], "admin/proveedor/index");

		$this->parser->parse('template', $data);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/proveedor/index");
		}

		$data['title']= "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Proveedor_model->get_proveedor_id( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/proveedor/index");
		}

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
			'Codigo','Empresa','Titular','NRC','Giro','Tel','Cel', 'Linea','Nombre','Apellido', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'codigo_proveedor','empresa_proveedor','titular_proveedor','nrc','giro','tel_empresa','cel_empresa','tipo_producto','primer_nombre_persona','primer_apellido_persona','estado'
		);
		
		$fields['id'] 		= array('id_proveedor');
		$fields['estado'] 	= array('estado');
		$fields['titulo'] 	= "Proveedor Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
	

}

?>
