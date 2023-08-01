<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Qrcodegen Class
 * @author Fadilah Ajiq Surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Qrcodegen Controller
 * 
 */

class Qrcodegen extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Qrcode_model');
        $this->load->library('ciqrcode');
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
            $count_all_records = $this->Qrcode_model->CountAllQrcode();
            $count_filtered_records = $this->Qrcode_model->CountAllQrcode($param);
            $records = $this->Qrcode_model->GetAllQrcodeData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id_qrcode'];
                $return['data'][$row]['actions'] = '<a href="'.site_url($this->class_path_name.'/edit/'.$record['id_qrcode']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                $return['data'][$row]['title'] = $record['title'];
                $return['data'][$row]['value'] = $record['value'];
				$return['data'][$row]['primary_image'] = base_url().'assets'.'/'.TEMPLATE_DIR.'/'.$record['primary_image'];
                $return['data'][$row]['image_link'] = '<center><a href="'.base_url().'assets'.'/'.TEMPLATE_DIR.'/'.$record['primary_image'].'"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></center>';
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
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                $id = $this->Qrcode_model->InsertRecord($post);
                $record = $this->Qrcode_model->GetQrcode($id);

                $created_date = date('Y-m-d_H-i-s', strtotime($record['create_date']));

                $qrconfig['cacheable']    = true; //boolean, the default is true
                $qrconfig['cachedir']     = ''; //string, the default is application/cache/
                $qrconfig['errorlog']     = ''; //string, the default is application/logs/
                $qrconfig['imagedir']     = 'img/qr/'; //direktori penyimpanan qr code
                $qrconfig['quality']      = true; //boolean, the default is true
                $qrconfig['size']         = '1024'; //interger, the default is 1024
                $qrconfig['black']        = array(224,255,255); // array, default is array(255,255,255)
                $qrconfig['white']        = array(70,130,180); // array, default is array(0,0,0)
                $this->ciqrcode->initialize($qrconfig);
                $qrimage = 'qrikkousha.png';

                $param['data'] = $record['value'];
                $param['level'] = 'H';
                $param['size'] = 10;
                $param['savename'] = FCPATH.'assets/'.TEMPLATE_DIR.'/'.$qrconfig['imagedir'].$qrimage;
                $this->ciqrcode->generate($param); // panggil function untuk generate QRCode

                // update data
                $img_arr = array('primary_image' => $qrconfig['imagedir'].$qrimage);
                $status = $this->Qrcode_model->UpdateRecord($id, $img_arr);

                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Qrcodegen',
                    'desc' => 'Add  Qrcodegen; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Qrcode_model->GetQrcode($id);
        
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
        //$this->data['pph_type']     = $this->Qrcode_model->GetPPH();
        if ($this->input->post()) {
            $post = $this->input->post();

            if ($this->validateForm($id)) {

                $this->Qrcode_model->UpdateRecord($id,$post);

                $created_date = date('Y-m-d_H-i-s', strtotime($record['create_date']));
                
                $qrconfig['cacheable']    = true; //boolean, the default is true
                $qrconfig['cachedir']     = ''; //string, the default is application/cache/
                $qrconfig['errorlog']     = ''; //string, the default is application/logs/
                $qrconfig['imagedir']     = 'img/qr/'; //direktori penyimpanan qr code
                $qrconfig['quality']      = true; //boolean, the default is true
                $qrconfig['size']         = '1024'; //interger, the default is 1024
                $qrconfig['black']        = array(224,255,255); // array, default is array(255,255,255)
                $qrconfig['white']        = array(70,130,180); // array, default is array(0,0,0)
                $this->ciqrcode->initialize($qrconfig);
                $qrimage = 'qrikkousha.png';

                $param['data'] = $record['value'];
                $param['level'] = 'H';
                $param['size'] = 10;
                $param['savename'] = FCPATH.'assets/'.TEMPLATE_DIR.'/'.$qrconfig['imagedir'].$qrimage;
                $this->ciqrcode->generate($param); // panggil function untuk generate QRCode

                // update data
                $img_arr = array('primary_image' => $qrconfig['imagedir'].$qrimage);
                $status = $this->Qrcode_model->UpdateRecord($id, $img_arr);

                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Qrcodegen',
                    'desc' => 'Edit Qrcodegen; ID: '.$id.'; Data: '.json_encode($post),
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
                $id= $post['ids'];
                $record = $this->Qrcode_model->GetQrcode($id);
                if ($record) {
                        $this->Qrcode_model->DeleteRecord($id);
                        if ( unlink(FCPATH.'assets/'.TEMPLATE_DIR.'/'.$record['primary_image']) ) {
                            $json['success'] = alert_box('Qrcode has been deleted.','success');
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Qrcodegen',
                                'desc' => 'Delete Qrcode Image; ID: '.$id.';',
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
                            'action' => 'User Qrcodegen',
                            'desc' => 'Delete  Qrcodegen; ID: '.$id.';',
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
                $detail = $this->Qrcode_model->GetQrcode($post['id']);
                $type = (isset($post['type'])) ? $post['type'] : 'primary';
                if ($detail && ($detail[$type.'_image'] != '')) {
                    $id = $post['id'];
                    //unlink(UPLOAD_DIR.'news/'.$detail[$type.'_image']);
                    if (unlink(UPLOAD_DIR.$detail[$type.'_image'])) {
                        $data_update = array($type.'_image' =>'');
                        $this->Qrcode_model->UpdateRecord($post['id'],$data_update);
                        $json['success'] = alert_box('File has been deleted.','success');
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'Qrcodegen',
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
                if (!check_exist_uri('Qrcodegen',$post['uri_path'])) {
                    $this->error = 'SEO URL is already used.';
                }
            }
        }
    }
}