<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Custom HTTP Page Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Custom HTTP Page Controller
 * 
 */
class Custom_http_page extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('News_model','News_category_model'));
        $this->class_path_name = $this->router->fetch_class();
    }

    public function page404() {
        $categories_arr = $this->News_model->getCategoriesWithNewsCount();
        $this->data['categories_arr'] = $categories_arr;
        $this->output->set_status_header('404');
    }

    public function page500() {
        $categories_arr = $this->News_model->getCategoriesWithNewsCount(); 
        $this->data['categories_arr'] = $categories_arr;
        $this->output->set_status_header('500');
    }
}