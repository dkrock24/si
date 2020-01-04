<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function validarUrl_method($menu_session)
    {
    	$flag = FALSE;
		foreach ($menu_session as $key => $menu_url) {

			$url_browser = "/".$menu_url->url_submenu;

			$r = preg_match_all("/.*?(\d+)$/", $_SERVER['PATH_INFO'], $matches);
			$b = is_numeric(substr($_SERVER['PATH_INFO'], -1, 1));
			if($b){

				$last_part 		= substr(strrchr($_SERVER['PATH_INFO'], "/"), 1);
				$last_part_cantidad =  strlen($last_part);
				$string_lenght 	= strlen($_SERVER['PATH_INFO']);
				$strin_final 	= substr($_SERVER['PATH_INFO'], 0 , ($string_lenght - ($last_part_cantidad + 1) ) );

				if($url_browser == $strin_final ){
					$flag = TRUE;
				}
			}else{
				if($url_browser == $_SERVER['PATH_INFO'] ){
					$flag = TRUE;
				}
			}
		}

        return $flag;
    }

   	function parametros($menu_session){
   		// Validar Permiso a la Url

   		if(isset($menu_session)){
   			$url_acceso = validarUrl_method($menu_session);
			if( !$url_acceso ){
				//header("location: ".base_url()."login/logout");
			}
   		}
   	}

    	
