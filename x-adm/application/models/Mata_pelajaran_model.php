<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mata_pelajaran Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Mata_pelajaran model
 * 
 */
class Mata_pelajaran_model extends CI_Model
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
    function GetAllMata_pelajaranData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='nama_mata_pelajaran'){
                            $this->db->like('LCASE(`mata_pelajaran`.`nama_mata_pelajaran`)',strtolower($param['search_value']));
                        } elseif($val['data']=='kode') {
                            $this->db->like('LCASE(`mata_pelajaran`.`kode`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='nama_mata_pelajaran'){
                            $this->db->like('LCASE(`mata_pelajaran`.`nama_mata_pelajaran`)',strtolower($param['search_value']));
                        } elseif($val['data']=='kode') {
                            $this->db->like('LCASE(`mata_pelajaran`.`kode`)',strtolower($param['search_value']));
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
            $this->db->order_by('id_mata_pelajaran','desc');
        }
        $data = $this->db
                ->select('*,
                    (select status.status from status where status.id_status = mata_pelajaran.is_active) as is_active')
                ->get('mata_pelajaran')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllMata_pelajaran($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='nama_mata_pelajaran'){
                            $this->db->like('LCASE(`mata_pelajaran`.`nama_mata_pelajaran`)',strtolower($param['search_value']));
                        } elseif($val['data']=='kode') {
                            $this->db->like('LCASE(`mata_pelajaran`.`kode`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='nama_mata_pelajaran'){
                            $this->db->like('LCASE(`mata_pelajaran`.`nama_mata_pelajaran`)',strtolower($param['search_value']));
                        } elseif($val['data']=='kode') {
                            $this->db->like('LCASE(`mata_pelajaran`.`kode`)',strtolower($param['search_value']));
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
                        ->from('mata_pelajaran')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetMata_pelajaran($id) {
        $data = $this->db
                ->where('id_mata_pelajaran',$id)
                ->where('is_delete', 0)
                ->limit(1)
                ->get('mata_pelajaran')
                ->row_array();
        return $data;
    }

    function GetAllMata_pelajaran() {
        $data = $this->db
                ->where('is_delete', 0)
                ->get('mata_pelajaran')
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
        $this->db->insert('mata_pelajaran',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('mata_pelajaran',$param);
    }

    function insertMata_pelajaran($param) {
        $this->db->insert('mata_pelajaran', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchMata_pelajaranValue($param) {
      $this->db->insert_batch('mata_pelajaran_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_mata_pelajaran',$id);
        $this->db->update('mata_pelajaran',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_mata_pelajaran',$id);
        $this->db->update('mata_pelajaran',array('is_delete'=>1));
    }
    
}

/* End of file Mata_pelajaran_model.php */
/* Location: ./application/models/Mata_pelajaran_model.php */