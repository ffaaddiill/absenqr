<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * News Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc News model
 * 
 */
class News_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
	
	function getAllNewsForSitemap() {
		$now = date('Y-m-d H:i:s');
		$data = $this->db
                ->where('news.id_status',1)
                ->where('news.is_delete',0)
                ->where('news.publish_date <=',$now)
                ->order_by('news.publish_date','desc')
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->get('news')
                ->result_array();
        return $data;
	}
    
    /**
     * get all data
     * @param string $param
     * @return array data
     */
    function GetAllNewsData($param=array()) {
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
            $this->db->order_by('news.id_news','desc');
        }
        $data = $this->db
                ->select("*,id_news as id")
                ->where('news.is_delete',0)
				->join('news_category', 'news_category.id = news.id_news_category', 'LEFT')
                ->get('news')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllNews($param=array()) {
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
                	->from('news')
				->join('news_category', 'news.id_news_category=news_category.id', 'left')
                	->where('news.is_delete',0)
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get detail by id
     * @param int $id
     * @return array data
     */
    function GetNews($id) {
        $data = $this->db
                ->where('id_news',$id)
                ->limit(1)
                ->get('news')
                ->row_array();
        return $data;
    }
	
	function getCategoryById($id) {
		$data = $this->db
				->where('id', $id)
				->limit(1)
				->get('news_category')
				->row_array();
		return $data;
	}

    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('news',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_news',$id);
        return $this->db->update('news',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_news',$id);
        $this->db->delete('news');
    }

    function delete_picture($id) {
        $this->db->where('id_news', $id);
        $this->db->update('news', array(
            'primary_image'=>'',
            'picture_file_name'=>''
        ));
    }

    /**
     * insert sites with batch method
     * @param array $data
     */
    function InsertSitesBatch($data){
        $this->db->insert_batch('news_sites',$data);
    }

    function setAsHeadline($param) {
		$this->db->insert('news_headline', $param);
    }
    
    function isExistHeadline($param) {
        $count = $this->db
                ->from('news_headline')
                ->count_all_results();
        return $count;
    }

    /**
     * Get Site by id
     * @param int $id
     * @return array data
     */
    function GetSitesById($id) {
        $data = $this->db
                ->where('id_news',$id)
                ->get('news_sites')
                ->result_array();
        return $data;
    }

    /**
     * delete site record
     * @param int $id
     */
    function DeleteSite($id){
        $this->db->where('id_news',$id);
        $this->db->delete('news_sites');
    }
    
}
/* End of file News_model.php */
/* Location: ./application/models/News_model.php */