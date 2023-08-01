<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Report_ppn Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Report_ppn Controller
 * 
 */

class Report_ppn extends CI_Controller {
	private $class_path_name;
    private $error;
    
    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        
        $this->class_path_name = $this->router->fetch_class();
    }


    public function index(){
    	$this->data['url_data'] = site_url($this->class_path_name.'/list_data');
    	$this->data['export_excel'] = site_url($this->class_path_name.'/export');
    	$this->data['page'] = 0;
    }

    public function list_data(){
    	$alias['search_vendor'] = "name";
        $alias['search_npwp'] = "npwp";
        $alias['search_bd_number'] = "bd_number";
        $alias['search_original_amount'] = "dpp";
        $alias['search_idr_amount'] = "jumlah_ppn";
        
        #$alias['search_bd_number'] = "a.bd_number";
        
    	$query = "
            select 
                *              
            from " . $this->db->dbprefix('view_ppn') . " 

            where bd_number != 0";

        
        $group_by = ""; 
        
        $this->data = query_grid($query, $alias,$group_by);
        
        
        $this->data['paging'] = paging($this->data['total'],3);
    }
    private function export_to_csv( $post = array() ){
    	$this->load->model('Bd_form_model');
        //$this->layout = 'none';
        $post = $post;

        $record = $this->Bd_form_model->GetReportPPn($post);
        // debugvar($record);
        // die();
        if(empty($record)){
            $this->session->set_flashdata('flash_message', alert_box('Tidak Ada Data','danger'));
            redirect('report_ppn');
        }
        $file_name = 'IMPORT_TO_SYSTEM_'.date('Y_m_d');
        if($record){
            $no = 0;
            foreach ($record as $key => $value) {
                $no++;
                $masa_pajak = date('m',strtotime($value['document_tax_date']));
                $tahun_pajak = date('Y',strtotime($value['document_tax_date']));
                $list[] = array(
                    'no'=>$no,
                    'no_dokumen_lain'=>$value['no_doc_tax'],
                    'tanggal_dokumen_lain'=>indonesia_time_format($value['document_tax_date']),
                    'masa_pajak'=>$masa_pajak,
                    'tahun_pajak'=>$tahun_pajak,
                    'npwp'=>$value['npwp'],
                    'nama'=>$value['name'],
                    'alamat_faktur_pajak'=>$value['alamat'],
                    'jumlah_dpp'=>$value['dpp'],
                    'jumlah'=>$value['jumlah_ppn'],
                    
                    );
            }
            
        }
        // echo '<pre>';
        // print_r($list);
        // die();
        $this->data = array(
            'list'=>$list,
        );
       
        $ouput_file_name = $file_name.'.xls';
        
        $this->load->library('parser');
        $this->parser->parse(TEMPLATE_DIR.'/'.$this->class_path_name.'/excel.html', $this->data);
        export_excel($ouput_file_name);
    }
    public function export(){
    	$this->layout = 'none';
    	$post = $this->input->post();
    	if($post['type_export']==1){ // to excel
    		$this->export_to_excel($post);
    	}else if($post['type_export']==2){
    		$this->export_to_csv($post);
    	}
    }
    private function export_to_excel($post=array()){
    	$this->load->model('Bd_form_model');
        //$this->layout = 'none';
        $post = $post;

        $record = $this->Bd_form_model->GetReportPPn($post);
        // debugvar($record);
        // die();
        if(empty($record)){
            $this->session->set_flashdata('flash_message', alert_box('Tidak Ada Data','danger'));
            redirect('report_ppn');
        }
        $file_name = 'IMPORT_TO_SYSTEM_'.date('Y_m_d');
        if($record){
            $no = 0;
            foreach ($record as $key => $value) {
                $no++;
                $masa_pajak = date('m',strtotime($value['document_tax_date']));
                $tahun_pajak = date('Y',strtotime($value['document_tax_date']));
                $list[] = array(
                    'no'=>$no,
                    'no_dokumen_lain'=>$value['no_doc_tax'],
                    'tanggal_dokumen_lain'=>indonesia_time_format($value['document_tax_date']),
                    'masa_pajak'=>$masa_pajak,
                    'tahun_pajak'=>$tahun_pajak,
                    'npwp'=>$value['npwp'],
                    'nama'=>$value['name'],
                    'alamat_faktur_pajak'=>$value['alamat'],
                    'jumlah_dpp'=>$value['dpp'],
                    'jumlah'=>$value['jumlah_ppn'],
                    
                    );
            }
            
        }
        // echo '<pre>';
        // print_r($list);
        // die();
        $this->data = array(
            'list'=>$list,
        );
       
        $ouput_file_name = $file_name.'.xls';
        
        $this->load->library('parser');
        $this->parser->parse(TEMPLATE_DIR.'/'.$this->class_path_name.'/excel.html', $this->data);
        export_excel($ouput_file_name);
        
    }
}