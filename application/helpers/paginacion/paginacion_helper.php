<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function paginacion($total_row , $per_page , $url , $x_total){

	// paginacion
	$config 					= array();
	$config["base_url"] 		= base_url() . $url;		
	$config["total_rows"] 		= $total_row;
	$config["per_page"] 		= $per_page;
	$config['use_page_numbers'] = TRUE;
	$config['cur_tag_open'] 	= '&nbsp;<a class="active" style="background:#007bff; color:white;">';
	$config['cur_tag_close'] 	= '</a>';
	$config['first_link'] 		= 'Inicio';
	$config['next_link'] 		= 'Siguiente';
	$config['prev_link'] 		= 'Anterior';
	$config['last_link'] 		= 'Ultimo';
	$config['x_total'] 			= $x_total;
	//$config['num_links'] = $total_row;

	return $config;
	// End Paginacion
}