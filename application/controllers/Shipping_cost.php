<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shipping_cost Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Shipping_cost Controller
 * 
 */
class Shipping_cost extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Shipping_cost_model');
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
            $count_all_records = $this->Shipping_cost_model->CountAllRecord();
            $count_filtered_records = $this->Shipping_cost_model->CountAllRecord($param);
            $records = $this->Shipping_cost_model->GetAllRecordData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id_shipping'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id_shipping']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['province'] = $record['province'];
                $return['data'][$row]['city'] = $record['city'];
                $return['data'][$row]['is_java'] = ($record['is_java']==0) ? 'Out Java' : 'In Java';
                $return['data'][$row]['create_date'] = custDateFormat($record['create_date'],'d M Y H:i:s');
                
            }

            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }

    public function edit($id){
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Shipping_cost_model->GetData($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);       
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['is_java'] = (isset($post['is_java'])) ? 1 : 0;
                // update data
                $this->Shipping_cost_model->UpdateRecord($id,$post);
                 // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Shipping',
                    'desc' => 'Edit Shipping; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name);
            }
        }
        $this->data['template'] = $this->class_path_name.'/form';
        $this->data['post'] = $record;
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }
    /**
     * validate form
     * @param int $id
     * @return boolean
     */
    private function validateForm($id=0) {
        // $post = $this->input->post();
        // $config = array(
        //     array(
        //         'field' => 'quiz_title',
        //         'label' => 'Quiz Title',
        //         'rules' => 'required'
        //     ),
        //     array(
        //         'field' => 'start_date',
        //         'label' => 'Start Date',
        //         'rules' => 'required'
        //     ),
        //     array(
        //         'field' => 'end_date',
        //         'label' => 'End Date',
        //         'rules' => 'required'
        //     ),
        //     array(
        //         'field' => 'id_site[]',
        //         'label' => 'Sites',
        //         'rules' => 'required'
        //     ),
        // );
        

        // $this->form_validation->set_rules($config);
        // if ($this->form_validation->run() === FALSE) {
        //     $this->error = alert_box(validation_errors(),'danger');
        //     return FALSE;
        // } else {
        //     $post_image = $_FILES;
        //     if (!$id) {
        //         if($post['is_question'] && $post['is_question']==1){
                    
        //             if (!isset($post['question']) || count($post['question'])==0 || $post['is_question']==1) {
        //                 $this->error = 'Please Add Question.';
                        
        //             } else {
        //                 foreach ($post['question'] as $question) {
        //                     if ($question['question'] == '') {
        //                         $this->error = 'Please input Question.';
        //                         echo 'asd';
        //                         break;
        //                     }
        //                 }
        //             }
        //         }
        //     }
            
        //     if (!$this->error) {
        //         if (!empty($post_image['image']['tmp_name'])) {
        //             $check_picture = validatePicture('image');
        //             if (!empty($check_picture)) {
        //                 $this->error = alert_box($check_picture,'danger');
        //                 return FALSE;
        //             }
        //         }
        //         return TRUE;
        //     } else {
        //         $this->error = alert_box($this->error,'danger');
        //         return FALSE;
        //     }
        // }
        return true;
    }
}