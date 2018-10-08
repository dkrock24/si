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
		$this->load->helper('url');

		$this->load->model('admin/Pais_model');  
		$this->load->model('admin/Menu_model');
	}

	// Start PAIS **********************************************************************************

	// Get Pais
	public function index(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['pais'] = $this->Pais_model->index();
		$data['home'] = 'admin/pais/pais';

		$this->parser->parse('template', $data);
	}

	// EDITAR PAIS //

	public function nuevo(){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['home'] = 'admin/pais/nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){

		$this->Pais_model->crear( $_POST );

		redirect(base_url()."admin/pais/index");
	}

	public function pais_edit( $id_pais ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['pais'] = $this->Pais_model->pais_edit( $id_pais );
		$data['home'] = 'admin/pais/pais_edit';

		$this->parser->parse('template', $data);
	}
	
	// UPDATE PAIS //
	public function pais_update( ){

		$data['pais'] = $this->Pais_model->pais_update( $_POST );
		
		redirect(base_url()."admin/pais/index");
	}

	// DELETE PAIS //
	public function pais_delete( $id_pais ){

		$data['pais'] = $this->Pais_model->pais_delete( $id_pais );
		
		redirect(base_url()."admin/pais/index");
	}

	// End PAIS

	// Start Departamento **********************************************************************************

	public function dep( $pais_id ){
		// Obtener todos los departamentos

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['depart'] = $this->Pais_model->get_pais_dep( $pais_id );
		$data['id_departamento'] = $pais_id;
		$data['home'] = 'admin/pais/pais_dep';

		$this->parser->parse('template', $data);
	}

	public function nuevo_dep( $id_pais ){
		// Mostrar formulario para crear nuevo departamento

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['id_pais'] = $id_pais;
		$data['home'] = 'admin/pais/pais_dep_nuevo';

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

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['dep'] = $this->Pais_model->editar_dep( $id_dep );
		$data['home'] = 'admin/pais/pais_dep_editar';

		$this->parser->parse('template', $data);
	}

	public function update_dep(){

		$this->Pais_model->update_dep( $_POST );
		
		redirect(base_url()."admin/pais/dep/".$_POST['id_pais']);
	}

	// End Departamento

	// Start Ciudad **********************************************************************************

	public function ciudad($id_dep){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['ciu'] = $this->Pais_model->get_pais_dep_ciu( $id_dep );
		$data['home'] = 'admin/pais/pais_dep_ciu';

		$this->parser->parse('template', $data);
	}

	public function ciudad_nuevo( $id_dep ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['dep'] =  $id_dep;
		$data['home'] = 'admin/pais/ciu_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear_ciu(){

		$this->Pais_model->crear_ciu( $_POST );
		
		redirect(base_url()."admin/pais/ciudad/".$_POST['id_departamento']);
	}

	public function editar_ciu( $id_ciu ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['ciu'] =  $this->Menu_model->get_ciu( $id_ciu );
		$data['home'] = 'admin/pais/ciu_editar';

		$this->parser->parse('template', $data);
	}

	public function update_ciu(){
		$this->Pais_model->update_ciu( $_POST );
		
		redirect(base_url()."admin/pais/ciudad/".$_POST['id_ciu']);
	}

	

	

	//public function actualizar(){}

	//public function ver(){}

	//public function eliminar(){}
}

?>
