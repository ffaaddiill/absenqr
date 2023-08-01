<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Arisan Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Arisan model
 * 
 */
class Arisan_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * insert data batch
     * @param array $data
     */
    function InsertArisanData($data) {
        $insert_data = array();
        foreach ($data['suggest'] as $row) {
            $insert_data[] = array(
                'pelanggan_id'=>$data['customer_id'],
                'name'=>$row['name'],
                'email'=>$row['email'],
                'phone'=>$row['phone'],
                'phone2'=>$row['phone2']
            );
        }
        if (count($insert_data)>0) {
            $this->db->insert_batch('arisan',$insert_data);
        }
    }
    
}
/* End of file Arisan_model.php */
/* Location: ./application/models/Arisan_model.php */