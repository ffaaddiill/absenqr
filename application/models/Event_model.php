<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Event Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Event model
 * 
 */
class Event_model extends CI_Model
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
    function GetEventData($limit=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->order_by('publish_date','desc')
                ->order_by('id_event','desc')
                ->get('event')
                ->result_array();

        foreach($data as $key => $value) {
            $data[$key]['total_gallery'] = $this->countEventGalleryById( $value['id_event'] );
        }

        return $data;
    }

    function countEventGalleryById($id) {
        $total_count = $this->db
                ->where('id_event', $id)
                ->from('event_gallery')
                ->count_all_results();

        return $total_count;
    }
    
    /**
     * get event by url/slug
     * @param string $uri_path
     * @return array data
     */
    function GetEventByUriPath($uri_path) {
        $now = date("Y-m-d");
        $data = $this->db
                ->where('LCASE(uri_path)',strtolower($uri_path))
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('publish_date <=',$now)
                ->order_by('id_event','desc')
                ->limit(1)
                ->get('event')
                ->row_array();
        if ($data) {
            $data['total_gallery'] = $this->countEventGalleryById( $data['id_event'] );
            $data['galleries'] = $this->db
                                    ->where('id_event',$data['id_event'])
                                    ->order_by('position','asc')
                                    ->order_by('id_event','desc')
                                    ->get('event_gallery')
                                    ->result_array();
        }
        return $data;
    }
    
}
/* End of file Event_model.php */
/* Location: ./application/models/Event_model.php */