<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends MY_Controller {

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
	    $this->load->library('../controllers/general');    

		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Categorias_model');
		$this->load->model('admin/Marca_model');
		$this->load->model('admin/Empresa_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Giros_model');
	}

// Start PAIS **********************************************************************************

	public function index(){

		$model = "Categorias_model";
		$url_page = "admin/categorias/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 11);

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] = $this->Categorias_model->get_categorias(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );

		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();

		$data['home'] = 'template/lista_template';
		$data['title'] = "Categorias";

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['categorias']	= $this->Categorias_model->get_categorias_padres();
		$data['marcas'] = $this->Marca_model->getAllMarca();
		$data['empresa'] = $this->Empresa_model->getEmpresas();
		$data['giros'] = $this->Giros_model->getAllgiros();
		$data['home'] = 'admin/categorias/categorias_nuevo';
		$data['title'] = "Crear Categoria";

		$this->parser->parse('template', $data);
	}

	public function crear(){

		$data['info'] = $this->Categorias_model->crear_categoria( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Categoria Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Categoria No Fue Creado");
		}

		redirect(base_url()."admin/categorias/index");
	}

	public function editar( $id_categoria ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;		
		$data['categorias'] = $this->Categorias_model->get_categoria_id( $id_categoria );
		$data['categorias_padres']	= $this->Categorias_model->get_categorias_padres();
		$data['empresa'] = $this->Empresa_model->getEmpresas();
		$data['giros'] = $this->Giros_model->getAllgiros();
		$data['home'] = 'admin/categorias/categorias_editar';
		$data['title'] = "Editar Categoria";

		$this->general->editar_valido($data['categorias'], "admin/categorias/index");

		$this->parser->parse('template', $data);
	}

	public function actualizar(){
		// Insert pais
		$data['info'] = $this->Categorias_model->actualizar_categoria( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Categoria Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Categoria No Fue Actualizado");
		}

		redirect(base_url()."admin/categorias/index");
	}

	public function eliminar($id){
		
		$data['info'] =$this->Categorias_model->delete_categoria( $id );
		if($data){
			$this->session->set_flashdata('warning', "Categoria Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Categoria No Fue Eliminado");
		}
		redirect(base_url()."admin/categorias/index");
	}

	public function column(){

		$column = array(
			'Categoria','Sub Categoria','Giro','Empresa','Creado', 'Actualizado', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_categoria','cat_padre','nombre_giro','nombre_comercial','creado_categoria','actualizado_categoria','estado'
		);
		
		$fields['id'] = array('id_categoria');
		$fields['estado'] = array('categoria_estado');
		$fields['titulo'] = "Categoria Lista";

		return $fields;
	}
	
}

?>