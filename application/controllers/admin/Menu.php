<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

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
		$this->load->model('Login_model');   
	}

	public function index(){
		// Construir Menu basado en el rol de usuario

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['lista_menu'] = $this->Menu_model->lista_menu();
		$data['home'] = 'admin/menu/menu';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['home'] = 'admin/menu/nuevoMenu.php';

		$this->parser->parse('template', $data);
	}

	public function save_menu(){

		$this->Menu_model->save_menu( $_POST );

		redirect(base_url()."admin/menu/index");
	}

	public function submenu( $id_menu ){
		// Selecionar todos los submenus de cada menu

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['submenus'] = $this->Menu_model->getSubMenu( $id_menu );		
		$data['home'] = 'admin/menu/submenu';

		$this->parser->parse('template', $data);
	}

	public function editar_menu( $id_menu ){
		// Cargar menu para editar

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['onMenu'] = $this->Menu_model->getOneMenu( $id_menu );

		$data['home'] = 'admin/menu/menueditar';			

		$this->parser->parse('template', $data);
	}

	// Cargar formulario para nuevo menu
	public function nuevo_submenu( $id_menu ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['allMenus'] = $this->Menu_model->getAllMenu();
		$data['home'] = 'admin/menu/nuevo_sub_menu.php';
		$data['id_menu'] = $id_menu;

		$this->parser->parse('template', $data);
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

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['allMenus'] = $this->Menu_model->getAllMenu();
		$data['onMenu'] = $this->Menu_model->getOneSubMenu( $id_sub_menu );

		$data['home'] = 'admin/menu/submenueditar';			

		$this->parser->parse('template', $data);
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

	public function delete_sub_menu( $id_sub_menu ){
		$this->Menu_model->delete_sub_menu( $id_sub_menu );
		redirect(base_url()."admin/menu/index");
	}
}