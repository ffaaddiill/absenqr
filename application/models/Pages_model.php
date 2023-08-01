<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
	
	function getPage($slug='') {
		$data = $this->db
				->where('id_status', 1)
				->where('is_delete', 0)
				->where('page_type', 1)
				->where('slug', $slug)
				->limit(1)
				->get('pages')->row_array();
				
		return $data;
	}
	
}