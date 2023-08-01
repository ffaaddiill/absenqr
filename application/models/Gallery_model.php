<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gallery Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Gallery model
 * 
 */
class Gallery_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all gallery
     * @param int $limit
     * @return array data
     */
    function GetGalleryData($limit=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $data = $this->db
                ->where('gallery.is_delete',0)
                ->where('gallery.id_status',1)
                // ->where('gallery_sites.id_site', 1)
                // ->join('gallery_sites', 'gallery.id_gallery = gallery_sites.id_gallery', 'left')
                ->order_by('gallery.position','asc')
                ->get('gallery')
                ->result_array();
        return $data;
    }
    
}
/* End of file Gallery_model.php */
/* Location: ./application/models/Gallery_model.php */