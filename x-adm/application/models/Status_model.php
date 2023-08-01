<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Status Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Status model
 * 
 */
class Status_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * get all admin data
     * @param string $param
     * @return array data
     */
    function GetAllStatusData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='status'){
                            $this->db->like('LCASE(`status`.`status`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='status'){
                            $this->db->like('LCASE(`status`.`status`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
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
            $this->db->order_by('id_status','desc');
        }
        $data = $this->db
                ->select('*')
                ->get('status')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllStatus($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='status'){
                            $this->db->like('LCASE(`status`.`status`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='status'){
                            $this->db->like('LCASE(`status`.`status`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                        ->select('*')
                        ->from('status')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetStatus($id) {
        $data = $this->db
                ->where('id_status',$id)
                ->where('is_delete', 0)
                ->limit(1)
                ->get('status')
                ->row_array();
        return $data;
    }

    function GetAllStatus() {
        $data = $this->db
                ->where('is_delete', 0)
                ->get('status')
                ->result_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('status',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('status',$param);
    }

    function insertStatus($param) {
        $this->db->insert('status', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchStatusValue($param) {
      $this->db->insert_batch('status_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_status',$id);
        $this->db->update('status',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_status',$id);
        $this->db->update('status',array('is_delete'=>1));
    }
    
}

/* End of file Status_model.php */
/* Location: ./application/models/Status_model.php */