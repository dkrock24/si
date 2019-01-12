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
		$this->load->model('admin/Atributos_model');  
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
		$data = $this->Giros_model->crear_giro( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Giro Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Giro No Fue Creado");
		}	


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
		$data = $this->Giros_model->actualizar_giro( $_POST );

		if($data){
			$this->session->set_flashdata('info', " !");
		}else{
			$this->session->set_flashdata('warning', "El Registro No Fue Actualizado");
		}

		redirect(base_url()."admin/giros/index");
	}

	public function get_atributos( $id_giro ){

		$data['atributos'] = $this->Atributos_model->get_atributos();
		$data['atributos_total'] = $this->Atributos_model->get_atributos_total();
		$data['giro'] = $this->Giros_model->get_giro_id( $id_giro );
		$data['plantilla'] = $this->Giros_model->get_plantilla( $id_giro );
		$data['plantilla_giro_total'] = $this->Giros_model->get_total_plantilla_giro( $id_giro );

		echo json_encode( $data );
		//echo json_encode( $giro );
	}

	public function guardar_giro_atributos(){

		$this->Giros_model->insert_plantilla( $_POST );

		$data['plantilla'] = $this->Giros_model->get_plantilla( $_POST['giro'] );
		$data['plantilla_giro_total'] = $this->Giros_model->get_total_plantilla_giro( $_POST['giro']  );
		
		echo json_encode( $data );
		
	}

	public function eliminar_giro_atributos(){
		$this->Giros_model->eliminar_plantilla( $_POST );

		$data['plantilla'] = $this->Giros_model->get_plantilla( $_POST['giro'] );
		$data['plantilla_giro_total'] = $this->Giros_model->get_total_plantilla_giro( $_POST['giro']  );
		
		echo json_encode( $data );
	}

	// GIROS EMPRESA

	public function listar_giros(){
		$data['lista_giros'] = $this->Giros_model->get_giros();
		$data['lista_empresa'] = $this->Giros_model->get_empresa();

		echo json_encode( $data );
	}

	public function guardar_giro_empresa(){
		$this->Giros_model->insert_giro_empresa( $_POST );
	}

	public function get_empresa_giro( $id_empresa ){
		$data['lista_giros'] = $this->Giros_model->get_empresa_giro( $id_empresa );
		$data['empresa_giro_total'] = $this->Giros_model->get_total_empresa_giro( $id_empresa );

		echo json_encode( $data );
	}

	public function eliminar_giro_empresa(){
		$this->Giros_model->eliminar_giro_empresa( $_POST );

		$data['lista_giros'] = $this->Giros_model->get_empresa_giro( $_POST['empresa']  );
		$data['empresa_giro_total'] = $this->Giros_model->get_total_empresa_giro( $_POST['empresa'] );
		
		echo json_encode( $data );
	}
	

}

?>
