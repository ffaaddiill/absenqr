<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Subscriber Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Subscriber model
 * 
 */
class Subscriber_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    public function add($data=array()) {

        $this->db->insert('subscriber', $data);
        $db_error = $this->db->error();
        return $db_error;        
    }
}