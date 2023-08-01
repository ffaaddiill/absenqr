<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cron Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Cron model
 * 
 */
class Cron_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    function CustomerEmailFlag() {
        $query = "
            SELECT a.id, a.first_name, a.last_name, a.no_phone, a.no_hp, b.email,
                a.address, a.city, a.province, a.jenis_kelamin
            FROM {$this->db->dbprefix('profiles')} a, {$this->db->dbprefix('users')} b where a.user_id = b.id and a.id > 
                (
                    select last_id from {$this->db->dbprefix('flag_email')}
                )
        ";
        $data = $this->db->query($query)->result_array();
        return $data;
    }
    
    function CustomerWebFlagEmail() {
        $data = $this->db
                ->where('flag_email',0)
                ->where('payment_date','0000-00-00 00:00:00')
                ->get('customer_web')
                ->result_array();
        return $data;
    }
    
    function UpdateLastID($last_id) {
        $query = "
            UPDATE flag_email
            set last_id = '".$last_id."'
            where id=1;
        ";
        $this->db->query($query);
    }
    
    function UpdateFlag() {
        $records = $this->CustomerEmailFlag();
        $id = array();
        foreach ($records as $record) {
            $id[] = $record['id'];
        }
        if ($id) {
            $idx = implode(',', $id);
            $query = "
                UPDATE profiles
                SET flag_email = 1
                WHERE id in (
                    " . $idx . "
                )
            ";
            $this->db->query($query);
        }
    }
    
    function UpdateCustomerWebFlag() {
        $query = "
            update {$this->db->dbprefix('customer_web')} a join (
                select id from {$this->db->dbprefix('customer_web')}
                where  flag_email = 0
                AND payment_date = '0000-00-00 00:00:00' 
            ) b
            on a.id=b.id
            set flag_email = 1
        ";
        $this->db->query($query);
    }
    
    /**
     * get customer registration data with payment
     * @return array data
     */
    function GetCustomerRegistrationPayment() {
        $the_date = date('Y-m-d',strtotime("-1 days"));
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
    function CountConditionalCustomerRegistered($condition=array()) {
        $the_date = date('Y-m-d',strtotime("-1 days"));
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
    

    function GetOrderMQ(){
        $date_now = date('Y-m-d H:i:00');
        $date = date_create($date_now);
        date_add($date, date_interval_create_from_date_string('+10 minutes'));
        $data_plus_15_m = date_format($date, 'Y-m-d H:i:00');
        //echo $data_plus_15_m;
        $data = $this->db
                #->select('movie_disconnect_mq.*')
                ->where('movie_disconnect_mq.status',0)
                ->where('movie_order_mq.start_time',$data_plus_15_m)
                ->join('movie_disconnect_mq','movie_disconnect_mq.transid=movie_order_mq.transid')
                ->get('movie_order_mq')
                ->result_array();
        
        return $data;
    }

    function GetDisconnectMQ(){
        $data = $this->db
                #->select('movie_disconnect_mq.*')
                ->where('movie_disconnect_mq.status',0)
                ->where('movie_disconnect_mq.disconnect_status !=',1)
                ->where('movie_order_mq.end_time <=',date('Y-m-d H:i:00'))
                ->join('movie_order_mq','movie_disconnect_mq.transid=movie_order_mq.transid')
                ->get('movie_disconnect_mq')
                ->result_array();
        //echo $this->db->last_query();
        return $data;
    }

    function GetListActiveOrderPPV(){
        $data = $this->db
                #->where('movie_disconnect_mq.status',0)
                ->where('movie_disconnect_mq.disconnect_status !=',1)
                ->where('movie_order_mq.start_time <=',date('Y-m-d 23:59:59'))
                ->where('movie_order_mq.start_time >=',date('Y-m-d 00:00:00'))
                ->join('movie_disconnect_mq','movie_disconnect_mq.transid=movie_order_mq.transid')
                ->get('movie_order_mq')
                ->result_array();

                return $data;
    }

    /**
    * Get Detail Order By Trans ID
    * @param string $transid
    * @retun object $data
    */

    function GetDetailOrderByTransId($transid){
        $data = $this->db
                ->select('movie_order_mq.start_time as start_time,movie_order_mq.end_time as end_time,movie_transaction.id_movie as id_movie,movie_schedule.channel_number as nagra_packed_id,movie_disconnect_mq.disconnect_status as status')
                ->where('movie_order_mq.transid',$transid)
                ->join('movie_disconnect_mq','movie_disconnect_mq.transid=movie_order_mq.transid')
                ->join('movie_transaction','movie_transaction.transid=movie_order_mq.transid')
                ->join('movie_schedule',' movie_schedule.id_movie_schedule=movie_transaction.id_movie_schedule')
                ->get('movie_order_mq')
                ->row();
        // echo $this->db->last_query();
        // echo '<br>';
        return $data;
    }
}
/* End of file Cron_model.php */
/* Location: ./application/models/Cron_model.php */