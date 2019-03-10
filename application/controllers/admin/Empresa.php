<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

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
		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');
		$this->load->model('accion/Accion_model');	

		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Terminal_model');
		$this->load->model('admin/Giros_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/ModoPago_model');
		$this->load->model('admin/Correlativo_model');
		$this->load->model('admin/Empresa_model');
		$this->load->model('admin/Moneda_model');
		$this->load->model('producto/Producto_model');				
		$this->load->model('producto/Orden_model');
	}

// Start Empresa **********************************************************************************

	public function index(){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['empresas'] = $this->Empresa_model->getEmpresas( );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'admin/empresa/empresa_lista';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['moneda'] = $this->Moneda_model->getAllMoneda();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'admin/empresa/empresa_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		if (isset($_POST)) {
			$this->Empresa_model->save($_POST);
		}

		redirect(base_url()."admin/Empresa/index");
	}

	public function editar( $empresa_id ){
		if(isset($empresa_id)){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['empresa'] = $this->Empresa_model->getEmpresaId( $empresa_id );
		$data['moneda'] = $this->Moneda_model->getAllMoneda();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'admin/empresa/empresa_editar';

		$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/Empresa/index");
		}
	}

	public function update(){
		if (isset($_POST)) {
			$this->Empresa_model->update($_POST);
		}

		redirect(base_url()."admin/Empresa/index");
	}
}