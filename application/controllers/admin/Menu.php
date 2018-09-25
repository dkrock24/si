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
		$this->load->library('session');
		$this->load->helper('url');

		$this->load->model('admin/Menu_model');
		$this->load->model('Login_model');   
	}

	public function index()
	{
		// Construir Menu
		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['home'] = 'admin/menu/menu';

		$this->parser->parse('template', $data);
	}

	public function submenu( $id_menu ){
		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['submenus'] = $this->Menu_model->getSubMenu( $id_menu );		
		$data['home'] = 'admin/menu/submenu';

		$this->parser->parse('template', $data);
	}

	public function editar_menu( $id_menu ){
		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['onMenu'] = $this->Menu_model->getOneMenu( $id_menu );

		$data['home'] = 'admin/menu/menueditar';			

		$this->parser->parse('template', $data);
	}

	public function update_menu(){

		$this->Menu_model->update_menu( $_POST );

		redirect(base_url()."admin/menu/index");
	}

	public function editar_sub_menu( $id_sub_menu ){
		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['allMenus'] = $this->Menu_model->getAllMenu();
		$data['onMenu'] = $this->Menu_model->getOneSubMenu( $id_sub_menu );

		$data['home'] = 'admin/menu/submenueditar';			

		$this->parser->parse('template', $data);
	}

	public function update_sub_menu(){

		$this->Menu_model->update_sub_menu( $_POST );

		redirect(base_url()."admin/menu/index");
	}
}