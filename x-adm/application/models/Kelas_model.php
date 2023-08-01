<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kelas Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Kelas model
 * 
 */
class Kelas_model extends CI_Model
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
    function GetAllKelasData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='nama_kelas'){
                            $this->db->like('LCASE(`kelas`.`nama_kelas`)',strtolower($param['search_value']));
                        } elseif($val['data']=='tahun_ajaran') {
                            $this->db->like('LCASE(`kelas`.`tahun_ajaran`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='nama_kelas'){
                            $this->db->like('LCASE(`kelas`.`nama_kelas`)',strtolower($param['search_value']));
                        } elseif($val['data']=='tahun_ajaran') {
                            $this->db->like('LCASE(`kelas`.`tahun_ajaran`)',strtolower($param['search_value']));
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
        if(isset($param['slug'])) {
            $this->db->where('slug', $param['slug']);
        }
        if (isset($param['order_field'])) {
            if (isset($param['order_sort'])) {
                $this->db->order_by($param['order_field'],$param['order_sort']);
            } else {
                $this->db->order_by($param['order_field'],'desc');
            }
        } else {
            $this->db->order_by('id_kelas','desc');
        }
        $data = $this->db
                ->select('*')
                ->get('kelas')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllKelas($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='nama_kelas'){
                            $this->db->like('LCASE(`kelas`.`nama_kelas`)',strtolower($param['search_value']));
                        } elseif($val['data']=='tahun_ajaran') {
                            $this->db->like('LCASE(`kelas`.`tahun_ajaran`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='nama_kelas'){
                            $this->db->like('LCASE(`kelas`.`nama_kelas`)',strtolower($param['search_value']));
                        } elseif($val['data']=='tahun_ajaran') {
                            $this->db->like('LCASE(`kelas`.`tahun_ajaran`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        if(isset($param['slug'])) {
            $this->db->where('slug', $param['slug']);
        }
        $total_records = $this->db
                        ->select('*')
                        ->from('kelas')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetKelas($id) {
        $data = $this->db
                ->where('id_kelas',$id)
                ->limit(1)
                ->get('kelas')
                ->row_array();
        return $data;
    }

    function GetAllKelas() {
        $data = $this->db
                ->get('kelas')
                ->result_array();
        return $data;
    }

    function getJenisKelamin() {
        $data = $this->db
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
        $this->db->insert('kelas',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('kelas',$param);
    }

    function insertKelas($param) {
        $this->db->insert('kelas', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchKelasValue($param) {
      $this->db->insert_batch('kelas_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_kelas',$id);
        $this->db->update('kelas',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_kelas',$id);
        $this->db->update('kelas');
    }
    
}

/* End of file Kelas_model.php */
/* Location: ./application/models/Kelas_model.php */