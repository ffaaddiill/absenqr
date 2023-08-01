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
class Categories extends CI_Controller {
	/**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('News_model', 'News_category_model'));
        $this->class_path_name = $this->router->fetch_class();
        $this->load->library("pagination");
    }
	
	public function index($slug='') {
		//$this->data['page_title'] = 'Home';
        // load slideshow'
        
        $this->data['category_slug'] = $slug;
		
		$this->data['sidebar_news_list'] = $this->News_model->GetNewsData(5, '', '', $slug);
        
        if(!empty($slug) && strtolower($slug) == 'video') { // NEWS TYPE VIDEO
        	
			if(isset($_GET['debug']) && $_GET['debug'] == '999') {
			}
	        
			if (!$news_list = $this->cache->get('allVideoData'.'_'.$slug) ) {
	            $news_list = $this->News_model->getVideos(9, $slug);
	            $this->cache->save('allNewsVideoData'.'_'.$slug,$news_list);
	        }
			$this->data['news_list'] = $news_list;
			
			$this->data['template'] = 'categories/categories-video';
			
        } else {
        	
			if(isset($_GET['debug']) && $_GET['debug'] == '999') {
			}
	        
			if (!$news_list = $this->cache->get('allNewsCategoryData'.'_'.$slug) ) {
	            $news_list = $this->News_model->GetNewsData(9, $slug);
	            $this->cache->save('allNewsCategoryData'.'_'.$slug,$news_list);
	        }
			$this->data['news_list'] = $news_list;
			
			if(isset($_GET['debug']) && $_GET['debug'] == 123) {
				//$terkini = $this->News_model->getNewsTerkini(5, $slug, $not_equal_to = '', $order_by_column='N.create_date', $order_position='desc');
				//$news_list = $this->News_model->GetNewsData(9, $slug);
				echo '<pre>';
				//print_r($news_list);
				
				echo $this->db->last_query();
				echo '<br><br>-------------------------------<br><br><br>';
	
				die();
				//die($this->db->last_query());
				
			}
			
			//die($this->db->last_query());
	        
			//die($this->db->last_query());
			
			if( !$news_video = $this->cache->get('news_video') ) {
				$news_video = $this->News_model->getNewsVideo(9);
				$this->cache->save('news_video',$news_video);
			}
			$this->data['news_video'] = $news_video;
	        
	        $this->data['page_title'] = 'Category';
		
        }
	}

	public function index_news($rowno=0) {
		//echo 'row:' . $rowno;
		
		$category = $this->uri->segment(1);
		$getCategoryData = $this->News_model->getCategory('', $category);
		$this->data['category_name'] = $getCategoryData['category_name'];
		$per_page = 10;
		$base_url = '';
		
		$this->data['sidebar_latest_news'] = $this->News_model->GetNewsData(5, $category, '', '');
		
		if( !$news_video = $this->cache->get('news_video') ) {
			$news_video = $this->News_model->getNewsVideo(9);
			$this->cache->save('news_video',$news_video);
		}
		$this->data['news_video'] = $news_video; 
		
		if(!empty($category) && strtolower($category) == 'video') { // NEWS TYPE VIDEO
		
			//die($category);
		
			$count_news_list = $this->News_model->countVideos();
			$newslist = $this->News_model->getNewsByPagination('video', '', 0, $per_page, $rowno);
			
			$base_url = base_url().'video/index-berita';
		
			$this->data['news_list'] = $newslist;
			$this->data['template'] = 'categories/index_video';
		} else {
			$count_news_list = $this->News_model->countNewsByCategory($category);
			$newslist = $this->News_model->getNewsByPagination('news', $category, 0, $per_page, $rowno); 
			
			$base_url = base_url().$category.'/index-berita';
		
			$this->data['news_list'] = $newslist;
		}
		
		$config = array();
        
		$config['base_url'] = $base_url;
        $config["total_rows"] = $count_news_list;
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
		
		//pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['attributes'] = ['class' => 'page-link'];
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = 'Awal';
		$config['last_link'] = 'Akhir';
		
		// $rowno = $this->uri->segment(3);
		
		// if(empty($rowno)) {
			// $rowno = 0;
		// }
		
		if(isset($_GET['debug']) && $_GET['debug'] == 123) {
			echo '<pre>';
			print_r($this->data['sidebar_latest_news']);
			die();
		}
		
		$this->pagination->initialize($config);

        $this->data["links"] = $this->pagination->create_links();
		
		$this->data['template'] = 'categories/index_news';
	}

	public function ajax_category_list() {
		
		if(!$this->input->post()) {
			redirect(base_url());
		}
		
		$this->layout = 'none';
		
		$slug = 'nasional';
		
		//die('tes');
		
		$count_news_list = $this->News_model->countNewsByCategory($slug);
		
		$config = array();
        $config["base_url"] = base_url() . "categories/ajax_category_list";
        $config["total_rows"] = $count_news_list;
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		//echo $this->uri->segment(3);
		
		$news_list = $this->News_model->getNewsByPagination($slug, 9, $config["per_page"], $page);
		
		// echo '<pre>';
		// print_r($news_list);
		// echo $this->db->last_query();
		// echo '<br><br>-------------------------------<br><br><br>';
		// die();
		
		$data['news_list'] = $news_list;

        $this->pagination->initialize($config);

        //$data["links"] = $this->pagination->create_links();
			
		$json['view'] = $this->load->view(TEMPLATE_DIR.'/ajax/ajax_category_list', $data, TRUE);
		
		// echo $json['view'];
		// die();
		
		header('Content-type: application/json');
        exit (
            json_encode($json)
        );
	}

	public function testbyfadil() {
		$this->layout = 'none';
		
		echo '<pre>';
		print_r(get3CategoryList(['sports','nasional','ekonomi'], [$this->uri->segment(1)]));
		
		die();
		
		$this->load->library('twitteroauth/src/TwitterOAuth');
		
		$tw = new TwitterOAuth(
			array(
				'consumerKey'=>'asFU2M5cbuHJjWWsP2dC4LtJC',
				'consumerSecret'=>'F4zygYNWUnDIEG0d9kSH6Rj8vTwJslhBWyik9ureQ2UrFYO9cl',
				'oauthToken'=>'1171730175836295170-qwjuv2b7H37XEehqJZ4iOdrYHkD7gB',
				'oauthTokenSecret'=>'gGmRKtCCJ2cVpe22rN3d6eC9YKfmuDxhrS5GWq28RRcvA'
			)
		);

		//$content = $tw->get("account/verify_credentials");
		//$statuses = $tw->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);
		//$post_status = $tw->post('statuses/update', ['status'=>'testing']);
		
		echo '<pre>';
		
		// foreach($statuses as $key=>$val) {
			// unset($val->entities->hashtags);
			// unset($val->entities->symbols);
			// print_r($val);
			// echo '<br><br>';
		// }
		
		
		// echo '<pre>';
		//print_r($statuses);
		// echo '<b><br><br>';

		die();
	}
}
	