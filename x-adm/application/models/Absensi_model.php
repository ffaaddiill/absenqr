<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Absensi Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Absensi model
 * 
 */
class Absensi_model extends CI_Model
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
    function GetAllAbsensiData($param=array()) {
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
            $this->db->order_by('id_qrabsen','desc');
        }

        $this->db->join('murid', 'murid.nis=qrabsen.nis', 'LEFT');
        $this->db->join('kelas', 'kelas.id_kelas=murid.kelas', 'LEFT');
        
        $data = $this->db
                ->select("*,id_qrabsen as id")
                //->where('is_delete', 0)
                ->get('qrabsen')
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
    function CountAllAbsensi($param=array()) {
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
                ->from('qrabsen')
                //->where('is_delete', 0)
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get detail by id
     * @param int $id
     * @return array data
     */
    function GetAbsensi($id) {
        $data = $this->db
                ->where('id_qrabsen',$id)
                //->where('is_delete', 0)
                ->limit(1)
                ->get('qrabsen')
                ->row_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('qrabsen',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_qrabsen',$id);
        $this->db->update('qrabsen',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_qrabsen',$id);
        $this->db->delete('qrabsen');
    }

    function delete_picture($id) {
        $this->db->where('id_qrabsen', $id);
        $this->db->update('qrabsen', array(
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
                ->get('qrabsen')
                ->row_array();
        if ($max) {
            return $max['max_position'];
        } else {
            return '1';
        }
    }

    /**
     * insert murid with batch method
     * @param array $data
     */
    function InsertAbsensiBatch($data){
        $this->db->insert_batch('qrabsen',$data);
    }

    /**
     * Get Absensi by id
     * @param int $id
     * @return array data
     */
    function GetAbsensiById($id) {
        $data = $this->db
                ->where('id_qrabsen',$id)
                ->get('qrabsen')
                ->result_array();
        return $data;
    }

    /**
     * delete site record
     * @param int $id
     */
    function DeleteAbsensi($id){
        $this->db->where('id_qrabsen',$id);
        $this->db->delete('qrabsen');
    }

    function getActiveProduct() {
        $data = $this->db
                //->where('is_delete', 0)
                ->where('id_status', 1)
                ->get('product')
                ->result_array();

        return $data;
    }

    function getAbsensiProduct($id_qrabsen) {
        $data = $this->db
                //->where('is_delete', 0)
                ->where('id_status', 1)
                ->where('id_qrabsen', $id_qrabsen)
                ->get('qrabsen')
                ->row_array();

        return $data;
    }
    
}
/* End of file Absensi_model.php */
/* Location: ./application/models/Absensi_model.php */