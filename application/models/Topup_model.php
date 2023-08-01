<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Topup Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Topup model
 * 
 */
class Topup_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    public function getVoucherList() {
    	$data = $this->db
    			->get('voucher_topup')
    			->result_array();

    	return $data;
    }

    /**
     * insert data transaction
     * @param array $data
     * @return int last inserted id
     */
    function InsertTransaction($data) {
        $this->db->insert('voucher_topup_transaction',$data);
        return $this->db->insert_id();
    }

    /**
     * get movie transaction by transid
     * @param string $transid
     * @return array data
     */
    function GetTopupTransactionByTransIDData($transid) {
        $data = $this->db
                ->where('is_delete',0)
                ->where('transid',$transid)
                ->limit(1)
                ->get('voucher_topup_transaction')
                ->row_array();
        
        return $data;
    }
    
    /**
     * update movie transaction
     * @param int $id_transaction
     * @param array $data
     */
    function UpdateTopupTransaction($id_transaction,$data) {
        $this->db->where('id_voucher_topup_transaction',$id_transaction);
        $this->db->update('voucher_topup_transaction',$data);
    }
}
/* End of file Slideshow_model.php */
/* Location: ./application/models/Slideshow_model.php */