<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Office Category Model Class
 * @author Hamba Allah
 * @version 3.0
 * @category Controller
 * @desc Office Category Model Controller
 * 
 */
class News_category_model extends CI_Model {

    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Get detail by id
     * @param int $id
     * @return array data
     */
    function GetRecord($id) {
        $data = $this->db
                ->where('id',$id)
                ->where('is_delete',0)
                ->limit(1)
                ->get('news_category')
                ->row_array();
        return $data;
    }
	
	function getCategories() {
		$data = $this->db
				->where('is_active', 1)
				->where('is_delete', 0)
				->get('news_category')
				->result_array();
		return $data;
	}

    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllRecord($param=array()) {
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
                ->from('news_category')
                ->where('is_delete',0)
                ->count_all_results();
        return $total_records;
    }

    /**
     * get all data
     * @param string $param
     * @return array data
     */
    function GetAllRecordData($param=array()) {
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
            $this->db->order_by('id','desc');
        }
        $data = $this->db
                ->select("*,id as id")
                ->where('is_delete',0)
                ->get('news_category')
                ->result_array();
        return $data;
    }

    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('news_category',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id',$id);
        $this->db->update('news_category',$param);
    }

    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id',$id);
        $this->db->delete('news_category');
    }
    
}
/* End of file Office_category_model.php */
/* Location: ./application/models/Office_category_model.php */