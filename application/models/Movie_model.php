<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Movie Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Movie model
 * 
 */
class Movie_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get featured movie
     * @return array data
     */
    function GetFeaturedMovieData() {
        $data = $this->db
                ->where('is_delete',0)
                ->where('id_status',1)
                ->where('is_featured',1)
                ->order_by('id_movie','desc')
                ->get('movie')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get movie data
     * @return array data
     */
    function GetMoviesData($limit, $offset) {
        $data = $this->db
                ->where('is_delete',0)
                ->where('id_status',1)
                ->order_by('id_movie','desc')
                ->limit($limit, $offset)
                ->get('movie')
                ->result_array();
        
        return $data;
    }

    /**
     * count movie data
     * added by fadilah ajiq surya
     * @return amount data
     */
    function CountMovieData() {
        $data = $this->db
                ->where('is_delete', 0)
                ->where('id_status', 1)
                ->from('movie')
                ->count_all_results();

        return $data;
    }
    
    /**
     * get movie by id
     * @param int $id_movie
     * @return array data
     */
    function GetMovieByIdData($id_movie) {
        $data = $this->db
                ->where('id_movie',$id_movie)
                ->where('is_delete',0)
                ->where('id_status',1)
                ->limit(1)
                ->get('movie')
                ->row_array();
        
        return $data;
    }
    
    /**
     * get movie schedule by id movie
     * @param int $id_movie
     * @return array data
     */
    function GetShowtimeByMovieIdData($id_movie) {
        //$date_now = date('Y-m-d H:i:s');
        $date_now = date('Y-m-d H:i:s');
        $date = date_create($date_now);
        date_add($date, date_interval_create_from_date_string('+16 minutes'));
        $data_plus_15_m = date_format($date, 'Y-m-d H:i:s');
        $data = $this->db
                ->select('movie_schedule.*,movie.title as movie_title, movie.price as price_default')
                ->join('movie','movie.id_movie=movie_schedule.id_movie','left')
                ->where('movie_schedule.id_movie',$id_movie)
                ->where('start_time >=',$data_plus_15_m)
                ->order_by('start_time','asc')
                ->get('movie_schedule')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get only movie schedule by id movie
     * @param int $id_movie
     * @return array data
     */
    function GetOnlyShowtimeByMovieIdData($id_movie) {
        $date_now = date('Y-m-d H:i:s');
        $data = $this->db
                ->select('movie_schedule.*,movie.price as price_default')
                ->join('movie','movie.id_movie=movie_schedule.id_movie','left')
                ->where('movie_schedule.id_movie',$id_movie)
                ->where('start_time >=',$date_now)
                ->order_by('start_time','asc')
                ->get('movie_schedule')
                ->result_array();
        
        return $data;
    }

    /**
     * get showtime data by id
     * @param int $id_showtime
     * @return array data
     */
    function GetShowtimeData($id_showtime) {
        $data = $this->db
                ->select('movie_schedule.*,movie.title as movie_title, movie.price as price_default')
                ->join('movie','movie.id_movie=movie_schedule.id_movie','left')
                ->where('movie_schedule.id_movie_schedule',$id_showtime)
                ->limit(1)
                ->get('movie_schedule')
                ->row_array();
        
        return $data;
    }
    
    /**
     * insert data transaction
     * @param array $data
     * @return int last inserted id
     */
    function InsertTransaction($data) {
        $this->db->insert('movie_transaction',$data);
        return $this->db->insert_id();
    }
    
    /**
     * get movie transaction by transid
     * @param string $transid
     * @return array data
     */
    function GetMovieTransactionByTransIDData($transid) {
        $data = $this->db
                ->where('is_delete',0)
                ->where('transid',$transid)
                ->limit(1)
                ->get('movie_transaction')
                ->row_array();
        
        return $data;
    }

    /**
     * get movie transaction by transid join with niaga table
     * @param string $transid
     * @return array data
     */
    function GetMovieTransactionByTransIDDataJoinNiaga($transid) {
        $data = $this->db
                ->where('movie_transaction.is_delete',0)
                ->where('movie_transaction.transid',$transid)
                ->limit(1)
                ->join('niaga', 'movie_transaction.transid = niaga.refno', 'left')
                ->get('movie_transaction')
                ->row_array();
        
        return $data;
    }
    /**
     * get movie transaction by transid join with danamon table
     * @param string $transid
     * @return array data
     */
    function GetMovieTransactionByTransIDDataJoinDanamon($transid) {
        $data = $this->db
                ->where('movie_transaction.is_delete',0)
                ->where('movie_transaction.transid',$transid)
                ->limit(1)
                ->join('danamon', 'movie_transaction.transid = danamon.refno', 'left')
                ->get('movie_transaction')
                ->row_array();
        
        return $data;
    }
    
    /**
     * update movie transaction
     * @param int $id_transaction
     * @param array $data
     */
    function UpdateMovieTransaction($id_transaction,$data) {
        $this->db->where('id_movie_transaction',$id_transaction);
        $this->db->update('movie_transaction',$data);
    }
    
    /**
     * get voucher data
     * @param string $voucher_code
     * @return array data
     */
    function GetVoucherData($voucher_code) {
        $now = date("Y-m-d");
        $data = $this->db
                ->where('LCASE(movie_voucher)',strtolower($voucher_code))
                ->where('voucher_status',0)
                ->where('is_delete',0)
                ->where('start_date <=',$now)
                ->where("(end_date >= '{$now}' OR end_date IS NULL || end_date = '0000-00-00')")
                ->limit(1)
                ->get('movie_voucher')
                ->row_array();
        
        return $data;
    }

    /**
     * insert MQ cron
     * @param array $record
     * @return last_id
     */
    function InsertMovieOrderMQ($record){
        $this->db->insert('movie_order_mq',$record);

        return $this->db->insert_id();
    }
    function InsertToMovieDisconnectMQ($record){
        $this->db->insert('movie_disconnect_mq',$record);
     }


    /**
     * get MQ order cron
     * @return record of movie then will be ordered to MQ
     */
    public function GetMovieOrder() {
        $data = $this->db
                     ->select('*')
                     ->where('start_time >=',date('Y-m-d H:i:s'))
                     ->get('movie_order_mq')
                     ->result_array();

        return $data;
    }

    public function GetMovieDisconnect() {

    }
    
}
/* End of file Movie_model.php */
/* Location: ./application/models/Movie_model.php */