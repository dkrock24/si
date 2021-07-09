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
			$results = $this->Nodos_model->get_ordenes_by_key($key, $filter=null);
			if($results['ordenes']) {
				
				$results['ordenes'] = $this->transfor_data($results);
			}
		}
		
		$this->load->view('nodo', $results);
	}

	public function polling($key = 0)
	{
		if ($key) {
			$results = $this->Nodos_model->get_ordenes_by_key($key, $filter='polling');

			if($results['ordenes']) {
				$results['ordenes'] = $this->transfor_data($results);
			}
		}
		echo json_encode($results);
	}

	private function transfor_data(array $results)
	{
		$categorias = [];
		foreach ($results['categorias'] as $key => $cat) {
			$categorias[] = $cat['id_categoria'];
		}

		foreach ($results['ordenes'] as $key1 => $ordenes) {

			foreach ($ordenes->detalle as $key2 => $detalle) {

				if(in_array((int)$detalle->categoria, $categorias)) {
					//$castResult[$ordenes][$key2]->detalle = $detalle;
					$results['ordenes'][$key1]->detalle[$key2] = $detalle;
				} else {
					unset($results['ordenes'][$key1]->detalle[$key2]);
				}
			}
		}

		return $results['ordenes'];
	}

	public function moverComanda()
	{
		if ($_POST['env']) {

			$this->Nodos_model->moverComanda($_POST['env']);
			$result = true;
		}
		return $result;
	}
}
