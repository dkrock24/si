<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database();    

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->helper('url');

		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/Empresa_model');
		$this->load->model('admin/Vistas_model');
		$this->load->model('Dashboard_model');
	}

	public function index()
	{		
		// Construir Menu		
		$this->load->model('Login_model');
		$usuario_id = $this->session->usuario[0]->id_usuario;

		$roles = $this->Usuario_model->get_usuario_roles( $usuario_id );
		$empleado_id = $this->session->usuario[0]->id_empleado;
		
		$roles_id = array();
		if(isset($roles)){
	        foreach ($roles as $rol) {
	            $roles_id = $rol->usuario_rol_role;
	        }

	        $_SESSION['roles'] = $roles_id;
			$_SESSION['menu'] =  $this->Menu_model->getMenu( $roles_id );
	    }else{
	    	$_SESSION['msj'] = "No Existen Menus Asignados";
			header("location: info");
		}

		// Obtener toda la informacion de la empresa en session.
		$empresa_id = $this->Usuario_model->permiso_empresa( $empleado_id );		

		$empresa_session = $this->session->empresa_id;
				
		if(isset($empresa_id)){
			if(isset($empresa_session)){
				//$_SESSION['empresa'] = $this->Usuario_model->permiso_empresa( $empresa_session );
				//get_empresa_by_id
				$_SESSION['empresa'] = $this->Empresa_model->getEmpresaId( $empresa_session );		
			}else{
				$_SESSION['empresa'] = $this->Empresa_model->getEmpresaId( $empresa_id[0]->id_empresa );				
			}
		}else{
			
			$_SESSION['msj'] = "No Existen Sucursales Asociadas al Usuario";
			header("location: info");
		}
		//echo $_SESSION['empresa'][0]->Empresa_Suc;

		$data['home'] = 'login/logout';
		$data['menu'] = $this->session->menu;

		if( $this->session->usuario[0]->pagina ){
			
			redirect( base_url().$this->session->usuario[0]->pagina );
		}

		$this->parser->parse('template', $data);
	}

	function dashboard(){

		$total_ordenes_mes = $this->Dashboard_model->ordenes_mes();
		$orden_total = "";
		$orden_suma = 0;
		foreach ($total_ordenes_mes as $key => $orden) {
			$orden_total = $orden_total.= ",".$orden->total;
			$orden_suma += $orden->total; 
		}

		$resultados = array(
			'ordenes' 	=> $this->Dashboard_model->total_ordenes(),
			'ventas' 	=> $this->Dashboard_model->total_ventas(),
			'cajas' 	=> $this->Dashboard_model->terminal_caja(),
			'terminales'=> $this->Dashboard_model->total_ordenes(),
			'usuario_actividad' => $this->Dashboard_model->usuarios_actividad(),
			'ordenes_mes' => $orden_total,
			'ordenes_suma' => $orden_suma
		);

		$data['data'] = $resultados;
		$data['home'] = 'home';
		$data['menu'] = $this->session->menu;

		$this->parser->parse('template', $data);

	}

	function seleccionar_empresa(){
		// Construir Menu		
		$this->load->model('Login_model');
		$usuario_id = $this->session->usuario[0]->id_usuario;
		$empleado_id = $this->session->usuario[0]->id_empleado;

		$roles = $this->Usuario_model->get_usuario_roles( $usuario_id );
		
		$roles_id = array();
		if(isset($roles)){
			foreach ($roles as $rol) {
	            $roles_id = $rol->usuario_rol_role;
	        }

	        $_SESSION['roles'] = $roles_id;
			$_SESSION['menu'] =  $this->Menu_model->getMenu( $roles_id );
		}

		$data['empresa'] = $this->get_empresa_informacion( $empleado_id );
		$permisoEmpresa = $data['empresa'];

		if(sizeof($permisoEmpresa) <= 1){
			header("location: index");
			$data['home'] = 'home';
		}else{
			$data['home'] = 'selecionar_empresa';
		}

		$data['menu'] = $this->session->menu;		

		$this->parser->parse('template', $data);
	}

	function set_empresa($empresa_id){
		$empresa = false;
		if(isset($empresa_id) and $empresa_id != 0){
			$_SESSION['empresa_id'] = $empresa_id;
			$empresa = true;
		}else{
			$empresa = false;
		}
		echo json_encode($empresa);
	}

	function buscar(){

		if(isset($_POST['buscar'])){
			
			$buscar_vista = $_POST['buscar'];

			$data['vistas'] = $this->Vistas_model->buscar_vista( $buscar_vista );

			if( $data['vistas'] ){

				$menu = $this->session->menu;

				$result = "";

				foreach ($menu as $key => $value) {					
					if($value->id_submenu == $data['vistas'][0]->id_submenu ){
						$result = $value->id_submenu;
						continue;
					}
				}

				if($result == $data['vistas'][0]->id_submenu ){
					redirect(base_url().$data['vistas'][0]->vista_url);
				}else{
					redirect(base_url()."admin/home/index");
				}
				
			}else{				
				redirect(base_url()."admin/home/index");
			}

		}
	}

	function get_empresa_informacion( $empleado_id ){
		// Validar Permiso en Empresa - Sucursales 
		$permisoEmpresa = $this->Usuario_model->permiso_empresa( $empleado_id );
		return $permisoEmpresa;
	}

	function info(){
		$data['msj'] = $this->session->msj;
		$data['home'] = 'admin/notificaciones/informacion';

		$this->parser->parse('template', $data);
	}

}