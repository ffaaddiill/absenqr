<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Package_group Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Package_group Controller
 * 
 */
class Package_group extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Package_group_model');
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
            $count_all_records = $this->Package_group_model->CountAllRecord();
            $count_filtered_records = $this->Package_group_model->CountAllRecord($param);
            $records = $this->Package_group_model->GetAllRecordData($param);
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
                $return['data'][$row]['package_name'] = $record['package_name'];
                $return['data'][$row]['position'] = $record['position'];
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
        $this->data['main_packages'] = $this->Package_group_model->GetPackages();
        $this->data['addon_packages'] = $this->Package_group_model->GetAddonPackages();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['is_featured'] = (isset($post['is_featured'])) ? 1 : 0;
                $post['is_soldout'] = (isset($post['is_soldout'])) ? 1 : 0;
                $post_packages = $post['packages'];
                $post_addon_packages = $post['addon_packages'];

                unset($post['packages']);
                unset($post['addon_packages']);
                
                // insert data
                $id = $this->Package_group_model->InsertRecord($post);
                
                // input main package
                $package_array = array();
                foreach ($post_packages as $row => $package) {
                    $package_array[] = array(
                        'id_package'=>$package['id_package'],
                        'id_package_group'=>$id,
                        'type'=>1
                    );
                }
                if ($package_array) {
                    $this->Package_group_model->InsertPackageBatch($package_array);
                    $post['packages'] = $post_packages;
                }

                // input addon package
                $addon_package_array = array();
                if($post_addon_packages){
                  foreach ($post_addon_packages as $row => $addon) {
                        $addon_package_array[] = array(
                            'id_package'=>$addon['id_package_addon'],
                            'id_package_group'=>$id,
                            'type'=>2
                        );
                    }
                    if ($package_array) {
                        $this->Package_group_model->InsertPackageBatch($addon_package_array);
                        $post['addon_packages'] = $post_packages;
                    }  
                }
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Package_group',
                    'desc' => 'Add Package_group; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Package_group_model->GetRecord($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['main_packages'] = $this->Package_group_model->GetPackages();
        $this->data['addon_packages'] = $this->Package_group_model->GetAddonPackages();
        // echo '<pre>';
        // print_r($record);
        // die();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['is_featured'] = (isset($post['is_featured'])) ? 1 : 0;
                $post['is_soldout'] = (isset($post['is_soldout'])) ? 1 : 0;
                $post_packages = $post['packages'];
                $post_addon_packages = $post['addon_packages'];
                
                unset($post['packages']);
                unset($post['addon_packages']);
                
                // update data
                $this->Package_group_model->UpdateRecord($id,$post);
                // purge data before new insert
                $this->Package_group_model->DeletePackageGroupItem($id);
                // input main package
                $package_array = array();
                foreach ($post_packages as $row => $package) {
                    $package_array[] = array(
                        'id_package'=>$package['id_package'],
                        'id_package_group'=>$id,
                        'type'=>1
                    );
                }
                if ($package_array) {
                    $this->Package_group_model->InsertPackageBatch($package_array);
                    $post['packages'] = $post_packages;
                }
                
                // input addon package
                $addon_package_array = array();
                if($post_addon_packages){
                  foreach ($post_addon_packages as $row => $addon) {
                        $addon_package_array[] = array(
                            'id_package'=>$addon['id_package_addon'],
                            'id_package_group'=>$id,
                            'type'=>2
                        );
                    }
                    if ($package_array) {
                        $this->Package_group_model->InsertPackageBatch($addon_package_array);
                        $post['addon_packages'] = $post_packages;
                    }  
                }

                
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Package_group',
                    'desc' => 'Edit Package_group; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Package_group_model->GetRecord($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'movie/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'movie/'.$record['thumbnail_image']);
                            }
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'movie/'.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.'movie/'.$record['primary_image']);
                            }*/
                            $this->Package_group_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Package_group',
                                'desc' => 'Delete Package_group; ID: '.$id.';',
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
                'field' => 'package_name',
                'label' => 'Package_group Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'uri_path',
                'label' => 'SEO URL',
                'rules' => 'required'
            ),
            array(
                'field' => 'price',
                'label' => 'Price (IDR',
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