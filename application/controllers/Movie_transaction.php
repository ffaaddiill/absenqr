<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Movie Transaction Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Movie Transaction Controller
 * 
 */
class Movie_transaction extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Movie_transaction_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
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
            $count_all_records = $this->Movie_transaction_model->CountAllMovieTransaction();
            $count_filtered_records = $this->Movie_transaction_model->CountAllMovieTransaction($param);
            $records = $this->Movie_transaction_model->GetAllMovieTransactionData($param);
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
                $return['data'][$row]['transid'] = $record['transid'];
                $return['data'][$row]['invoice'] = $record['invoice'];
                $return['data'][$row]['movie_title'] = $record['movie_title'];
                $return['data'][$row]['start_time'] = custDateFormat($record['start_time'],'d M Y H:i');
                $return['data'][$row]['customer_id'] = $record['customer_id'];
                $return['data'][$row]['name'] = $record['name'];
                $return['data'][$row]['email'] = $record['email'];
                $return['data'][$row]['status'] = (($record['status'] == '1') ? 'PAID' : ($record['status'] == '3') ? 'FAILED' : 'REQUESTED');
                $return['data'][$row]['create_date'] = custDateFormat($record['create_date'],'d M Y H:i:s');
            }
            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }
    
    public function detail($id=0) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Movie_transaction_model->GetMovieTransaction($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Detail';
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['post'] = $record;
    }
}
/* End of file Movie_transaction.php */
/* Location: ./application/controllers/Movie_transaction.php */