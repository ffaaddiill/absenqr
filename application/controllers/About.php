<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Pages_model');
        $this->data['page_title'] = 'About';
    }
	
	public function index() {
        $about = $this->db
                ->where('slug', $this->uri->segment(1))
                ->get('pages')
                ->row_array();

        if(empty($about)) {
            show_404();
        }
        
		$this->data['about_page'] = $about;
	}
	
}