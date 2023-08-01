<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Main Controller
 * 
 */
class Search extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('News_model','News_category_model'));
        $this->class_path_name = $this->router->fetch_class();
    }
	
	public function index() {
		$categories_arr = $this->News_model->getCategoriesWithNewsCount();
			
		$this->data['categories_arr'] = $categories_arr;
		
		if($this->input->post()) {
			$post = $this->input->post();
			$keyword = $post['keyword'];
			$search_data = $this->News_model->search($keyword);

			$this->data['news_list'] = $search_data;
			$this->data['post'] = $post;
		}
	}
    
}