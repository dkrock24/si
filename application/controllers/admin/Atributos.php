<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atributos extends CI_Controller {

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

		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
	}

// Start PAIS **********************************************************************************

	public function index(){
		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['lista_atributos'] = $this->Atributos_model->get_atributos();
		$data['home'] = 'admin/atributos/atributos_lista';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );		
		$data['home'] = 'admin/atributos/atributos_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert pais
		$this->Atributos_model->crear_atributo( $_POST );

		redirect(base_url()."admin/atributos/index");
	}

	public function edit( $id_prod_atributo ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );		
		$data['atributo'] = $this->Atributos_model->get_atributo_id( $id_prod_atributo );
		$data['home'] = 'admin/atributos/atributos_editar';

		$this->parser->parse('template', $data);
	}

	public function actualizar(){
		// Insert pais
		$this->Atributos_model->actualizar_atributo( $_POST );

		redirect(base_url()."admin/atributos/index");
	}
	
	

}

?>
