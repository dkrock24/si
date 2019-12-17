<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //need this!!
        	
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination'); 
		$this->load->library('../controllers/general');

		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Menu_model');	

		$this->load->model('producto/Producto_model');	
		$this->load->model('producto/Bodega_model');
		$this->load->model('admin/Marca_model');
		$this->load->model('accion/Accion_model');	
		$this->load->model('admin/Giros_model');	
		$this->load->model('admin/Sucursal_model');	
		$this->load->model('admin/Categorias_model');	
    }

    public function MyPagination($model , $url_page, $vista)
    {
        $filtro="";
		if(isset($_SESSION['filters']) ){
            if($_SESSION['filters']== ""){
                $filtro = "";
                $_SESSION['filtros'] = null;
            }  
            if($_SESSION['url'] != $url_page){
                
                $_SESSION['filters'] = $filtro;
                $_SESSION['filtros'] = null;
                $_SESSION['url'] = $url_page;

            }        
           
		}else{
            $_SESSION['filters'] = $filtro;
            $_SESSION['filtros'] = null;
            $_SESSION['url'] = $url_page;
        }

		if($_POST){

            $flag = false;
				
			foreach ($_POST as $key => $field) {
				
				if($field){
                    
                    if($flag){
                        $filtro .= " and ". $key ." like '%$field%' ";
                    }else{
                        $filtro .= " ". $key ." like '%$field%'  ";
                    }
					$flag = true;
                }
                
               
			}
			$_SESSION['filters'] = $filtro ;
			$_SESSION['filtros'] = $_POST ;
        }
        
        //Paginacion
		$_SESSION['per_page'] = "";
		$contador_tabla;
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
        }

        $total_row = $this->$model->record_count($_SESSION['filters']);
		
		$config = paginacion($total_row, $_SESSION['per_page'] , $url_page);
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


		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles;
        $vista_id = $vista;
        
        $f = $this->fields();
        if(!$_SESSION['filtros']){
            $ff = array();
            foreach ($f['field'] as $item) {
                $ff[$item] = "";
            }
            $_SESSION['filtros'] = $ff;
        }

        $data['field'] = $_SESSION['filtros'];
        $data['config'] = $config;
        $data['page'] = $page;
        $data['vista_id'] = $vista_id;
        $data['id_rol'] = $id_rol;
        $data['contador_tabla'] = $contador_tabla;
        
        return $data;       



    }
}
