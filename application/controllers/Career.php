<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Career Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Career Controller
 * 
 */
class Career extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Career_model');
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
            $count_all_records = $this->Career_model->CountAllCareer();
            $count_filtered_records = $this->Career_model->CountAllCareer($param);
            $records = $this->Career_model->GetAllCareerData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;
                    <a href="'.site_url($this->class_path_name.'/applicant/'.$record['id']).'"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['division'] = $record['division'];
                $return['data'][$row]['title'] = $record['title'];
                $return['data'][$row]['publish_date'] = ($record['publish_date']) ? custDateFormat($record['publish_date'],'d M Y') : '-';
                $return['data'][$row]['id_status'] = ($record['id_status'] == 1) ? 'Publish' : 'Draft';
                $return['data'][$row]['count_applicant'] = $record['count_applicant'];
                $return['data'][$row]['create_date'] = custDateFormat($record['create_date'],'d M Y H:i:s');
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
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['end_date'] = (isset($post['forever'])) ? NULL : $post['end_date'];
                unset($post['forever']);
                
                // insert data
                $id = $this->Career_model->InsertRecord($post);
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Career',
                    'desc' => 'Add Career; ID: '.$id.'; Data: '.json_encode($post),
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
    public function edit($id=0) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Career_model->GetCareer($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['end_date'] = (isset($post['forever'])) ? NULL : $post['end_date'];
                unset($post['forever']);
                
                // update data
                $this->Career_model->UpdateRecord($id,$post);
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Career',
                    'desc' => 'Edit Career; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Career_model->GetCareer($id);
                        if ($record) {
                            $this->Career_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Career',
                                'desc' => 'Delete Career; ID: '.$id.';',
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
     * answer page
     * @param int $id
     */
    public function applicant($id=0) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Career_model->GetCareer($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Career Applicant ('.$record['title'].')';
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data_applicant/'.$id);
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
    
    /**
     * list data answer
     * @param int $id
     */
    public function list_data_applicant($id=0) {
        $this->layout = 'none';
        $id = (int)$id;
        $record = $this->Career_model->GetCareer($id);
        if ($record && $id && $this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $param['search_value'] = $post['search']['value'];
            $param['search_field'] = $post['columns'];
            $param['where_prefix_field'] = 'id_career';
            $param['where_prefix_value'] = $id;
            $param_pref['where_prefix_field'] = 'id_career';
            $param_pref['where_prefix_value'] = $id;
            if (isset($post['order'])) {
                $param['order_field'] = $post['columns'][$post['order'][0]['column']]['data'];
                $param['order_sort'] = $post['order'][0]['dir'];
            }
            $param['row_from'] = $post['start'];
            $param['length'] = $post['length'];
            $count_all_records = $this->Career_model->CountAllCareerApplicant($param_pref);
            $count_filtered_records = $this->Career_model->CountAllCareerApplicant($param);
            $records = $this->Career_model->GetAllCareerApplicantData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '<a href="'.site_url($this->class_path_name.'/download_resume/'.$record['id']).'" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>';
                $return['data'][$row]['name'] = $record['name'];
                $return['data'][$row]['email'] = $record['email'];
                $return['data'][$row]['resume'] = $record['resume'];
                $return['data'][$row]['create_date'] = custDateFormat($record['create_date'],'d M Y H:i:s');
            }
            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }
    
    /**
     * download resume page
     * @param int $id
     */
    public function download_resume($id=0) {
        $this->layout = 'none';
        if ($id) {
            $record = $this->Career_model->GetCareerApplicant($id);
            if ($record) {
                if ($record['file_resume_file_name'] != '') {
                    $this->azure->DownloadBlob(AZURE_FOLDER_CV,$record['file_resume_file_name']);
                    exit();
                }
            }
        }
        exit;
        redirect($this->class_path_name);
    }
    
    /**
     * validate form
     * @param int $id
     * @return boolean
     */
    private function validateForm($id=0) {
        $post = $this->input->post();
        $config = array(
            array(
                'field' => 'division',
                'label' => 'Division',
                'rules' => 'required'
            ),
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required'
            ),
            array(
                'field' => 'requirement',
                'label' => 'Requirement',
                'rules' => 'required'
            ),
            array(
                'field' => 'publish_date',
                'label' => 'Publish Date',
                'rules' => 'required'
            ),
            array(
                'field' => 'uri_path',
                'label' => 'SEO URL',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            if (!isset($post['forever']) && $post['end_date'] == '') {
                $this->error = 'Please input End Date.';
            }
            if (!$this->error) {
                return TRUE;
            } else {
                $this->error = alert_box($this->error,'danger');
                return FALSE;
            }
        }
    }
}
/* End of file Career.php */
/* Location: ./application/controllers/Career.php */