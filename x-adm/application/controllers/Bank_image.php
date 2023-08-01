<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BankImage Class
 * @author Fadilah Ajiq Surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Bank Image Controller
 * 
 */

class Bank_image extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Bankimage_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        //$this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['page'] = 0;
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
            $count_all_records = $this->Bankimage_model->CountAllBankImage();
            $count_filtered_records = $this->Bankimage_model->CountAllBankImage($param);
            $records = $this->Bankimage_model->GetAllBankImageData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id_bank_image'];
                $return['data'][$row]['actions'] = '<a href="'.site_url($this->class_path_name.'/edit/'.$record['id_bank_image']).'"><span class="fa fa-edit" aria-hidden="true"></span></a>';
                $return['data'][$row]['title'] = $record['title'];
				$return['data'][$row]['primary_image'] = MAINSITE.'uploads/'.$record['primary_image'];
                $return['data'][$row]['image_link'] = '<center><a class="btn btn-sm btn-default" href="'.MAINSITE.'uploads/'.$record['primary_image'].'">View Image</a></center>';
                /*$return['data'][$row]['value'] = $record['value'];*/
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
        //$this->data['vendors'] = $this->Bankimage_model->GetVendor();
        
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            // echo '<pre>';
            // print_r($post);
            // die();
            if ($this->validateForm()) {
                $id = $this->Bankimage_model->InsertRecord($post);
                $record = $this->Bankimage_model->GetBankImage($id);

                $created_date = date('Y-m-d_H-i-s', strtotime($record['create_date']));

                $post_image = $_FILES;
                
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = $post['uri_path'].'-'.$created_date;
                    try {
                        //Upload blob
                        $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR .'/image-bank/', $filename);
    
                        // resize image
                        //copy_image_resize_to_folder(UPLOAD_DIR. '/image-bank'. '/'.$picture_db, UPLOAD_DIR . '/image-bank/', 'tmb_'. $filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                        //copy_image_resize_to_folder(UPLOAD_DIR. '/image-bank'. '/'.$picture_db, UPLOAD_DIR  . '/image-bank/', 'sml_'. $filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                        
                        // update data
                          $img_arr = array(
                            'primary_image' => 'image-bank' . '/'. $picture_db
                        );
                          $status = $this->Bankimage_model->UpdateRecord($id, $img_arr);
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
                    'action' => 'User BankImage',
                    'desc' => 'Add  BankImage; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                redirect($this->class_path_name);
            }
            $this->data['post'] = $post;
                // echo '<pre>';
                // print_r($this->data['post']);
                // die();
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
        $record = $this->Bankimage_model->GetBankImage($id);
        
        if (!$record) {
            redirect($this->class_path_name);
        }
        
        // echo '<pre>';
        // print_r($this->data['vendors']);
        // die();
        //$this->load->model('Vendor_model');
        //$this->data['category_vendor'] = $this->Vendor_model->GetCategoryVendor();
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        //$this->data['pph_type']     = $this->Bankimage_model->GetPPH();
        if ($this->input->post()) {
            $post = $this->input->post();

            if ($this->validateForm($id)) {

                $this->Bankimage_model->UpdateRecord($id,$post);

                $created_date = date('Y-m-d_H-i-s', strtotime($record['create_date']));
                
                $picture_db = '';
                $post_image = $_FILES;

                // echo '<pre>';
                // print_r($post_image);
                // die();

                if ($post_image['primary_image']['tmp_name']) {
                    
                    
                    $filename = $post['uri_path'].'-'.$created_date;
                    
                    try {
                    
                        //Upload blob
                        $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR .'/image-bank/', $filename);

                        // resize image
                        //copy_image_resize_to_folder(UPLOAD_DIR. '/image-bank'. '/'.$picture_db, UPLOAD_DIR . '/image-bank/', 'tmb_'. $filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                        //copy_image_resize_to_folder(UPLOAD_DIR. '/image-bank'. '/'.$picture_db, UPLOAD_DIR  . '/image-bank/', 'sml_'. $filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                        
                        // update data
                        $img_arr = array(
                            'primary_image' => 'image-bank' . '/'. $picture_db
                        );
                        $status = $this->Bankimage_model->UpdateRecord($id, $img_arr);
                        
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                } else {
                    rename('', '');
                }

                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User BankImage',
                    'desc' => 'Edit BankImage; ID: '.$id.'; Data: '.json_encode($post),
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
            $type = 'primary';
            if ($post['ids'] != '') {
                $id= $post['ids'];
                $record = $this->Bankimage_model->GetBankImage($id);
                if ($record) {
                        $this->Bankimage_model->DeleteRecord($id);
                        if (unlink(UPLOAD_DIR.$record[$type.'_image'])) {
                            $data_update = array($type.'_image' =>'');
                            //$this->Bankimage_model->UpdateRecord($post['id'],$data_update);
                            $json['success'] = alert_box('File has been deleted.','success');
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Bank Image',
                                'desc' => 'Delete '.ucfirst($type).' Picture News; ID: '.$id.';',
                            );
                            insert_to_log($data_log);
                            // end insert to log
                        } else {
                            $json['error'] = alert_box('Failed to remove File. Please try again.','danger');
                        }

                        $json['success'] = alert_box('Data has been deleted','success');
                        $this->session->set_flashdata('flash_message',$json['success']);
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'User BankImage',
                            'desc' => 'Delete  BankImage; ID: '.$id.';',
                        );
                        insert_to_log($data_log);
                            // end insert to log
                   
                } else {
                    $json['error'] = alert_box('Failed. Please refresh the page.','danger');
                    die();
                }
                 
                
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
        //redirect($this->class_path_name);
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
                $detail = $this->Bankimage_model->GetBankImage($post['id']);
                $type = (isset($post['type'])) ? $post['type'] : 'primary';
                if ($detail && ($detail[$type.'_image'] != '')) {
                    $id = $post['id'];
                    //unlink(UPLOAD_DIR.'news/'.$detail[$type.'_image']);
                    if (unlink(UPLOAD_DIR.$detail[$type.'_image'])) {
                        $data_update = array($type.'_image' =>'');
                        $this->Bankimage_model->UpdateRecord($post['id'],$data_update);
                        $json['success'] = alert_box('File has been deleted.','success');
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'Bank Image',
                            'desc' => 'Delete '.ucfirst($type).' Picture News; ID: '.$id.';',
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
                'label' => 'Image Title',
                'rules' => 'required'
            ),
            array(
                'field' => 'uri_path',
                'label' => 'SEO URL',
                'rules' => 'required'
            ),
            // array(
				// 'field' => 'primary_image',
                // 'label' => 'Image File',
                // 'rules' => 'required'
			// )

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

            if(!$id){
                if (!check_exist_uri('bank_image',$post['uri_path'])) {
                    $this->error = 'SEO URL is already used.';
                }
            }
        }
    }
}