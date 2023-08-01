<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Subscriber Class
 * @author Hamba Allah
 * @version 3.0
 * @category Controller
 * @desc Subscriber Controller
 * 
 */
class Subscriber extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Subscriber_model');
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
            $count_all_records = $this->Subscriber_model->CountAllRecord();
            $count_filtered_records = $this->Subscriber_model->CountAllRecord($param);
            $records = $this->Subscriber_model->GetAllRecordData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/view/'.$record['id']).'"><span class="fa fa-search-plus" aria-hidden="true"></span></a>
                ';
                
                $return['data'][$row]['customer_email'] = $record['customer_email'];
                $return['data'][$row]['customer_ip_address'] = $record['customer_ip_address'];
				$return['data'][$row]['modified_by'] = ($record['modified_by'] == 0) ? '-' : $record['modified_by'];
				$return['data'][$row]['created_date'] = $record['created_date'];
                
            }

            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }

    /**
     * add page
     */
    public function add() {
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                // insert data
                $id = $this->Subscriber_model->InsertRecord($post);
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Subscriber',
                    'desc' => 'Add Subscriber; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name);
            }
            $this->data['post'] = $post;
        }
        $this->data['template'] = $this->class_path_name.'/form';
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }

    /**
     * detail page
     * @param int $id
     */
    public function view($id=0) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Subscriber_model->GetRecord($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Detail';
        $this->data['cancel_url'] = site_url($this->class_path_name);
        
        $this->data['template'] = $this->class_path_name.'/view';
        $this->data['view'] = $record;
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }
    
    /**
     * delete page
     */
    public function delete() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $json = array();
            if ($post['ids'] != '') {
                $array_id = array_map('trim', explode(',', $post['ids']));
                if (count($array_id)>0) {
                    foreach ($array_id as $row => $id) {
                        $record = $this->Subscriber_model->GetRecord($id);
                        if ($record) {
                            $this->Subscriber_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Subscriber',
                                'desc' => 'Delete Subscriber; ID: '.$id.';',
                            );
                            insert_to_log($data_log);
                            // end insert to log
                            $json['success'] = alert_box('Data has been deleted','success');
                            $this->session->set_flashdata('flash_message',$json['success']);
                        } else {
                            $json['error'] = alert_box('Failed. Please refresh the page.','danger');
                            break;
                        }
                    }
                }
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
        redirect($this->class_path_name);
    }

    /**
     * validate form
     * @param int $id
     * @return boolean
     */
    private function validateForm($id=0) {
        $config = array(
            array(
                'field' => 'subscriber_email',
                'label' => 'Subscriber Name',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            if(!$id){
                if (!check_exist_uri('subscriber',$post['slug'])) {
                    $this->error = 'SEO URL is already used.';
                }
            }
			
			if (!$this->error) {
				return TRUE;
			} else {
				return FALSE;
			}
            
        }
    }
    
}
/* End of file Subscriber.php */
/* Location: ./application/controllers/Subscriber.php */