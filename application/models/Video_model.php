<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Video Model Class
 * @author Alfian Purnomo <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Video model
 * 
 */
class Video_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }


    function GetVideoList(){
    	$data = $this->db
    			->where('id_status',1)
    			->where('is_delete',0)
                ->order_by('create_date','desc')
    			->get('video')
    			->result_array();
    	return $data;
    }
    function GetVideoData(){
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->limit(3)
                ->order_by('create_date','desc')
                ->get('video')
                ->result_array();
        return $data;
    }

    function GetVideoDetailByPath($path){
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('uri_path',$path)
                ->get('video')
                ->row_array();
        return $data;
    }
}