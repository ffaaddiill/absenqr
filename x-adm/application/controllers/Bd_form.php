<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bd_form Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Bd_form Controller
 * 
 */

class Bd_form extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Bd_form_model');
        $this->load->model('Vendor_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    

    public function test_api(){
        $this->layout = 'none';
        $number = '1.231.111,00';
        $number = natural_number($number);
        echo $number;
        die();

        // $url = 'https://openexchangerates.org/api/latest.json?app_id=0dec0365de704e18918ee61b149dfe55';

        // $result = json_decode(file_get_contents($url));
        // $date = date('Y-m-d');
        // foreach ($result->rates as $key => $value) {
        //     echo $key;
        //     echo '<br>';
        //     //echo '<br>';
        //     //echo $value;
        // }
        // echo '<pre>';
        // print_r($result);
        // echo $result->disclaimer;



    }
    /**
     * index page
     */
    public function index() {
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        $this->data['form_action'] = site_url($this->class_path_name.'/export_to_excel');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['page'] = 0;
    }

    /**
    * check bd number ajax
    * @param string bd_number
    * @return json array
    */
    public function CheckBdNumber(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $bd_number = $post['bd_number'];
            $data = $this->db->get_where('form_bd',array('bd_number'=>$bd_number,'is_delete'=>0))->row_array();

            if($data){
                $json['error'] = 1;
            }else{
                $json['error'] = 0;
            }


            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }

    /**
    * check soa number ajax
    * @param string soa_number
    * @return json array
    */
    public function CheckSOANumber(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $bd_number = $post['soa_number'];
            $data = $this->db->get_where('form_soa',array('soa_number'=>$bd_number,'is_delete'=>0))->row_array();

            if($data){
                $json['error'] = 1;
            }else{
                $json['error'] = 0;
            }


            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
    public function getVendor(){ 
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $list_vendor = $this->Bd_form_model->GetVendor();
            $list_currency = $this->db->get('currency')->result_array();
            $html_vendor = '';
            $html_currency = '';
            foreach ($list_vendor as $key => $value) {
                
                $html_vendor .= '<option  value="'.$value['id_vendor'].'">'.$value['name'].'</option>';
            }
            foreach ($list_currency as $k => $v) {
                $html_currency .= '<option  value="'.$v['id_currency'].'">'.$v['iso_1'].'</option>';
            }
            $json['html_vendor']    = $html_vendor;
            $json['html_currency']  = $html_currency;
            
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }

    public function getCodeByCostCenter(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $record = $this->Bd_form_model->getCodeByCostCenter($post['id_cost_center']);

            if($record){
                $html = '';
                
                $json['code'] = '<label class="control-label text-left">'.$record['code'].'</label>';  
                
            }else{
                $json['error'] = alert_box('Cannot find code','danger');
            }
            
            
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
    public function getAccountBankingByIdNumber(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $id_vendor_banking = $post['id_vendor_banking'];
            $record = $this->Bd_form_model->GetVendorAccountBankingById($id_vendor_banking);
            $json['account_name']   = $record['account_name'];
            $json['bank_name']      = $record['bank_name'];
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
    public function getAccountBankingByVendor(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $id = $post['id_vendor'];
            $row = $post['row'];

            $list_account = $this->Bd_form_model->GetVendorAccountBanking($id);
            if($row == 'edit_item'){
                if($list_account){
                    $html_list_account = '<div class="form-group">';
                        $html_list_account .= '<label for="account_number">Account Number</label>';
                        $html_list_account .= '<select class="form-control" name="id_vendor_banking" id="id_vendor_banking">';
                        foreach ($list_account as $x => $d) {
                            $html_list_account .= '<option  value="'.$d['id_vendor_banking'].'">'.$d['account_number'].'</option>';
                        }
                        $html_list_account .= '</select>';
                    $html_list_account .= '</div>';
                    
                }else{
                    $html_list_account = '<div class="form-group">';
                        $html_list_account .= '<label style="color:red" for="account_number">Belum ada akun banking</label>';
                    $html_list_account .= '</div>';
                }
            }else{
                if($list_account){
                    $html_list_account = '<div class="form-group no-margin">';
                        $html_list_account .= '<label for="item_account_number'.$row.'">Account Number</label>';
                        $html_list_account .= '<select class="form-control" data-row="'.$row.'" name="item_bd['.$row.'][id_vendor_banking]" id="id_vendor_banking_'.$row.'">';
                        foreach ($list_account as $x => $d) {
                            $html_list_account .= '<option  value="'.$d['id_vendor_banking'].'">'.$d['account_number'].'</option>';
                        }
                        $html_list_account .= '</select>';
                    $html_list_account .= '</div>';
                    
                }else{
                    $html_list_account = '<div class="form-group no-margin">';
                        $html_list_account .= '<label style="color:red" for="item_account_number'.$row.'">Belum ada akun banking</label>';
                    $html_list_account .= '</div>';
                }    
            }
             
            $json['html'] = $html_list_account;
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
    public function add_vendor(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $vendor_accounts = $post['account'];
            $row = $post['row'];
            unset($post['account']);
            unset($post['row']);
            $id = $this->Bd_form_model->InsertRecordVendor($post);

            if($id){
                if($vendor_accounts){
                    $data_account = array();
                    foreach ($vendor_accounts as $k => $account) {
                        if($account['account_number']){
                            $data_account[] = array(
                                'id_vendor'=>$id,
                                'account_name'=>$account['account_name'],
                                'account_number'=>$account['account_number'],
                                'bank_name'=>$account['bank_name'] 
                                );
                        }
                        
                    }
                    if(count($data_account)>0){
                        $this->Bd_form_model->InsertAccountVendorBatch($data_account);
                    }
                }
                $list_vendor = $this->Bd_form_model->GetVendor();
                $html = '';
                foreach ($list_vendor as $key => $value) {
                    if($value['id_vendor']==$id){
                        $selected = 'selected="selected"';
                    }else{
                        $selected = '';
                    }
                    $html .= '<option '.$selected.' value="'.$value['id_vendor'].'">'.$value['name'].'</option>';
                }
                $json['html'] = $html;
                $list_account = $this->Bd_form_model->GetVendorAccountBanking($id);
                if($list_account){
                    if($row=='edit_item'){
                        $html_list_account = '<div class="form-group">';
                            $html_list_account .= '<label for="account_number">Account Number</label>';
                            $html_list_account .= '<select class="form-control" name="id_vendor_banking" id="id_vendor_banking">';
                            foreach ($list_account as $x => $d) {
                                $html_list_account .= '<option  value="'.$d['id_vendor_banking'].'">'.$d['account_number'].'</option>';
                            }
                            $html_list_account .= '</select>';
                        $html_list_account .= '</div>';
                    }else{
                        $html_list_account = '<div class="form-group no-margin">';
                            $html_list_account .= '<label for="item_account_number'.$row.'">Account Number</label>';
                            $html_list_account .= '<select class="form-control" data-row="'.$row.'" name="item_bd['.$row.'][id_vendor_banking]" id="id_vendor_banking_'.$row.'">';
                            foreach ($list_account as $x => $d) {
                                $html_list_account .= '<option  value="'.$d['id_vendor_banking'].'">'.$d['account_number'].'</option>';
                            }
                            $html_list_account .= '</select>';
                        $html_list_account .= '</div>';
                    }
                    
                }  
                $json['id_vendor'] = $id; 
                $json['html_list_account'] = $html_list_account;
            }else{
                $json['error'] = alert_box('Cannot save the data..please try again','danger');
            }
            
            
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    } 
    public function saveRequestor(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $id = $this->Bd_form_model->InsertRecordRequestor($post);

            if($id){
                $list_requestor = $this->Bd_form_model->GetRequestor();
                $html = '';
                foreach ($list_requestor as $key => $value) {
                    if($value['id_requestor']==$id){
                        $selected = 'selected="selected"';
                    }else{
                        $selected = '';
                    }
                    $html .= '<option '.$selected.' value="'.$value['id_requestor'].'">'.$value['name'].'</option>';
                }
                $json['html'] = $html;  
                $json['id_requestor'] = $id;  
                $json['success'] = alert_box('Berhasil ','success');
            }else{
                $json['error'] = alert_box('Cannot save the data..please try again','danger');
            }
            
            
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }

    public function getTax(){
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $id_sub_tax = $post['id_sub_tax'];
            $data = $this->db->get_where('sub_tax',array('id_sub_tax'=>$id_sub_tax))->row_array();

            if($data){
                $json['percentage'] = $data['value'];
            }else{
                $json['error'] = 'Error';
            }


            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }

    public function getCostcenterAndRequestorByDivisi(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $id_divisi      = $post['id_divisi'];
            $cost_center    = $this->Bd_form_model->GetDivisi();
            $list_requestor = $this->Bd_form_model->GetRequestor();
            $html = '';
            $html_req = '';
            foreach ($cost_center as $key => $value) {
                $html .= '<option value="'.$value['id_divisi'].'">'.$value['name'].'</option>';    
            }  
            foreach ($list_requestor as $k => $val) {
                $html_req .= '<option value="'.$val['id_requestor'].'">'.$val['name'].'</option>';
            }
            $json['html'] = $html;
            $json['html_req'] = $html_req;
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }

    public function getCostcenterByDivisi(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $id_divisi      = $post['id_divisi'];
            $cost_center    = $this->Bd_form_model->getCostcenterByDivisi($id_divisi);
            
            $html = '';
            
            foreach ($cost_center as $key => $value) {
                $html .= '<option value="'.$value['id_cost_center'].'">'.$value['name'].'</option>';    
            }  
            
            $json['html'] = $html;
            
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
    public function list_data(){
        $alias['search_create_date_start'] = "a.request_date";
        $alias['search_create_date_end'] = "a.due_date";
        $alias['search_bd_number'] = "a.bd_number";
        // $alias['search_vendor'] = "b.name";
        // $alias['search_npwp'] = "b.npwp";
        $alias['search_amount'] = "a.amount";
        $alias['search_type'] = "(
                case
                    WHEN a.payment_type = 1 THEN 'Full Payment'
                    WHEN a.payment_type = 2 THEN 'Advance'
                    WHEN a.payment_type = 3 then 'Partial'
                end
                )";
        $alias['search_status'] = "(
                case
                    WHEN a.id_status = 1 THEN 'Paid'
                    WHEN a.id_status = 2 THEN 'Unpaid'
                    WHEN a.id_status = 3 THEN 'Partial'
                    WHEN a.id_status = 4 THEN 'Over'
                    WHEN a.id_status = 5 THEN 'Under'
                end
                )";
        $query = "
            select 
                a.id_form_bd as idx,
                a.id_form_bd as id,
                a.*,
                (
                case
                    WHEN a.payment_type = 1 THEN 'Full Payment'
                    WHEN a.payment_type = 2 THEN 'Advance'
                    WHEN a.payment_type = 3 then 'Partial'
                end
                ) as type,
                (
                case
                    WHEN a.id_status = 1 THEN 'Paid'
                    WHEN a.id_status = 2 THEN 'Unpaid'
                    WHEN a.id_status = 3 THEN 'Partial'
                    WHEN a.id_status = 4 THEN 'Over'
                    WHEN a.id_status = 5 THEN 'Under'
                end
                ) as status              
            from " . $this->db->dbprefix('form_bd') . " a

            where a.is_delete = 0";

        
        $group_by = "a.id_form_bd"; 
        //echo $query;
        $this->data = query_grid($query, $alias,$group_by);

        foreach ($this->data['data'] as $key => $value) {
             
            $this->data['data'][$key]['item_bds']       = $this->Bd_form_model->GetBd_itemByIdBd($value['id']);
            $getTotal = $this->getRealTotalAmount($this->data['data'][$key]);
            $this->data['data'][$key]['total_amount']   = $getTotal['iso_2'].'. '.number_format($getTotal['total_amount'],2,",",".");
            $this->data['data'][$key]['total_ppn']      = $getTotal['total_ppn'];
        }
        
        $this->data['paging'] = paging($this->data['total'],3);
        
    }

    private function getRealTotalAmount($data){
        $total_amount = 0;
        $total_ppn = 0;
        $total_pph_amounts = 0;
        $USD = 0;
        $iso_2 = '';
        foreach ($data['item_bds'] as $row => $item) {
           if($item['id_status_pajak']==1){ 
                if($item['id_currency'] != 1){
                    $amount_ppn = 0.1 * $item['real_amount']  * $item['curs_ppn'];
                    //echo $amount_ppn;echo '<br>';
                    $total_ppn = $total_ppn + $amount_ppn;
                    $total_amount = $total_amount + ($item['real_amount'] );
                    $USD++; 
                }else{
                    $amount_ppn = 0.1 * $item['real_amount'];
                    $total_amount = $total_amount + ($item['real_amount'] ) + $amount_ppn;
                    $total_ppn = 0;
                }
            }else{
                $total_amount = $total_amount + ($item['real_amount'] );
            }
            if($item['pph_item']){
                $total_pph_amount = 0;
                foreach ($item['pph_item'] as $key => $pph) {
                    $pph_amount = ($item['real_amount']  * ($pph['percentage']/100));
                    $total_pph_amount = $total_pph_amount + $pph_amount;
                }
            }else{
                $total_pph_amount =0 ;
            }
            $total_pph_amounts= $total_pph_amounts + $total_pph_amount;
            $iso_2 = $item['iso_2'];
        }
        $return['total_amount'] = $total_amount-$total_pph_amounts;
        $return['total_ppn']    = $total_ppn;
        if($iso_2){
            $return['iso_2']        = $iso_2;    
        }else{
            $return['iso_2']        = '';
        }
        
        return $return;
        //return $total_pph_amounts;
    }

    

    public function export_to_excel(){
        $this->layout = 'none';
        $record = $this->Bd_form_model->GetResultReport();
        $file_name = 'LIST_PPH_IMTV_'.date('Y_m_d');
        $category_tax = $this->db->select('name')->order_by('id_tax','asc')->get_where('tax',array('is_delete'=>0))->result_array();
        if($record){
            $no = 0;
            foreach ($record as $key => $value) {
                $no++;
                $list[] = array(
                    'no'=>$no,
                    'bd_number'=>$value['bd_number'],
                    'vendor_name'=>(isset($value['prefix_vendor']) ? $value['prefix_vendor'].'. ' : '' ).$value['vendor_name'],
                    'description'=>$value['description'],
                    'original_amount'=>$value['original_amount'],
                    'idr_amount'=>$value['idr_amount'],
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
        //export_to($ouput_file_name);
        
    }

    /**
    * edit item bd ajax
    * @param int $id item bd
    * @return json html detail payment
    */
    public function edit_item_bd(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post = $this->input->post();
            if(isset($post['id_form_bd_item'])){
                $id_item_bd = $post['id_form_bd_item'];
                $record     = $this->Bd_form_model->GetItemBDById($id_item_bd);
                $data['list_vendors'] = $this->Bd_form_model->GetVendor(); 
                $data['type'] = 'bd';   
            }elseif(isset($post['id_form_soa_item'])){
                $id_item_bd = $post['id_form_soa_item'];
                $record     = $this->Bd_form_model->GetItemBDByIdSOA($id_item_bd);
                $data['type'] = 'soa';
            }
            
            $data['record']     = $record;
            $data['currency']   = $this->db->get('currency')->result_array();
            
            $json['html'] = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/form_edit_item', $data, true);
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );


        }
    }

    public function save_item_bd(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post           = $this->input->post();
            if(isset($post['id_form_bd_item'])){
                $id_item_bd     = $post['id_form_bd_item'];
                $bd_number      = $post['bd_number'];
                
                unset($post['id_form_bd_item']);
                unset($post['bd_number']);
                
                $this->Bd_form_model->UpdateRecordItemBd($id_item_bd,$post);
                $record         = $this->Bd_form_model->GetItemBDById($id_item_bd);
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Edit Item BD',
                    'desc' => 'Edit Item BD; ID: '.$id_item_bd.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
            }elseif (isset($post['id_form_soa_item'])) {
                $id_item_bd     = $post['id_form_soa_item'];
                $bd_number      = $post['bd_number'];
                
                unset($post['id_form_soa_item']);
                unset($post['bd_number']);
                
                $this->Bd_form_model->UpdateRecordItemBdSOA($id_item_bd,$post);
                $record         = $this->Bd_form_model->GetItemBDByIdSOA($id_item_bd);
                 $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Edit Item SOA',
                    'desc' => 'Edit Item SOA; ID: '.$id_item_bd.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
            }
            
           
            // echo '<pre>';
            // print_r($record);
            // die();
            if($record){
                $json['success']  = 'Berhasil';
                
            }else{
                $json['error']  = 'No Record';
            }
            
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }

    public function delete_item_bd(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post = $this->input->post();

            $id_form_bd_item = $post['id_form_bd_item'];
            $data_update = array('is_delete'=>1);

            $this->Bd_form_model->UpdateRecordItemBd($id_form_bd_item,$data_update);
             $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Delete Item BD',
                    'desc' => 'Delete Item BD; ID: '.$id_form_bd_item.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
            $json['message']    = alert_box('Data Berhasil di Hapus','success',TRUE);
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );

        }
        
    }
    public function edit_item_pph(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post           = $this->input->post();
            if(isset($post['id_form_bd_item'])){
                $id_item_pph    = $post['id_form_bd_item'];
                $record         = $this->Bd_form_model->GetDetailPPHItemById($id_item_pph);
                $data['type']   = 'bd';
            }elseif(isset($post['id_form_soa_item'])){
                $id_item_pph    = $post['id_form_soa_item'];
                $record         = $this->Bd_form_model->GetDetailPPHItemById($id_item_pph);
                $data['type']   = 'soa';
            }
            
            // echo '<pre>';
            // print_r($record);
            // die();
            $data['record'] = $record;
            $data['row'] = $post['row'];
            $data['pph_type'] = $this->Bd_form_model->GetPPH();

            $json['html'] = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/form_edit_item_pph', $data, true);
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }

    public function delete_item_pph(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post           = $this->input->post();
            
            if(isset($post['id_form_bd_item'])){
                $id_item_pph    = $post['id_form_bd_item_pph'];
                $id_item_bd     = $post['id_form_bd_item'];
                $row            = $post['row'];
                
                $data_update = array('is_delete'=>1);
                $this->Bd_form_model->UpdateRecordPPHItem($id_item_pph,$data_update);
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Delete Item PPH',
                    'desc' => 'Delete Item PPH; ID: '.$id_item_pph.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                $record         = $this->Bd_form_model->GetPPHItemByIdBDItem($id_item_bd);
                // echo $this->db->last_query();
                // echo '<pre>';
                // print_r($record);
                // die();
                $json['row']        = $row;
                $data['type']       = 'bd';
            }elseif(isset($post['id_form_soa_item'])){
                $id_item_pph    = $post['id_form_soa_item_pph'];
                $id_item_bd     = $post['id_form_soa_item'];
                $row            = $post['row'];
                
                $data_update = array('is_delete'=>1);
                $this->Bd_form_model->UpdateRecordPPHItemSOA($id_item_pph,$data_update);
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Delete Item PPH SOA',
                    'desc' => 'Delete Item PPH SOA; ID: '.$id_item_pph.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                $record         = $this->Bd_form_model->GetPPHItemByIdBDItemSOA($id_item_bd);
                // echo $this->db->last_query();
                // echo '<pre>';
                // print_r($record);
                // die();
                $json['row']        = $row;
                $data['type']       = 'soa';
            }
            if(empty($record)){
                
                $data['item_pph']   = $record;
                $data['row']        = $row;
                
                $json['html']       = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/list_item_pph', $data, true);
                $json['success'] = alert_box('Data has been deleted','success',TRUE);
            }else{
                $json['error'] = alert_box('Error !!!','danger',TRUE);
            }
            
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }

    public function save_item_pph(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post           = $this->input->post();
            if(isset($post['id_form_bd_item'])){
                $id_item_pph    = $post['id_form_bd_item_pph'];
                $id_item_bd     = $post['id_form_bd_item'];
                $row            = $post['row'];
                
                unset($post['id_form_bd_item_pph']);
                unset($post['id_form_bd_item']);
                unset($post['row']);
                $this->Bd_form_model->UpdateRecordPPHItem($id_item_pph,$post);
                $record         = $this->Bd_form_model->GetPPHItemByIdBDItem($id_item_bd);
                $data['type'] = 'bd';
            }elseif (isset($post['id_form_soa_item'])) {
                $id_item_pph    = $post['id_form_soa_item_pph'];
                $id_item_bd     = $post['id_form_soa_item'];
                $row            = $post['row'];
                
                unset($post['id_form_soa_item_pph']);
                unset($post['id_form_soa_item']);
                unset($post['row']);
                $this->Bd_form_model->UpdateRecordPPHItemSOA($id_item_pph,$post);
                $record         = $this->Bd_form_model->GetPPHItemByIdBDItemSOA($id_item_bd);
                $data['type'] = 'soa';
            }
            
            $data_log = array(
                'id_user' => id_auth_user(),
                'id_group' => id_auth_group(),
                'action' => 'User Edit Item PPH',
                'desc' => 'Edit Item PPH; ID: '.$id_item_pph.'; Data: '.json_encode($post),
            );
            insert_to_log($data_log);
            // echo '<pre>';
            // print_r($record);
            // die();
            if($record){
                $data['item_pph']   = $record;
                $data['row']        = $row;
                $json['row']        = $row;    
                $json['html']       = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/list_item_pph', $data, true);
            }else{
                $json['error']  = 'No Record';
            }
            
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
    private function getTotalAmount($data){
        $total_amount = 0;
        $total_ppn = 0;
        $total_pph_amounts = 0;
        $USD = 0;
        foreach ($data['item_bds'] as $row => $item) {
           if($item['id_status_pajak']==1){ 
                if($item['id_currency'] != 1){
                    $amount_ppn = 0.1 * $item['real_amount']  * $item['curs_ppn'];
                    //echo $amount_ppn;echo '<br>';
                    $total_ppn = $total_ppn + $amount_ppn;
                    $total_amount = $total_amount + ($item['real_amount'] );
                    $USD++; 
                }else{
                    $amount_ppn = 0.1 * $item['real_amount'];
                    $total_amount = $total_amount + ($item['real_amount'] ) + $amount_ppn;
                    $total_ppn = 0;
                }
            }else{
                $total_amount = $total_amount + ($item['real_amount'] );
            }
            if($item['pph_item']){
                $total_pph_amount = 0;
                foreach ($item['pph_item'] as $key => $pph) {
                    $pph_amount = ($item['real_amount']  * ($pph['percentage']/100));
                    $total_pph_amount = $total_pph_amount + $pph_amount;
                }
            }else{
                $total_pph_amount =0 ;
            }
            $total_pph_amounts= $total_pph_amounts + $total_pph_amount;
        }
        $return['total_amount'] = $total_amount-$total_pph_amounts;
        $return['total_ppn']    = $total_pph_amounts;
        return $return;
        //return $total_pph_amounts;
    }
    /**
     * add page
     */
    public function add() {
        $this->data['vendors'] = $this->Bd_form_model->GetVendor();
        $this->data['requestor'] = $this->Bd_form_model->GetRequestor();
        $this->data['category_vendor'] = $this->Vendor_model->GetCategoryVendor();
        $this->data['divisi']       = $this->Bd_form_model->GetDivisi();
        $this->data['page_title']   = 'Add';
        $this->data['form_action']  = site_url($this->class_path_name.'/add');
        $this->data['cancel_url']   = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            // echo '<pre>';
            // print_r($post);
            // die();
            if ($this->validateForm()) {
                $item_bds = $post['item_bd'];
                $post['id_auth_user'] = id_auth_user();
                // echo '<pre>';
                // print_r($item_bds);
                // die();
                unset($post['item_bd']);

                $id = $this->Bd_form_model->InsertRecord($post);


                // if question is set/add
                $bd_form_item = array();
                if (isset($item_bds) && count($item_bds)>0) {
                    foreach ($item_bds as $key => $item_bd) {
                        $amount_natural_number = natural_number($item_bd['real_amount']);
                        $curs_ppn = $item_bd['curs_ppn'] / ($amount_natural_number * 0.1);
                
                        $bd_form_item[] = array(
                            'id_form_bd'=>$id,
                            'id_vendor'=>$item_bd['id_vendor'],
                            'id_vendor_banking'=>$item_bd['id_vendor_banking'],
                            'curs_ppn'=>$curs_ppn,
                            'name'=>$item_bd['name'],
                            'qty'=>1,
                            'id_currency'=>$item_bd['id_currency'],
                            'final_amount'=>0,
                            'real_amount'=>$amount_natural_number,
                            'id_status_pajak'=>(isset($item_bd['id_status_pajak'])) ? 1 : 2 ,  
                        );
                    }
                }
                
                // inser data batch item BD FORM
                if (count($bd_form_item)>0) {
                    $this->Bd_form_model->InsertItemBatch($bd_form_item);
                }
                $post['item_bd'] =$item_bds;
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Bd_form',
                    'desc' => 'Add  Bd_form; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Bd_form_model->GetBd_form($id);
        
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['vendors'] = $this->Bd_form_model->GetVendor();
        $this->data['requestor'] = $this->Bd_form_model->GetRequestor();
        // echo '<pre>';
        // print_r($record);
        // die();
        $this->load->model('Vendor_model');
        $this->data['category_vendor']  = $this->Vendor_model->GetCategoryVendor();
        $this->data['divisi']           = $this->Bd_form_model->GetDivisi();
        $this->data['cost_center']      = $this->Bd_form_model->GetDivisi();
        $this->data['page_title']       = 'Edit';
        $this->data['form_action']      = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url']       = site_url($this->class_path_name);
        $this->data['pph_type']         = $this->Bd_form_model->GetPPH();
        if ($this->input->post()) {
            $post = $this->input->post();
            // echo '<pre>';
            // print_r($post);
            // die();
            $item_bds = (isset($post['item_bd'])) ? $post['item_bd'] : array();
            $item_pphs = (isset($post['pph'])) ? $post['pph'] : array();#$post['item_pph'];
            if ($this->validateForm($id)) {
                $post['id_auth_user'] = id_auth_user();
                
                unset($post['item_bd']);
                unset($post['pph']);
                $this->Bd_form_model->UpdateRecord($id,$post);
                // print_r($item_bds);
                // die();
                // if question is set/add
                $bd_form_item = array();
                if (isset($item_bds) && count($item_bds)>0) {
                    foreach ($item_bds as $key => $item_bd) {
                        $amount_natural_number = natural_number($item_bd['real_amount']);
                        $curs_ppn = $item_bd['curs_ppn'] / ($amount_natural_number * 0.1);
                        $bd_form_item[] = array(
                            'id_form_bd'=>$id,
                            'id_vendor'=>$item_bd['id_vendor'],
                            'id_vendor_banking'=>$item_bd['id_vendor_banking'],
                            'curs_ppn'=>$curs_ppn,
                            'name'=>$item_bd['name'],
                            'qty'=>1,
                            'id_currency'=>$item_bd['id_currency'],
                            'final_amount'=>0,
                            'real_amount'=>$amount_natural_number,
                            'id_status_pajak'=>(isset($item_bd['id_status_pajak'])) ? 1 : 2 ,  
                        );
                    }
                }
                // inser data batch item BD FORM
                if (count($bd_form_item)>0) {
                    $this->Bd_form_model->InsertItemBatch($bd_form_item);
                }
                

                
                $bd_form_pph = array();
                if (isset($item_pphs) && count($item_pphs)>0) {
                    foreach ($item_pphs as $id_form_bd_item => $item_pph) {

                        foreach ($item_pph['item_pph'] as $k => $v) {
                            $bd_form_pph[] = array(
                                'id_sub_tax'=>$v['id_sub_tax'],
                                'percentage'=>$v['percentage'],
                                'id_form_bd_item'=> $id_form_bd_item
                            );
                        }
                        
                    }
                }
                // print_r($bd_form_pph);
                // die();
                // insert data batch item BD FORM
                if (count($bd_form_pph)>0) {
                    $this->Bd_form_model->InsertPPHBatch($bd_form_pph);
                }

                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Bd_form',
                    'desc' => 'Edit Bd_form; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name);
            }
             $record['item_bd'] = $item_bds;
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
            if ($post['id'] != '') {
                $id= $post['id'];
                $record = $this->Bd_form_model->GetBd_form($id);
                if ($record) {
                        $this->Bd_form_model->DeleteRecord($id);
                        $json['success'] = alert_box('Data has been deleted','success');
                        $this->session->set_flashdata('flash_message',$json['success']);
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'User Bd_form',
                            'desc' => 'Delete  Bd_form; ID: '.$id.';',
                        );
                        insert_to_log($data_log);
                            // end insert to log
                   
                } else {
                    $json['error'] = alert_box('Failed. Please refresh the page.','danger');
                    break;
                }
                 
                
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
        //redirect($this->class_path_name);
    }
    
    public function GetDetailSOA(){
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $id                     = $post['id_form_bd'];
            $record                 = $this->Bd_form_model->GetBd_formWithSOA($id); 
            $total_amount           = $this->getTotalAmount($this->Bd_form_model->GetBd_form($record['id_form_bd']));
            $record['total_amount'] = $total_amount['total_amount'];

            $data['post'] = $record;
            $json['html'] = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/detail_soa', $data, true);
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
    public function SOA($id=0){
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record                 = $this->Bd_form_model->GetBd_formWithSOA($id); 
        $total_amount           = $this->getTotalAmount($this->Bd_form_model->GetBd_form($record['id_form_bd']));
        $record['total_amount'] = $total_amount['total_amount'];
        // echo '<pre>';
        // print_r($record);
        // die();
        
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Payment';
        $this->data['pph_type']         = $this->Bd_form_model->GetPPH();
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['form_action'] = site_url($this->class_path_name.'/soa/'.$id);
        if($this->input->post()){
            $post = $this->input->post();
            // echo '<pre>';
            // print_r($post);
            
            $post['id_form_bd'] = $id;
            $item_soas = (isset($post['item_soa'])) ? $post['item_soa'] : array();
            $item_pphs = (isset($post['pph'])) ? $post['pph'] : array();
            unset($post['item_soa']);
            unset($post['pph']);
            if($this->validateFormSOA($id)){  
                if(isset($post['id_form_soa']) && $post['id_form_soa']!=0){ // update proses
                    
                    $id_form_soa = $post['id_form_soa'];
                    $this->Bd_form_model->UpdateRecordSOA($id_form_soa,$post);
                }else{ // insert proses
                    $id_form_soa = $this->Bd_form_model->InsertRecordSOA($post);
                }
                
                $soa_form_item = array();
                if (isset($item_soas) && count($item_soas)>0) {
                    foreach ($item_soas as $key => $item_soa) {

                
                        $soa_form_item[] = array(
                            'id_form_bd'=>$id,
                            'name'=>$item_soa['name'],
                            'id_form_soa'=>$id_form_soa,
                            'curs_ppn'=>$item_soa['curs_ppn'],
                            'id_currency'=>$item_soa['id_currency'],
                            'real_amount'=>natural_number($item_soa['real_amount']),
                            'id_status_pajak'=>(isset($item_soa['id_status_pajak'])) ? 1 : 2 ,  
                        );
                    }
                }
                // inser data batch item BD FORM
                if (count($soa_form_item)>0) {
                    $this->Bd_form_model->InsertItemSOABatch($soa_form_item);
                }

                $soa_form_pph = array();
                if (isset($item_pphs) && count($item_pphs)>0) {
                    foreach ($item_pphs as $id_form_soa_item => $item_pph) {

                        foreach ($item_pph['item_pph'] as $k => $v) {
                            $bd_form_pph[] = array(
                                'id_sub_tax'=>$v['id_sub_tax'],
                                'percentage'=>$v['percentage'],
                                'id_form_soa_item'=> $id_form_soa_item
                            );
                        }
                        
                    }
                }
                // print_r($bd_form_pph);
                // die();
                // insert data batch item BD FORM
                if (count($bd_form_pph)>0) {
                    $this->Bd_form_model->InsertSOAPPHBatch($bd_form_pph);
                }
                 $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Add SOA',
                    'desc' => 'Add SOA; ID: '.$id_form_soa.';',
                );
                insert_to_log($data_log);
                redirect($this->class_path_name);
            }
            $record['item_soa'] = $item_soas;
        }
        $this->data['template'] = $this->class_path_name.'/soa_form';
        $this->data['post'] = $record;
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }
    
    public function payment_soa(){
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            // echo '<pre>';
            // print_r($post);
            // die();

            $id_form_soa        = $post['id_form_soa'];
            $amount_balance     = $post['amount_balance'];
            $spending_amount    = $post['amount'];

            if($amount_balance==$spending_amount){
                $data_update = array(
                    'date_of_paid'=>$post['date_of_paid'],
                    'spending_amount'=>$spending_amount,
                    'id_status'=>3 // balance
                    );
                $this->Bd_form_model->UpdateRecordSOA($id_form_soa,$data_update);
                $json['success'] = '';
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Payment SOA',
                    'desc' => 'Payment SOA; ID: '.$id_form_soa.';',
                );
                insert_to_log($data_log);
            }else{
                $json['error'] = alert_box('Jumlah yang dibayarkan tidak sesuai','danger');
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
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
                'field' => 'bd_number',
                'label' => 'BD Number',
                'rules' => 'required|callback_check_bd_number_exists['.$id.']'
            ),
             array(
                'field' => 'id_divisi',
                'label' => 'Divisi',
                'rules' => 'required'
            ),
             array(
                'field' => 'id_cost_center',
                'label' => 'Cost Center',
                'rules' => 'required'
            ),
             array(
                'field' => 'id_requestor',
                'label' => 'Requestor',
                'rules' => 'required'
            ),
             array(
                'field' => 'date_of_promise',
                'label' => 'Date of Promise',
                'rules' => 'required'
            )

        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            
            if (!$id) {
                if(empty($post['item_bd'])){
                    $this->error = alert_box('Masukan Item BD Terlebih Dahulu','danger');
                    return FALSE;
                }else{
                    foreach ($post['item_bd'] as $key => $value) {
                        if(empty($value['name'])){
                            $this->error = alert_box('Masukan Nama Item','danger');
                            return FALSE;
                        }
                        if(empty($value['id_vendor_banking'])){
                            $this->error = alert_box('Vendor Belom Memiliki Account Bank','danger');

                            return FALSE;
                        }
                    }
                }
            } else {
                if($post['item_bd']){
                    foreach ($post['item_bd'] as $key => $value) {
                        if(empty($value['name'])){
                            $this->error = alert_box('Masukan Nama Item','danger');
                            return FALSE;
                        }
                        if(empty($value['id_vendor_banking'])){
                            $this->error = alert_box('Vendor Belom Memiliki Account Bank','danger');

                            return FALSE;
                        }
                    }
                }
            }
            if (!$this->error) {
                
                return TRUE;
            } else {
                $this->error = alert_box($this->error,'danger');
                return FALSE;
            }
        }
    }
    
    /**
     * validate form
     * @param int $id
     * @return boolean
     */
    private function validateFormSOA($id=0) {
        $post = $this->input->post();
        $config = array(
           
            array(
                'field' => 'soa_number',
                'label' => 'SOA Number',
                'rules' => 'required'
            )

        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    /**
     * form validation check email exist
     * @param string $string
     * @param int $id
     * @return boolean
     */
    public function check_email_exists($string,$id=0) {
        if (!$this->Bd_form_model->checkExistsEmail($string, $id)) {
            $this->form_validation->set_message('check_email_exists', '{field} is already exists. Please use different {field}');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * form validation check Bd Number exist
     * @param string $string
     * @param int $id
     * @return boolean
     */
    public function check_bd_number_exists($string,$id=0) {
        if (!$this->Bd_form_model->checkBdNumber($string, $id)) {
            $this->form_validation->set_message('check_bd_number_exists', 'BD Number is already exists. Please use different BD Number');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * form validation check SOA Number exist
     * @param string $string
     * @param int $id
     * @return boolean
     */
    public function check_soa_number_exists($string,$id=0) {
        if (!$this->Bd_form_model->checkSOANumber($string, $id)) {
            $this->form_validation->set_message('check_soa_number_exists', 'SOA Number. is already exists. Please use different SOA Number.');
            return FALSE;
        } else {

            return TRUE;
        }
    }

    /**
     * form validation check username exist
     * @param string $string
     * @param int $id
     * @return boolean
     */
    public function check_username_exists($string,$id=0) {
        if (!$this->Bd_form_model->checkExistsUsername($string, $id)) {
            $this->form_validation->set_message('check_username_exists', '{field} is already exists. Please use different {field}');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
/* End of file Bd_form.php */
/* Location: ./application/controllers/Bd_form.php */