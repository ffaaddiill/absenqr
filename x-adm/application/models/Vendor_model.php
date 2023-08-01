<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Vendor Model Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Vendor model
 * 
 */
class Vendor_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get category vendor data
     * @return array data
     */
    function GetCategoryVendor() {
        
        $data = $this->db
                ->order_by('id_vendor_category','asc')
                ->get('vendor_category')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get all admin data
     * @param string $param
     * @return array data
     */
    function GetAllVendorData($param=array()) {
        
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
                ->select('vendor.*,vendor_category.id_vendor_category,vendor_category.category_name,id_vendor as id')
                ->join('vendor_category','vendor.id_category_vendor=vendor_category.id_vendor_category','left')
                ->get('vendor')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllVendor($param=array()) {
       
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
                ->from('vendor')
                ->join('vendor_category','vendor.id_category_vendor=vendor_category.id_vendor_category','left')
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetVendor($id) {
        $data = $this->db
                ->where('id_vendor',$id)
                ->limit(1)
                ->get('vendor')
                ->row_array();
        
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('vendor',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_vendor',$id);
        $this->db->update('vendor',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_vendor',$id);
        $this->db->delete('vendor');
    }
    
    /**
     * check exist email
     * @param string $email
     * @param int $id
     * @return boolean true/false 
     */
    function checkName($email,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_vendor !=',$id);
        }
        $count_records = $this->db
                ->from('vendor')
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
            $this->db->where('id_vendor !=',$id);
        }
        $count_records = $this->db
                ->from('vendor')
                ->where('username',$username)
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
/* End of file Vendor_model.php */
/* Location: ./application/models/Vendor_model.php */