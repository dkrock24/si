<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caja extends MY_Controller {

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

		$model = "Caja_model";
		$url_page = "admin/caja/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 35);

		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol']);
		$data['registros'] = $this->Caja_model->get_all_caja( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
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
			'Sucursal','Nombre','Codigo','Doc','Template','Resolucion','RNTicket','Cajero','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_sucursal','nombre_caja','cod_interno_caja','nombre','factura_nombre','resol_num_caja','resol_num_tiq_caja','pred_cod_cajr','estado'
		);
		
		$fields['id'] = array('id_caja');
		$fields['estado'] = array('estado_caja');
		$fields['titulo'] = "Caja Lista";

		return $fields;
	}
}