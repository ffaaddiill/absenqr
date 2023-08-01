<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Harbolnas Model Class
 * @author fadilah ajiq surya, fadilah.ajiq.surya@gmail.com
 * @version 3.0
 * @category Model
 * @desc Harbolnas model
 * 
 */
class Harbolnas_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * get harbolnas data
     * @return single row
     */
    function GetHarbolnas() {
        $data = $this->db
                ->where('is_delete', 0)
                ->where('is_active', 1)
                ->limit(1)
                ->get('harbolnas')
                ->row_array();
        return $data;
    }

}