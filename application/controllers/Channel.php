<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Channel Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Channel Controller
 * 
 */
class Channel extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Channel_model');
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
            $count_all_records = $this->Channel_model->CountAllRecord();
            $count_filtered_records = $this->Channel_model->CountAllRecord($param);
            $records = $this->Channel_model->GetAllRecordData($param);
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
                $return['data'][$row]['name'] = $record['name'];
                $return['data'][$row]['is_hd'] = ($record['is_hd'] == 1) ? 'HD' : 'Not HD';
               # $return['data'][$row]['channel_number'] = $record['channel_number'];
                $return['data'][$row]['create_date'] = custDateFormat($record['create_date'],'d M Y H:i:s');
                
            }

            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }


    public function add_category(){
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = array();
            $post = $this->input->post();
            if($post['category_name']){
                $data_post = array(
                    'category_name'=>$post['category_name'],
                    'colour'=>$post['color'],
                    'position'=>$post['position']
                    );
                $id = $this->Channel_model->InsertCategory($data_post);
                if($id){
                     $json['success'] = alert_box('Data Category has been save','success');
                     $json['html'] = $this->get_category_channel($id);
                }else{
                    $json['error'] = alert_box('Failed save category. Please try again.','danger');
                    $json['html'] = $this->get_category_channel();
                    break;
                     
                }
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
    /**
     * get option select category
     * @param id insert_id
     * @return html
     */
    function get_category_channel($id){
        $list_category =  $this->Channel_model->GetChannelCategoryList();
        $div = '';
        foreach ($list_category as $key => $value) {
            $selected = '';
            if($id == $value->id_channel_category){
                $selected = 'selected="selected"';
            }
            $div .= '<option '.$selected.' value="'.$value->id_channel_category.'">'.$value->category_name.'</option>';
            
        }
        
        return $div;
    }
    /**
     * add page
     */
    public function add() {
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['form_action_add_group'] = site_url($this->class_path_name.'/add_category');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['category_channel'] = $this->Channel_model->GetChannelCategoryList();
        $this->data['list_package'] = $this->Channel_model->GetPackageList();
        $this->data['list_package_addon'] = $this->Channel_model->GetPackageAddonList();
        // echo '<pre>';
        // print_r($this->data['list_package_addon']);
        // die();
        if ($this->input->post()) {
            $post = $this->input->post();
            
            if ($this->validateForm()) {
                $post['is_hd'] = (isset($post['is_hd'])) ? 1 : 0;
                $post['is_exclusive'] = (isset($post['is_exclusive'])) ? 1 : 0;
                $post['is_free'] = (isset($post['is_free'])) ? 1 : 0;
                if(isset($post['addon'])){
                    $post_addon = $post['addon'];
                }
                if(isset($post['package'])){
                    $post_package = $post['package'];
                }
                if(isset($post['channel_number'])){
                    $post_channel_number = $post['channel_number'];
                }
                unset($post['package']);
                unset($post['addon']);
                unset($post['channel_number']);
                
                
                // insert data
                $id = $this->Channel_model->InsertRecord($post);
                
               if($id){
                    // if question is set/add
                    $channel_number = array();
                    if (isset($post_channel_number) && count($post_channel_number)>0) {
                        $arr_c_number = array();
                        foreach($post_channel_number as $val){

                            if(!isset($arr_c_number[$val])){
                                $arr_c_number[$val]=$val;
                            }
                            
                        }
                        
                        $post_channel_number = array_values($arr_c_number);
                        
                        foreach ($post_channel_number as $number) {
                            $channel_number[] = array(
                                'id_channel'=>$id,
                                'channel_number'=>$number
                                
                            );
                        }
                        
                    }
                    
                    if (count($channel_number)>0) {
                        $this->Channel_model->InsertChannelNumberBatch($channel_number);
                    }
                    // if Channel addon is set/add
                    $channel_addon = array();
                    if (isset($post_addon) && count($post_addon)>0) {
                        foreach ($post_addon as $addon) {
                            $channel_addon[] = array(
                                'id_channel'=>$id,
                                'id_package_addon'=>$addon
                            );
                        }
                    }
                    if (count($channel_addon)>0) {
                        $this->Channel_model->InsertAddOnBatch($channel_addon);
                    } 
                    $channel_package = array();
                    if (isset($post_package) && count($post_package)>0) {
                        foreach ($post_package as $package) {
                            $channel_package[] = array(
                                'id_channel'=>$id,
                                'id_package'=>$package
                            );
                        }
                    }
                    if (count($channel_package)>0) {
                        $this->Channel_model->InsertPackageBatch($channel_package);
                    }  
                    $post_image = $_FILES;
                    if ($post_image['logo_file_name']['tmp_name']) {
                        $filename = url_title($post['name'],'_',true);
                        try {
                            //Upload blob
                            $picture_db = $this->azure->UploadFileToStorage($post_image['logo_file_name'],AZURE_FOLDER_CHANNEL,$filename);
                            $this->Channel_model->UpdateRecord($id,array('logo_file_name'=>$picture_db));
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
                }
                     
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Channel',
                    'desc' => 'Add Channel; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Channel_model->GetRecord($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
         $this->data['form_action_add_group'] = site_url($this->class_path_name.'/add_category');
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['category_channel'] = $this->Channel_model->GetChannelCategoryList();
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['list_package'] = $this->Channel_model->GetPackageList();
        $this->data['list_package_byid'] = array_column($this->Channel_model->GetPackageListByID($id), 'id_package');
       
        $this->data['list_package_addon'] = $this->Channel_model->GetPackageAddonList();
        $this->data['list_package_addonbyid'] = array_column($this->Channel_model->GetPackageAddonListByID($id),'id_package_addon');
        // echo '<pre>';
        //  exit(print_R($record['channel_number']));

        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            
            if ($this->validateForm($id)) {
                $post['is_hd'] = (isset($post['is_hd'])) ? 1 : 0;
                $post['is_free'] = (isset($post['is_free'])) ? 1 : 0;
                $post['is_exclusive'] = (isset($post['is_exclusive'])) ? 1 : 0;
                $post_addon = $post['addon'];
                $post_package = $post['package'];
                if(isset($post['channel_number'])){
                    $post_channel_number = $post['channel_number'];
                }
                unset($post['channel_number']);
                // update data
                
                
               $this->Channel_model->UpdateRecord($id,$post);
                    $channel_number = array();
                    if (isset($post_channel_number) && count($post_channel_number)>0) {
                        $arr_c_number = array();
                        foreach($post_channel_number as $val){

                            if(!isset($arr_c_number[$val])){
                                $arr_c_number[$val]=$val;
                            }
                            
                        }
                        
                        $post_channel_number = array_values($arr_c_number);
                        
                        foreach ($post_channel_number as $number) {
                            $channel_number[] = array(
                                'id_channel'=>$id,
                                'channel_number'=>$number
                                
                            );
                        }
                        
                    }
                    $this->Channel_model->DeleteChannelNumber($id);
                    if (count($channel_number)>0) {
                        
                        $this->Channel_model->InsertChannelNumberBatch($channel_number);
                    }
                  // if question is set/add
                    $channel_addon = array();
                    if (isset($post_addon) && count($post_addon)>0) {
                        foreach ($post_addon as $addon) {
                            $channel_addon[] = array(
                                'id_channel'=>$id,
                                'id_package_addon'=>$addon
                            );
                        }
                    }
                    $this->Channel_model->DeleteChannelAddon($id);
                    if (count($channel_addon)>0) {
                        
                        $this->Channel_model->InsertAddOnBatch($channel_addon);
                    } 
                    $channel_package = array();
                    if (isset($post['package']) && count($post['package'])>0) {
                        foreach ($post_package as $package) {
                            $channel_package[] = array(
                                'id_channel'=>$id,
                                'id_package'=>$package
                            );
                        }
                    }
                    $this->Channel_model->DeleteChannelPackage($id);
                    if (count($channel_package)>0) {
                        
                        $this->Channel_model->InsertPackageBatch($channel_package);
                    }  
                    $post_image = $_FILES;
                    if ($post_image['logo_file_name']['tmp_name']) {
                        $filename = url_title($post['name'],'_',true);
                        try {
                            //Upload blob
                            $picture_db = $this->azure->UploadFileToStorage($post_image['logo_file_name'],AZURE_FOLDER_CHANNEL,$filename);
                            $this->Channel_model->UpdateRecord($id,array('logo_file_name'=>$picture_db));
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
                     
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Channel',
                    'desc' => 'Add Channel; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name);
            }
            $this->data['post'] = $post;
        }
        if(empty($record['uri_path']) && $record['uri_path']==''){
           $record['uri_path'] = str_replace(' ', '-', strtolower($record['name'])); 
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
                        $record = $this->Channel_model->GetRecord($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'movie/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'movie/'.$record['thumbnail_image']);
                            }
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'movie/'.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.'movie/'.$record['primary_image']);
                            }*/
                            $this->Channel_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Channel',
                                'desc' => 'Delete Channel; ID: '.$id.';',
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
                $detail = $this->Channel_model->GetRecord($post['id']);
                if ($detail && ($detail['logo_file_name'] != '')) {
                    $id = $post['id'];
                    //unlink(UPLOAD_DIR.'movie/'.$detail[$type.'_image']);
                    if ($this->azure->DeleteBlob(AZURE_FOLDER_CHANNEL,$detail['logo_file_name'] == TRUE)) {
                        $data_update = array('logo_file_name' =>'');
                        $this->Channel_model->UpdateRecord($post['id'],$data_update);
                        $json['success'] = alert_box('File hase been deleted.','success');
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'Channel',
                            'desc' => 'Delete '.ucfirst($type).' Picture Channel; ID: '.$id.';',
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
                'field' => 'name',
                'label' => 'Channel Name',
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
            if (!$id) {
                if (!isset($post['channel_number']) || count($post['channel_number'])==0) {
                    $this->error = 'Please Add Channel Number.';
                } else {
                    foreach ($post['channel_number'] as $question) {
                        if ($question == '') {
                            $this->error = 'Please input Channel Number.';
                            break;
                        }
                    }
                }
            }else{
                    foreach ($post['channel_number'] as $question) {
                        if ($question == '') {
                            $this->error = 'Please input Channel Number.';
                            break;
                        }
                    }
            }
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
    

    public function list_group(){
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
            $count_all_records = $this->Channel_model->CountAllRecordGroup();
            $count_filtered_records = $this->Channel_model->CountAllRecordGroup($param);
            $records = $this->Channel_model->GetAllRecordDataGroup($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit_group/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['category_name'] = $record['category_name'];
               
                $return['data'][$row]['create_date'] = custDateFormat($record['create_date'],'d M Y H:i:s');
                
            }

            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name.'/group');
    }

    public function group(){
        $this->data['add_url'] = site_url($this->class_path_name.'/add_group');
        $this->data['url_data'] = site_url($this->class_path_name.'/list_group');
        $this->data['url_delete'] = site_url($this->class_path_name.'/delete_group');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
    /**
     * add page
     */
    public function add_group() {
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add_group');
        $this->data['cancel_url'] = site_url($this->class_path_name.'/group');
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateFormGroup()) {
                
                
                
                // insert data
                $id = $this->Channel_model->InsertRecordGroup($post);
                
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Channel Group',
                    'desc' => 'Add Channel Group; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name.'/group');
            }
            $this->data['post'] = $post;
        }
        $this->data['template'] = $this->class_path_name.'/form_group';
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }

    /**
     * detail page
     * @param int $id
     */
    public function edit_group($id=0) {
        if (!$id) {
            redirect($this->class_path_name.'/group');
        }
        $record = $this->Channel_model->GetRecordGroup($id);
        if (!$record) {
             redirect($this->class_path_name.'/group');
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit_group/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name.'/group');
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateFormGroup($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                
                
                // update data
                $this->Channel_model->UpdateRecordGroup($id,$post);
                
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Channel Group',
                    'desc' => 'Edit Channel Group; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name.'/group');
            }
        }
        $this->data['template'] = $this->class_path_name.'/form_group';
        $this->data['post'] = $record;
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }
    /**
     * delete page
     */
    public function delete_group() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $json = array();
            if ($post['ids'] != '') {
                $array_id = array_map('trim', explode(',', $post['ids']));
                if (count($array_id)>0) {
                    foreach ($array_id as $row => $id) {
                        $record = $this->Channel_model->GetRecordGroup($id);
                        if ($record) {
                           
                            $this->Channel_model->DeleteRecordGroup($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Channel_group',
                                'desc' => 'Delete Channel_group; ID: '.$id.';',
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
        redirect($this->class_path_name.'/group');
    }
    /**
     * validate form
     * @param int $id
     * @return boolean
     */
    private function validateFormGroup($id=0) {
        $post = $this->input->post();
        
        $config = array(
            array(
                'field' => 'category_name',
                'label' => 'Channel Group Name',
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