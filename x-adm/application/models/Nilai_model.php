<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Nilai Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Nilai model
 * 
 */
class Nilai_model extends CI_Model
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
    function GetAllNilaiData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='nilai_min'){
                            $this->db->like('LCASE(`nilai`.`nilai_min`)',strtolower($param['search_value']));
                        } elseif($val['data']=='nilai_max') {
                            $this->db->like('LCASE(`nilai`.`nilai_max`)',strtolower($param['search_value']));
                        } elseif($val['data']=='nilai_abjad') {
                            $this->db->like('LCASE(`nilai`.`nilai_abjad`)',strtolower($param['search_value']));
                        } elseif($val['data']=='bobot') {
                            $this->db->like('LCASE(`nilai`.`bobot`)',strtolower($param['search_value']));
                        }elseif($val['data']=='keterangan') {
                            $this->db->like('LCASE(`nilai`.`keterangan`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='nilai_min'){
                            $this->db->like('LCASE(`nilai`.`nilai_min`)',strtolower($param['search_value']));
                        } elseif($val['data']=='nilai_max') {
                            $this->db->like('LCASE(`nilai`.`nilai_max`)',strtolower($param['search_value']));
                        } elseif($val['data']=='nilai_abjad') {
                            $this->db->like('LCASE(`nilai`.`nilai_abjad`)',strtolower($param['search_value']));
                        } elseif($val['data']=='bobot') {
                            $this->db->like('LCASE(`nilai`.`bobot`)',strtolower($param['search_value']));
                        } elseif($val['data']=='keterangan') {
                            $this->db->like('LCASE(`nilai`.`keterangan`)',strtolower($param['search_value']));
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
            $this->db->order_by('id_nilai','desc');
        }
        $data = $this->db
                ->select('*,
                    (select status.status from status where status.id_status = nilai.is_active) as is_active')
                ->get('nilai')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllNilai($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='nama_nilai'){
                            $this->db->like('LCASE(`nilai`.`nama_nilai`)',strtolower($param['search_value']));
                        } elseif($val['data']=='tahun_ajaran') {
                            $this->db->like('LCASE(`nilai`.`tahun_ajaran`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='nama_nilai'){
                            $this->db->like('LCASE(`nilai`.`nama_nilai`)',strtolower($param['search_value']));
                        } elseif($val['data']=='tahun_ajaran') {
                            $this->db->like('LCASE(`nilai`.`tahun_ajaran`)',strtolower($param['search_value']));
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
                        ->from('nilai')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetNilai($id) {
        $data = $this->db
                ->where('id_nilai',$id)
                ->where('is_delete', 0)
                ->limit(1)
                ->get('nilai')
                ->row_array();
        return $data;
    }

    function GetAllNilai() {
        $data = $this->db
                ->where('is_delete', 0)
                ->get('nilai')
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
        $this->db->insert('nilai',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('nilai',$param);
    }

    function insertNilai($param) {
        $this->db->insert('nilai', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchNilaiValue($param) {
      $this->db->insert_batch('nilai_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_nilai',$id);
        $this->db->update('nilai',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_nilai',$id);
        $this->db->update('nilai',array('is_delete'=>1));
    }
    
}

/* End of file Nilai_model.php */
/* Location: ./application/models/Nilai_model.php */