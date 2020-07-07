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
		$this->load->library('excel');	

		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');
		$this->load->helper('paginacion/paginacion_helper');

		if( ! isset($this->session->userdata['usuario'][0]->id_rol )){
			
			redirect(base_url()."login/index");
		}
		
		parametros($this->session->menu ,  $this->session->usuario[0]->pagina);

		$this->load->model('admin/Menu_model');	

		$this->load->model('producto/Producto_model');	
		$this->load->model('producto/Bodega_model');
		$this->load->model('admin/Marca_model');
		$this->load->model('accion/Accion_model');	
		$this->load->model('admin/Giros_model');	
		$this->load->model('admin/Sucursal_model');	
		$this->load->model('admin/Categorias_model');

		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Terminal_model');
		$this->load->model('admin/Giros_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/ModoPago_model');
		$this->load->model('admin/Correlativo_model');
		$this->load->model('producto/Producto_model');				
		$this->load->model('producto/Orden_model');
		$this->load->model('admin/Moneda_model');
		$this->load->model('admin/Template_model');
		$this->load->model('admin/Impuesto_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('admin/Vistas_model');
        $this->load->model('producto/Venta_model');
		$this->load->model('producto/Traslado_model');
		$this->load->model('producto/Compras_model');
		$this->load->model('admin/Proveedor_model');
		$this->load->model('producto/EfectosDocumento_model');
		$this->load->model('admin/Documento_model');
		
		
    }

    public function MyPagination($model , $url_page, $vista)
    {
        $filtro="";
		if(isset($_SESSION['filters']) ){

			if($_SESSION['filters']== "")
			{
                $filtro = "";
                $_SESSION['filtros'] = null;
			}  
			
			if($_SESSION['url'] != $url_page)
			{                
                $_SESSION['filters'] 	= $filtro;
                $_SESSION['filtros'] 	= null;
                $_SESSION['url'] 		= $url_page;
            }           
		}else{
			
            $_SESSION['url'] 	= $url_page;
            $_SESSION['filters']= $filtro;
            $_SESSION['filtros']= null;
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

			if(!isset($_POST['total_pagina'])){

				$_SESSION['filters'] = $filtro ;
				$_SESSION['filtros'] = $_POST ;
			}			
        }
        
        //Paginacion
		$_SESSION['per_page'] = "";
		$contador_tabla;
		if( isset( $_POST['total_pagina'] ))
		{
			$per_page 				= $_POST['total_pagina'];
			$_SESSION['per_page'] 	= $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] 	= 10;
				$_SESSION['x_total'] 	= 10;
			}			
        }

		$total_row = $this->$model->record_count($_SESSION['filters']);
				
		if($this->uri->segment(4)){
			if($_SESSION['per_page']!=0)
			{
				$page 					= ($this->uri->segment(4) - 1 ) * $_SESSION['per_page'];				
				$_SESSION['per_page'] 	= $_SESSION['per_page'] ;
				$_SESSION['x_total']  	= ($this->uri->segment(4)  ) * $_SESSION['per_page'] ;
				$contador_tabla 		= $page+1;
			}else{
				$page 			= 0;
				$contador_tabla =1;
			}
		}else{
			$page 			= 0;
			$contador_tabla =1;
		}
		$config = paginacion($total_row, $_SESSION['per_page'] , $url_page , $_SESSION['x_total']);
		
		$this->pagination->initialize($config);

		$str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        
        // paginacion End

		$id_rol 	= $this->session->roles;
        $vista_id 	= $vista;
        
        $f = $this->fields();
		if(!$_SESSION['filtros'])
		{
            $ff = array();
            foreach ($f['field'] as $item) {
                $ff[key($item)
				] = "";
            }
            $_SESSION['filtros'] = $ff;
		}		

        $data['page'] 			= $page;
        $data['config'] 		= $config;
		$data['id_rol'] 		= $id_rol;
        $data['vista_id'] 		= $vista_id;
		$data['total_records'] 	= $total_row;
        $data['contador_tabla'] = $contador_tabla;
        $data['field'] 			= $_SESSION['filtros'];
        return $data;

	}
	
	public function xls( $registros , $titulo,  $column, $fields ){

		require_once APPPATH . "/libraries/PHPExcel.php";
		
		$this->load->library('PHPExcel');

		$fileName = 'data-'.time().'.xlsx'; 		
		
		// load excel library
        $this->load->library('excel');
        $listInfo = $registros;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);		
		
		// set Header

		$cnt = 65;

		foreach ($column as $item) {

			$objPHPExcel->getActiveSheet()->SetCellValue(chr($cnt).'1', $item );
			$cnt++;

		}
	
        // set Row
		
		$rowCount = 2;
		
		foreach ($listInfo as $list) {
			$indice = 0;

			for ($i = 65; $i <= 90; $i++) {
				$key_field = "";
				if(isset($fields['field'][$indice])){
					foreach ($fields['field'][$indice] as $key => $value) {
						$key_field = $key;
						
						continue;
					}$indice++;
				}else{
					continue;
				}
				
				if( isset( $key_field )){
					if(isset($list->$key_field)){
						$list->$key_field;


						$list->$key_field;
						
						$objPHPExcel->getActiveSheet()->SetCellValue(chr($i) . $rowCount, $list->$key_field );				
						
					}
					
				}
				
			}
			
			$rowCount++;

		}
		$i++;

        $filename = $titulo. date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output'); 

	}

	public function generarDocumento( $name ,  $data ){

		$file = fopen('asstes/temp/'.$name.'.php', 'w');
        fwrite($file, $data);
		fclose($file);  
	}


	public function db_error_format($data){

		$result['message'] = " <br><br>Codigo Error : ".  $data['message'];
		return $result;
	}

	public function return_modena(){
		return $this->Moneda_model->get_modena_by_user();
	}
}
