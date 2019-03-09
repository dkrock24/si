<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function paginacion($total_row , $per_page , $url){

	// paginacion
		$config = array();
		$config["base_url"] = base_url() . $url;
		
		$config["total_rows"] = $total_row;
		$config["per_page"] = $per_page;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_row;
		$config['cur_tag_open'] = '&nbsp;<a class="active" style="background:#007bff; color:white;">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';

		
		return $config;

		// End Paginacion
}