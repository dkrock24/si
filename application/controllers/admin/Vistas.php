<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vistas extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');

		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Acceso_model');
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Vistas_model');
		$this->load->model('admin/Roles_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('producto/Estados_model');
	}

	public function index()
	{

		$model 		= "Vistas_model";
		$url_page 	= "admin/vistas/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 22);

		if (isset($_POST['role']) and isset($_POST['menu'])) {

			$data['roles'] 		=  $this->Acceso_model->getRoles();
			$data['menus'] 		=  $this->Menu_model->lista_menu();
			$data['accesos'] 	=  $this->Acceso_model->get_menu_acceso($_POST['role'], $_POST['menu'], NULL);
			$data['vista_componentes'] 		=  $this->Acceso_model->get_vista_componentes($_POST['role'], $_POST['menu']);
			$data['accesos_menus_internos'] =  $this->Acceso_model->get_menu_internos($_POST['role'], $_POST['menu']);
		} else {
			$data['roles'] =  $this->Acceso_model->getRoles();
			$data['menus'] =  $this->Menu_model->lista_menu();
		}

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['registros']		=  $this->Vistas_model->get_vistas($pag['config']["per_page"], $pag['page'], $_SESSION['filters']);
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones($pag['vista_id'], $pag['id_rol']);
		$data['title'] 			= "Vistas";
		$data['home'] 			= 'template/lista_template';

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo()
	{
		$data['menu'] 	= $this->session->menu;
		$data['title'] 	= "Nueva Vista";
		$data['home'] 	= 'admin/vistas/vistas_nuevo';

		echo $this->load->view('admin/vistas/vistas_nuevo',$data, TRUE);
	}

	public function crear()
	{
		$this->Vistas_model->crear($_POST);
		redirect(base_url() . "admin/vistas/index");
	}

	public function editar($vista_id)
	{
		$data['menu'] 	= $this->session->menu;
		$data['vistas'] = $this->Vistas_model->vistas_by_id($vista_id);
		$data['estados'] = $this->Vistas_model->estados_vistas($vista_id);
		$data['lista_estado'] = $this->Estados_model->get_estados($vista_id);
		$data['title'] 	= "Editar Vista";
		$data['home'] 	= 'admin/vistas/vistas_editar';

		echo $this->load->view('admin/vistas/vistas_editar',$data, TRUE);
	}

	public function update()
	{
		$this->Vistas_model->update($_POST);
		redirect(base_url() . "admin/vistas/index");
	}

	public function column()
	{
		$column = array(
			'Nombre', 'Codigo', 'Metodo', 'Url', 'Descripcion', 'Botones', 'Estado'
		);
		return $column;
	}

	public function fields()
	{
		$fields['field'] = array(
			['vista_nombre' => 'Nombre'],
			['vista_codigo' => 'Codigo'],
			['vista_accion' => 'Metodo'],
			['vista_url' => 'Url'],
			['vista_descripcion' => 'Descripcion'],
			['total' => 'Botones'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);

		$fields['id'] 	  = array('id_vista');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Vistas Lista";

		return $fields;
	}

	/* Funciones para la seccion de componentes de vistas - CRUD */

	public function componentes($vista_id)
	{
		$model 		= "Vistas_model";
		$url_page 	= "admin/vistas/componentes";
		$pag 		= $this->MyPagination($model, $url_page, $vista_id);

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->columnC();
		$data['fields'] 		= $this->fieldsC();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['componentes'] 	= $this->Vistas_model->vistas_componente_by_id($vista_id);
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones($pag['vista_id'], $pag['id_rol']);
		$data['home'] 			= 'admin/vistas/componentes_lista';
		$data['title'] 			= "Vistas";
		$data['vista_id'] 		= $vista_id;

		echo $this->load->view('admin/vistas/componentes_lista',$data, TRUE);
	}

	public function componentes_nuevo($vista_id)
	{
		$data['menu'] = $this->session->menu;
		$data['componentes'] = $this->Vistas_model->get_all_componentes();
		$data['roles'] = $this->Roles_model->getAllRoles();
		$data['home'] = 'admin/vistas/componentes_nuevo';

		//$vista_id = $this->Vistas_model->getVistaId($vista_id);
		$data['vista_id'] = $vista_id; //$vista_id[0]->Vista;

		echo $this->load->view('admin/vistas/componentes_nuevo',$data, TRUE);
	}

	public function componente_crear()
	{
		$this->Vistas_model->componente_crear($_POST);
		$data['vista_id'] = $_POST['vista_id'];
		redirect(base_url() . "admin/vistas/componentes/" . $data['vista_id']);
	}

	public function componente_eliminar($vista, $componente_vista_id)
	{

		$data = $this->Vistas_model->componente_eliminar($vista, $componente_vista_id);

		if (!$data['code']) {
			$this->session->set_flashdata('warning', "Componente Fue Eliminado");
		} else {
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Componente No Fue Eliminado : " . $data['message']);
		}
		redirect(base_url() . "admin/vistas/componentes/" . $vista);
	}

	public function copiar($id, $componente_id)
	{

		$id_rol = $this->session->roles;

		$this->Vistas_model->copiar_componente($id, $componente_id, $id_rol);
		redirect(base_url() . "admin/vistas/componentes/" .  $id);
	}

	public function agregar_estado($estado, $vista)
	{
		$this->Vistas_model->agregar_estado($estado, $vista);
		$datos = $this->Vistas_model->estados_vistas($vista);

		echo json_encode($datos);
	}

	public function update_estado($acion, $id, $orden, $vista)
	{
		$this->Vistas_model->update_estado($acion, $id, $orden, $vista);
		$datos = $this->Vistas_model->estados_vistas($vista);

		echo json_encode($datos);
	}

	public function delete_estado($id, $vista_id)
	{
		$this->Vistas_model->delete_estado($id, $vista_id);
		$datos = $this->Vistas_model->estados_vistas($vista_id);

		echo json_encode($datos);
	}

	public function columnC()
	{

		$column = array(
			'Vista', 'Accion', 'btn Nombre', 'btn Css', 'btn Icon', 'btn Url', 'btn Codigo', 'btn Posicion', 'Estado'
		);
		return $column;
	}

	public function fieldsC()
	{
		$fields['field'] = array(
			['vista_nombre' => 'Vista'],
			['accion_nombre' => 'Accion'],
			['accion_btn_nombre' => 'btn Nombre'],
			['accion_btn_css' => 'btn Css'],
			['accion_btn_icon' => 'btn Icon'],
			['accion_btn_url' => 'btn Url'],
			['accion_btn_codigo' => 'btn Codigo'],
			['accion_valor' => 'btn Posicion'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);

		$fields['id'] = array('id');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Componente Lista";

		return $fields;
	}
}
