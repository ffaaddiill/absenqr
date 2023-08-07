<?php
require_once APPPATH . 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Murid Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Murid Controller
 * 
 */
class Murid extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Murid_model');
        $this->load->model('Tahun_ajaran_model');
        $this->load->model('Kelas_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index($slug='') {
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        $this->data['add_batch_url'] = site_url($this->class_path_name.'/add_batch');
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data/'.$slug);
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
    
    /**
     * list data
     */
    public function list_data($slug='') {
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

            //die($slug);
            if(!empty($slug) && strtolower($slug) != 'add' && strtolower($slug) != 'edit') {
                $param['slug'] = $slug;
            }
            $count_all_records = $this->Murid_model->CountAllMurid();
            $count_filtered_records = $this->Murid_model->CountAllMurid($param);
            $records = $this->Murid_model->GetAllMuridData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id_murid'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id_murid']).'"><span class="fa fa-edit" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['nama_murid'] = $record['nama_murid'];
                $return['data'][$row]['nis'] = $record['nis'];
                $return['data'][$row]['nama_kelas'] = $record['nama_kelas'];
                $return['data'][$row]['jenis_kelamin'] = $record['jenis_kelamin'];
                $return['data'][$row]['id_status'] = ($record['id_status'] == 1) ? 'Active' : 'Not Active';
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

        $slug = $this->uri->segment(3);
            //die($slug);
        if(!empty($slug) && strtolower($slug) != 'add' && strtolower($slug) != 'edit') {
            $param['slug'] = $slug;
        }

        /*
        $this->data['sites'] = get_sites();
        $this->data['list_product'] = $this->Murid_model->getActiveProduct();
        $this->data['product_slideshow'] = $this->Murid_model->getMuridProduct( $this->uri->segment(3) );*/

        if ($this->input->post()) {
            $post = $this->input->post();

            if ($this->validateForm()) {
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;

                // insert data
                $id = $this->Murid_model->InsertRecord($post);

               /* if($id){
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
                        $this->Murid_model->InsertSitesBatch($sites);
                    }
                }*/
                

                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($post['title'],'_',true);
                    
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.$this->class_path_name.'/', $filename);
                    $this->Murid_model->UpdateRecord($id,array('primary_image'=>$this->class_path_name.'/'.$picture_db,'picture_file_name'=>$picture_db));
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Murid',
                    'desc' => 'Add Murid; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name);
            }
            $this->data['class_path_name'] = $this->class_path_name;
            $this->data['post'] = $post;
        }
        $this->data['tahun_ajaran'] = $this->Tahun_ajaran_model->GetAllTahun_ajaranData();
        $this->data['kelas'] = $this->Kelas_model->GetAllKelasData();

        $this->data['template'] = $this->class_path_name.'/form';
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }

    public function add_batch() {
        $this->data['page_title'] = 'Add Excel/CSV File to Upload';
        $this->data['form_action'] = site_url($this->class_path_name.'/add_batch_generate_summary');
        $this->data['cancel_url'] = site_url($this->class_path_name);

        $this->data['template'] = $this->class_path_name.'/form_upload_batch';
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }

    public function add_batch_generate_summary() {
        $this->layout = 'none';
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     
        if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
         
            $arr_file = explode('.', $_FILES['file']['name']);
            $extension = end($arr_file);
         
            if('csv' == $extension) {
                $reader = new Csv();
            } else {
                $reader = new Xlsx();
            }
     
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            // debugvar($sheetData);
            // die();

            $data_arr = array();

            if (!empty($sheetData)) {
                for ($i=2; $i<count($sheetData); $i++) {
                    $data_arr[] = array(
                        'nama_murid' => $sheetData[$i][0],
                        'nis' => $sheetData[$i][1],
                        'kelas' => generate_slug($sheetData[$i][2]),
                        'tahun_ajaran' => $sheetData[$i][3],
                        'jenis_kelamin' => strtoupper($sheetData[$i][4])
                    );
                }
            }

            // debugvar($data_arr);
            // die();

            $return_insert = $this->Murid_model->InsertMuridBatch($data_arr);

            $writeSpreadSheet = new Spreadsheet();
            $header_arr = array(
                'Nama', 
                'NIS',
                'Kelas',
                'Tahun Ajaran',
                'L/P'
            );

            $sheet = $writeSpreadSheet->getActiveSheet()
                    ->fromArray(
                        $return_insert,
                        NULL,
                        'A2'
                    );

            for($i = 1; $i<=$sheet->getHighestRow(); $i++) {
                $cellValue = $sheet->getCell('B'.$i)->getValue();
                $sheet->setCellValueExplicit('B'.$i, $cellValue, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }

            $idx = 0;
            for($i='A'; $i<=$sheet->getHighestColumn(); $i++) {
                $sheet->setCellValue($i.'1', $header_arr[$idx]);
                $sheet->getColumnDimension($i)->setAutoSize(TRUE);
                $sheet->getStyle($i.'1')->getFont()->setBold(true);
                $idx++;
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($writeSpreadSheet);
            $filename = 'summary-batch-data-'.date("d-m-Y").'-'.strtotime(date("d-m-Y H:i:s"));
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
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
        $record = $this->Murid_model->GetMurid($id);
        $this->data['tahun_ajaran'] = $this->Tahun_ajaran_model->GetAllTahun_ajaranData();
        $this->data['kelas'] = $this->Kelas_model->GetAllKelasData();
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);

        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modified_date'] = date('Y-m-d H:i:s');
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                /*$id_site = $post['id_site'];
                unset($post['id_site']);*/
                
                // update data
                /*echo '<pre>';
                print_r($post);
                echo '<br>';
                print_r($_FILES);
                echo '</pre>';
                die();*/
                $this->Murid_model->UpdateRecord($id,$post);

                /*$sites = array();
                if (isset($id_site) && count($id_site)>0) {
                    foreach ($id_site as $site) {
                        $sites[] = array(
                            'id_slideshow'=>$id,
                            'id_site'=>$site
                        );
                    }
                }*/
                /*if (count($sites)>0) {
                    $this->Murid_model->DeleteSite($id);
                    $this->Murid_model->InsertSitesBatch($sites);
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
                    $this->Murid_model->UpdateRecord($id,array('primary_image'=>$this->class_path_name.'/'.$picture_db,'picture_file_name'=>$picture_db));
                     
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Murid',
                    'desc' => 'Edit Murid; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name);
            }
        }
        $this->data['class_path_name'] = $this->class_path_name;
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
                        $record = $this->Murid_model->GetMurid($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'slideshow_product/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'slideshow_product/'.$record['thumbnail_image']);
                            }*/
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.$record['primary_image']);
                            }
                            $this->Murid_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Murid',
                                'desc' => 'Delete Murid; ID: '.$id.';',
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
            if (isset($post['id_murid']) && $post['id_murid'] > 0 && ctype_digit($post['id_murid'])) {
                $id = $post['id_murid'];
                $record = $this->Murid_model->GetMurid($id);
                if ($record && $record['primary_image'] != '') {
                    unlink(UPLOAD_DIR.$record['primary_image']);
                    $this->Murid_model->delete_picture($id);
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
                'field' => 'nama_murid',
                'label' => 'Nama Murid',
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

    public function tesf() {
        $this->layout = 'none';
        $data = $this->db
                ->select('menu')
                ->where('parent_auth_menu', 84)
                ->get('auth_menu')
                ->num_rows();

        print_r($data);
    }
}
/* End of file Murid.php */
/* Location: ./application/controllers/Murid.php */