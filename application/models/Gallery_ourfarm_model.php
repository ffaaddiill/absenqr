<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gallery_ourfarm Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Gallery_ourfarm model
 * 
 */
class Gallery_ourfarm_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all gallery_ourfarm
     * @param int $limit
     * @return array data
     */
    function GetGallery_ourfarmData($limit=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $data = $this->db
                ->where('gallery_ourfarm.is_delete',0)
                ->where('gallery_ourfarm.id_status',1)
                // ->where('gallery_ourfarm_sites.id_site', 1)
                // ->join('gallery_ourfarm_sites', 'gallery_ourfarm.id_gallery_ourfarm = gallery_ourfarm_sites.id_gallery_ourfarm', 'left')
                ->order_by('gallery_ourfarm.position','asc')
                ->get('gallery_ourfarm')
                ->result_array();
        return $data;
    }
    
}
/* End of file Gallery_ourfarm_model.php */
/* Location: ./application/models/Gallery_ourfarm_model.php */