<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends MY_Controller {

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

		$this->load->model('admin/Giros_model');  
		$this->load->model('producto/Producto_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('admin/Empresa_model');
		$this->load->model('admin/Ciudad_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Persona_model');
		$this->load->model('admin/Template_model');
		$this->load->model('admin/Documento_model');
		$this->load->model('producto/Orden_model');
		$this->load->model('admin/ModoPago_model');
		

	}

// Start  **********************************************************************************

	public function index(){

		$model = "Template_model";
		$url_page = "admin/template/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 24);


		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] = $this->Template_model->getAllTemplate( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']);
		$data['title'] = "Templates";
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}
	
	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;
		$data['title'] = "Nuevo Template";
		$data['home'] = 'admin/template/template_nuevo';

		$this->parser->parse('template', $data);
	}
	

	public function crear(){
		
		$data = $this->Template_model->crear_template( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Template Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Template No Fue Creado");
		}	

		redirect(base_url()."admin/template/asociar");
	}

	public function asociar(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;
		$data['result'] = null;
		$data['documento_id'] = 0;
		$data['factura_id'] = 0;
		$data['result'] = 0;

		if(isset($_POST['documento']) && isset($_POST['factura_id'])){
			$data['documento_id'] = $_POST['documento'];
			$data['factura_id'] = $_POST['factura_id'];
			$factura_id = $_POST['factura_id'];
			$data['factura_id'] = $factura_id;
			$data['result'] = $this->Template_model->getTemplateBySucursal($factura_id);
			
		}

		$data['menu'] = $this->session->menu;
		$data['pagos'] = $this->ModoPago_model->getAllFormasPago();
		$data['template'] = $this->Template_model->get_template();
		$data['sucursales'] = $this->Producto_model->get_sucursales();
		$data['documento'] = $this->Documento_model->getAllDocumento();
		$data['home'] = 'admin/template/template_asociar';

		$this->parser->parse('template', $data);
	}

	public function update_pago( $id_tabla , $id_pago ){
		$this->Template_model->update_pago( $id_tabla , $id_pago );
	}

	public function associar_sucursal(){

		$this->Template_model->associar_sucursal( $_POST  );

		redirect(base_url()."admin/template/asociar");
	}

	public function activacion(){
		$this->Template_model->activacion_sucursal( $_POST  );

		redirect(base_url()."admin/template/asociar");
	}
	

	public function editar( $formato_id ){
		
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;
		$data['menu'] = $this->session->menu;		
		$data['formato'] = $this->Template_model->getFormatoId($formato_id);
		$data['title'] = "Editar Template";
		$data['home'] = 'admin/template/template_editar';

		$this->parser->parse('template', $data);
	}

	public function update(){
		// Actualizar Giro 
		$data = $this->Template_model->update( $_POST );

		if($data){
			$this->session->set_flashdata('info', " !");
		}else{
			$this->session->set_flashdata('warning', "El Registro No Fue Actualizado");
		}

		redirect(base_url()."admin/template/index");
	}

	public function eliminar($id_template){

		$data = $this->Template_model->eliminar( $id_template );

		if($data){
			$this->session->set_flashdata('danger', "Template Fue Eliminado !");
		}else{
			$this->session->set_flashdata('warning', "El Registro No Fue Actualizado");
		}


		redirect(base_url()."admin/template/index");
	}
	
	public function column(){

		$column = array(
			//'Sucursal','Pago','Documento','Formato','Lineas','Descripcion','Creado','Estado'
			'Formato','Lineas','Descripcion','Creado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			//'nombre_sucursal','nombre_modo_pago','nombre','factura_nombre','factura_lineas','factura_descripcion','factura_creado','estado'
			'factura_nombre','factura_lineas','factura_descripcion','factura_creado','estado'
		);
		
		$fields['id'] = array('id_factura');
		$fields['estado'] = array('factura_estatus');
		$fields['titulo'] = "Template Lista";

		return $fields;
	}

	function printer( $orden_id ){
		
		// Get ordern
		$data['productos'] = $this->Orden_model->get_orden_detalle( $orden_id );
		$data['temp'] = $this->Template_model->printer( $orden_id , 2 , 2 );
		$data['home'] = 'admin/printer/printer';

		$info = [];
		$data['orden'] = $data['productos'] ;
		foreach ($data['productos'] as $key => $value) {
			$info['cantidad'] = $value->cantidad;
			$info['descripcion '] = $value->descripcion ;
			$info['precioUnidad'] = $value->precioUnidad;
			$info['total'] = $value->total;
		}

		$this->parser->parse('template', $data);
	}
	

}

?>
