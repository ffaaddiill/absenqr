<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * News Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc News Controller
 * 
 */
class News extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->data['page_title'] = 'News';
    }

    /**
     * Index Page for this controller.
     * @access public
     */
    public function index() {
        $page_detail = getPageByPath('news');

        $news_list = $this->News_model->GetNewsData();

        $categories_arr = $this->News_model->getCategoriesWithNewsCount();

        if(isset($_GET['debuginfo']) && !empty($_GET['debuginfo']) && $_GET['debuginfo'] == 'news') {
            $this->Layout = 'blank';
            echo '<pre>';
            print_r($news_list);
            print_r($this->db->last_query());
            die();
        }

        /*if(empty($news_list)) {
            show_404();
        }*/
        
        $this->data['categories_arr'] = $categories_arr;
        $this->data['news_list'] = $news_list;

    }

    /*public function tesupload() {
        mkdir('/home/borneot4/public_html/uploads/news/tilapia/', 0755, true);
    }*/

    /**
     * category page.
     * @access public
     */
    public function category($slug='') {
        $page_detail = getPageByPath('news');

        $news_list = $this->News_model->GetNewsData(['news_category.slug'=>$slug]);

        $single_category = $this->News_model->getCategory('', $slug);

        $categories_arr = $this->News_model->getCategoriesWithNewsCount();

        if(isset($_GET['debuginfo']) && !empty($_GET['debuginfo']) && $_GET['debuginfo'] == 'news') {
            $this->Layout = 'blank';
            echo '<pre>';
            print_r($news_list);
            print_r($this->db->last_query());
            die();
        }

        /*if(empty($news_list)) {
            show_404();
        }*/
        
        $this->data['single_category'] = $single_category;
        $this->data['categories_arr'] = $categories_arr;
        $this->data['category_news_list'] = $news_list;
    }
    
    /**
     * detail page
     * @access public
     * @param string $slug
     */
    public function view_news($slug='') {

        //die('view news');

        if (!$slug) {
            redirect('/');
            exit;
        }

        // $where_arr = array(
        //     'news.slug' => $slug,
        //     'news.id_status'=>1,
        //     'news.is_delete'=>0,
        //     'news.publish_date'=>' <='.date("Y-m-d H:i:s")
        // );

        $records = $this->News_model->GetNewsByUriPath($slug);

        $categories_arr = $this->News_model->getCategoriesWithNewsCount();

        if(isset($_GET['debuginfo']) && !empty($_GET['debuginfo']) && $_GET['debuginfo'] == 'news') {
            $this->Layout = 'blank';
            echo '<pre>';
            print_r($records);
            print_r($this->db->last_query());
            print_r($categories_arr);
            die();
        }

        if(empty($records)) {
            show_404();
        }
        
        if (!$records) {
            redirect('/');
            exit;
        }
        
        // get all records
        $this->data['news'] = $records;
        $this->data['categories_arr'] = $categories_arr;
    }
	
	public function ajax_news_video() {
		
		if($this->input->post()) {
			//die('post');
			$post = $this->input->post();
			$single_video = $this->News_model->getSingleVideo($post['id_news']);
			
			// echo '<pre>';
			// print_r($single_video);
			// die();
			
			$data['video'] = $single_video;
			
			$json['view'] = $this->load->view(TEMPLATE_DIR.'/ajax/ajax_video', $data, TRUE);
			
			header('Content-type: application/json');
            exit (
                json_encode($json)
            );
		}
	}

    
}

/* End of file News.php */
/* Location: ./application/controllers/News.php */
