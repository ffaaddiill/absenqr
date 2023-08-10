<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Banner Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Banner model
 * 
 */
class Qrs_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    function getMuridByNis($nis) {
        $data = $this->db
                ->select('murid.nama_murid, kelas.nama_kelas')
                ->where('murid.nis', $nis)
                ->limit(1)
                ->join('kelas', 'murid.kelas = kelas.id_kelas', 'left')
                ->get('murid')
                ->row_array();

        return $data;
    }

    function data_check($param) {
        $data_check = $this->db->select('absen_in')
                    ->where($param)
                    ->where('absen_date >', date("Y-m-d 00:00:00"))
                    ->where('absen_date <', date("Y-m-d 07:00:00"))
                    ->get('qrabsen')
                    ->row_array();
        
        echo '<pre>';
        print_r($data_check);
        die();

        //return $data_check;
    }

    function check_nis($nis = '') {
        return $this->db
                ->where('murid.nis', $nis)
                ->limit(1)
                ->from('murid')
                ->count_all_results();
    }

    function save_in($param) {
        $status = '';
        $data_exist = $this->db
                    ->where($param)
                    ->where('absen_date', date("Y-m-d"))
                    ->limit(1)
                    ->from('qrabsen')
                    ->count_all_results();

        if($data_exist == 0) {
            $data = array(
                'nis'=>$param['nis'],
                'absen_in'=>strtotime(date("Y-m-d H:i:s")),
                'absen_date'=>date("Y-m-d")
            );
            $status = $this->db->insert('qrabsen', $data);
        }

        return $status;
    }

    function save_out($param) {
        $status = '';
        $data_exist = $this->db
                    ->where($param)
                    ->where('absen_date', date("Y-m-d"))
                    ->limit(1)
                    ->from('qrabsen')
                    ->count_all_results();
        if($data_exist > 0) {
            $get_absen_out = $this->db
                    ->select('absen_out')
                    ->where('nis', $param['nis'])
                    ->where('absen_date', date("Y-m-d"))
                    ->limit(1)
                    ->get('qrabsen')
                    ->row_array();

            //echo $this->db->last_query();

            if(empty($get_absen_out['absen_out']) || $get_absen_out['absen_out'] == 'NULL' || $get_absen_out['absen_out'] == '') {
                $status = $this->db
                        ->where('nis', $param['nis'])
                        ->where('absen_date', date("Y-m-d"))
                        ->update('qrabsen', ['absen_out'=>strtotime(date("Y-m-d H:i:s"))]);
            }  
        } else {
            $data = array(
                'nis'=>$param['nis'],
                'absen_out'=>strtotime(date("Y-m-d H:i:s")),
                'absen_date'=>date("Y-m-d")
                );
            $status = $this->db->insert('qrabsen', $data);
        }

        return $status;
    }
}