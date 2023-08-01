<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Tahun_ajaran Model Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Tahun_ajaran model
 * 
 */
class Tahun_ajaran_model extends CI_Model
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
    function GetAllTahun_ajaranData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='iso_1'){
                            $this->db->like('LCASE(`tahun_ajaran`.`iso_1`)',strtolower($param['search_value']));
                        } elseif($val['data']=='iso_2') {
                            $this->db->like('LCASE(`tahun_ajaran`.`iso_2`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='iso_1'){
                            $this->db->like('LCASE(`tahun_ajaran`.`iso_1`)',strtolower($param['search_value']));
                        } elseif($val['data']=='iso_2') {
                            $this->db->like('LCASE(`tahun_ajaran`.`iso_2`)',strtolower($param['search_value']));
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
            $this->db->order_by('id_tahun_ajaran','desc');
        }
        $data = $this->db
                ->select('*')
                ->get('tahun_ajaran')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllTahun_ajaran($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='iso_1'){
                            $this->db->like('LCASE(`tahun_ajaran`.`iso_1`)',strtolower($param['search_value']));
                        } elseif($val['data']=='iso_2') {
                            $this->db->like('LCASE(`tahun_ajaran`.`iso_2`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='iso_1'){
                            $this->db->like('LCASE(`tahun_ajaran`.`iso_1`)',strtolower($param['search_value']));
                        } elseif($val['data']=='iso_2') {
                            $this->db->like('LCASE(`tahun_ajaran`.`iso_2`)',strtolower($param['search_value']));
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
                        ->from('tahun_ajaran')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetTahun_ajaran($id) {
        $data = $this->db
                ->where('id_tahun_ajaran',$id)
                //->where('is_delete', 0)
                ->limit(1)
                ->get('tahun_ajaran')
                ->row_array();
        return $data;
    }

    function GetAllTahun_ajaran() {
        $data = $this->db
                //->where('is_delete', 0)
                ->get('tahun_ajaran')
                ->result_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('tahun_ajaran',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('tahun_ajaran',$param);
    }

    function insertTahun_ajaran($param) {
        $this->db->insert('tahun_ajaran', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchTahun_ajaranValue($param) {
      $this->db->insert_batch('tahun_ajaran_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_tahun_ajaran',$id);
        $this->db->update('tahun_ajaran',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_tahun_ajaran',$id);
        $this->db->update('tahun_ajaran',array('is_delete'=>1));
    }
    
    /**
     * check exist email
     * @param string $email
     * @param int $id
     * @return boolean true/false 
     */
    function checkName($email,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_sub_tax !=',$id);
        }
        $count_records = $this->db
                ->from('tax')
                ->where('LCASE(name)',strtolower($email))
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * check exist username
     * @param string $username
     * @param int $id
     * @return boolean true/false 
     */
    function checkExistsUsername($username,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_sub_tax !=',$id);
        }
        $count_records = $this->db
                ->from('tax')
                ->where('username',$username)
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
/* End of file Tahun_ajaran_model.php */
/* Location: ./application/models/Tahun_ajaran_model.php */