<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payment Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Payment Controller
 * 
 */

class Payment extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Payment_model');
        $this->load->model('Bd_form_model');
        $this->load->model('Vendor_model');
        $this->class_path_name = $this->router->fetch_class();
    }


    public function index(){

    }

    public function delete_payment(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post = $this->input->post();

            $id_invoice_payment = $post['id_invoice_payment'];
            $bd_number          = $post['bd_number'];
            $data_update = array(
                'is_delete'=>1
                );
            $this->Payment_model->UpdateInvoicePayment($id_invoice_payment,$data_update);
            $get_status = $this->db->get_where('invoice_payment',array('id_invoice_payment'=>$id_invoice_payment))->row()->is_delete;

            if($get_status==1){
                //$this->data['form_message'] = 'Berhasil di Hapus';
                $this->UpdateStatusBD($bd_number);
                $json['success'] = 'Berhasil di Hapus';
            }else{
                $json['error']  = alert_box('Gagal di Hapus','danger',true);
                //$this->data['form_message'] = 'Gagal di Hapus';
            }

            header('Content-type: application/json');
            exit (
                json_encode($json)
            );

        }
    }

    private function UpdateStatusBD($bd_number){
        //echo '<pre>';
        $record                     = $this->Payment_model->GetBd_formByBdNUmber($bd_number);
        $history_payment            = $this->Payment_model->GetHistoryPayment(array('bd_number'=>$record['bd_number']));
        //print_r($history_payment);
        $record['history_payment']  = $history_payment;
        $total_amount = $this->getTotalAmount($record);
        $total_amount = $total_amount['total_amount'];
        $payment_type = $record['payment_type'];
        $total_bayar  = total_bayar_invoice($history_payment);
        // echo 'Total bayar :'.$total_bayar.'<br>';
        // echo 'Total Amount'.$total_amount;
        // die();
        if($total_bayar==$total_amount){
            $id_status_payment = 1; // paid

        }else if($total_bayar < $total_amount && $payment_type != 2 && $total_bayar!=0){
            $id_status_payment = 3; // partial
        }else if($total_bayar > $total_amount && $payment_type != 2 && $total_bayar!=0){
            $id_status_payment = 3; // partial
        }elseif(($total_bayar > $total_amount && $payment_type == 2 && $total_bayar!=0)){
            $id_status_payment = 4; // over
        }elseif (($total_bayar < $total_amount && $payment_type == 2 && $total_bayar!=0)) {
            $id_status_payment = 5;
        }   
        else{
            $id_status_payment = 2; // unpaid
        }
        $data_update = array(
            'id_status'=>$id_status_payment
            );
        $this->Payment_model->UpdateDataBDForm($record['id_form_bd'],$data_update);


    }

    /**
    * edit item invoice
    * @param int $id invoice
    * @return json html detail invoice
    */
    public function edit_invoice(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post = $this->input->post();
            $id_invoice = $post['id_invoice'];
            $record     = $this->Payment_model->GetInvoiceById($id_invoice);
            // print_r($record);
            // die();
            $data['record']     = $record;
            $json['html'] = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/form_edit_invoice', $data, true);
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );


        }
    }

    /**
    * edit item invoice paymeny
    * @param int $id invoice payment
    * @return json html detail invoice payment
    */
    public function edit_invoice_payment(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post = $this->input->post();
            $id_invoice_payment = $post['id_invoice_payment'];
            $record             = $this->Payment_model->GetInvoiceByIdPayment($id_invoice_payment);
            // print_r($record);
            // die();
            $data['record']     = $record;
            $json['html'] = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/form_edit_invoice_payment', $data, true);
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );


        }
    }

    public function save_invoice(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post           = $this->input->post();
            
            $id_invoice     = $post['id_invoice'];
            
            unset($post['id_invoice']);
            
            
            $this->Payment_model->UpdateRecordInvoice($id_invoice,$post);
            $record         = $this->Payment_model->GetInvoiceById($id_invoice);
            $data_log = array(
                'id_user' => id_auth_user(),
                'id_group' => id_auth_group(),
                'action' => 'User Edit Invoice',
                'desc' => 'Edit Invoice; ID: '.$id_invoice.'; Data: '.json_encode($post),
            );
            insert_to_log($data_log);
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

    public function save_invoice_payment(){
        $this->layout = 'none';
        if($this->input->post() && $this->input->is_ajax_request()){
            $post           = $this->input->post();
            
            $id_invoice     = $post['id_invoice_payment'];
            
            unset($post['id_invoice']);
            
            
            $this->Payment_model->UpdateRecordInvoicePayment($id_invoice,$post);
            $record         = $this->Payment_model->GetInvoiceByIdPayment($id_invoice);
            $data_log = array(
                'id_user' => id_auth_user(),
                'id_group' => id_auth_group(),
                'action' => 'User Edit Invoice',
                'desc' => 'Edit Invoice; ID: '.$id_invoice.'; Data: '.json_encode($post),
            );
            insert_to_log($data_log);
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

    /**
    * check invoice & tax numeber ajax
    * @param string keyword,field
    * @return json array
    */
    public function CheckInvoiceTax(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $keyword = $post['keyword'];
            $field = $post['field'];
            $data = $this->db->get_where('invoice',array($field=>$keyword,'is_delete'=>0))->row_array();

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
        $return['total_ppn']    = $total_ppn;
        return $return;
        //return $total_pph_amounts;
    }
    public function test_ah(){
        $this->layout = 'none';

        $bd_paid = '1601078-01';

        $ex = explode('-',  $bd_paid);

        print_r($ex);
        die();
    }
    public function view($bd_number=0){
        if(!$bd_number){
            redirect('bd_form');
        }
        $record             = $this->Payment_model->GetBd_formByBdNUmber($bd_number);
        $history_payment    = $this->Payment_model->GetHistoryPayment(array('bd_number'=>$record['bd_number']));
        $total_amount = $this->getTotalAmount($record);
        
        $record['total_amount']     = round($total_amount['total_amount'],2);
        $record['total_ppn']        = round($total_amount['total_ppn'],2);
        $record['history_payment']  = $history_payment;
        $id_vendor = $record['item_bds'][0]['id_vendor'];
        // echo '<pre>';
        // print_r($record);
        // die();
        $this->data['form_action'] = site_url($this->class_path_name.'/view/'.$bd_number);
        $this->data['cancel_url'] = site_url('bd_form');
        if (!$record) {
            redirect($this->class_path_name);
        }

        if($this->input->post()){
            $post = $this->input->post();
                // echo '<pre>';
                // print_r($post);
                // die();
            if($record['payment_type']==2){
                $data_update = array(
                    'soa_number'=>$post['soa_number']
                    );
                $this->Payment_model->UpdateDataBDForm($record['id_form_bd'],$data_update);
            }
            if($post['payment']){
                $payment = $post['payment'];
                $invoice = '';
                $total_amount_invoices = 0;
                foreach ($payment as $key => $value) {
                    $id_auth_user = id_auth_user();
                    if($value['id_invoice']){
                        $last_id = $value['id_invoice'];
                    }else{
                        $data_insert = array(
                            'bd_number'=>$bd_number,
                            'invoice_number'=>$value['invoice_number'],
                            'invoice_date'=>$value['invoice_date'],
                            'tax_number'=>$value['tax_number'],
                            'tax_date'=>$value['tax_date'],
                            'id_auth_user'=> $id_auth_user,
                            );
                        $last_id = $this->Payment_model->InsertRecordInvoice($data_insert); 
                    }
                    
                    if($last_id){
                        // $item_invoices = $value['item_invoice'];
                        // $item_invoice = array();
                        // foreach ($item_invoices as $k => $v) {
                        //     $item_invoice[] = array(
                        //         'id_invoice' => $last_id,
                        //         'id_form_bd_item'=>$v['id_item'],
                        //         ); 
                        // }
                        // if(count($item_invoice) > 0){
                        //     $this->Payment_model->InsertBatchItemInvoice($item_invoice);
                        // }

                        $item_payments = $value['item_payment'];
                        #$item_payment = array();
                        $total_amount_invoice = 0;
                        foreach ($item_payments as $row => $paymment) {
                            if($paymment['spending_amount']){
                                $part_percentage = ($paymment['spending_amount'] * $paymment['curs_finance']) / ($total_amount['total_amount'] * $paymment['curs_finance']);
                                $item_payment = array(
                                    'id_invoice' => $last_id,
                                    'id_form_bd' => $record['id_form_bd'],
                                    'bd_paid_number'=>create_bd_paid_number($paymment['date_of_paid'],$id_vendor),
                                    'date_of_paid'=>date('Y-m-d',strtotime($paymment['date_of_paid'])),
                                    'curs_finance'=>$paymment['curs_finance'],
                                    'spending_amount'=>$paymment['spending_amount'],
                                    'payment_by'=>isset($paymment['payment_by']) ? $paymment['payment_by'] : 1,
                                    'attr_payment'=>$paymment['attr_payment'],
                                    'id_auth_user'=> $id_auth_user,
                                    'part_percentage'=> $part_percentage,
                                    'type'=> isset($payment['type']) ? $payment['type'] : 1 
                                    );
                                $total_amount_invoice = $total_amount_invoice + ($paymment['spending_amount'] * $paymment['curs_finance']);
                                $curs = $paymment['curs_finance'];
                                $this->Payment_model->InsertItemPaymentInvoice($item_payment); 
                            }
                            
                        }
                        // if(count($item_payment) > 0){
                        //     $this->Payment_model->InsertBatchItemPaymentInvoice($item_payment);
                        // }
                    }
                        

                    if($key == 0){
                        $invoice .= $last_id;
                    }else{
                        $invoice .= ', '.$last_id;
                    }
                    $total_amount_invoices = $total_amount_invoices + $total_amount_invoice;
                    //die();
                }
                // if(isset($item_payments[0]['curs_finance'])){
                //     $curs = $item_payments[0]['curs_finance'];
                // }else{
                //     $curs = $item_payments[1]['curs_finance'];
                // }
                // echo $curs;
                // echo '<pre>';
                // print_r($item_payments);
                $total_bayar_invoice = total_bayar_invoice($history_payment);
                $total_amount = round($total_amount['total_amount'],2) * $curs + round($total_amount['total_ppn'],2);
                $total_amount_invoices = $total_amount_invoices +  $total_bayar_invoice['ppn'] +  $total_bayar_invoice['dpp'];
                
                //echo 'Total Bayar Invoice : '.$total_bayar_invoice.'<br>';
                // echo 'Total Amount Invoice = '.$total_amount_invoices;echo '<br>';
                // echo 'Total Amount = '.$total_amount;
                if($total_amount_invoices==$total_amount){
                    $id_status_payment = 1; // paid

                }else if($total_amount_invoices < $total_amount && $record['payment_type'] != 2){
                    $id_status_payment = 3; // partial
                }else if($total_amount_invoices > $total_amount && $record['payment_type'] != 2){
                    $id_status_payment = 3; // partial
                }elseif(($total_amount_invoices > $total_amount && $record['payment_type'] == 2)){
                    $id_status_payment = 4; // over
                }elseif (($total_amount_invoices < $total_amount && $record['payment_type'] == 2)) {
                    $id_status_payment = 5;
                }   
                else{
                    $id_status_payment = 2; // unpaid
                }
                // echo $id_status_payment;
                // die();
                $data_update = array(
                    'id_status'=>$id_status_payment
                    );
                $this->Payment_model->UpdateDataBDForm($record['id_form_bd'],$data_update);
               
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Add Invoice',
                    'desc' => 'Add Invoice; ID: '.$invoice.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect('bd_form');
            }
            
            $record = array_merge($record,$post);
        }
        
        $this->data['template'] = $this->class_path_name.'/view';
        $this->data['post'] = $record;
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }

    public function GetDetailPayment(){
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $bd_number      = $post['bd_number'];
            #$curs_finance   = $post['curs_finance'];

            #$this->Payment_model->UpdateDataPayment(array('bd_number'=>$bd_number),array('curs_finance'=>$curs_finance));

            $record = $this->Payment_model->GetBd_formByBdNUmber($bd_number);

            $data['post'] = $record;
            $json['html'] = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/detail_payment', $data, true);
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }

    public function GetNominalItem(){
        $this->layout="none";
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $id_form_bd_item = $post['id_form_bd_item'];
            if($id_form_bd_item){
                $data = $this->Payment_model->GetNetAmountItem($id_form_bd_item);
                $json['amount'] = $data['net_amount'];
            }else{
                $json['amount'] = 0;
            }
            
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
}