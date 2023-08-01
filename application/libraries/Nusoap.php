<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Nusoap
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Library
 * @desc Nusoap library 
 * 
 */

class Nusoap {
    
    /**
     * load the third party
     */
    function __construct() {
        require_once(APPPATH . 'third_party/Nusoap/nusoap.php');
    }

}

/* End of file Nusoap.php */
/* Location: ./application/libraries/Nusoap.php */