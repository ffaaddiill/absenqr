<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Product model
 * 
 */
class Product_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
	
	function getAllProductForSitemap() {
		$now = date('Y-m-d H:i:s');
		$data = $this->db
                ->where('product.id_status',1)
                ->where('product.is_delete',0)
                ->where('product.publish_date <=',$now)
                ->order_by('product.publish_date','desc')
                ->join('product_category', 'product.id_product_category = product_category.id', 'left')
                ->get('product')
                ->result_array();
        return $data;
	}
    
    /**
     * get all data
     * @param string $param
     * @return array data
     */
    function GetAllProductData($param=array()) {
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        if (isset($param['row_from']) && isset($param['length'])) {
            $this->db->limit($param['length'],$param['row_from']);
        }
        if (isset($param['order_field'])) {
            if (isset($param['order_sort'])) {
                $this->db->order_by($param['order_field'],$param['order_sort']);
            } else {
                $this->db->order_by($param['order_field'],'desc');
            }
        } else {
            $this->db->order_by('product.id_product','desc');
        }
        $data = $this->db
                ->select("*,id_product as id")
                ->where('product.is_delete',0)
				->join('product_category', 'product_category.id = product.id_product_category', 'LEFT')
                ->join('area', 'product.id_area = area.id', 'LEFT')
                ->join('product_package', 'product.id_package = product_package.id', 'LEFT')
                ->get('product')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllProduct($param=array()) {
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                	->from('product')
				->join('product_category', 'product.id_product_category=product_category.id', 'left')
                	->where('product.is_delete',0)
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get detail by id
     * @param int $id
     * @return array data
     */
    function GetProduct($id) {
        $data = $this->db
                ->where('id_product',$id)
                ->limit(1)
                ->get('product')
                ->row_array();
        return $data;
    }
	
	function getCategoryById($id) {
		$data = $this->db
				->where('id', $id)
				->limit(1)
				->get('product_category')
				->row_array();
		return $data;
	}

    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('product',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_product',$id);
        return $this->db->update('product',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_product',$id);
        $this->db->delete('product');
    }

    function delete_picture($id) {
        $this->db->where('id_product', $id);
        $this->db->update('product', array(
            'primary_image'=>'',
            'picture_file_name'=>''
        ));
    }

    /**
     * insert sites with batch method
     * @param array $data
     */
    function InsertSitesBatch($data){
        $this->db->insert_batch('product_sites',$data);
    }

    function setAsHeadline($param) {
		$this->db->insert('product_headline', $param);
    }
    
    function isExistHeadline($param) {
        $count = $this->db
                ->from('product_headline')
                ->count_all_results();
        return $count;
    }

    /**
     * Get Site by id
     * @param int $id
     * @return array data
     */
    function GetSitesById($id) {
        $data = $this->db
                ->where('id_product',$id)
                ->get('product_sites')
                ->result_array();
        return $data;
    }

    /**
     * delete site record
     * @param int $id
     */
    function DeleteSite($id){
        $this->db->where('id_product',$id);
        $this->db->delete('product_sites');
    }
    
}
/* End of file Product_model.php */
/* Location: ./application/models/Product_model.php */