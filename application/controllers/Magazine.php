<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Magazine Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Magazine Controller
 * 
 */
class Magazine extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Magazine_model');
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
            $count_all_records = $this->Magazine_model->CountAllMagazine();
            $count_filtered_records = $this->Magazine_model->CountAllMagazine($param);
            $records = $this->Magazine_model->GetAllMagazineData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['title'] = $record['title'];
                $return['data'][$row]['position'] = $record['position'];
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
                $post['uri_path'] = url_title($post['title']);
                $post['editiontime'] = date('Y-m-01',strtotime($post['editiontime']));
                
                // insert data
                $id = $this->Magazine_model->InsertRecord($post);
                                
                $post_image = $_FILES;
                if ($post_image['image']['tmp_name']) {
                    $filename = 'i'.url_title($post['title'],'_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['image'],AZURE_FOLDER_MAGZ,$filename);
                        $this->Magazine_model->UpdateRecord($id,array('image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_MAGZ.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'magazine/',AZURE_FOLDER_MAGZ,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                if ($post_image['filemagz']['tmp_name']) {
                    $filename = 'f'.url_title($post['title'],'_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['filemagz'],AZURE_FOLDER_MAGZ,$filename);
                        $this->Magazine_model->UpdateRecord($id,array('filemagz'=>$picture_db));
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Magazine',
                    'desc' => 'Add Magazine; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Magazine_model->GetMagazine($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['uri_path'] = url_title($post['title']);
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['editiontime'] = date('Y-m-01',strtotime($post['editiontime']));
                
                // update data
                $this->Magazine_model->UpdateRecord($id,$post);
                
                $post_image = $_FILES;
                if ($post_image['image']['tmp_name']) {
                    $filename = 'i'.url_title($post['title'],'_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['image'],AZURE_FOLDER_MAGZ,$filename);
                        $this->Magazine_model->UpdateRecord($id,array('image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_MAGZ.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'magazine/',AZURE_FOLDER_MAGZ,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                if ($post_image['filemagz']['tmp_name']) {
                    $filename = 'f'.url_title($post['title'],'_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['filemagz'],AZURE_FOLDER_MAGZ,$filename);
                        $this->Magazine_model->UpdateRecord($id,array('filemagz'=>$picture_db));
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Magazine',
                    'desc' => 'Edit Magazine; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Magazine_model->GetMagazine($id);
                        if ($record) {
                            $this->Magazine_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Magazine',
                                'desc' => 'Delete Magazine; ID: '.$id.';',
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
                'field' => 'title',
                'label' => 'Title',
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
                if (!empty($post_image['filemagz']['tmp_name'])) {
                    $check_picture = validateFile('filemagz');
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
/* End of file Magazine.php */
/* Location: ./application/controllers/Magazine.php */