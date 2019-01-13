<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

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

		$this->load->model('admin/Categorias_model');  
		$this->load->model('admin/Menu_model');
	}

// Start PAIS **********************************************************************************

	public function index(){
		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['lista_categorias'] = $this->Categorias_model->get_categorias();
		$data['home'] = 'admin/categorias/categorias_lista';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['categorias']	= $this->Categorias_model->get_categorias_padres();
		$data['home'] = 'admin/categorias/categorias_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){

		// Crear Categoria y Sub Categoria
		$this->Categorias_model->crear_categoria( $_POST );
		redirect(base_url()."admin/categorias/index");
	}

	public function edit( $id_categoria ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;		
		$data['categorias'] = $this->Categorias_model->get_categoria_id( $id_categoria );
		$data['categorias_padres']	= $this->Categorias_model->get_categorias_padres();
		$data['home'] = 'admin/categorias/categorias_editar';

		$this->parser->parse('template', $data);
	}

	public function actualizar(){
		// Insert pais
		$this->Categorias_model->actualizar_categoria( $_POST );

		redirect(base_url()."admin/categorias/index");
	}
	
	

}

?>
