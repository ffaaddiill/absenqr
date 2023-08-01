<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Banner Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Banner model
 * 
 */
class Banner_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all banner
     * @param int $limit
     * @return array data
     */
    function GetBannerData($limit=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $data = $this->db
                ->where('banner.is_delete',0)
                ->where('banner.id_status',1)
                // ->where('banner_sites.id_site', 1)
                // ->join('banner_sites', 'banner.id_banner = banner_sites.id_banner', 'left')
                ->order_by('banner.position','asc')
                ->get('banner')
                ->row_array();
        return $data;
    }
    
}
/* End of file Banner_model.php */
/* Location: ./application/models/Banner_model.php */