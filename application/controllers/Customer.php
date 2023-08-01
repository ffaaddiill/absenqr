<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customer Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Customer Controller
 * 
 */
class Customer extends CI_Controller {
    
    private $class_path_name;

    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->output->enable_profiler(true);
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
            $count_all_records = $this->Customer_model->CountAllCustomer();
            $count_filtered_records = $this->Customer_model->CountAllCustomer($param);
            $records = $this->Customer_model->GetAllCustomerData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/detail/'.$record['id']).'"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['kode_pemasangan'] = $record['kode_pemasangan'];
                $return['data'][$row]['first_name'] = $record['first_name'];
                $return['data'][$row]['email'] = $record['email'];
                $return['data'][$row]['no_phone'] = $record['no_phone'];
                $return['data'][$row]['no_hp'] = $record['no_hp'];
                $return['data'][$row]['promo'] = $record['promo'];
                $return['data'][$row]['package_id'] = $record['package_id'];
                $return['data'][$row]['addon_id'] = $record['addon_id'];
                $return['data'][$row]['decoder_id'] = $record['decoder_id'];
                $return['data'][$row]['gender'] = $record['gender'];
                $return['data'][$row]['step'] = $record['step'];
                $return['data'][$row]['created_date'] = custDateFormat($record['created_date'],'d M Y H:i:s');
            }
            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        //redirect($this->class_path_name);
    }
    
    /**
     * detail page
     * @param int $id
     */
    public function detail($id=0) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Customer_model->GetCustomer($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Detail';
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['post'] = $record;
        $this->data['download_url'] = site_url($this->class_path_name.'/download/'.$record['id']);
    }
    
    /**
     * let's download the file
     * @param int $id
     */
    public function download($id=0) {
        $this->layout = 'none';
        if ($id) {
            $record = $this->Customer_model->GetCustomer($id);
            if ($record) {
                if ($record['file_identity'] != '') {
                    /**
                     * disabled
                    $this->load->helper('download');
                    force_download(PATH_ROOT_DOCUMENT.'foto_id/'.$record['file_identity'],NULL);
                     * 
                     */
                    $this->azure->DownloadBlob(AZURE_FOLDER_CUSTOMER,$record['file_identity']);
                    exit();
                }
            }
        }
        redirect($this->class_path_name);
    }
    function export_excel(){
        $this->layout = 'none';
        $list=array();
        $post=$this->input->post();
        
        $record = $this->Customer_model->GetAllCustomerData();
        
        $name_file='customer_registration';
        
        if(count($record)>0){
            $no=0;
            foreach($record as $row){
                
                $no++;
                $list[]=array(
                                        'no'=>$no,
                                        
                                        'kode_pemasangan'=>$row['kode_pemasangan'],
                                        'first_name'=>$row['first_name'],
                                        'email'=>$row['email'],
                                        'no_phone'=>$row['no_phone'],
                                        'no_hp'=>$row['no_hp'],
                                        'package_id'=>$row['package_id'],
                                        'addon_id'=>$row['addon_id'],
                                        'decoder_id'=>$row['decoder_id'],
                                        'gender'=>$row['gender'],
                                        'step'=>$row['step'],
                                        'created_date'=>custDateFormat($row['created_date'],'d M Y')
                                         );
            }
        }
        
         
        $this->data = array(
            'list'=>$list,
        );
       
        $ouput_file_name = 'report_'.$name_file.'.xls';
        
        $this->load->library('parser');
        $this->parser->parse(TEMPLATE_DIR.'/'.$this->class_path_name.'/excel.html', $this->data);
       // echo $a;
       // die();
        export_to($ouput_file_name);
    }
    
}
/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */