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
class Gallery extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Gallery_model');
        $this->data['page_title'] = 'Gallery';
    }

    public function index() {
        $gallery = $this->Gallery_model->GetGalleryData();

        if(isset($_GET['debuginfo']) && !empty($_GET['debuginfo']) && $_GET['debuginfo'] == 'gallery') {
            $this->Layout = 'blank';
            echo '<pre>';
            print_r($gallery);
            die();
        }

        if(empty($gallery)) {
            show_404();
        }
        
        $this->data['gallery'] = $gallery;
        
    }

}