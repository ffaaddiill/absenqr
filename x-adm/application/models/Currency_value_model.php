<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Currency Value Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Currency model
 * 
 */
class Currency_value_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    function GetAllCurrencyValueData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='value'){
                            $this->db->like('LCASE(`currency_value`.`value`)',strtolower($param['search_value']));
                        } elseif($val['data']=='is_active') {
                            $this->db->like('LCASE(`currency_value`.`is_active`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='value'){
                            $this->db->like('LCASE(`currency_value`.`value`)',strtolower($param['search_value']));
                        } elseif($val['data']=='is_active') {
                            $this->db->like('LCASE(`currency_value`.`is_active`)',strtolower($param['search_value']));
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
            $this->db->order_by('id_currency_value','desc');
        }
        $data = $this->db
                ->select('
                        currency.id_currency,
                        currency.iso_1,
                        currency.iso_2,
                        currency.update_date,
                        currency.create_date,
                        currency_value.id_currency_value,
                        currency_value.id_currency,
                        currency_value.value,
                        currency_value.is_active,
                        currency_value.valid_date
                        ')
                ->join('currency', 'currency.id_currency = currency_value.id_currency', 'left')
                ->get('currency_value')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllCurrencyValue($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='value'){
                            $this->db->like('LCASE(`currency_value`.`value`)',strtolower($param['search_value']));
                        } elseif($val['data']=='is_active') {
                            $this->db->like('LCASE(`currency_value`.`is_active`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='value'){
                            $this->db->like('LCASE(`currency_value`.`value`)',strtolower($param['search_value']));
                        } elseif($val['data']=='is_active') {
                            $this->db->like('LCASE(`currency_value`.`is_active`)',strtolower($param['search_value']));
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
                        ->from('currency_value')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetCurrencyValue($id) {
        $data = $this->db
                ->where('id_currency_value',$id)
                ->limit(1)
                ->get('currency_value')
                ->row_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('currency_value',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('currency_value',$param);
    }

    function insertCurrencyValue($param) {
        $this->db->insert('currency_value', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchCurrencyValue($param) {
      $this->db->insert_batch('currency_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_currency_value',$id);
        $this->db->update('currency_value',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_currency_value',$id);
        $this->db->delete('currency_value');
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
/* End of file Currency_value_model.php */
/* Location: ./application/models/Currency_value_model.php */