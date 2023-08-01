<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Program Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Program Controller
 * 
 */
class Program extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Program_model');
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
            $count_all_records = $this->Program_model->CountAllRecord();
            $count_filtered_records = $this->Program_model->CountAllRecord($param);
            $records = $this->Program_model->GetAllProgramData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;
                    ';
                $return['data'][$row]['name'] = $record['name'];
                
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
        $this->data['status_list'] = $this->Program_model->getStatus();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                $insert_id = $this->Program_model->InsertNewRecord($post);
                if($insert_id){
                    $post_image = $_FILES;
                    if ($post_image['image']['tmp_name']) {
                        $filename = url_title($post['name'],'_',true);
                        $picture_db = file_copy_to_folder($post_image['image'], UPLOAD_DIR.'quiz/', $filename);
                        copy_image_resize_to_folder(UPLOAD_DIR.'program/'.$picture_db, UPLOAD_DIR.'program/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                        copy_image_resize_to_folder(UPLOAD_DIR.'program/'.$picture_db, UPLOAD_DIR.'program/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);

                        $this->Program_model->UpdateRecord($insert_id,array('image'=>$picture_db));
                    }
                    // insert to log
                    $data_log = array(
                        'id_user' => id_auth_user(),
                        'id_group' => id_auth_group(),
                        'action' => 'User Program',
                        'desc' => 'Add Program; ID: '.$insert_id.'; Data: '.json_encode($post),
                    );
                    insert_to_log($data_log);
                    // end insert to log
                    $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                    
                    redirect($this->class_path_name);
                }else{

                }
            }
            
           }
        $this->data['template'] = $this->class_path_name.'/form';
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }

    /**
     * edit page
     */
    public function edit($id) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Program_model->GetProgram($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['status_list'] = $this->Program_model->getStatus();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $this->Program_model->UpdateRecord($id,$post);
                if($id){
                    $post_image = $_FILES;
                    if ($post_image['image']['tmp_name']) {
                        $filename = url_title($post['name'],'_',true);
                        $picture_db = file_copy_to_folder($post_image['image'], UPLOAD_DIR.'quiz/', $filename);
                        copy_image_resize_to_folder(UPLOAD_DIR.'program/'.$picture_db, UPLOAD_DIR.'program/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                        copy_image_resize_to_folder(UPLOAD_DIR.'program/'.$picture_db, UPLOAD_DIR.'program/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);

                        $this->Program_model->UpdateRecord($id,array('image'=>$picture_db));
                    }
                    // insert to log
                    $data_log = array(
                        'id_user' => id_auth_user(),
                        'id_group' => id_auth_group(),
                        'action' => 'User Program',
                        'desc' => 'Edit Program; ID: '.$id.'; Data: '.json_encode($post),
                    );
                    insert_to_log($data_log);
                    // end insert to log
                    $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                    
                    redirect($this->class_path_name);
                }else{

                }
            }
            
           }
        $this->data['template'] = $this->class_path_name.'/form';
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
        $this->data['post'] = $record;
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
                        $record = $this->Program_model->GetProgram($id);
                        if ($record) {
                            if ($record['image'] != '' && file_exists(UPLOAD_DIR.'program/'.$record['image'])) {
                                unlink(UPLOAD_DIR.'program/'.$record['image']);
                                @unlink(UPLOAD_DIR.'program/tmb_'.$record['image']);
                                @unlink(UPLOAD_DIR.'program/sml_'.$record['image']);
                            }
                            $this->Program_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Program',
                                'desc' => 'Delete Program; ID: '.$id.';',
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
        $post = $this->input->post();
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Program Name',
                'rules' => 'required'
            ),
            
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            $post_image = $_FILES;
            
            if (!$this->error) {
                if (!empty($post_image['image']['tmp_name'])) {
                    $check_picture = validatePicture('image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture,'danger');
                        return FALSE;
                    }
                }
                return TRUE;
            } else {
                $this->error = alert_box($this->error,'danger');
                return FALSE;
            }
        }
    }
}