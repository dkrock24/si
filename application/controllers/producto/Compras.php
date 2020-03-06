<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends MY_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('../controllers/general');

		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');
		$this->load->helper('paginacion/paginacion_helper');	
	}

	public function index()
	{
		$model = "Compras_model";
		$url_page = "producto/compras/index";
		$pag = $this->MyPagination($model, $url_page, $vista = 89) ;

		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['registros'] = $this->Traslado_model->getTraslado( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['title'] = "Compras";
		$data['home'] = 'template/lista_template';		

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
    }

    public function nuevo(){
        
    }

    public function column(){

		$column = array(
			'Correlativo','Firma Salida','Firma Llegada','Salida','Llegada','Placa','Descripcion','Creado','Estado'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			'correlativo_tras','envia','recibe','fecha_salida','fecha_llegada','transporte_placa','descripcion_tras','creado_tras','estado'
		);
		
		$fields['id'] 		= array('id_tras');
		$fields['estado'] 	= array('estado_tras');
		$fields['titulo'] 	= "Compras Lista";
		$fields['estado_alterno'] 	= "Completado";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

    }
    
}