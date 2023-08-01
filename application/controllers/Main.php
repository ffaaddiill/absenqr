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
class Main extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Slideshow_model','Banner_model','Package_model','Gallery_ourfarm_model','Gallery_hatcherylab_model','Slideshow_product_model','Gallery_model','Product_model', 'Location_model', 'Video_model'));
        $this->class_path_name = $this->router->fetch_class();
    }

    public function index() {
        $top_slideshow = $this->Slideshow_model->GetSlideshowData();
        $this->data['top_slideshow'] = $top_slideshow;

        //$product_slideshow = $this->Slideshow_product_model->GetSlideshowProductData();
        //$this->data['product_slideshow'] = $product_slideshow;

        $gallery = $this->Gallery_model->GetGalleryData();
        $this->data['gallery_slug'] = 'gallery';
        $this->data['gallery'] = $gallery;

        $gallery_ourfarm = $this->Gallery_ourfarm_model->GetGallery_ourfarmData();
        $this->data['gallery_ourfarm_slug'] = 'gallery-ourfarm';
        $this->data['gallery_ourfarm'] = $gallery_ourfarm;

        $gallery_hatcherylab = $this->Gallery_hatcherylab_model->GetGallery_hatcherylabData();
        $this->data['gallery_hatcherylab_slug'] = 'gallery-hatchery-rnd-room';
        $this->data['gallery_hatcherylab'] = $gallery_hatcherylab;

        $banner_homepage = $this->Banner_model->GetBannerData();
        $this->data['banner_homepage'] = $banner_homepage;

        /*echo '<pre>';
        print_r($product_slideshow);
        die();

        $this->layout = 'blank';*/

    }

    
    function test() {
        
        echo get_client_ip();exit();
    }
	
	function tes_fb_api() {
		try {
	  		// Returns a `FacebookFacebookResponse` object
		  	$response = $fb->post(
		    	'/{your-page-id}/feed',
		    	array (
		      		'message' => 'Awesome!'
		    	),
		    	'{access-token}'
		  	);
			} catch(FacebookExceptionsFacebookResponseException $e) {
				echo 'Graph returned an error: ' . $e->getMessage();
		  		exit;
			} catch(FacebookExceptionsFacebookSDKException $e) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}
			$graphNode = $response->getGraphNode();
	}
    
    /**
     * Index Page for this controller.
     * @access public
     */



    public function allitems() {
    	$data = $this->db
    			->select('title, uri_path, primary_image')
    			->where('uri_path', 'full-items')
    			->limit(1)
    			->get('bank_image')
    			->row_array();

    	$this->data['full_item_img'] = !empty($data['primary_image']) ? MAINSITE.'uploads/'.$data['primary_image']:'';

    	//die('allitems!');
    }

    public function allcars() {
        

        $this->data['full_item_img'] = !empty($data['primary_image']) ? MAINSITE.'uploads/'.$data['primary_image']:'';

        //die('allitems!');
    }

    /*public function index($category='food') {
        $this->load->library('user_agent');
        

        if(time() >= strtotime('25-12-2015') && time() <= strtotime('05-01-2016')) {
            // natan event has been started
            $this->data['template'] = $this->class_path_name.'/main_natal';
        } else {
            $this->data['template'] = $this->class_path_name.'/main';
        }

        $this->data['page_title'] = 'Home';

        $food_beverage = $this->Product_model->GetProductData(0, $category, '', '', '', 'product.publish_date', 'desc');
		$this->data['food_beverage'] = $food_beverage;

		
		if(isset($_GET['debug']) && $_GET['debug'] == '999') {
			echo '<pre>';
			print_r($food);
			die();
		}
    }*/
	
    public function clear_all_cache(){
        $this->layout='none';
        $this->cache->clean();
    }
}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */
