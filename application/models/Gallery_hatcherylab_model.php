<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gallery_hatcherylab Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Gallery_hatcherylab model
 * 
 */
class Gallery_hatcherylab_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all gallery_hatcherylab
     * @param int $limit
     * @return array data
     */
    function GetGallery_hatcherylabData($limit=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $data = $this->db
                ->where('gallery_hatcherylab.is_delete',0)
                ->where('gallery_hatcherylab.id_status',1)
                // ->where('gallery_hatcherylab_sites.id_site', 1)
                // ->join('gallery_hatcherylab_sites', 'gallery_hatcherylab.id_gallery_hatcherylab = gallery_hatcherylab_sites.id_gallery_hatcherylab', 'left')
                ->order_by('gallery_hatcherylab.position','asc')
                ->get('gallery_hatcherylab')
                ->result_array();
        return $data;
    }
    
}
/* End of file Gallery_hatcherylab_model.php */
/* Location: ./application/models/Gallery_hatcherylab_model.php */