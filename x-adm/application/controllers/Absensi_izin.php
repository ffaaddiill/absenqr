<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Absensi_izin Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Absensi_izin Controller
 * 
 */
class Absensi_izin extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Absensi_izin_model');
        $this->load->model('Murid_model');
        $this->load->model('Kelas_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data/');
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

            //die($slug);
            if(!empty($slug) && strtolower($slug) != 'add' && strtolower($slug) != 'edit') {
                $param['slug'] = $slug;
            }
            $count_all_records = $this->Absensi_izin_model->CountAllAbsensi_izin();
            $count_filtered_records = $this->Absensi_izin_model->CountAllAbsensi_izin($param);
            $records = $this->Absensi_izin_model->GetAllAbsensi_izinData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id_absensi_izin'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id_absensi_izin']).'"><span class="fa fa-edit" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['nama_murid'] = $record['nama_murid'];
                $return['data'][$row]['nis'] = $record['nis'];
                $return['data'][$row]['nama_kelas'] = $record['nama_kelas'];
                $return['data'][$row]['kategori_izin'] = $record['kategori_izin'];
                $return['data'][$row]['tanggal_izin_start'] = $record['tanggal_izin_start'];
                $return['data'][$row]['tanggal_izin_end'] = $record['tanggal_izin_end'];
                $return['data'][$row]['created_date'] = date('d-m-Y H:i:s', strtotime($record['created_date']));
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
    public function add($userid=NULL) {
        if(empty($userid)) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add/'.$userid);
        $this->data['cancel_url'] = site_url('murid/view/'.$userid);

        $murid = $this->Murid_model->GetMurid($userid);
        $kategori_izin = $this->Absensi_izin_model->getKategoriIzin();

        $this->data['post'] = $murid;
        $this->data['kategori_izin'] = $kategori_izin;

        if ($this->input->post()) {
            $post = $this->input->post();

            $insert_post = array(
                'nis'=>$post['nis'],
                'kategori_izin'=>$post['kategori_izin'],
                'tanggal_izin_start'=>date('Y-m-d H:i:s', strtotime($post['tanggal_izin_start'])),
                'tanggal_izin_end'=>date('Y-m-d H:i:s', strtotime($post['tanggal_izin_end'])),
                'keterangan'=>$post['keterangan']
            );

            if ($this->validateForm()) {
                // insert data
                $id = $this->Absensi_izin_model->InsertRecord($insert_post);

                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Absensi_izin',
                    'desc' => 'Add Absensi_izin; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect(site_url('murid/view/'.$userid));
            }
            $this->data['class_path_name'] = $this->class_path_name;
            $this->data['post'] = $post;
        }

        $this->data['kelas'] = $this->Kelas_model->GetAllKelasData();

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
        $record = $this->Absensi_izin_model->GetAbsensi_izin($id);
        $record['tanggal_izin_start'] = date("d-m-Y H:i:s", strtotime($record['tanggal_izin_start']));
        $record['tanggal_izin_end'] = date("d-m-Y H:i:s", strtotime($record['tanggal_izin_end']));
        $kategori_izin = $this->Absensi_izin_model->getKategoriIzin();

        $this->data['kategori_izin'] = $kategori_izin;
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
                $post['tanggal_izin_start'] = date('Y-m-d H:i:s', strtotime($post['tanggal_izin_start']));
                $post['tanggal_izin_end'] = date('Y-m-d H:i:s', strtotime($post['tanggal_izin_end']));

                $this->Absensi_izin_model->UpdateRecord($id,$post);

                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Absensi_izin',
                    'desc' => 'Edit Absensi_izin; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Absensi_izin_model->GetAbsensi_izin($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'slideshow_product/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'slideshow_product/'.$record['thumbnail_image']);
                            }*/
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.$record['primary_image']);
                            }
                            $this->Absensi_izin_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Absensi_izin',
                                'desc' => 'Delete Absensi_izin; ID: '.$id.';',
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
            if (isset($post['id_absensi_izin']) && $post['id_absensi_izin'] > 0 && ctype_digit($post['id_absensi_izin'])) {
                $id = $post['id_absensi_izin'];
                $record = $this->Absensi_izin_model->GetAbsensi_izin($id);
                if ($record && $record['primary_image'] != '') {
                    unlink(UPLOAD_DIR.$record['primary_image']);
                    $this->Absensi_izin_model->delete_picture($id);
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
                'field' => 'kategori_izin',
                'label' => 'Kategori Izin',
                'rules' => 'required'
            ),
            array(
                'field' => 'tanggal_izin_start',
                'label' => 'Tanggal mulai izin',
                'rules' => 'required'
            ),
            array(
                'field' => 'tanggal_izin_end',
                'label' => 'Tanggal berakhir izin',
                'rules' => 'required'
            ),
            array(
                'field' => 'nis',
                'label' => 'Nomor Induk Siswa',
                'rules' => 'required'
            )
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
/* End of file Absensi_izin.php */
/* Location: ./application/controllers/Absensi_izin.php */