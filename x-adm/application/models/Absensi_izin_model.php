<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Absensi_izin Model Class
 * @author Fadilah Ajiq Surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Absensi_izin model
 * 
 */
class Absensi_izin_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all data
     * @param string $param
     * @return array data
     */
    function GetAllAbsensi_izinData($param=array()) {
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
            $this->db->order_by('id_absensi_izin','desc');
        }
        $this->db->join('murid', 'absensi_izin.nis = murid.nis', 'left');
        $this->db->join('kelas', 'murid.kelas = kelas.id_kelas', 'left');
        //$this->db->join('qrabsen', 'qrabsen.nis=absensi_izin.nis', 'LEFT');
        $data = $this->db
                ->select("*,id_absensi_izin as id")
                ->get('absensi_izin')
                ->result_array();

        // echo '<pre>';
        // print_r($this->db->last_query());
        // die();
        
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllAbsensi_izin($param=array()) {
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
                ->from('absensi_izin')
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get detail by id
     * @param int $id
     * @return array data
     */
    function GetAbsensi_izin($id) {
        $data = $this->db
                ->where('id_absensi_izin',$id)
                //->where('is_delete', 0)
                ->limit(1)
                ->get('absensi_izin')
                ->row_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('absensi_izin',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_absensi_izin',$id);
        $this->db->update('absensi_izin',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_absensi_izin',$id);
        $this->db->delete('absensi_izin');
    }

    function delete_picture($id) {
        $this->db->where('id_absensi_izin', $id);
        $this->db->update('absensi_izin', array(
            'primary_image'=>'',
            'picture_file_name'=>''
        ));
    }
    
    /**
     * get maximum position
     * @return string max position
     */
    function GetMaxPosition() {
        $max = $this->db
                ->select('max(position)+1 as max_position')
                ->get('absensi_izin')
                ->row_array();
        if ($max) {
            return $max['max_position'];
        } else {
            return '1';
        }
    }

    /**
     * insert absensi_izin with batch method
     * @param array $data
     */
    function InsertAbsensi_izinBatch($data){
        $return = $data;

        foreach($data as $key=>$val) {
            $check_kelas = $this->db->select('kelas.id_kelas, kelas.slug')->where('kelas.slug', $val['kelas'])->limit(1)->get('kelas')->row_array();

            $check_tahun_ajaran = $this->db->select('tahun_ajaran.id_tahun_ajaran, tahun_ajaran.tahun')->where('tahun_ajaran.tahun', $val['tahun_ajaran'])->limit(1)->get('tahun_ajaran')->row_array();

            $check_jenis_kelamin = $this->db->select('jenis_kelamin.id_jenis_kelamin, jenis_kelamin.huruf_jk')->where('jenis_kelamin.huruf_jk', $val['jenis_kelamin'])->limit(1)->get('jenis_kelamin')->row_array();

            if(!$check_kelas) {
                $return[$key]['status'] = $data[$key]['status'] = 0;
                $return[$key]['kelas'] = $val['kelas'] . ' (kelas tidak ditemukan)';
            } else {
                $return[$key]['kelas'] = $val['kelas'];
                $data[$key]['kelas'] = $check_kelas['id_kelas'];
            }

            if(!$check_tahun_ajaran) {
                $return[$key]['status'] = $data[$key]['status'] = 0;
                $return[$key]['tahun_ajaran'] = $val['tahun_ajaran'] . ' (tahun_ajaran tidak ditemukan)';
            } else {
                $return[$key]['tahun_ajaran'] = $val['tahun_ajaran'];
                $data[$key]['tahun_ajaran'] = $check_tahun_ajaran['id_tahun_ajaran'];
            }

            if(!$check_jenis_kelamin) {
                $return[$key]['status'] = $data[$key]['status'] = 0;
                $return[$key]['jenis_kelamin'] = $val['jenis_kelamin'] . ' (jenis_kelamin tidak ditemukan)';
            } else {
                $return[$key]['jenis_kelamin'] = $val['jenis_kelamin'];
                $data[$key]['jenis_kelamin'] = $check_jenis_kelamin['id_jenis_kelamin'];
            }
        }

        foreach($data as $key=>$val) {
            if(isset($val['status']) && $val['status'] == 0) {
                unset($data[$key]);
            }
        }
        $data = array_values($data);

        if(!empty($data)) {
            $this->db->insert_batch('absensi_izin',$data);
        }
        
        foreach($return as $key=>$val) {
            if(!isset($val['status'])) {
                unset($return[$key]);
            }
        }
        $return = array_values($return);

        //debugvar($data);
        // echo '<br>';
        // debugvar($return);
        //die();

        return $return;
    }

    /**
     * Get Absensi_izin by id
     * @param int $id
     * @return array data
     */
    function GetAbsensi_izinById($id) {
        $data = $this->db
                ->where('id_absensi_izin',$id)
                ->get('absensi_izin')
                ->result_array();
        return $data;
    }

    /**
     * delete site record
     * @param int $id
     */
    function DeleteAbsensi_izin($id){
        $this->db->where('id_absensi_izin',$id);
        $this->db->delete('absensi_izin');
    }

    function getActiveProduct() {
        $data = $this->db
                //->where('is_delete', 0)
                ->where('id_status', 1)
                ->get('product')
                ->result_array();

        return $data;
    }

    function getAbsensi_izinProduct($id_absensi_izin) {
        $data = $this->db
                //->where('is_delete', 0)
                ->where('id_status', 1)
                ->where('id_absensi_izin', $id_absensi_izin)
                ->get('absensi_izin')
                ->row_array();

        return $data;
    }
    
}
/* End of file Absensi_izin_model.php */
/* Location: ./application/models/Absensi_izin_model.php */