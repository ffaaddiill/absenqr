<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Report Model Class
 * @author ivan lubis
 * @version 2.1
 * @category Model
 * @desc report model
 * 
 */
class Report_model extends CI_Model
{
    
    /**
     * Constructor 
     * @desc to load extends
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get customer registration data with payment
     * @return array data
     */
    function GetCustomerRegistrationPayment($the_date='') {
        if(!$the_date){
            $the_date = date('Y-m-d',strtotime("-1 days"));
        }else{
            $the_date = date('Y-m-d',strtotime($the_date));
        }
        
        $data = $this->db->query(
                "
                (
                    select 
                        a.first_name,a.email,a.no_phone,a.no_hp,a.address,a.gender,a.created_date as reg_date, a.payment_method, a.kode_pemasangan,
                        b.transidmerchant as transid,b.payment_date_time as pay_date, b.totalamount as total_amount,b.trxstatus as transaction_status
                    from customer_web a
                    join doku b on b.kode_pemesanan=a.kode_pemasangan
                    where (a.created_date between '{$the_date} 00:00:00' and '{$the_date} 23:59:57') and (b.trxstatus is not null) and a.kode_pemasangan != ''
                )
                UNION
                (
                    select 
                        a.first_name,a.email,a.no_phone,a.no_hp,a.address,a.gender,a.created_date as reg_date, a.payment_method, a.kode_pemasangan,
                        b.refno as transid,b.transdate as pay_date, b.amount as total_amount,b.status as transaction_status
                    from customer_web a
                    join niaga b on b.kode_pemesanan=a.kode_pemasangan
                    where (a.created_date between '{$the_date} 00:00:00' and '{$the_date} 23:59:57') and (b.status IS NOT NULL) and a.kode_pemasangan != ''
                )
                order by reg_date desc
                "
            )->result_array();
        return $data;
    }
    
    /**
     * count customer web with conditional query
     * @param array $condition
     * @return int total records
     */
    function CountConditionalCustomerRegistered($condition=array(),$date='') {
        if(!$date){
            $the_date = date('Y-m-d',strtotime("-1 days"));
        }else{
            $the_date = date('Y-m-d',strtotime($date));
        }
        
        if ($condition) {
            $this->db->where($condition);
        }
        $count = $this->db
                ->from('customer_web')
                ->where("(created_date between '{$the_date} 00:00:00' and '$the_date 23:59:57')")
                ->count_all_results();
        return $count;        
    }
    
    /**
     * get customer by date
     * @param string $date
     * @return array data
     */
    function GetCustomerByDateData($date) {
        $data = $this->db
                ->select('first_name,email,no_phone,no_hp,kode_pemasangan,created_date,payment_date,step,payment_method,memberships.name as package_name')
                ->join('memberships','memberships.id=customer_web.package_id','left')
                ->where("created_date between '{$date} 00:00:00' and '{$date} 23:59:57'")
                ->order_by('created_date','desc')
                ->get('customer_web')
                ->result_array();
        return $data;
    }
    
    /**
     * get customer doku by date
     * @param string $date
     * @return array data
     */
    function GetCustomerDOKUByDateData($date) {
        $data = $this->db
                ->select('transidmerchant,totalamount,trxstatus,payment_date_time,kode_pemesanan')
                ->where("payment_date_time between '{$date} 00:00:00' and '{$date} 23:59:57'")
                ->get('doku')
                ->result_array();
        return $data;
    }
    
    /**
     * get customer niaga by date
     * @param string $date
     * @return string data
     */
    function GetCustomerNIAGAByDateData($date) {
        $data = $this->db
                ->select('transid,refno,amount,status,errdesc,transdate,kode_pemesanan')
                ->where("transdate between '{$date} 00:00:00' and '{$date} 23:59:57'")
                ->order_by('id','desc')
                ->get('niaga')
                ->result_array();
        return $data;
    }
    
    /**
     * get service request by date
     * @param string $date
     * @return array data
     */
    function GetServiceRequestByDate($date) {
        $data = $this->db
                ->where("created_at between '{$date} 00:00:00' and '{$date} 23:59:57'")
                ->order_by('id')
                ->get('services')
                ->result_array();
                
        return $data;
    }
    
    /**
     * get upgrade addon by date
     * @param string $date
     * @return array data
     */
    function GetUpgradeAddonByDate($date) {
        $data = $this->db
                ->where("created_at between '{$date} 00:00:00' and '{$date} 23:59:57'")
                ->order_by('id')
                ->get('upgrade_addon')
                ->result_array();
                
        return $data;
    }
    
}

/* End of file report_model.php */
/* Location: ./application/models/report_model.php */

