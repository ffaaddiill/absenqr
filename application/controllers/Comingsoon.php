<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comingsoon Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Comingsoon Controller
 * 
 */
class Comingsoon extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['page_title'] = 'Comingsoon';
    }

}

/* End of file Comingsoon.php */
/* Location: ./application/controllers/Comingsoon.php */
