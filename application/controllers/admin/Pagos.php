<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos extends MY_Controller {

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
        $this->load->model('admin/Pagos_model');
	}

	public function index(){

		$model 		= "Pagos_model";
		$url_page 	= "admin/pagos/index";
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
		$data['registros'] 		= $this->Pagos_model->getPagos( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= "Tipo de pago";
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/pagos/p_nuevo';
		$data['title'] = "Crear Nuevo Pago";

		echo $this->load->view('admin/pagos/p_nuevo',$data, TRUE);
	}

	public function crear(){

		if(isset($_POST)){
			$data = $this->Pagos_model->save( $_POST );

			if($data){
				$this->session->set_flashdata('success', "Tipo Pago Fue Creado");
			}else{
				$this->session->set_flashdata('danger', "Tipo Pago No Fue Creado");
			}
		}

		redirect(base_url()."admin/pagos/index");
	}

	public function editar( $pago_id ){

		$id_rol = $this->session->roles;
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] 		= $this->session->menu;
		$data['pagos'] 		= $this->Pagos_model->getPagoId($pago_id);
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] 		= 'admin/pagos/p_editar';
		$data['title'] 		= "Editar Forma Pago";

		echo $this->load->view('admin/pagos/p_editar',$data, TRUE);
	}

	public function update(){

		if(isset($_POST)){
			$data = $this->Pagos_model->update( $_POST );

			if($data){
				$this->session->set_flashdata('info', "Tipo Pago Fue Actualizado");
			}else{
				$this->session->set_flashdata('danger', "Tipo Pago No Fue Actualizado");
			}
		}

		redirect(base_url()."admin/pagos/index");
	}

	public function eliminar($id){

		$data = $this->Pagos_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('warning', "Tipo Pago Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Tipo Pago No Fue Eliminado");
		}
		redirect(base_url()."admin/pagos/index");
	}

	public function column(){

		$column = array(
			'Nombre','Codigo','Descripcion','Valor pago','Creado','Estado'
		);
		return $column;
	}

	public function fields(){
		
		$fields['field'] = array(
			['nombre_modo_pago' => 'Nombre'],
			['codigo_modo_pago' => 'Codigo'],
			['descripcion_modo_pago' => 'Descripcion'],
			['valor_modo_pago' => 'Valor pago'],
			['creado_modo_pago' => 'Creado'],
			['orden_estado_nombre'=> 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 	  = array('id_modo_pago');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Formas de Pago";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
}
