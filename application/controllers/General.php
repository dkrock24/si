<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

	function __construct()
	{
		
	}

	public function editar_valido($data, $url){
		
		$_flag = false;

		if(!$data){
			redirect(base_url().$url);
		}
	}
}