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

	public function index(){
		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['pais'] = $this->Pais_model->get_pais();
		$data['home'] = 'admin/pais/pais';

		$this->parser->parse('template', $data);
	}
	
	public function nuevo(){
		// NUEVO PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['home'] = 'admin/pais/pais_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert pais
		$this->Pais_model->crear_pais( $_POST );

		redirect(base_url()."admin/pais/index");
	}

	public function edit( $id_pais ){
		// EDITAR PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['pais'] = $this->Pais_model->edit_pais( $id_pais );
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

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['depart'] = $this->Pais_model->get_dep( $pais_id );
		$data['id_departamento'] = $pais_id;
		$data['home'] = 'admin/pais/dep';

		$this->parser->parse('template', $data);
	}

	public function nuevo_dep( $id_pais ){
		// Mostrar formulario para crear nuevo departamento

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
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

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
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

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['ciu']  = $this->Pais_model->get_ciu( $id_dep );
		$data['home'] = 'admin/pais/ciu';

		$this->parser->parse('template', $data);
	}

	public function nuevo_ciu( $id_dep ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['dep']  =  $id_dep;
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
		$data['ciu']  =  $this->Menu_model->get_ciu( $id_ciu );
		$data['home'] = 'admin/pais/ciu_editar';

		$this->parser->parse('template', $data);
	}

	public function update_ciu(){

		$this->Pais_model->update_ciu( $_POST );
		
		redirect(base_url()."admin/pais/ciudad/".$_POST['id_ciu']);
	}

}

?>
