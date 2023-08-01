<?php


/**
 * Jurusan Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Jurusan Controller
 * 
 */

class Imsak extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->class_path_name = $this->router->fetch_class();
    }

    public function index() {

        $ch = curl_init();                    // initiate curl
        $url = "http://sihat.kemenag.go.id/site/get_imsakiyah"; // where you want to post data
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
        curl_setopt($ch, CURLOPT_POSTFIELDS, "tahun=3&lokasi=667"); // define what you want to post
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
        $output = curl_exec ($ch); // execute
         
        curl_close ($ch); // close curl handle

        echo '<pre>';
        print_r($output);
    }

}