<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Movie Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Movie Controller
 * 
 */
class Movie extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Movie_model');
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
            $count_all_records = $this->Movie_model->CountAllMovie();
            $count_filtered_records = $this->Movie_model->CountAllMovie($param);
            $records = $this->Movie_model->GetAllMovieData($param);
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
                $return['data'][$row]['id_status'] = ($record['id_status'] == 1) ? 'Active' : 'Not Active';
                $return['data'][$row]['price'] = 'Rp. '.number_format($record['price'],0);
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
                $post['is_featured'] = (isset($post['is_featured'])) ? 1 : 0;
                $post_schedule = $post['schedules'];
                unset($post['schedules']);
                
                // insert data
                $id = $this->Movie_model->InsertRecord($post);
                
                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    $filename = url_title($post['title'].'-thumb','_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['thumbnail_image'],AZURE_FOLDER_MOVIE,$filename);
                        $this->Movie_model->UpdateRecord($id,array('thumbnail_image'=>$picture_db));
                        // resize image
                        //$thumb_prefix = 'thumb/';
                        //$source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_MOVIE.'/'.$picture_db;
                        //$this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'movie/',AZURE_FOLDER_MOVIE,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
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
                        $picture_db = $this->azure->UploadFileToStorage($post_image['primary_image'],AZURE_FOLDER_MOVIE,$filename);
                        $this->Movie_model->UpdateRecord($id,array('primary_image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_MOVIE.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'movie/',AZURE_FOLDER_MOVIE,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                
                // insert schedule
                $data_schedule = array();
                foreach ($post_schedule as $schedule) {
                    $data_schedule[] = array(
                        'id_movie'=>$id,
                        'channel_number'=>$schedule['channel_number'],
                        'start_time'=>$schedule['start_time'],
                        'end_time'=>$schedule['end_time'],
                        'price_override'=>$schedule['price_override']
                    );
                }
                // insert bulk
                if (count($data_schedule)>0) {
                    $this->Movie_model->InsertScheduleBulk($data_schedule);
                }
                // add this var to input into logs
                $post['schedules'] = $post_schedule;
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Movie',
                    'desc' => 'Add Movie; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Movie_model->GetMovie($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $record['schedules'] = $this->Movie_model->GetScheduleByMovieData($record['id_movie']);
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['is_featured'] = (isset($post['is_featured'])) ? 1 : 0;
                $post_schedule = $post['schedules'];
                unset($post['schedules']);
                
                // update data
                $this->Movie_model->UpdateRecord($id,$post);
                
                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    $filename = url_title($post['title'].'-thumb','_',true);
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['thumbnail_image'],AZURE_FOLDER_MOVIE,$filename);
                        $this->Movie_model->UpdateRecord($id,array('thumbnail_image'=>$picture_db));
                        // resize image
                        //$thumb_prefix = 'movie/thumb/';
                        //$source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$picture_db;
                        //$this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'movie/',AZURE_FOLDER_UPLOADS,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
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
                        $picture_db = $this->azure->UploadFileToStorage($post_image['primary_image'],AZURE_FOLDER_MOVIE,$filename);
                        $this->Movie_model->UpdateRecord($id,array('primary_image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_MOVIE.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'movie/',AZURE_FOLDER_MOVIE,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                
                // input schedule
                $this->Movie_model->DeleteScheduleByMovie($id);
                $data_schedule = array();
                foreach ($post_schedule as $schedule) {
                    $data_schedule[] = array(
                        'id_movie'=>$id,
                        'channel_number'=>$schedule['channel_number'],
                        'start_time'=>$schedule['start_time'],
                        'end_time'=>$schedule['end_time'],
                        'price_override'=>$schedule['price_override']
                    );
                }
                // insert bulk
                if (count($data_schedule)>0) {
                    $this->Movie_model->InsertScheduleBulk($data_schedule);
                }
                // add this var to input into logs
                $post['schedules'] = $post_schedule;
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Movie',
                    'desc' => 'Edit Movie; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Movie_model->GetMovie($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'movie/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'movie/'.$record['thumbnail_image']);
                            }
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'movie/'.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.'movie/'.$record['primary_image']);
                            }*/
                            $this->Movie_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Movie',
                                'desc' => 'Delete Movie; ID: '.$id.';',
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
                $detail = $this->Movie_model->GetMovie($post['id']);
                $type = (isset($post['type'])) ? $post['type'] : 'primary';
                if ($detail && ($detail[$type.'_image'] != '')) {
                    $id = $post['id'];
                    //unlink(UPLOAD_DIR.'movie/'.$detail[$type.'_image']);
                    if ($this->azure->DeleteBlob(AZURE_FOLDER_UPLOADS,$detail[$type.'_image'] == TRUE)) {
                        $data_update = array($type.'_image' =>'');
                        $this->Movie_model->UpdateRecord($post['id'],$data_update);
                        $json['success'] = alert_box('File hase been deleted.','success');
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'Movie',
                            'desc' => 'Delete '.ucfirst($type).' Picture Movie; ID: '.$id.';',
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
            $post_image = $_FILES;
            if (!$this->error) {
                if (!empty($post_image['thumbnail_image']['tmp_name'])) {
                    $check_picture = validatePicture('thumbnail_image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture,'danger');
                        return FALSE;
                    }
                }
                if (!empty($post_image['primary_image']['tmp_name'])) {
                    $check_picture = validatePicture('primary_image');
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
/* End of file Movie.php */
/* Location: ./application/controllers/Movie.php */