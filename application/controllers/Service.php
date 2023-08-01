<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Service Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Service Controller
 * 
 */
class Service extends CI_Controller {
    
    private $class_path_name;

    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Service_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
         $this->data['export_excel_url']=site_url('service/export_excel_service');
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
            $count_all_records = $this->Service_model->CountAllService();
            $count_filtered_records = $this->Service_model->CountAllService($param);
            $records = $this->Service_model->GetAllServiceData($param);
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
                $return['data'][$row]['program'] = $record['program'];
                $return['data'][$row]['problem'] = $record['problem'];
                $return['data'][$row]['day_problem'] = $record['day_problem'];
                $return['data'][$row]['address'] = $record['address'].'<br/>'.$record['city'];
                $return['data'][$row]['status'] = $record['status'];
                $return['data'][$row]['created_at'] = custDateFormat($record['created_at'],'d M Y <br/> H:i:s');
            }
            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }

    /**
     * Service Request export to excel
     * function was created by Fadilah Ajiq Surya on 20 August 2015 at 11:35 PM, BSP
     **/
    function export_excel_service() {
        $this->layout = 'none';
        $list=array();
        $post=$this->input->post();
        $record = $this->Service_model->GetAllServiceData();
        $name_file=url_title('service_request',true);
        
        if(count($record)>0){
            foreach($record as $row){
                $list[]=array(
                            'name' => $row['name'],
                            'customer_id' => $row['no_customer'],
                            'phone' => $row['phone'],
                            'email' => $row['email'],
                            'program' => $row['program'],
                            'problem' => $row['problem'],
                            'day_problem' => $row['day_problem'],
                            'address' => $row['address'],
                            'status' => $row['status'],
                            'create_date'=>date('d F Y',strtotime($row['created_at']))
                             );
            }
        }

        $this->data = array(
            'list' => $list
            );

        $ouput_file_name = 'report_'.$name_file.'.xls';
        $this->load->library('parser');
        $this->parser->parse(TEMPLATE_DIR.'/service/excel.html', $this->data);
        export_to($ouput_file_name);
    }
}
/* End of file Service.php */
/* Location: ./application/controllers/Service.php */