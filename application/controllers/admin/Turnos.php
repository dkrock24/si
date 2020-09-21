<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Turnos extends MY_Controller {

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
		$this->load->helper('seguridad/url_helper');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('accion/Accion_model');
        $this->load->model('admin/ModoPago_model');
        $this->load->model('admin/Turnos_model');
	}

	public function index(){

		$model 		= "Turnos_model";
		$url_page 	= "admin/turnos/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 6);

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['registros'] 		= $this->Turnos_model->getTurno( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= "Turnos";
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/turnos/nuevo';
		$data['title'] = "Crear Nuevo Pago";

		$this->parser->parse('template', $data);
	}

	public function save(){

		if(isset($_POST)){
			$data = $this->Turnos_model->save( $_POST );

			if($data){
				$this->session->set_flashdata('success', "Turno Fue Creado");
			}else{
				$this->session->set_flashdata('danger', "Turno No Fue Creado");
			}
		}

		redirect(base_url()."admin/turnos/index");
	}

	public function editar( $turno_id ){

		$id_rol   = $this->session->roles;
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] 		= $this->session->menu;
		$data['turnos'] 		= $this->Turnos_model->getTurnoId($turno_id);
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] 		= 'admin/turnos/editar';
		$data['title'] 		= "Editar Turno";

		$this->parser->parse('template', $data);
	}

	public function update(){

		if(isset($_POST)){
			$data = $this->Turnos_model->update( $_POST );

			if($data){
				$this->session->set_flashdata('info', "Turno Fue Actualizado");
			}else{
				$this->session->set_flashdata('danger', "Turno No Fue Actualizado");
			}
		}

		redirect(base_url()."admin/turnos/index");
	}

	public function eliminar($id){

		$data = $this->Turnos_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('warning', "Turno Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Turno No Fue Eliminado");
		}
		redirect(base_url()."admin/turnos/index");
	}

	public function column(){

		$column = array(
			'Nombre','Inicio','Fin','Estado'
		);
		return $column;
	}

	public function fields(){
		
		$fields['field'] = array(
			['nombre_turno'    => 'Nombre'],
			['hora_inicio'   => 'Inicio'],
			['hora_fin'      => 'Fin'],
			['orden_estado_nombre'=> 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 	  = array('id_turno');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Turnos";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
}
