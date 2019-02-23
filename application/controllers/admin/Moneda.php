<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moneda extends CI_Controller {

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

	public function index(){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['monedas'] = $this->Moneda_model->getMoneda();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'admin/moneda/moneda_lista';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/moneda/moneda_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){
		if(isset($_POST)){
			$this->Moneda_model->save( $_POST );
		}

		redirect(base_url()."admin/moneda/index");
	}

	public function editar( $moneda_id ){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['monedas'] = $this->Moneda_model->getMonedaId($moneda_id);
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'admin/moneda/moneda_editar';

		$this->parser->parse('template', $data);
	}

	public function update(){
		if(isset($_POST)){
			$this->Moneda_model->update( $_POST );
		}

		redirect(base_url()."admin/moneda/index");
	}
}
