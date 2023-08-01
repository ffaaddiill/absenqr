<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Report_pph Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Report_pph Controller
 * 
 */

class Report_pph extends CI_Controller {
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
    	$alias['search_vendor'] = "vendor_name";
        $alias['search_npwp'] = "npwp";
        $alias['search_bd_number'] = "bd_number";
        $alias['search_original_amount'] = "original_amount";
        $alias['search_idr_amount'] = "idr_amount";
        $alias['search_wht_code'] = "wht_code";
        #$alias['search_bd_number'] = "a.bd_number";
        
    	$query = "
            select 
                id_form_bd_item_pph, 
                id_form_bd,
                id_form_bd_item,
                bd_number as bd_number,
                prefix_vendor,
                name as vendor_name,
                item_name as description,
                round(sum(part_percentage)) as percent_merge,
                round(sum(real_amount_part)) as original_amount, 
                round(sum(amount_part)) as idr_amount,
                percentage as rate_pph,
                sum(amount_part) as pph_amount,
                wht_code as wht_code,
                npwp,
                address_npwp,
                pph_23,
                pph_26,
                pph_21,
                pph_4              
            from " . $this->db->dbprefix('view_pph_all') . " 

            where id_form_bd_item != 0";

        
        $group_by = "id_form_bd_item_pph"; 
        
        $this->data = query_grid($query, $alias,$group_by);
        
        
        $this->data['paging'] = paging($this->data['total'],3);
    }
    private function export_to_csv( $post = array() ){
    	$this->load->model('Bd_form_model');
        //$this->layout = 'none';
        $post = $post;

        $record = $this->Bd_form_model->GetResultReport($post);
        if(empty($record)){
            $this->session->set_flashdata('flash_message', alert_box('Tidak Ada Data','danger'));
            redirect('report_pph');
        }
        if($record){
            $no = 0;
            foreach ($record as $key => $value) {
                $no++;
                $list[] = array(
                    'no'=>$no,
                    'bd_number'=>$value['bd_number'],
                    'vendor_name'=>(isset($value['prefix_vendor']) ? $value['prefix_vendor'].'. ' : '' ).$value['vendor_name'],
                    'description'=>$value['description'],
                    'original_amount'=>number_format($value['original_amount'],0,',','.'),
                    'idr_amount'=>number_format($value['idr_amount'],0,',','.'),
                    'rate_pph'=>$value['rate_pph'].' %',
                    'pph_amount'=>$value['pph_amount'],
                    'wht_code'=>$value['wht_code'],
                    'npwp'=>$value['npwp'],
                    'address'=>$value['address_npwp'],
                    'pph_23'=>$value['pph_23'],
                    'pph_26'=>$value['pph_26'],
                    'pph_21'=>$value['pph_21'],
                    'pph_4'=>$value['pph_4'],
                    'wht_code'=>$value['wht_code']
                    );
            }
     //       $this->load->helper('csv');
		   // array_to_csv($list, 'report.csv');
            $file_name = 'IMPORT_TO_SYSTEM'.date('Y_m_d');
            $ouput_file_name = $file_name.'.xls';
        
            $this->load->library('parser');
            $this->parser->parse(TEMPLATE_DIR.'/report_pph/csv.html', $this->data);
            export_excel($ouput_file_name);
        }
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

        $record = $this->Bd_form_model->GetResultReport($post);
        if(empty($record)){
            $this->session->set_flashdata('flash_message', alert_box('Tidak Ada Data','danger'));
            redirect('report_pph');
        }
        $file_name = 'LIST_PPH_IMTV_'.date('Y_m_d');
        $category_tax = $this->db->select('name')->order_by('id_tax','asc')->get_where('tax',array('is_delete'=>0))->result_array();
        if($record){
            $no = 0;
            foreach ($record as $key => $value) {
                $no++;
                $list[] = array(
                    'no'=>$no,
                    'bd_number'=>"'".$value['bd_number'],
                    'prefix_vendor'=>isset($value['prefix_vendor']) ? $value['prefix_vendor'].'. ' : '' ,
                    'vendor_name'=>$value['vendor_name'],
                    'description'=>$value['description'],
                    'original_amount'=>number_format($value['original_amount'],0,',','.'),
                    'idr_amount'=>number_format($value['idr_amount'],0,',','.'),
                    'rate_pph'=>$value['rate_pph'].' %',
                    'pph_amount'=>number_format($value['pph_amount'],0,',','.'),
                    'wht_code'=>$value['wht_code'],
                    'npwp'=>$value['npwp'],
                    'address'=>$value['address_npwp'],
                    'pph_23'=>number_format($value['pph_23'],0,',','.'),
                    'pph_26'=>number_format($value['pph_26'],0,',','.'),
                    'pph_21'=>number_format($value['pph_21'],0,',','.'),
                    'pph_4'=>number_format($value['pph_4'],0,',','.'),
                    'wht_code'=>$value['wht_code']
                    );
            }
            foreach ($category_tax as $tax) {
                $header_pph[] = array(
                    'header_name'=>$tax['name']
                    );
            }
        }
        // echo '<pre>';
        // print_r($list);
        // die();
        $this->data = array(
            'list'=>$list,
            'header_pph'=>$header_pph,
            'count_header'=>count($header_pph)
        );
       
        $ouput_file_name = $file_name.'.xls';
        
        $this->load->library('parser');
        $this->parser->parse(TEMPLATE_DIR.'/bd_form/excel.html', $this->data);
        export_excel($ouput_file_name);
        
    }
}