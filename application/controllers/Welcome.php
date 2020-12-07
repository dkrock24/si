<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

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
	public function index($name)
	{

		/*$filepath = "./asstes/printer_files/".$name;
		// EDIT: I added some permission/file checking.
		if (!file_exists($filepath)) {
			throw new Exception("File $filepath does not exist");
		}
		if (!is_readable($filepath)) {
			throw new Exception("File $filepath is not readable");
		}
		http_response_code(200);
		header('Content-Length: ' . filesize($filepath));
		//header("Content-Type: application/txt");
		//header('Content-Disposition: attachment;"'); // feel free to change the suggested filename
		readfile($filepath);*/
		$this->load->view('welcome_message');
	}
}
