<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sub_tax Model Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Sub_tax model
 * 
 */
class Sub_tax_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get category tax data
     * @return array data
     */
    function GetCategorySub_tax() {
        
        $data = $this->db
                ->order_by('id_tax','asc')
                ->get('tax')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get all admin data
     * @param string $param
     * @return array data
     */
    function GetAllSub_taxData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='main_tax'){
                            $this->db->like('LCASE(`tax`.`name`)',strtolower($param['search_value']));
                        }else{
                            $this->db->like('LCASE(`sub_tax`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                        
                    } else {
                        if($val['data']=='main_tax'){
                            $this->db->or_like('LCASE(`tax.name`)',strtolower($param['search_value']));
                        }else{
                            $this->db->or_like('LCASE(`sub_tax`.`'.$val['data'].'`)',strtolower($param['search_value']));
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
            $this->db->order_by('id','desc');
        }
        $data = $this->db
                ->select('sub_tax.*,tax.name as main_tax,sub_tax.id_sub_tax as id')
                ->join('tax','tax.id_tax=sub_tax.id_tax','left')
                ->where('sub_tax.is_delete',0)
                ->get('sub_tax')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllSub_tax($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='main_tax'){
                            $this->db->like('LCASE(`tax`.`name`)',strtolower($param['search_value']));
                        }else{
                            $this->db->like('LCASE(`sub_tax`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                        
                    } else {
                        if($val['data']=='main_tax'){
                            $this->db->or_like('LCASE(`tax.name`)',strtolower($param['search_value']));
                        }else{
                            $this->db->or_like('LCASE(`sub_tax`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                ->join('tax','tax.id_tax=sub_tax.id_tax','left')
                ->where('sub_tax.is_delete',0)
                ->from('sub_tax')
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetSub_tax($id) {
        $data = $this->db
                ->where('id_sub_tax',$id)
                ->limit(1)
                ->get('sub_tax')
                ->row_array();
        
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('sub_tax',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_sub_tax',$id);
        $this->db->update('sub_tax',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_sub_tax',$id);
        $this->db->update('sub_tax',array('is_delete'=>1));
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
/* End of file Sub_tax_model.php */
/* Location: ./application/models/Sub_tax_model.php */