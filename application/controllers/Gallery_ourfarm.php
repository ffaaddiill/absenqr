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
class Gallery_ourfarm extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Gallery_ourfarm_model');
        $this->data['page_title'] = 'Gallery_ourfarm';
    }

    public function index() {
        $gallery_ourfarm = $this->Gallery_ourfarm_model->GetGallery_ourfarmData();

        if(isset($_GET['debuginfo']) && !empty($_GET['debuginfo']) && $_GET['debuginfo'] == 'gallery') {
            $this->Layout = 'blank';
            echo '<pre>';
            print_r($gallery_ourfarm);
            die();
        }

        if(empty($gallery_ourfarm)) {
            show_404();
        }

        $this->data['gallery_ourfarm'] = $gallery_ourfarm;        
    }

}