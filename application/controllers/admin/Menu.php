<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    @$this->load->library('session');
	    
		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');

		$this->load->model('admin/Menu_model');
		$this->load->model('Login_model');   
		$this->load->model('admin/Url_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/Vistas_model');
	}

	public function index(){
		
		// Construir Menu basado en el rol de usuario
		$data['title'] 		= "Menus";	
		$data['home'] 		= 'admin/menu/menu';
		$data['menu'] 		= $this->session->menu;
		$data['lista_menu'] = $this->Menu_model->lista_menu();

		echo $this->load->view('admin/menu/menu',$data, TRUE);
	}

	public function nuevo(){
		$data['title'] 	= "Nuevo Menu";	
		$data['menu'] 	= $this->session->menu;
		$data['home']	= 'admin/menu/nuevoMenu.php';

		echo $this->load->view('admin/menu/nuevoMenu',$data, TRUE);
	}

	public function crear(){
		$this->Menu_model->save_menu( $_POST );
		redirect(base_url()."admin/menu/index");
	}

	public function submenu( $id_menu ){
		// Selecionar todos los submenus de cada menu

		$data['title'] 		= "SubMenu";			
		$data['home'] 		= 'admin/menu/submenu';
		$data['menu'] 		= $this->session->menu;
		$data['submenus'] 	= $this->Menu_model->getSubMenu( $id_menu );

		echo $this->load->view('admin/menu/submenu',$data, TRUE);
	}

	public function editar_menu( $id_menu ){
		// Cargar menu para editar

		$data['title'] 	= "Editar Menu";	
		$data['menu'] 	= $this->session->menu;
		$data['home'] 	= 'admin/menu/menueditar';
		$data['onMenu'] = $this->Menu_model->getOneMenu( $id_menu );

		echo $this->load->view('admin/menu/menueditar',$data, TRUE);
	}

	// Cargar formulario para nuevo menu
	public function nuevo_submenu( $id_menu ){

		$data['id_menu'] 	= $id_menu;
		$data['title'] 		= "Nuevo SubMenu";	
		$data['menu'] 		= $this->session->menu;
		$data['home'] 		= 'admin/menu/nuevo_sub_menu.php';
		$data['allMenus'] 	= $this->Menu_model->getAllMenu();
		$data['vistas2'] 	= $this->Vistas_model->get_all_vistas();

		echo $this->load->view('admin/menu/nuevo_sub_menu',$data, TRUE);
	}

	public function save_sub_menu( $id_menu ){
		// Guardar nuevo sub menu
		$this->Menu_model->save_sub_menu( $_POST );
		redirect(base_url()."admin/menu/submenu/". $id_menu );
	}

	public function update_menu(){
		// Update Menu
		$this->Menu_model->update_menu( $_POST );
		redirect(base_url()."admin/menu/index");
	}

	public function editar_sub_menu( $id_sub_menu ){
		// Cargar sub menu para editar

		$data['title'] 		= "Editar SubMenu";
		$data['menu'] 		= $this->session->menu;
		$data['home'] 		= 'admin/menu/submenueditar';			
		$data['allMenus'] 	= $this->Menu_model->getAllMenu();
		$data['vistas'] 	= $this->Vistas_model->get_all_vistas();
		$data['vistas2'] 	= $this->Vistas_model->get_all_vistas();
		$data['onMenu'] 	= $this->Menu_model->getOneSubMenu( $id_sub_menu );

		echo $this->load->view('admin/menu/submenueditar',$data, TRUE);
	}

	public function update_sub_menu(){
		// Update sub menu 
		$this->Menu_model->update_sub_menu( $_POST );
		redirect(base_url()."admin/menu/submenu/". $_POST['id_menu']);
	}

	public function delete( $id_menu ){
		$this->Menu_model->delete_menu( $id_menu );
		redirect(base_url()."admin/menu/index");
	}

	public function delete_sub_menu( $id_sub_menu , $menu_id){
		$this->Menu_model->delete_sub_menu( $id_sub_menu );
		redirect(base_url()."admin/menu/submenu/".$menu_id );
	}
}