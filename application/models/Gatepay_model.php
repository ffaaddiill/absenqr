<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gatepay Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Gatepay model
 * 
 */
class Gatepay_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get doku transaction by id
     * @param string $table
     * @param string $order_id
     * @return array data
     */
    function GetDOKUTransactionByIdData($table,$order_id) {
        $data = $this->db
                ->where('transidmerchant',$order_id)
                ->limit(1)
                ->get($table)
                ->row_array();
        
        return $data;
    }
    
    /**
     * get doku requested transaction
     * @param type $table
     * @param type $order_id
     * @return type
     */
    function GetDOKURequestedTransactionByIdData($table,$order_id) {
        $data = $this->db
                ->where('transidmerchant',$order_id)
                ->where('trxstatus','Requested')
                ->limit(1)
                ->get($table)
                ->row_array();
        
        return $data;
    }
    
    /**
     * update doku transaction
     * @param string $table
     * @param string $order_id
     * @param array $data
     */
    function UpdateDOKUTransaction($table,$order_id,$data) {
        $this->db->where('transidmerchant',$order_id);
        $this->db->update($table,$data);
    }
    
    /**
     * update niaga transaction
     * @param string $table
     * @param string $order_id
     * @param array $data
     */
    function UpdateNIAGATransaction($table,$order_id,$data) {
        $this->db->where('refno',$order_id);
        $this->db->update($table,$data);
    }

    /**
     * update danamon transaction
     * @param string $table
     * @param string $order_id
     * @param array $data
     */
    function UpdateDANAMONTransaction($table,$order_id,$data) {
        $this->db->where('refno',$order_id);
        $this->db->update($table,$data);
    }
    
    /**
     * get customer web by id
     * @param string $order_id
     * @return array data
     */
    function GetDOKUCustomerWebByIdData($order_id) {
        $data = $this->db
                ->select('customer_web.*,doku.transidmerchant,doku.trxstatus, doku.totalamount,doku.payment_date_time')
                ->join('doku', 'doku.kode_pemesanan=customer_web.kode_pemasangan','left')
                ->where('transidmerchant',$order_id)
                ->limit(1)
                ->get('customer_web')
                ->row_array();
        
        return $data;
    }
    
    /**
     * get customer web by id
     * @param string $order_id
     * @return array data
     */
    function GetNIAGACustomerWebByIdData($order_id) {
        $data = $this->db
                ->select('customer_web.*,niaga.refno,niaga.errdesc,niaga.amount,niaga.signature,niaga.remark,niaga.transdate,niaga.status')
                ->join('niaga', 'niaga.kode_pemesanan=customer_web.kode_pemasangan','left')
                ->where('refno',$order_id)
                ->limit(1)
                ->get('customer_web')
                ->row_array();
        
        return $data;
    }

    /**
     * get customer web by danamon id
     * @param string $order_id
     * @return array data
     */
    function GetDANAMONCustomerWebByIdData($order_id) {
        $data = $this->db
                ->select('customer_web.*,danamon.refno,danamon.errdesc,danamon.amount,danamon.signature,danamon.remark,danamon.transdate,danamon.status')
                ->join('danamon', 'danamon.kode_pemesanan=customer_web.kode_pemasangan','left')
                ->where('refno',$order_id)
                ->limit(1)
                ->get('customer_web')
                ->row_array();
        
        return $data;
    }
    
    /**
     * get niaga record by ref no
     * @param string $ref_id
     * @return array data
     */
    function GetNiagaWebByRefId($ref_id) {
        $data = $this->db
                ->where('refno',$ref_id)
                ->limit(1)
                ->get('niaga')
                ->row_array();
        
        return $data;
    }

    /**
     * get danamon record by ref no
     * @param string $ref_id
     * @return array data
     */
    function GetDanamonWebByRefId($ref_id) {
        $data = $this->db
                ->where('refno',$ref_id)
                ->limit(1)
                ->get('danamon')
                ->row_array();
        
        return $data;
    }
    
    /**
     * get niaga record by ref no
     * @param string $ref_id
     * @return array data
     */
    function GetNiagaPrepaidByRefId($ref_id) {
        $data = $this->db
                ->where('refno',$ref_id)
                ->limit(1)
                ->get('fat_niaga')
                ->row_array();
        
        return $data;
    }

    function GetDanamonPrepaidByRefId($ref_id) {
        $data = $this->db
                ->where('refno',$ref_id)
                ->limit(1)
                ->get('fat_danamon')
                ->row_array();
        
        return $data;
    }
    
    /**
     * get doku record by trans id
     * @param string $trans_id
     * @return array data
     */
    function GetDOKUWebByTransMerchId($trans_id) {
        $data = $this->db
                ->where('transidmerchant',$trans_id)
                ->limit(1)
                ->get('doku')
                ->row_array();
        
        return $data;
    }
    
    /**
     * get package name by id
     * @param string/array $package
     * @return string package name
     */
    function GetPackageNameByIdData($package) {
        $return = '';
        $package_id = explode(',', $package);
        if (is_array($package_id)) {
            $package_id=array_map('trim',$package_id);
            $this->db->where_in('id',$package_id);
        } else {
            $this->db->where('id',$package_id);
        }
        $data = $this->db
                ->select('name')
                ->get('memberships')
                ->result_array();
        if ($data) {
            $arr = array();
            foreach ($data as $row => $val) {
                $arr[] = $val['name'];
            }
            $return = implode(',', $arr);
        }
        return $return;
    }
    
    /**
     * get DOKU prepaid transaction
     * @param string $order_id
     * @return array data
     */
    function GetDOKUPrepaidTransactionByIdData($order_id) {
        $data = $this->db
                ->select('fat_transaction.*,fat_doku.transidmerchant,fat_doku.trxstatus, fat_doku.totalamount, fat_regional.regional')
                ->join('fat_doku', 'fat_doku.kode_pemesanan=fat_transaction.invoice','left')
                ->join('fat_regional', 'fat_regional.id_regional=fat_transaction.id_regional','left')
                ->where('transidmerchant',$order_id)
                ->where('is_delete',0)
                ->limit(1)
                ->get('fat_transaction')
                ->row_array();
        if ($data) {
            $data['item_detail'] = $this->db
                    ->select('fat_transaction_detail.*,fat_product.name')
                    ->where('id_transaction',$data['id_transaction'])
                    ->join('fat_product','fat_product.id_product=fat_transaction_detail.id_product','left')
                    ->get('fat_transaction_detail')
                    ->result_array();
        }
        return $data;
    }
    
    /**
     * get niaga prepaid transaction
     * @param string $order_id
     * @return array data
     */
    function GetNIAGAPrepaidTransactionByIdData($order_id) {
        $data = $this->db
                ->select('fat_transaction.*,fat_niaga.refno,fat_niaga.transid, fat_niaga.amount, fat_niaga.remark, fat_niaga.status, fat_niaga.signature, fat_regional.regional')
                ->join('fat_niaga', 'fat_niaga.transid=fat_transaction.transid','left')
                ->join('fat_regional', 'fat_regional.id_regional=fat_transaction.id_regional','left')
                ->where('fat_transaction.transid',$order_id)
                ->where('is_delete',0)
                ->limit(1)
                ->get('fat_transaction')
                ->row_array();
        if ($data) {
            $data['item_detail'] = $this->db
                    ->select('fat_transaction_detail.*,fat_product.name')
                    ->where('id_transaction',$data['id_transaction'])
                    ->join('fat_product','fat_product.id_product=fat_transaction_detail.id_product','left')
                    ->get('fat_transaction_detail')
                    ->result_array();
        }
        return $data;
    }

    /**
     * get danamon prepaid transaction
     * @param string $order_id
     * @return array data
     */
    function GetDANAMONPrepaidTransactionByIdData($order_id) {
        $data = $this->db
                ->select('fat_transaction.*,fat_danamon.refno,fat_danamon.transid, fat_danamon.amount, fat_danamon.remark, fat_danamon.status, fat_danamon.signature, fat_regional.regional')
                ->join('fat_danamon', 'fat_danamon.transid=fat_transaction.transid','left')
                ->join('fat_regional', 'fat_regional.id_regional=fat_transaction.id_regional','left')
                ->where('fat_transaction.transid',$order_id)
                ->where('is_delete',0)
                ->limit(1)
                ->get('fat_transaction')
                ->row_array();
        if ($data) {
            $data['item_detail'] = $this->db
                    ->select('fat_transaction_detail.*,fat_product.name')
                    ->where('id_transaction',$data['id_transaction'])
                    ->join('fat_product','fat_product.id_product=fat_transaction_detail.id_product','left')
                    ->get('fat_transaction_detail')
                    ->result_array();
        }
        return $data;
    }
    
    /**
     * update transaction prepaid
     * @param string $transid
     * @param array $data
     */
    function UpdateTransactionPrepaid($transid,$data) {
        $this->db->where('transid',$transid);
        $this->db->update('fat_transaction',$data);
    }
    
    /**
     * insert data to doku
     * @param type $data
     */
    function InsertDoku($data) {
        $this->db->insert('doku',$data);
    }
    
    /**
     * insert data to niaga
     * @param array $data
     */
    function InsertNiaga($data) {
        $this->db->insert('niaga',$data);
    }

    /**
     * insert data to danamon
     * @param array $data
     */
    function InsertDanamon($data) {
        $this->db->insert('danamon',$data);
    }
    
    /**
     * count customer web
     * @return int total customer
     */
    function CountCustomerWeb() {
        $count = $this->db
                ->from('customer_web')
                ->where("date_format({$this->db->dbprefix('created_date')},  '%m%y') = date_format( NOW( ) ,  '%m%y')")
                ->count_all_results();
        return $count;
    }
    
    /**
     * get max refno from niaga table
     * @return string refno
     */
    function GetMaxRefNiaga() {
        $data = $this->db
                ->select('max(refno) as refno')
                ->get('niaga')
                ->row_array();
        if (isset($data['refno'])) {
            return $data['refno'];
        } else {
            return '';
        }
    }

    /**
     * get max refno from danamon table
     * @return string refno
     */
    function GetMaxRefDanamon() {
        $data = $this->db
                ->select('max(refno) as refno')
                ->get('danamon')
                ->row_array();
        if (isset($data['refno'])) {
            return $data['refno'];
        } else {
            return '';
        }
    }
    
    /**
     * get movie transaction doku
     * @param string $order_id
     * @return array data
     */
    function GetDOKUMovieTransactionByIdData($order_id) {
        $data = $this->db
                ->select('movie_transaction.*,doku.transidmerchant, doku.trxstatus, doku.totalamount')
                ->join('doku', 'doku.transidmerchant=movie_transaction.transid','left')
                ->where('transid',$order_id)
                ->limit(1)
                ->get('movie_transaction')
                ->row_array();
        
        return $data;
    }
    
    /**
     * insert payment data to log
     * @param array $data
     */
    function InsertPaymentLog($data) {
        $this->db->insert('payment_log',$data);
    }
}
/* End of file Gatepay_model.php */
/* Location: ./application/models/Gatepay_model.php */