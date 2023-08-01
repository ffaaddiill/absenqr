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
class Gallery_hatcherylab extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Gallery_hatcherylab_model');
        $this->data['page_title'] = 'Gallery_hatcherylab';
    }

    public function index() {
        $gallery_hatcherylab = $this->Gallery_hatcherylab_model->GetGallery_hatcherylabData();

        if(isset($_GET['debuginfo']) && !empty($_GET['debuginfo']) && $_GET['debuginfo'] == 'gallery') {
            $this->Layout = 'blank';
            echo '<pre>';
            print_r($gallery_hatcherylab);
            die();
        }

        if(empty($gallery_hatcherylab)) {
            show_404();
        }

        $this->data['gallery_hatcherylab'] = $gallery_hatcherylab;        
    }

}