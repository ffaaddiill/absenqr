<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customer inbox Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Customer inbox model
 * 
 */
class Customer_inbox_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    public function add($data=array()) {
        return $this->db->insert('customer_inbox', $data);
    }
}