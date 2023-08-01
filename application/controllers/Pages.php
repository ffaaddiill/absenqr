<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Pages_model');
		$this->load->model('News_model');
        $this->data['page_title'] = 'Pages';
    }
	
	public function index($slug='') {
		//$this->data['sidebar_latest_news'] = array_reverse($this->News_model->GetNewsData(5, '', '', 'nasional'));

		if(!$slug) {
			show_404();
		}

        $page_content = $this->Pages_model->getPage($slug);
        if(! $page_content) {
        	show_404();
        }
		
        $this->data['page_content'] = $page_content;


	}
	
}