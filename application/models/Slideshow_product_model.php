<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Slideshow Product Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Slideshow Product model
 * 
 */
class Slideshow_product_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all slideshow_product
     * @param int $limit
     * @return array data
     */
    function GetSlideshowProductData($limit=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $data = $this->db
                ->where('slideshow_product.is_delete',0)
                ->where('slideshow_product.id_status',1)
                // ->where('slideshow_product_sites.id_site', 1)
                // ->join('slideshow_product_sites', 'slideshow_product.id_slideshow_product = slideshow_product_sites.id_slideshow_product', 'left')
                ->order_by('slideshow_product.position','asc')
                ->get('slideshow_product')
                ->result_array();
        return $data;
    }
    
}
/* End of file Slideshow_product_model.php */
/* Location: ./application/models/Slideshow_product_model.php */