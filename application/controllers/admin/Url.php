<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Url extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Este controlador cumple el objetivo de validar los acceso a las urls de los usuarios
	 * basado en menus y roles.
	 */

	public function __construct()
	{
		parent::__construct();    
		$this->load->database();    

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->helper('url');

		$this->load->model('admin/Url_model');
	}

	public function index()
	{	
		return 1;
	}

	public function acceso_url( $role_id , $vista_id, $menu_is ){
		
		$acceso_url = false;

		$acceso = $this->Url_model->acceso_url( $role_id , $vista_id, $menu_is );

		if($acceso){
			$acceso_url = TRUE;
		}

		return $acceso_url;
	}


}