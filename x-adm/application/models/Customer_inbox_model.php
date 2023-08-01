<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customer_inbox Model Class
 * @author Fadilah Ajiq Surya
 * @version 3.0
 * @category Controller
 * @desc Customer_inbox Model Controller
 * 
 */
class Customer_inbox_model extends CI_Model {

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
                ->where('id_customer_inbox',$id)
                ->limit(1)
                ->get('customer_inbox')
                ->row_array();
        return $data;
    }
	
	function getCustomer_inboxs() {
		$data = $this->db
				->get('customer_inbox')
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
                ->from('customer_inbox')
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
            $this->db->order_by('id_customer_inbox','desc');
        }
        $data = $this->db
                ->select("*,id_customer_inbox as id")
                ->get('customer_inbox')
                ->result_array();
        return $data;
    }

    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('customer_inbox',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_customer_inbox',$id);
        $this->db->update('customer_inbox',$param);
    }

    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_customer_inbox',$id);
        $this->db->delete('customer_inbox');
    }
    
}
/* End of file Office_category_model.php */
/* Location: ./application/models/Office_category_model.php */