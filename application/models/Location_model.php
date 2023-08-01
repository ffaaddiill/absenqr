<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Location model
 * 
 */
class Location_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get location category
     * @return array data
     */
    function GetLocationCategory() {
        $data = $this->db
		->where('is_delete',0)
		->order_by('position','asc')
		->get('category_offices')
		->result_array();
        return $data;
    }
    
    /**
     * get hierarchy office data 
     * @return array data
     */
    function GetLocationData() {
        $data = $this->GetLocationCategory();
        if ($data) {
            foreach ($data as $row => $record) {
		$data[$row]['offices'] = $this->db
			->select('offices.*, regionals.name as regional, category_offices.name as category_office')
			->join('regionals','regionals.id=offices.regional_id','left')
			->join('category_offices','category_offices.id=offices.category_office_id','left')
                        ->where('offices.category_office_id',$record['id'])
                        ->where('offices.is_delete',0)
			->order_by('offices.id')
			->get('offices')
			->result_array();
            }
        }
        return $data;
    }
    
}
/* End of file Location_model.php */
/* Location: ./application/models/Location_model.php */