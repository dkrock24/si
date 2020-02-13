<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends My_Controller {

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
	     $this->load->library('pagination');     

		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

        $this->load->model('admin/Reporte_model');  
        $this->load->model('admin/Turnos_model');  
        $this->load->model('admin/Usuario_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
	}

// Start Report **********************************************************************************

	public function index(){

        $data['turno'] = $this->Turnos_model->getTurnos();
        $data['cajero'] = $this->Usuario_model->get_cajeros('Cajero');

        if( isset( $_POST['fecha_i'])){
            
            $filters = array(
                'fh_inicio' => $_POST['fecha_i'],
                'fh_fin'    => $_POST['fecha_f'],
                'turno'     => $_POST['turno'],
                'cajero'    => $_POST['cajero']
            );
    
            $data['result'] = $this->Reporte_model->filtrar_venta($filters);
        }

        $data['menu'] = $this->session->menu;
        $data['title'] = 'Reportes';
        $data['home'] = 'admin/reporte/index';

		$this->parser->parse('template', $data);
    }
	

}

?>
