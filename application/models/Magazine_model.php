<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Magazine Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Magazine model
 * 
 */
class Magazine_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get channel list by status
     * @param int $limit
     * @return array data
     */
    function GetMagazineData($limit=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $data = $this->db
                ->where('is_delete',0)
                ->order_by('position','desc')
                ->get('magazine')
                ->result_array();
        return $data;
    }

    /**
     * created by fadilah ajiq surya, 24 August 2015 at 4.25 PM, BSP
     * get highlight data
     * @return single row
     */
    function GetHighlight() {
        $data = $this->db
                ->where('is_delete', 0)
                ->where('is_active', 1)
                ->limit(1)
                ->get('highlight')
                ->row_array();
        return $data;
    }
    
    /**
     * get magazine by url/slug
     * @param string $uri_path
     * @return array data
     */
    function GetMagazineByUriPath($uri_path) {
        $now = date("Y-m-d");
        $data = $this->db
                ->where('LCASE(uri_path)',strtolower($uri_path))
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('publish_date <=',$now)
                ->where("(end_date >= '{$now}' OR end_date IS NULL || end_date = '0000-00-00')")
                ->order_by('id_magazine','desc')
                ->limit(1)
                ->get('magazine')
                ->row_array();
        return $data;
    }
    
}
/* End of file Magazine_model.php */
/* Location: ./application/models/Magazine_model.php */