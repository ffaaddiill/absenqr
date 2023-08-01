<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * HTML2PDF
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Library
 * @desc HTML2PDF library 
 * 
 */

class Convert2pdf {
    
    /**
     * load the third party
     */
    function __construct() {
        require_once(APPPATH . 'third_party/Html2Pdf/html2pdf.class.php');
    }

}

/* End of file Html2pdf.php */
/* Location: ./application/libraries/Html2pdf.php */