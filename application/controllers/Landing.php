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
class Landing extends CI_Controller {
	/**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Slideshow_model','Package_model','News_model', 'Location_model', 'Video_model'));
        $this->class_path_name = $this->router->fetch_class();
    }
	
	public function index($category='rental-mobil', $id=0, $slug='') {
		//$this->data['page_title'] = 'Home';
        // load slideshow
        
        $article = $this->News_model->GetNewsById($id);
		$this->data['article'] = $article;
        
		// echo $category . ' - ' . $id . ' - ' . $slug;
        // die();
        
		$this->data['sidebar_latest_news'] = $this->News_model->GetNewsData(5, $category, $id); 
        
        if( !$news_video = $this->cache->get('news_video') ) {
			$news_video = $this->News_model->getNewsVideo();
			$this->cache->save('news_video',$news_video);
		}
		$this->data['news_video'] = $news_video;
		
        $this->data['page_title'] = 'Landing';
		
		if(isset($_GET['debug']) && $_GET['debug'] == 123) {
			$terkini = array_reverse($this->News_model->GetNewsData(5));
			echo '<br><br>';
			echo '<pre>';
			print_r($news_video);
			//die($this->db->last_query());
			die();
		}
	}
}
	