<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BankImage Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc BankImage model
 * 
 */
class BankImage_model extends CI_Model
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
    function GetAllBankImageData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
					if ($i==0) {
						if($val['data']=='title'){
                        		$this->db->like('LCASE(`bank_image`.`title`)',strtolower($param['search_value']));
                        	} elseif($val['data']=='path') {
                            	$this->db->like('LCASE(`bank_image`.`path`)',strtolower($param['search_value']));
                        	} else{
                            
                        }
                    } else {
                        if($val['data']=='title'){
                            $this->db->like('LCASE(`bank_image`.`title`)',strtolower($param['search_value']));
                        } elseif($val['data']=='path') {
                            $this->db->like('LCASE(`bank_image`.`path`)',strtolower($param['search_value']));
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
            $this->db->order_by('id_bank_image','desc');
        }
        $data = $this->db
                ->select('*')
                ->get('bank_image')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllBankImage($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='title'){
                            $this->db->like('LCASE(`bank_image`.`title`)',strtolower($param['search_value']));
                        } elseif($val['data']=='path') {
                            $this->db->like('LCASE(`bank_image`.`path`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='title'){
                            $this->db->like('LCASE(`bank_image`.`title`)',strtolower($param['search_value']));
                        } elseif($val['data']=='path') {
                            $this->db->like('LCASE(`bank_image`.`path`)',strtolower($param['search_value']));
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
                        ->from('bank_image')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetBankImage($id) {
        $data = $this->db
                ->where('id_bank_image',$id)
                //->where('is_delete', 0)
                ->limit(1)
                ->get('bank_image')
                ->row_array();
        return $data;
    }

    function GetAllBankImage() {
        $data = $this->db
                ->where('is_delete', 0)
                ->get('bank_image')
                ->result_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('bank_image',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('bank_image',$param);
    }

    function insertBankImage($param) {
        $this->db->insert('bank_image', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchBankImageValue($param) {
      $this->db->insert_batch('bank_image_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_bank_image',$id);
        $this->db->update('bank_image',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_bank_image',$id);
        $this->db->delete('bank_image');
    }
    
}

/* End of file BankImage_model.php */
/* Location: ./application/models/BankImage_model.php */