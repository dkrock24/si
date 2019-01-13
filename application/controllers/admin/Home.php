<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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

		$this->load->model('admin/Menu_model');
		//$this->load->model('Login_model');
		$this->load->model('admin/Usuario_model');
	}

	public function index()
	{		
		// Construir Menu		
		$this->load->model('Login_model');
		$usuario_id = $this->session->usuario[0]->id_usuario;
		$empleado_id = $this->session->usuario[0]->id_empleado;

		$roles = $this->Usuario_model->get_usuario_roles( $usuario_id );
		
		$roles_id = array();
        foreach ($roles as $rol) {
            $roles_id = $rol->usuario_rol_role;
        }

		$_SESSION['roles'] = $roles_id;
		$_SESSION['menu'] =  $this->Menu_model->getMenu( $roles_id );

		// Validar Permiso en Empresa - Sucursales 
		$permisoEmpresa = $this->Usuario_model->permiso_empresa( $empleado_id );

		if(sizeof($permisoEmpresa) > 1){
			$data['home'] = 'selecionar_empresa';
		}else{
			$data['home'] = 'home';
		}
		
		$data['menu'] = $this->session->menu;		

		$this->parser->parse('template', $data);
	}
}