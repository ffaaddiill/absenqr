<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Banner Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Banner Controller
 * 
 */
class Banner extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
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
            $count_all_records = $this->Banner_model->CountAllBanner();
            $count_filtered_records = $this->Banner_model->CountAllBanner($param);
            $records = $this->Banner_model->GetAllBannerData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="fa fa-edit" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['title'] = $record['title'];
                $return['data'][$row]['view_image'] = '<center><button onclick="setBannerImage(\''.MAINSITE.'uploads/'.$record['primary_image'].'\')" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#showup-modal-banner">View <i class="fa fa-external-link"></i></button></center>';
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

        /*
        $this->data['sites'] = get_sites();
        $this->data['list_product'] = $this->Banner_model->getActiveProduct();
        $this->data['product_banner'] = $this->Banner_model->getBannerProduct( $this->uri->segment(3) );*/

        if ($this->input->post()) {
            $post = $this->input->post();

            if ($this->validateForm()) {
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;

                $end_date = isset($post['end_date']) && !empty($post['end_date'])?date('Y-m-d H:i:s', strtotime($post['end_date'])):'';
                $post['publish_date'] = date('Y-m-d H:i:s', strtotime($post['publish_date']));
                
                $post['position'] = ($post['position'] == '') ? $this->Banner_model->GetMaxPosition() : $post['position'];
                
                // insert data
                $id = $this->Banner_model->InsertRecord($post);

                /*if($id){
                    // if Sites  is set/add
                    $sites = array();
                    if (isset($id_site) && count($id_site)>0) {
                        foreach ($id_site as $site) {
                            $sites[] = array(
                                'id_banner'=>$id,
                                'id_site'=>$site
                            );
                        }
                    }
                    if (count($sites)>0) {
                        $this->Banner_model->InsertSitesBatch($sites);
                    }
                }*/
                

                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($post['title'],'_',true);
                    
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.$this->class_path_name, $filename);
                    $this->Banner_model->UpdateRecord($id,array('primary_image'=>$this->class_path_name.'/'.$picture_db,'picture_file_name'=>$picture_db));
                    
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Banner',
                    'desc' => 'Add Banner; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Banner_model->GetBanner($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['sites'] = get_sites();

        /*
        $this->data['list_site'] = array_column($this->Banner_model->GetSitesById($id),'id_site');

       $this->data['list_product'] = $this->Banner_model->getActiveProduct();

        $this->data['product_banner'] = $this->Banner_model->getBannerProduct( $this->uri->segment(3) );*/

        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;

                $end_date = isset($post['end_date']) && !empty($post['end_date'])?date('Y-m-d H:i:s', strtotime($post['end_date'])):'';
                $post['publish_date'] = date('Y-m-d H:i:s', strtotime($post['publish_date']));

                /*$id_site = $post['id_site'];
                unset($post['id_site']);*/
                
                // update data
                /*echo '<pre>';
                print_r($post);
                echo '<br>';
                print_r($_FILES);
                echo '</pre>';
                die();*/
                $this->Banner_model->UpdateRecord($id,$post);

                /*$sites = array();
                if (isset($id_site) && count($id_site)>0) {
                    foreach ($id_site as $site) {
                        $sites[] = array(
                            'id_banner'=>$id,
                            'id_site'=>$site
                        );
                    }
                }
                if (count($sites)>0) {
                    $this->Banner_model->DeleteSite($id);
                    $this->Banner_model->InsertSitesBatch($sites);
                }*/
                
                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.$record['primary_image'])) {
                        unlink(UPLOAD_DIR.$record['primary_image']);
                    }
                    $filename = url_title($post['title'],'_',true);
                    /**
                     * activated*/
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.$this->class_path_name, $filename);
                    $this->Banner_model->UpdateRecord($id,array('primary_image'=>$this->class_path_name.'/'.$picture_db,'picture_file_name'=>$picture_db));
                     
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Banner',
                    'desc' => 'Edit Banner; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Banner_model->GetBanner($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'banner/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'banner/'.$record['thumbnail_image']);
                            }*/
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.$record['primary_image']);
                            }
                            $this->Banner_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Banner',
                                'desc' => 'Delete Banner; ID: '.$id.';',
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
                $id = $post['id'];
                $record = $this->Banner_model->GetBanner($id);
                if ($record && $record['primary_image'] != '') {
                    unlink(UPLOAD_DIR.$record['primary_image']);
                    $this->Banner_model->delete_picture($id);
                    $json['success'] = true;
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
            )/*,
            array(
                'field' => 'url_link',
                'label' => 'URL Link',
                'rules' => 'required'
            ),*/
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
/* End of file Banner.php */
/* Location: ./application/controllers/Banner.php */