<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->load->database('client', true);

		 
		@$this->load->library('session');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function login(){

		$this->load->model('login_model');

		if(isset($_POST['usuario']) and isset($_POST['passwd'])){	

			$usuario = $_POST['usuario'];
			$passwd  = $_POST['passwd'];

			$user['usuario'] = $this->login_model->login( $usuario , $passwd );	

			if($user['usuario'] != 0){	
				//$_SESSION = $user;
				$_SESSION['db'] = $user;
				
				header("location: validar");

			}else{

				$this->load->view('login');
			}
		}		
		else{			
			$this->load->view('login');
		}
	}

	public function validar(){

		$this->load->model('Login_model');

		$a = @$_SESSION['db']['usuario'][0]->nombre_usu;
		$b = @$_SESSION['db']['usuario'][0]->password_usu;

		$user = array();
		$user = $this->Login_model->autenticacion( $a , $b );	

			if($user != 0){	
				session_start();
				$_SESSION['usuario'] = $user;
				
				header("location:../admin/home/index");

			}else{

				$this->load->view('login');
			}
	}

	public function logout(){
		$this->session->sess_destroy();
		$this->load->view('login');
	}
}

