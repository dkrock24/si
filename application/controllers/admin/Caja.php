<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caja extends CI_Controller {

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

		$this->load->model('admin/Terminal_model');  
		$this->load->model('admin/Caja_model');  
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Documento_model');
		$this->load->model('admin/Sucursal_model');
	}

	public function index(){

		//Paginacion
		$contador_tabla;
		$_SESSION['per_page'] = "";
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Caja_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/caja/index");
		$this->pagination->initialize($config);
		if($this->uri->segment(4)){
			if($_SESSION['per_page']!=0){
				$page = ($this->uri->segment(4) - 1 ) * $_SESSION['per_page'];
				$contador_tabla = $page+1;
			}else{
				$page = 0;
				$contador_tabla =1;
			}
		}else{
			$page = 0;
			$contador_tabla =1;
		}

		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );

		// paginacion End

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		//parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 30; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['registros'] = $this->Caja_model->get_all_caja( $config["per_page"], $page );
		$data['title'] = "Terminales";
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['doc'] = $this->Documento_model->getAllDocumento();
		$data['suc'] = $this->Sucursal_model->getSucursal();
		$data['title'] = "Nueva Caja";
		$data['home'] = 'admin/caja/c_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert Nuevo Usuario
		$data = $this->Caja_model->crear_caja( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Caja Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Caja No Fue Creado");
		}	
		redirect(base_url()."admin/caja/index");
	}

	public function editar($caja_id){
		
		$menu_session = $this->session->menu;	
		//parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['doc'] = $this->Documento_model->getAllDocumento();
		$data['suc'] = $this->Sucursal_model->getSucursal();
		$data['caja'] = $this->Caja_model->get_caja( $caja_id );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'admin/caja/c_editar';
		$data['title'] = "Editar Caja";

		$this->parser->parse('template', $data);
	}

	public function update(){

		$data = $this->Caja_model->update_caja( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Caja Fue Actualizada");
		}else{
			$this->session->set_flashdata('warning', "Caja No Fue Actualizada");
		}	
		redirect(base_url()."admin/caja/index");
	}

	public function column(){

		$column = array(
			'Empresa','Nombre','Codigo','Doc','FechaO','FechaR','Resolucion','RNTicket','RFTicket','CodCaja','Abrir','Impr','PuertoDos','PuertoWin','Espos','Turno','CodCajero','CodSucursal','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'Empresa','nombre_caja','cod_interno_caja','pred_id_tpdoc','fecha_oper_caja','resol_num_caja','resol_fecha_caja','resol_num_tiq_caja',
			'resol_fec_tiq_caja','cod_ctb_caja','abrir_caja','impr_journ','impr_puerto_DOS','impr_puerto_WIN','es_pos','num_turnos',
			'pred_cod_cajr','pred_cod_sucu','estado_caja'
		);
		
		$fields['id'] = array('id_caja');
		$fields['estado'] = array('estado_caja');
		$fields['titulo'] = "Caja Lista";

		return $fields;
	}
}