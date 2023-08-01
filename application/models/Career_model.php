<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Career Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Career model
 * 
 */
class Career_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all data
     * @param int $limit
     * @return array data
     */
    function GetCareersData($limit=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $now = date("Y-m-d");
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('publish_date <=',$now)
                ->where("(end_date >= '{$now}' OR end_date IS NULL || end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->order_by('id_career','desc')
                ->get('career')
                ->result_array();
        return $data;
    }
    
    /**
     * get data by id
     * @param int $id
     * @return array data
     */
    function GetCareerData($id) {
        $now = date("Y-m-d");
        $data = $this->db
                ->where('id_career',$id)
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('publish_date <=',$now)
                ->where("(end_date >= '{$now}' OR end_date IS NULL || end_date = '0000-00-00')")
                ->order_by('id_career','desc')
                ->limit(1)
                ->get('career')
                ->row_array();
        return $data;
    }
    
    /**
     * insert resume
     * @param array $data
     * @return int last inserted id
     */
    function InsertResume($data) {
        $this->db->insert('career_applicant',$data);
        return $this->db->insert_id();
    }
}
/* End of file Career_model.php */
/* Location: ./application/models/Career_model.php */