<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Upgrade Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Upgrade Controller
 * 
 */
class Upgrade extends CI_Controller {
    
    private $class_path_name;

    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Upgrade_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['export_excel_url']=site_url($this->class_path_name.'/export_excel/');
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
    
    /**
     * list data
     */
    public function list_data() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $param['search_value'] = $post['search']['value'];
            $param['search_field'] = $post['columns'];
            if (isset($post['order'])) {
                $param['order_field'] = $post['columns'][$post['order'][0]['column']]['data'];
                $param['order_sort'] = $post['order'][0]['dir'];
            }
            $param['row_from'] = $post['start'];
            $param['length'] = $post['length'];
            $count_all_records = $this->Upgrade_model->CountAllUpgrade();
            $count_filtered_records = $this->Upgrade_model->CountAllUpgrade($param);
            $records = $this->Upgrade_model->GetAllUpgradeData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['name'] = $record['name'];
                $return['data'][$row]['no_customer'] = $record['no_customer'];
                $return['data'][$row]['phone'] = $record['phone'];
                $return['data'][$row]['email'] = $record['email'];
                $return['data'][$row]['saya_ingin'] = $record['saya_ingin'];
                $return['data'][$row]['created_at'] = custDateFormat($record['created_at'],'d M Y');
            }
            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }
    function export_excel(){
        $this->layout = 'none';
        $list=array();
        $post=$this->input->post();
        
        $record = $this->Upgrade_model->GetAllUpgradeData();
        $name_file='upgrade_add_on';
        
        if(count($record)>0){
            $no=0;
            foreach($record as $row){
                
                $no++;
                $list[]=array(
                                        'no'=>$no,
                                        
                                        'name'=>$row['name'],
                                        'no_customer'=>$row['no_customer'],
                                        'phone'=>$row['phone'],
                                        'email'=>$row['email'],
                                        'saya_ingin'=>$row['saya_ingin'],
                                        'created_at'=>custDateFormat($row['created_at'],'d M Y')
                                         );
            }
        }
        
         
        $this->data = array(
            'list'=>$list,
        );
       
        $ouput_file_name = 'report_'.$name_file.'.xls';
        
        $this->load->library('parser');
        $this->parser->parse(TEMPLATE_DIR.'/'.$this->class_path_name.'/excel.html', $this->data);
        export_to($ouput_file_name);
    }
}
/* End of file Upgrade.php */
/* Location: ./application/controllers/Upgrade.php */