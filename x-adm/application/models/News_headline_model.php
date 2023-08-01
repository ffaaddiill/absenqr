<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * News Headline Model Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Model
 * @desc News Headline model
 * 
 */
class News_headline_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * get all admin data
     * @param string $param
     * @return array data
     */
    function GetAllNews_headlineData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
					if ($i==0) {
						if($val['data']=='title'){
                            $this->db->like('LCASE(`news_headline`.`title`)',strtolower($param['search_value']));
                        }
                    } else {
                        if($val['data']=='title'){
                            $this->db->like('LCASE(`news_headline`.`title`)',strtolower($param['search_value']));
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
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
            $this->db->order_by('id_news_headline','desc');
        }
        $data = $this->db
                ->select('*')
                ->get('news_headline')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllNews_headline($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='title'){
                            $this->db->like('LCASE(`news_headline`.`title`)',strtolower($param['search_value']));
                        }
                    } else {
                        if($val['data']=='title'){
                            $this->db->like('LCASE(`news_headline`.`title`)',strtolower($param['search_value']));
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                        ->select('*')
                        ->from('news_headline')
                        ->count_all_results();
        return $total_records;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetNews_headline($id) {
        $data = $this->db
                ->where('id_news_headline',$id)
                //->where('is_delete', 0)
                ->limit(1)
                ->get('news_headline')
                ->row_array();
        return $data;
    }

    function GetAllNews_headline() {
        $data = $this->db->get('news_headline')->result_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('news_headline',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('news_headline',$param);
    }

    function insertNews_headline($param) {
        $this->db->insert('news_headline', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchNews_headlineValue($param) {
      $this->db->insert_batch('news_headline_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_news_headline',$id);
        $this->db->update('news_headline',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_news_headline',$id);
        $this->db->delete('news_headline');
    }
    
}

/* End of file News_headline_model.php */
/* Location: ./application/models/News_headline_model.php */