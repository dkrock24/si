<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nodo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    $this->load->library('../controllers/general');
		$this->load->helper('url');	

		$this->load->model('admin/Nodos_model');
	}

	public function index($key = 0)
	{
		if ($key) {
			$results = $this->Nodos_model->get_ordenes_by_key($key);

			//var_dump($results);
			
			$results = $this->transfor_data($results);
			$results['ordenes'] = $results;
			
		}
		$this->load->view('nodo', $results);
	}


	private function transfor_data(array $results)
	{
		//var_dump((array)$results['categorias']);
		$categorias = [];
		foreach ($results['categorias'] as $key => $cat) {
			$categorias[] = $cat['id_categoria'];
		}
		
		return $ordenesFiltradas = array_filter($results['ordenes'], function($index, $key) use($categorias) {

			return array_filter($index->detalle, function($index, $key) use($categorias) {
				if(in_array($index->categoria, $categorias)) {
					return $index;
				}
			}, ARRAY_FILTER_USE_BOTH);
		}, ARRAY_FILTER_USE_BOTH);
	}
}
