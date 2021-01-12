<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Integrador extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->database();

        $this->load->library('parser');
        @$this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('../controllers/general');
        $this->load->helper('url');
        $this->load->helper('paginacion/paginacion_helper');

        $this->load->model('accion/Accion_model');
        $this->load->model('admin/Integrador_model');
    }


    public function index()
    {

        $model 		= "Integrador_model";
		$url_page 	= "admin/integrador/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 6) ;

		// Seguridad :: Validar URL usuario	

		$data['menu'] 			= $this->session->menu;
		$data['registros'] 		= $this->Integrador_model->getIntegrador(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['links'] 			= $pag['links'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['filtros'] 		= $pag['field'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol'] );
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= "Integrador";
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

        $this->parser->parse('template', $data);
    }

    public function crear()
    {
        $data['menu'] 	= $this->session->menu;
		$data['home'] 	= 'data/integrador/crear';
		$data['title'] 	= "Crear Integracion";

		$this->parser->parse('template', $data);
    }

    public function save()
    {
        if(isset($_POST)){
			$data = $this->Integrador_model->save( $_POST );

			if($data){
				$this->session->set_flashdata('success', "Integrador Fue Creado");
			}else{
				$this->session->set_flashdata('danger', "Integrador No Fue Creado");
			}
		}

		redirect(base_url()."data/integrador/index");
    }

    public function editar( $integrador ){

		$id_rol = $this->session->roles;
		$vista_id = 6; // Vista Orden Lista

		$data['menu'] 		= $this->session->menu;
		$data['integrador']	= $this->Integrador_model->getIntegradorId($integrador);
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] 		= 'data/integrador/editar';
		$data['title'] 		= "Editar Moneda";

		$this->parser->parse('template', $data);
    }
    
    public function update()
    {
        if(isset($_POST)){
			$data = $this->Integrador_model->update( $_POST );

			if($data){
				$this->session->set_flashdata('info', "Integrador Fue Actualizado");
			}else{
				$this->session->set_flashdata('danger', "Integrador No Fue Actualizado");
			}
		}

		redirect(base_url()."data/integrador/index");
    }

    public function eliminar($id){

		$data = $this->Integrador_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('warning', "Integrador Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Integrador No Fue Eliminado");
		}
		redirect(base_url()."data/integrador/index");
	}

    public function column(){

		$column = array(
			'Nombre','URL','ACCION','Estado'
		);
		return $column;
	}

	public function fields(){
		
		$fields['field'] = array(
			['nombre_integrador' => 'Nombre'],
			['url_integrador' => 'Simbolo'],
			['accion_integrador' => 'Alias'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_integrador');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Integrador Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
}