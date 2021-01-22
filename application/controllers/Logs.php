<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logs extends MY_Controller
{

    private $logViewer;

    public function __construct()
    {
        parent::__construct(); 
        $this->logViewer = new \CILogViewer\CILogViewer();
    }

    public function index()
    {
        echo $this->logViewer->showLogs();
        return;
    }
}
