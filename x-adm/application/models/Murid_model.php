<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Murid Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Murid model
 * 
 */
class Murid_model extends CI_Model
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
    function GetAllMuridData($param=array()) {
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if(strtolower($val['data']) == 'nama_kelas') {
                            $this->db->like('LCASE(`kelas`.`nama_kelas`)',strtolower($param['search_value']));
                        } else if(strtolower($val['data']) == 'jenis_kelamin') {
                            $this->db->like('LCASE(`jenis_kelamin`.`jenis_kelamin`)',strtolower($param['search_value']));
                        } else if(strtolower($val['data']) == 'id_status') {
                            if(strtolower($param['search_value']) == 'active') {
                                $this->db->like('LCASE(`murid`.`id_status`)', '1');
                            } else {
                                $this->db->like('LCASE(`murid`.`id_status`)', '0');
                            }
                        } else {
                            $this->db->like('LCASE(`murid`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                    } else {
                        if(strtolower($val['data']) == 'nama_kelas') {
                            $this->db->or_like('LCASE(`kelas`.`nama_kelas`)',strtolower($param['search_value']));
                        } else if(strtolower($val['data']) == 'jenis_kelamin') {
                            $this->db->or_like('LCASE(`jenis_kelamin`.`jenis_kelamin`)',strtolower($param['search_value']));
                        } else if(strtolower($val['data']) == 'id_status') {
                            if(strtolower($param['search_value']) == 'active') {
                                $this->db->or_like('LCASE(`murid`.`id_status`)', '1');
                            } else {
                                $this->db->or_like('LCASE(`murid`.`id_status`)', '0');
                            }
                        } else {
                            $this->db->or_like('LCASE(`murid`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
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
            $this->db->order_by('id_murid','desc');
        }
        $this->db->join('kelas', 'murid.kelas = kelas.id_kelas', 'left');
        $this->db->join('jenis_kelamin', 'murid.jenis_kelamin = jenis_kelamin.id_jenis_kelamin','LEFT');
        //$this->db->join('qrabsen', 'qrabsen.nis=murid.nis', 'LEFT');
        if(isset($param['slug']) && !empty($param['slug'])) {
            $this->db->where('kelas.slug', $param['slug']);
        }
        $data = $this->db
                ->select("*,id_murid as id")
                //->where('is_delete', 0)
                ->get('murid')
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
    function CountAllMurid($param=array()) {
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if(strtolower($val['data']) == 'nama_kelas') {
                            $this->db->like('LCASE(`kelas`.`nama_kelas`)',strtolower($param['search_value']));
                        } else if(strtolower($val['data']) == 'jenis_kelamin') {
                            $this->db->like('LCASE(`jenis_kelamin`.`jenis_kelamin`)',strtolower($param['search_value']));
                        } else if(strtolower($val['data']) == 'id_status') {
                            if(strtolower($param['search_value']) == 'active') {
                                $this->db->like('LCASE(`murid`.`id_status`)', '1');
                            } else {
                                $this->db->like('LCASE(`murid`.`id_status`)', '0');
                            }
                        } else {
                            $this->db->like('LCASE(`murid`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                    } else {
                        if(strtolower($val['data']) == 'nama_kelas') {
                            $this->db->or_like('LCASE(`kelas`.`nama_kelas`)',strtolower($param['search_value']));
                        } else if(strtolower($val['data']) == 'jenis_kelamin') {
                            $this->db->or_like('LCASE(`jenis_kelamin`.`jenis_kelamin`)',strtolower($param['search_value']));
                        } else if(strtolower($val['data']) == 'id_status') {
                            if(strtolower($param['search_value']) == 'active') {
                                $this->db->or_like('LCASE(`murid`.`id_status`)', '1');
                            } else {
                                $this->db->or_like('LCASE(`murid`.`id_status`)', '0');
                            }
                        } else {
                            $this->db->or_like('LCASE(`murid`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        if(isset($param['slug']) && !empty($param['slug'])) {
            $this->db->where('kelas.slug', $param['slug']);
        }
        $total_records = $this->db
                ->from('murid')
                //->where('is_delete', 0)
                ->join('kelas', 'murid.kelas = kelas.id_kelas', 'left')
                ->join('jenis_kelamin', 'murid.jenis_kelamin = jenis_kelamin.id_jenis_kelamin', 'left')
                ->count_all_results();
        return $total_records;
    }

    /**
     * Get records for generate absen in excel format
     * @param string $param
     * @return int total records
     */
    function GetAllMuridForAbsen($param=array()) {
        if(isset($param['slug']) && !empty($param['slug'])) {
            $this->db->where('slug', $param['slug']);
        }
        /*$this->db->join('kelas', 'murid.kelas = kelas.id_kelas', 'left');
        $this->db->join('jenis_kelamin', 'murid.jenis_kelamin = jenis_kelamin.id_jenis_kelamin','LEFT');*/
        
        $data_kelas_arr = $this->db
                        ->select('kelas.id_kelas, kelas.nama_kelas, kelas.slug')
                        ->order_by('kelas.id_kelas', 'desc')
                        ->get('kelas')
                        ->result_array(); 

        foreach($data_kelas_arr as $dkey=>$valk) {
            $data_kelas_arr[$dkey]['murid'] = $this->db
                                    ->select("murid.nama_murid, murid.nis, murid.kelas, jenis_kelamin.jenis_kelamin, jenis_kelamin.huruf_jk as gender")
                                    ->where('murid.id_status', 1)
                                    ->where('murid.kelas', $valk['id_kelas'])
                                    ->order_by('murid.id_murid', 'desc')
                                    ->join('jenis_kelamin', 'murid.jenis_kelamin = jenis_kelamin.id_jenis_kelamin','LEFT')
                                    ->get('murid')
                                    ->result_array();

            foreach($data_kelas_arr[$dkey]['murid'] as $mkey=>$valm) {
                $data_kelas_arr[$dkey]['murid'][$mkey]['absen'] = $this->db
                                            ->select('nis, absen_in, absen_out, absen_date')
                                            ->where('nis', $valm['nis'])
                                            ->where( 'absen_date >=', date("Y-m-d", strtotime(reset($param['date_arr']))))
                                            ->where( 'absen_date <=', date("Y-m-d", strtotime(end($param['date_arr']))))
                                            ->get('qrabsen')
                                            ->result_array();
            }
        }

        // debugvar($data_kelas_arr);
       
        // echo $this->db->last_query();
        // die();
        return $data_kelas_arr;
    }
    
    /**
     * Get detail by id
     * @param int $id
     * @return array data
     */
    function GetMurid($id) {
        $data = $this->db
                ->where('id_murid',$id)
                //->where('is_delete', 0)
                ->limit(1)
                ->join('kelas', 'murid.kelas = kelas.id_kelas', 'left')
                ->join('jenis_kelamin', 'murid.jenis_kelamin = jenis_kelamin.id_jenis_kelamin','LEFT')
                ->join('tahun_ajaran', 'murid.tahun_ajaran = tahun_ajaran.id_tahun_ajaran', 'left')
                ->get('murid')
                ->row_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('murid',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_murid',$id);
        $this->db->update('murid',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_murid',$id);
        $this->db->delete('murid');
    }

    function delete_picture($id) {
        $this->db->where('id_murid', $id);
        $this->db->update('murid', array(
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
                ->get('murid')
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
    function InsertMuridBatch($data){
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
            $this->db->insert_batch('murid',$data);
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
     * Get Murid by id
     * @param int $id
     * @return array data
     */
    function GetMuridById($id) {
        $data = $this->db
                ->where('id_murid',$id)
                ->get('murid')
                ->result_array();
        return $data;
    }

    /**
     * delete site record
     * @param int $id
     */
    function DeleteMurid($id){
        $this->db->where('id_murid',$id);
        $this->db->delete('murid');
    }

    function getActiveProduct() {
        $data = $this->db
                //->where('is_delete', 0)
                ->where('id_status', 1)
                ->get('product')
                ->result_array();

        return $data;
    }

    function getMuridProduct($id_murid) {
        $data = $this->db
                //->where('is_delete', 0)
                ->where('id_status', 1)
                ->where('id_murid', $id_murid)
                ->get('murid')
                ->row_array();

        return $data;
    }
    
}
/* End of file Murid_model.php */
/* Location: ./application/models/Murid_model.php */