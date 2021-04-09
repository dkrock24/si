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

		// Cargamos la base de datos prefijada client y definida en conf del framework
		//$this->load->database('client', true);
		$this->load->database();
		@$this->load->library('session');
		$this->load->helper('url');
	}

	public function index()
	{
		// Este metodo carga la vista del login del sistema
		$this->load->view('login');
	}

	public function login(){
		// Se autentica el usuario luego de ingresar sus credenciales
		$this->load->model('Login_model');

		if(isset($_POST['usuario']) and isset($_POST['passwd'])){	

			$usuario = $_POST['usuario'];
			$passwd  = $_POST['passwd'];
			$uuid	 = $_POST['uuid'];

			// Autenticamos al usuario respecto a su negocio
			$user = $this->Login_model->autenticacion( $usuario , $passwd );	
			if($user != 0){	
				$_SESSION['db'] = $user;
				
				// Usuario encontrado y redireccionado para validarlo a su empresa
				//header("location: validar");
					//session_start();
					
					$_SESSION['usuario'] = $user;					
					$_SESSION['uuid'] = $uuid;

					header("location:../admin/home/seleccionar_empresa");

			}else{
				$this->session->set_flashdata('warning', "Usuario / Password Incorrectos");
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
		
		//$roles = $this->Usuario_model->get_usuario_roles( $user[0]->id_usuario );

			if($user != 0){	
				session_start();
				
				$_SESSION['usuario'] = $user;
				//Empresa_Suc

				header("location:../admin/home/seleccionar_empresa");

			}else{
				$this->session->set_flashdata('warning', "Usuario / Password Incorrectos");
				$this->load->view('login');
			}
	}

	public function logout(){
		$this->session->sess_destroy();
		$this->load->view('login');
	}
}

