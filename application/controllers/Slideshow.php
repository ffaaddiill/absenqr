<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Slideshow Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Slideshow Controller
 * 
 */
class Slideshow extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Slideshow_model');
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
            $count_all_records = $this->Slideshow_model->CountAllSlideshow();
            $count_filtered_records = $this->Slideshow_model->CountAllSlideshow($param);
            $records = $this->Slideshow_model->GetAllSlideshowData($param);
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
                $return['data'][$row]['url_link'] = $record['url_link'];
                $return['data'][$row]['position'] = $record['position'];
                $return['data'][$row]['id_status'] = ($record['id_status'] == 1) ? 'Active' : 'Not Active';
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
        $this->data['sites'] = get_sites();

        $this->data['list_product'] = $this->Slideshow_model->getActiveProduct();
        $this->data['product_slideshow'] = $this->Slideshow_model->getSlideshowProduct( $this->uri->segment(3) );

        if ($this->input->post()) {
            $post = $this->input->post();

            echo '<pre>';
            print_r($post);
            echo '</pre>';
            $id_site = $post['id_site'];
            unset($post['id_site']);

            if ($this->validateForm()) {
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['position'] = ($post['position'] == '') ? $this->Slideshow_model->GetMaxPosition() : $post['position'];
                
                // insert data
                $id = $this->Slideshow_model->InsertRecord($post);

                if($id){
                    // if Sites  is set/add
                    $sites = array();
                    if (isset($id_site) && count($id_site)>0) {
                        foreach ($id_site as $site) {
                            $sites[] = array(
                                'id_slideshow'=>$id,
                                'id_site'=>$site
                            );
                        }
                    }
                    if (count($sites)>0) {
                        $this->Slideshow_model->InsertSitesBatch($sites);
                    }
                }
                

                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($post['title'],'_',true);
                    /**
                     * disabled
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.'slideshow/', $filename);
                    $this->Slideshow_model->UpdateRecord($id,array('primary_image'=>$picture_db));
                     * 
                     */
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['primary_image'],AZURE_FOLDER_UPLOADS,'slideshow/'.$filename);
                        $this->Slideshow_model->UpdateRecord($id,array('primary_image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'slideshow/thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'slideshow/',AZURE_FOLDER_UPLOADS,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
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
                    'action' => 'Slideshow',
                    'desc' => 'Add Slideshow; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Slideshow_model->GetSlideshow($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['sites'] = get_sites();
        $this->data['list_site'] = array_column($this->Slideshow_model->GetSitesById($id),'id_site');

        $this->data['list_product'] = $this->Slideshow_model->getActiveProduct();

        $this->data['product_slideshow'] = $this->Slideshow_model->getSlideshowProduct( $this->uri->segment(3) );

        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;

                $id_site = $post['id_site'];
                unset($post['id_site']);
                
                // update data
                /*echo '<pre>';
                print_r($post);
                echo '<br>';
                print_r($_FILES);
                echo '</pre>';
                die();*/
                $this->Slideshow_model->UpdateRecord($id,$post);

                $sites = array();
                if (isset($id_site) && count($id_site)>0) {
                    foreach ($id_site as $site) {
                        $sites[] = array(
                            'id_slideshow'=>$id,
                            'id_site'=>$site
                        );
                    }
                }
                if (count($sites)>0) {
                    $this->Slideshow_model->DeleteSite($id);
                    $this->Slideshow_model->InsertSitesBatch($sites);
                }
                
                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    /*if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'slideshow/'.$record['primary_image'])) {
                        unlink(UPLOAD_DIR.'slideshow/'.$record['primary_image']);
                    }*/
                    $filename = url_title($post['title'],'_',true);
                    /**
                     * disabled
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.'slideshow/', $filename);
                    $this->Slideshow_model->UpdateRecord($id,array('primary_image'=>$picture_db));
                     * 
                     */
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['primary_image'],AZURE_FOLDER_UPLOADS,'slideshow/'.$filename);
                        
                        /*echo '<pre>';
                        echo $picture_db;
                        die();*/

                        $this->Slideshow_model->UpdateRecord($id,array('primary_image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'slideshow/thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'slideshow',AZURE_FOLDER_UPLOADS,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
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
                    'action' => 'Slideshow',
                    'desc' => 'Edit Slideshow; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Slideshow_model->GetSlideshow($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'slideshow/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'slideshow/'.$record['thumbnail_image']);
                            }
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'slideshow/'.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.'slideshow/'.$record['primary_image']);
                            }*/
                            $this->Slideshow_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Slideshow',
                                'desc' => 'Delete Slideshow; ID: '.$id.';',
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
            array(
                'field' => 'url_link',
                'label' => 'URL Link',
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
/* End of file Slideshow.php */
/* Location: ./application/controllers/Slideshow.php */