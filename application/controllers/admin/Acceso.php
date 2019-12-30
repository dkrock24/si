<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acceso extends CI_Controller {

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

		$this->load->model('admin/Acceso_model');
		$this->load->model('admin/Menu_model');
		$this->load->model('Login_model');
	}

	public function index()
	{
		if(isset($_POST['role']) and isset($_POST['menu'])){

			//$this->Acceso_model->sincronizar_componentes( $_POST['role'],  $_POST['menu']);

			$_SESSION['accesos'] 				=  $this->Acceso_model->get_menu_acceso( $_POST['role'] , $_POST['menu'] , NULL );
			
			$_SESSION['accesos_menus_internos'] =  $this->Acceso_model->get_menu_internos( $_POST['role'] , $_POST['menu'] );
			
			$_SESSION['vista_componentes'] 		=  $this->Acceso_model->accesos_componentes( $_POST['role'] , $_POST['menu']);
			

			$data['roles'] 	=  $this->Acceso_model->getRoles();
			$data['menus'] 	=  $this->Menu_model->lista_menu();

			$_SESSION['r'] = $_POST['role'];
			$_SESSION['m'] = $_POST['menu'];

			$data['r'] 		= $_SESSION['r'];
			$data['m'] 		= $_SESSION['m'];

			$data['accesos']= $_SESSION['accesos'];
			$data['vista_componentes']= $_SESSION['vista_componentes'];
			$data['accesos_menus_internos'] = $_SESSION['accesos_menus_internos'];

		}else{

			if(isset($_SESSION['accesos'])){

				$data['accesos']= $_SESSION['accesos'];
				$data['vista_componentes']= $_SESSION['vista_componentes'];
				$data['accesos_menus_internos'] = $_SESSION['accesos_menus_internos'];
	
				$data['r'] 		= $_SESSION['r'];
				$data['m'] 		= $_SESSION['m'];
	
				$data['roles'] =  $this->Acceso_model->getRoles();	
				$data['menus'] =  $this->Menu_model->lista_menu();
				
			}else{
	
				$data['roles'] =  $this->Acceso_model->getRoles();	
				$data['menus'] =  $this->Menu_model->lista_menu();
			}

		}

		$data['menu'] 	= $this->session->menu;		
		$data['title'] 	= "Menu Accesos";	
		$data['home'] 	= 'admin/acceso/Vacceso.php';

		$this->parser->parse('template', $data);

	}

	public function acceso_guardar(){

		if(isset($_POST)){
			$this->Acceso_model->update_acceso_menu( $_POST );	
		}
		redirect(base_url()."admin/acceso/index" );
	}

	public function accesos_menus_internos(){

		if(isset($_POST)){
			$this->Acceso_model->update_acceso_menu_interno( $_POST );	
		}
		redirect(base_url()."admin/acceso/index" );
	}

	public function accesos_componenes(){

		if(isset($_POST)){
			$this->Acceso_model->accesos_componenes( $_POST );	
		}
		redirect(base_url()."admin/acceso/index" );
	}

	function sincAccionesRoles(){
		$this->Acceso_model->sincAccionesRoles();
		redirect(base_url()."admin/acceso/index" );
	}

	


	
}