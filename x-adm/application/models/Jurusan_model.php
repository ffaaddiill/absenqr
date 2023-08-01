<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Jurusan Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Jurusan model
 * 
 */
class Jurusan_model extends CI_Model
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
    function GetAllJurusanData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='nama_jurusan'){
                            $this->db->like('LCASE(`jurusan`.`nama_jurusan`)',strtolower($param['search_value']));
                        } elseif($val['data']=='kode') {
                            $this->db->like('LCASE(`jurusan`.`kode`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='nama_jurusan'){
                            $this->db->like('LCASE(`jurusan`.`nama_jurusan`)',strtolower($param['search_value']));
                        } elseif($val['data']=='kode') {
                            $this->db->like('LCASE(`jurusan`.`kode`)',strtolower($param['search_value']));
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
            $this->db->order_by('id_jurusan','desc');
        }
        $data = $this->db
                ->select('*,
                    (select status.status from status where status.id_status = jurusan.is_active) as is_active')
                ->get('jurusan')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllJurusan($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='nama_jurusan'){
                            $this->db->like('LCASE(`jurusan`.`nama_jurusan`)',strtolower($param['search_value']));
                        } elseif($val['data']=='kode') {
                            $this->db->like('LCASE(`jurusan`.`kode`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='nama_jurusan'){
                            $this->db->like('LCASE(`jurusan`.`nama_jurusan`)',strtolower($param['search_value']));
                        } elseif($val['data']=='kode') {
                            $this->db->like('LCASE(`jurusan`.`kode`)',strtolower($param['search_value']));
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
                        ->from('jurusan')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetJurusan($id) {
        $data = $this->db
                ->where('id_jurusan',$id)
                ->where('is_delete', 0)
                ->limit(1)
                ->get('jurusan')
                ->row_array();
        return $data;
    }

    function GetAllJurusan() {
        $data = $this->db
                ->where('is_delete', 0)
                ->get('jurusan')
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
        $this->db->insert('jurusan',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('jurusan',$param);
    }

    function insertJurusan($param) {
        $this->db->insert('jurusan', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchJurusanValue($param) {
      $this->db->insert_batch('jurusan_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_jurusan',$id);
        $this->db->update('jurusan',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_jurusan',$id);
        $this->db->update('jurusan',array('is_delete'=>1));
    }
    
}

/* End of file Jurusan_model.php */
/* Location: ./application/models/Jurusan_model.php */