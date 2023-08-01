<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Tax Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Tax Controller
 * 
 */

class Tax extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Tax_model');
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
            $count_all_records = $this->Tax_model->CountAllTax();
            $count_filtered_records = $this->Tax_model->CountAllTax($param);
            $records = $this->Tax_model->GetAllTaxData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '<a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                $return['data'][$row]['name'] = $record['name'];
                $return['data'][$row]['description'] = $record['description'];
                $return['data'][$row]['value'] = $record['value'].' %';
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
        #$this->data['categorys'] = $this->Tax_model->GetCategoryTax();
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                
                
                // inser data
                $id = $this->Tax_model->InsertRecord($post);
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Tax',
                    'desc' => 'Add  Tax; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Tax_model->GetTax($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                
                $this->Tax_model->UpdateRecord($id,$post);
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Tax',
                    'desc' => 'Edit Tax; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Tax_model->GetTax($id);
                        if ($record) {
                            if ($id == id_auth_user()) {
                                $json['error'] = alert_box('You can\'t delete Your own account.','danger');
                                break;
                            } else {
                                if (is_superadmin()) {
                                    /**
                                     * disabled
                                    if ($record['image'] != '' && file_exists(UPLOAD_DIR.'admin/'.$record['image'])) {
                                        unlink(UPLOAD_DIR.'admin/'.$record['image']);
                                        @unlink(UPLOAD_DIR.'admin/tmb_'.$record['image']);
                                        @unlink(UPLOAD_DIR.'admin/sml_'.$record['image']);
                                    }
                                     * 
                                     */
                                    
                                    try {
                                        // Delete Picture from blob storage.
                                        $thumbnail_file = str_replace('admin/', 'admin/thumb/', $record['image']);
                                        $this->azure->DeleteBlob(AZURE_FOLDER_UPLOADS, $record['image']);
                                        $this->azure->DeleteBlob(AZURE_FOLDER_UPLOADS, $thumbnail_file);
                                        $this->Tax_model->DeleteRecord($id);
                                        $json['success'] = alert_box('Data has been deleted','success');
                                        $this->session->set_flashdata('flash_message',$json['success']);
                                        // insert to log
                                        $data_log = array(
                                            'id_user' => id_auth_user(),
                                            'id_group' => id_auth_group(),
                                            'action' => 'User Tax',
                                            'desc' => 'Delete User Tax; ID: '.$id.';',
                                        );
                                        insert_to_log($data_log);
                                        // end insert to log
                                    }
                                    catch(ServiceException $e){
                                        // Handle exception based on error codes and messages.
                                        // Error codes and messages are here: 
                                        // http://msdn.microsoft.com/library/azure/dd179439.aspx
                                        $code = $e->getCode();
                                        $error_message = $e->getMessage();
                                        $json['error'] = alert_box($code.": ".$error_message."<br />","danger");
                                    }
                                } else {
                                    $json['error'] = alert_box('You don\'t have permission to delete this record(s). Please contact the Taxistrator.','danger');
                                    break;
                                }
                            }
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
     * delete picture
     */
    public function delete_picture() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = array();
            $post = $this->input->post();
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $detail = $this->Tax_model->GetTax($post['id']);
                if ($detail && $detail['image'] != '') {
                    $id = $post['id'];
                    /**
                     * disabled
                    unlink(UPLOAD_DIR.'admin/'.$detail['image']);
                    @unlink(UPLOAD_DIR.'admin/tmb_'.$detail['image']);
                    @unlink(UPLOAD_DIR.'admin/sml_'.$detail['image']);
                     * 
                     */
                    try {
                        // Delete Picture from blob storage.
                        $thumbnail_file = str_replace('admin/', 'admin/thumb/', $detail['image']);
                        $this->azure->DeleteBlob(AZURE_FOLDER_UPLOADS, $detail['image']);
                        $this->azure->DeleteBlob(AZURE_FOLDER_UPLOADS, $thumbnail_file);
                        $data_update = array('image' =>'');
                        $this->Tax_model->UpdateRecord($post['id'],$data_update);
                        $json['success'] = alert_box('File hase been deleted.','success');
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'User Tax',
                            'desc' => 'Delete Picture User Tax; ID: '.$id.';',
                        );
                        insert_to_log($data_log);
                        // end insert to log
                    }
                    catch(ServiceException $e){
                        // Handle exception based on error codes and messages.
                        // Error codes and messages are here: 
                        // http://msdn.microsoft.com/library/azure/dd179439.aspx
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        $json['error'] = alert_box($code.": ".$error_message."<br />","danger");
                    }
                } else {
                    $json['error'] = alert_box('Failed to remove File. Please try again.','danger');
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
        $post = $this->input->post();
        $config = array(
           
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|alpha_numeric_spaces'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            
            if (!$id) {
                
            } else {
                
            }
            if (!$this->error) {
                
                return TRUE;
            } else {
                $this->error = alert_box($this->error,'danger');
                return FALSE;
            }
        }
    }
    
    /**
     * form validation check email exist
     * @param string $string
     * @param int $id
     * @return boolean
     */
    public function check_email_exists($string,$id=0) {
        if (!$this->Tax_model->checkExistsEmail($string, $id)) {
            $this->form_validation->set_message('check_email_exists', '{field} is already exists. Please use different {field}');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * form validation check username exist
     * @param string $string
     * @param int $id
     * @return boolean
     */
    public function check_username_exists($string,$id=0) {
        if (!$this->Tax_model->checkExistsUsername($string, $id)) {
            $this->form_validation->set_message('check_username_exists', '{field} is already exists. Please use different {field}');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
/* End of file Tax.php */
/* Location: ./application/controllers/Tax.php */