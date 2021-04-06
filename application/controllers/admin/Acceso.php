<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acceso extends CI_Controller {

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
			$_SESSION['accesos'] 				=  $this->Acceso_model->get_menu_acceso( $_POST['role'] , $_POST['menu'] , NULL );
			$_SESSION['accesos_menus_internos'] =  $this->Acceso_model->get_menu_internos( $_POST['role'] , $_POST['menu'] );
			$_SESSION['vista_componentes'] 		=  $this->Acceso_model->accesos_componentes( $_POST['role'] , $_POST['menu']);

			$data['roles'] = $this->Acceso_model->getRoles();
			$data['menus'] = $this->Menu_model->lista_menu();
			$_SESSION['r'] = $_POST['role'];
			$_SESSION['m'] = $_POST['menu'];
			$data['r'] 	   = $_SESSION['r'];
			$data['m'] 	   = $_SESSION['m'];

			$data['accesos'] = $_SESSION['accesos'];
			$data['vista_componentes'] = $_SESSION['vista_componentes'];
			$data['accesos_menus_internos'] = $_SESSION['accesos_menus_internos'];

		}else{

			if(isset($_SESSION['accesos'])){

				$data['accesos'] = $this->Acceso_model->get_menu_acceso( $_SESSION['r'] , $_SESSION['m'] , NULL );
				$data['accesos_ms_internos'] = $this->Acceso_model->get_menu_internos( $_SESSION['r'] , $_SESSION['m'] );
				$data['vista_componentes'] = $this->Acceso_model->accesos_componentes( $_SESSION['r'] , $_SESSION['m']);
	
				$data['r'] = $_SESSION['r'];
				$data['m'] = $_SESSION['m'];	
				$data['roles'] = $this->Acceso_model->getRoles();	
				$data['menus'] = $this->Menu_model->lista_menu();
				
			}else{
				$data['roles'] = $this->Acceso_model->getRoles();	
				$data['menus'] = $this->Menu_model->lista_menu();
			}
		}

		$data['menu'] 	= $this->session->menu;
		$data['titulo'] = "Menu Accesos";
		$data['home'] 	= 'admin/acceso/Vacceso.php';
		echo $this->load->view('admin/acceso/Vacceso',$data, TRUE);

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

	public function sincAccionesRoles(){

		$this->Acceso_model->sincAccionesRoles();
		
		$this->index();
	}
}