<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * News Class
 * @author fadilah ajiq surya<fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc News Controller
 * 
 */
class Schedule extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->class_path_name = $this->router->fetch_class();
    }
	
	public function news_schedule() {
		
	}
	
}
    