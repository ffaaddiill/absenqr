<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customer Model Class
 * @author fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Customer model
 * 
 */
class Customer_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
	
    function saveDataRental($param) {
    	$this->db->insert('customer',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    function getCustomerProductById($id) {
    	$data = $this->db
    			->where('id_product', $id)
    			->join('product_package', 'product.id_package = product_package.id', 'LEFT')
    			->get('product')
    			->row_array();
    	return $data;
    }

    function getCustomerById($id) {
    	$data = $this->db
    			->where('id', $id)
    			->get('customer')
    			->row_array();
    	return $data;
    }
}