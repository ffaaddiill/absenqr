<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Slideshow Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Slideshow model
 * 
 */
class Slideshow_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all slideshow
     * @param int $limit
     * @return array data
     */
    function GetSlideshowData($limit=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $data = $this->db
                ->where('slideshow.is_delete',0)
                ->where('slideshow.id_status',1)
                // ->where('slideshow_sites.id_site', 1)
                // ->join('slideshow_sites', 'slideshow.id_slideshow = slideshow_sites.id_slideshow', 'left')
                ->order_by('slideshow.position','asc')
                ->get('slideshow')
                ->result_array();
        return $data;
    }
    
}
/* End of file Slideshow_model.php */
/* Location: ./application/models/Slideshow_model.php */