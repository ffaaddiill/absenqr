<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Jenis_kelamin Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Jenis_kelamin model
 * 
 */
class Jenis_kelamin_model extends CI_Model
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
    function GetAllJenis_kelaminData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='jenis_kelamin'){
                            $this->db->like('LCASE(`jenis_kelamin`.`jenis_kelamin`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='jenis_kelamin'){
                            $this->db->like('LCASE(`jenis_kelamin`.`jenis_kelamin`)',strtolower($param['search_value']));
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
            $this->db->order_by('id_jenis_kelamin','desc');
        }
        $data = $this->db
                ->select('*')
                ->get('jenis_kelamin')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllJenis_kelamin($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='jenis_kelamin'){
                            $this->db->like('LCASE(`jenis_kelamin`.`jenis_kelamin`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='jenis_kelamin'){
                            $this->db->like('LCASE(`jenis_kelamin`.`jenis_kelamin`)',strtolower($param['search_value']));
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
                        ->from('jenis_kelamin')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetJenis_kelamin($id) {
        $data = $this->db
                ->where('id_jenis_kelamin',$id)
                ->where('is_delete', 0)
                ->limit(1)
                ->get('jenis_kelamin')
                ->row_array();
        return $data;
    }

    function GetAllJenis_kelamin() {
        $data = $this->db
                ->where('is_delete', 0)
                ->get('jenis_kelamin')
                ->result_array();
        return $data;
    }

    function getJenisKelamin() {
        $data = $this->db
                ->where('is_delete', 0)
                ->get('jenis_kelamin')
                ->result_array();

        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('jenis_kelamin',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('jenis_kelamin',$param);
    }

    function insertJenis_kelamin($param) {
        $this->db->insert('jenis_kelamin', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchJenis_kelaminValue($param) {
      $this->db->insert_batch('jenis_kelamin_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_jenis_kelamin',$id);
        $this->db->update('jenis_kelamin',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_jenis_kelamin',$id);
        $this->db->update('jenis_kelamin',array('is_delete'=>1));
    }
    
}

/* End of file Jenis_kelamin_model.php */
/* Location: ./application/models/Jenis_kelamin_model.php */