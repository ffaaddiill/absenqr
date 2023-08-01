<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gallery_hatcherylab Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Gallery_hatcherylab model
 * 
 */
class Gallery_hatcherylab_model extends CI_Model
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
    function GetAllGallery_hatcherylabData($param=array()) {
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
            $this->db->order_by('id','desc');
        }
        $data = $this->db
                ->select("*,id_gallery_hatcherylab as id")
                ->where('is_delete',0)
                ->get('gallery_hatcherylab')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllGallery_hatcherylab($param=array()) {
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
                ->from('gallery_hatcherylab')
                ->where('is_delete',0)
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get detail by id
     * @param int $id
     * @return array data
     */
    function GetGallery_hatcherylab($id) {
        $data = $this->db
                ->where('id_gallery_hatcherylab',$id)
                ->where('is_delete',0)
                ->limit(1)
                ->get('gallery_hatcherylab')
                ->row_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('gallery_hatcherylab',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_gallery_hatcherylab',$id);
        $this->db->update('gallery_hatcherylab',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_gallery_hatcherylab',$id);
        $this->db->delete('gallery_hatcherylab');
    }

    function delete_picture($id) {
        $this->db->where('id_gallery_hatcherylab', $id);
        $this->db->update('gallery_hatcherylab', array(
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
                ->get('gallery_hatcherylab')
                ->row_array();
        if ($max) {
            return $max['max_position'];
        } else {
            return '1';
        }
    }

    /**
     * insert sites with batch method
     * @param array $data
     */
    function InsertSitesBatch($data){
        $this->db->insert_batch('gallery_hatcherylab_sites',$data);
    }

    /**
     * Get Site by id
     * @param int $id
     * @return array data
     */
    function GetSitesById($id) {
        $data = $this->db
                ->where('id_gallery_hatcherylab',$id)
                ->get('gallery_hatcherylab_sites')
                ->result_array();
        return $data;
    }

    /**
     * delete site record
     * @param int $id
     */
    function DeleteSite($id){
        $this->db->where('id_gallery_hatcherylab',$id);
        $this->db->delete('gallery_hatcherylab_sites');
    }

    function getActiveProduct() {
        $data = $this->db
                ->where('is_delete', 0)
                ->where('id_status', 1)
                ->get('product')
                ->result_array();

        return $data;
    }

    function getGallery_hatcherylabProduct($id_gallery_hatcherylab) {
        $data = $this->db
                ->where('is_delete', 0)
                ->where('id_status', 1)
                ->where('id_gallery_hatcherylab', $id_gallery_hatcherylab)
                ->get('gallery_hatcherylab')
                ->row_array();

        return $data;
    }
    
}
/* End of file Gallery_hatcherylab_model.php */
/* Location: ./application/models/Gallery_hatcherylab_model.php */