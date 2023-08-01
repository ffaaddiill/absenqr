<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Harbolnas Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Harbolnas Controller
 * 
 */
class Harbolnas extends CI_Controller {
    
    private $class_path_name;
    private $error;

    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Harbolnas_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        $this->data['export_excel_url']=site_url('harbolnas/export_excel_harbolnas');
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
            $count_all_records = $this->Harbolnas_model->CountAllHarbolnas();
            $count_filtered_records = $this->Harbolnas_model->CountAllHarbolnas($param);
            $records = $this->Harbolnas_model->GetAllHarbolnasData($param);
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
                $return['data'][$row]['teaser'] = $record['teaser'];
                $return['data'][$row]['description'] = $record['description'];
                $return['data'][$row]['is_active'] = ( isset($record['is_active']) && $record['is_active'] == 1 ) ? 'Active' : 'Inactive';
                $return['data'][$row]['created_date'] = custDateFormat($record['created_date'],'d M Y H:i:s');
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
                $id = $this->Harbolnas_model->InsertRecord($post);
                                
                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    $filename = url_title($post['title'].'-thumb','_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['thumbnail_image'],AZURE_FOLDER_UPLOADS,'harbolnas/'.$filename);
                        $this->Harbolnas_model->UpdateRecord($id,array('thumbnail_image'=>$picture_db));
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($post['title'],'_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['primary_image'],AZURE_FOLDER_UPLOADS,'harbolnas/'.$filename);
                        $this->Harbolnas_model->UpdateRecord($id,array('primary_image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'harbolnas/thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'harbolnas/',AZURE_FOLDER_UPLOADS,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
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
                    'action' => 'Harbolnas',
                    'desc' => 'Add Harbolnas; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Harbolnas_model->GetHarbolnas($id);
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
                //$post['modify_date'] = date('Y-m-d H:i:s');
                $post['is_active'] = (isset($post['is_active'])) ? 1 : 0;
                //$post['end_date'] = (isset($post['forever'])) ? NULL : $post['end_date'];
                unset($post['forever']);
                
                // update data
                $this->Harbolnas_model->UpdateRecord($id,$post);

                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    $filename = url_title($post['title'].'-thumb','_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['thumbnail_image'],AZURE_FOLDER_UPLOADS,'harbolnas/'.$filename);
                        $this->Harbolnas_model->UpdateRecord($id,array('thumbnail_image'=>$picture_db));
                        // resize image
                        //$thumb_prefix = 'harbolnas/thumb/';
                        //$source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$picture_db;
                        //$this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'harbolnas/',AZURE_FOLDER_UPLOADS,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($post['title'],'_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['primary_image'],AZURE_FOLDER_UPLOADS,'harbolnas/'.$filename);
                        $this->Harbolnas_model->UpdateRecord($id,array('primary_image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'harbolnas/thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'harbolnas/',AZURE_FOLDER_UPLOADS,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
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
                    'action' => 'Harbolnas',
                    'desc' => 'Edit Harbolnas; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Harbolnas_model->GetHarbolnas($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'news/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'news/'.$record['thumbnail_image']);
                            }
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'news/'.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.'news/'.$record['primary_image']);
                            }*/
                            $this->Harbolnas_model->DeleteRecord($id);
                            /*echo $this->db->last_query();
                            die();*/
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Harbolnas',
                                'desc' => 'Delete Harbolnas; ID: '.$id.';',
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
     * delete picture
     */
    public function delete_picture() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = array();
            $post = $this->input->post();
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $detail = $this->Harbolnas_model->GetHarbolnas($post['id']);
                $type = (isset($post['type'])) ? $post['type'] : 'primary';
                if ($detail && ($detail[$type.'_image'] != '')) {
                    $id = $post['id'];
                    //unlink(UPLOAD_DIR.'movie/'.$detail[$type.'_image']);
                    if ($this->azure->DeleteBlob(AZURE_FOLDER_UPLOADS,$detail[$type.'_image'] == TRUE)) {
                        $data_update = array($type.'_image' =>'');
                        $this->Harbolnas_model->UpdateRecord($post['id'],$data_update);
                        $json['success'] = alert_box('File hase been deleted.','success');
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'Harbolnas',
                            'desc' => 'Delete '.ucfirst($type).' Picture Harbolnas; ID: '.$id.';',
                        );
                        insert_to_log($data_log);
                        // end insert to log
                    } else {
                        $json['error'] = alert_box('Failed to remove File. Please try again.','danger');
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

    /**
     * Harbolnas export to excel
     * function was created by Fadilah Ajiq Surya on 20 August 2015 at 11:35 PM, BSP
     **/
    function export_excel_harbolnas() {
        $this->layout = 'none';
        $list=array();
        $post=$this->input->post();
        $record = $this->Harbolnas_model->GetAllHarbolnasData();
        $name_file=url_title('harbolnas',true);
        
        if(count($record)>0){
            $no=0;
            foreach($record as $row){
                $no++;
                $list[]=array(
                            'no' => $no,
                            'customer_id' => $row['pelanggan_id'],
                            'name' => $row['name'],
                            'email' => $row['email'],
                            'phone' => $row['phone'],
                            'phone2' => $row['phone2'],
                            'create_date'=>date('d F Y',strtotime($row['create_date']))
                             );
            }
        }

        $this->data = array(
            'list' => $list
            );

        $ouput_file_name = 'report_'.$name_file.'.xls';
        $this->load->library('parser');
        $this->parser->parse(TEMPLATE_DIR.'/harbolnas/excel.html', $this->data);
        export_to($ouput_file_name);
    }
}
/* End of file Harbolnas.php */
/* Location: ./application/controllers/Harbolnas.php */