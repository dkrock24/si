<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Giros extends CI_Controller {

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

		$this->load->model('admin/Giros_model');  
		$this->load->model('admin/Menu_model');
	}

// Start  **********************************************************************************

	public function index(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['lista_giros'] = $this->Giros_model->get_giros();
		$data['home'] = 'admin/giros/giros_lista';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );		
		$data['home'] = 'admin/giros/giros_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert Nuevo Giro
		$this->Giros_model->crear_giro( $_POST );

		redirect(base_url()."admin/giros/index");
	}

	public function editar( $id_giro ){
		
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );		
		$data['giros'] = $this->Giros_model->get_giro_id( $id_giro );
		$data['home'] = 'admin/giros/giros_editar';

		$this->parser->parse('template', $data);
	}

	public function actualizar(){
		// Actualizar Giro 
		$this->Giros_model->actualizar_giro( $_POST );

		redirect(base_url()."admin/giros/index");
	}
	

}

?>
