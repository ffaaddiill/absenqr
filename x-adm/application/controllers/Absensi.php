<?php
require_once APPPATH . 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Absensi Class
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Absensi Controller
 * 
 */
class Absensi extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Absensi_model');
        $this->load->model('Murid_model');
        $this->load->model('Kelas_model');
        $this->load->model('Tahun_ajaran_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index($kelas='') {
        $this->data['class_name'] = $this->class_path_name;
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data/'.$kelas);
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }

    public function AbsenExportToExcel() {
        $this->layout = 'none';
        $spreadsheet = new Spreadsheet();
        $sheet = '';
        
        $header_arr = array(
            'No', 
            'NIS',
            'Nama',
            'L / P'
        );

        $date_obj = date_range(date("Y-m-d"), date("Y-m-d", strtotime('+1 month')));

        $date_arr = array();
        foreach ($date_obj as $date) {
            $date_arr[] = ((array)$date->format('d-m-Y'))[0];
        }

        $createCellColumns = createColumnsArray('ZZ');
        $cell_range = array_slice( $createCellColumns, array_search('E', $createCellColumns), (count($date_arr)*2) );

        $kelas_murid = array_reverse($this->Murid_model->GetAllMuridForAbsen(['date_arr'=>$date_arr]));

        $no = 1;
        $noo = $nooo = 0;
        $x = 3;
        $firstCell = $firstCellnd = '';

        $celldate = '';
        
        foreach($kelas_murid as $keyk=>$valk) {
            $x=3;
            $no=1;
            $worksheet = new Worksheet($spreadsheet, $valk['nama_kelas']);

            $spreadsheet->addSheet($worksheet, $keyk);
            $spreadsheet->setActiveSheetIndexByName($valk['nama_kelas']);
            $sheet = $spreadsheet->getActiveSheet();

            $allheader = array_merge($header_arr, $date_arr);
            $sheet->fromArray(
                $allheader,
                NULL,
                'A1'
            );

            foreach ($cell_range as $noo=>$i) {
                if($noo % 2 == 0) {
                    $sheet->setCellValue($i.'1', date("d-m-Y", strtotime($date_arr[($noo/2)])));
                    $sheet->setCellValue($i.'2', 'Masuk');
                } else {
                    $sheet->mergeCells($cell_range[$noo-1].'1'.':'.$i.'1');
                    $sheet->setCellValue($i.'1', date("d-m-Y", strtotime($date_arr[round($noo/2)-1])));
                    $sheet->setCellValue($i.'2', 'Pulang');
                }
            }

            foreach ($valk['murid'] as $muridkey=>$valmurid) {
                $sheet->setCellValue('A'.$x, $no++);
                $sheet->setCellValueExplicit('B'.$x, $valmurid['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('C'.$x, $valmurid['nama_murid']);
                $sheet->setCellValue('D'.$x, ucfirst($valmurid['gender']));
                foreach($valmurid['absen'] as $absenk=>$valabsen) {
                    foreach ($cell_range as $nooo=>$i) {
                        $celldate = $sheet->getCell($i.'1')->getValue();
                        if($nooo % 2 == 0) {
                            if($valabsen['absen_in'] != NULL && !empty($valabsen['absen_in']) && $celldate == date("d-m-Y", $valabsen['absen_in'])) {
                                $sheet->setCellValue($i.$x, date("H:i:s", $valabsen['absen_in']));
                            }
                        } else {
                            if($valabsen['absen_out'] != NULL && !empty($valabsen['absen_out']) && $celldate == date("d-m-Y", $valabsen['absen_out'])) {
                                $sheet->setCellValue($i.$x, date("H:i:s", $valabsen['absen_out']));
                            }
                        }
                    }
                    $nooo++;
                }
                $x++;
            }

            $border = 0;
            for ($i = 'E'; $i!=$sheet->getHighestColumn(); $i++) {
                $sheet->getColumnDimension($i)->setAutoSize(TRUE);
                $spreadsheet->getActiveSheet()->getStyle($i.'2:'.$sheet->getHighestColumn().'2')
                    ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                if($border % 2 != 0) {
                    $spreadsheet->getActiveSheet()->getStyle($i.'1:'.$i.'2')
                    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                }

                $sheet->getStyle('A1:'.$sheet->getHighestColumn().'2')
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ECECEC');
                $border++;
            }

            $spreadsheet->getActiveSheet()->getStyle($sheet->getHighestColumn().'1:'.$sheet->getHighestColumn().'2')
                    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->getColumnDimension('A')->setAutoSize(TRUE);
            $sheet->getColumnDimension('B')->setAutoSize(TRUE);
            $sheet->getColumnDimension('C')->setAutoSize(TRUE);
            $sheet->getColumnDimension('D')->setAutoSize(TRUE);

            $spreadsheet->getActiveSheet()->getStyle('A1:D2')
                ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);    
            $spreadsheet->getActiveSheet()->getStyle('A1:D2')
                ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('D1:D2')
                    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('B1:'.$sheet->getHighestColumn().'2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:'.$sheet->getHighestColumn().'2')->getAlignment()->setVertical('center');
            $sheet->getStyle('D')->getAlignment()->setHorizontal('center');

            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:B2');
            $sheet->mergeCells('C1:C2');
            $sheet->mergeCells('D1:D2');
        }


        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-absensi-siswa-periode-1-bulan-'.date("d-m-Y").'-'.strtotime(date("d-m-Y H:i:s"));
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    
    /**
     * list data
     */
    public function list_data($kelas='') {
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
            if(!empty($kelas)) {
                $param['kelas'] = $kelas;
            }
            $count_all_records = $this->Absensi_model->CountAllAbsensi();
            $count_filtered_records = $this->Absensi_model->CountAllAbsensi($param);
            $records = $this->Absensi_model->GetAllAbsensiData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id_qrabsen'];
                /*$return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id_qrabsen']).'"><span class="fa fa-edit" aria-hidden="true"></span></a>';*/
                $return['data'][$row]['nis'] = $record['nis'];
                $return['data'][$row]['nama_murid'] = $record['nama_murid'];
                $return['data'][$row]['nama_kelas'] = $record['nama_kelas'];
                $return['data'][$row]['absen_in'] = (!empty($record['absen_in']))?date("d-m-Y H:i:s", (int)$record['absen_in']):'-';
                $return['data'][$row]['absen_out'] = (!empty($record['absen_out']))?date("d-m-Y H:i:s", (int)$record['absen_out']):'-';
                $return['data'][$row]['absen_date'] = (!empty($record['absen_date']))?date("d-m-Y", strtotime($record['absen_date'])):'-';
                $return['data'][$row]['created_date'] = (!empty($record['created_date']))?date("d-m-Y H:i:s", strtotime($record['created_date'])):'-';
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
        $this->data['list_product'] = $this->Absensi_model->getActiveProduct();
        $this->data['product_slideshow'] = $this->Absensi_model->getAbsensiProduct( $this->uri->segment(3) );*/

        if ($this->input->post()) {
            $post = $this->input->post();

            if ($this->validateForm()) {
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;

                // insert data
                $id = $this->Absensi_model->InsertRecord($post);

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
                        $this->Absensi_model->InsertSitesBatch($sites);
                    }
                }*/
                

                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($post['title'],'_',true);
                    
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.$this->class_path_name.'/', $filename);
                    $this->Absensi_model->UpdateRecord($id,array('primary_image'=>$this->class_path_name.'/'.$picture_db,'picture_file_name'=>$picture_db));
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Absensi',
                    'desc' => 'Add Absensi; ID: '.$id.'; Data: '.json_encode($post),
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
    
    /**
     * detail page
     * @param int $id
     */
    public function edit($id=0) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Absensi_model->GetAbsensi($id);
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
                $this->Absensi_model->UpdateRecord($id,$post);

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
                    $this->Absensi_model->DeleteSite($id);
                    $this->Absensi_model->InsertSitesBatch($sites);
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
                    $this->Absensi_model->UpdateRecord($id,array('primary_image'=>$this->class_path_name.'/'.$picture_db,'picture_file_name'=>$picture_db));
                     
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Absensi',
                    'desc' => 'Edit Absensi; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Absensi_model->GetAbsensi($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'slideshow_product/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'slideshow_product/'.$record['thumbnail_image']);
                            }*/
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.$record['primary_image']);
                            }
                            $this->Absensi_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Absensi',
                                'desc' => 'Delete Absensi; ID: '.$id.';',
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
            if (isset($post['id_qrabsen']) && $post['id_qrabsen'] > 0 && ctype_digit($post['id_qrabsen'])) {
                $id = $post['id_qrabsen'];
                $record = $this->Absensi_model->GetAbsensi($id);
                if ($record && $record['primary_image'] != '') {
                    unlink(UPLOAD_DIR.$record['primary_image']);
                    $this->Absensi_model->delete_picture($id);
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
                'field' => 'nama_absensi',
                'label' => 'Nama Absensi',
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
/* End of file Absensi.php */
/* Location: ./application/controllers/Absensi.php */