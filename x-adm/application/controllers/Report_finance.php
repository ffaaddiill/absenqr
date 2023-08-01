<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Report_finance Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Report_finance Controller
 * 
 */

class Report_finance extends CI_Controller {
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
    	$alias['search_bd_date'] = "a.submit_to_finance";
        $alias['search_bd_paid_number'] = "g.bd_paid_number";
        $alias['search_bd_number'] = "a.bd_number";
        $alias['search_date_of_paid'] = "g.date_of_paid";
        
        $query = "
            SELECT 
                a.bd_number as no_bd,
                a.id_form_bd as no_form_bd,
                a.submit_to_finance as bd_date,
                c.name as vendor,
                b.name as description,
                b.id_vendor_banking as vendor_banking_id,
                a.submit_to_finance,
                g.bd_paid_number as bd_paid_number,
                g.date_of_paid as date_of_paid,
                g.spending_amount as spending_amount,
                (select sum(real_amount) from form_bd_item where id_form_bd=no_form_bd) as dpp,
                (select sum(case when (id_status_pajak = 1) then (10/100) * real_amount * curs_ppn  else 0 end) from form_bd_item where id_form_bd=no_form_bd and is_delete=0) as VAT,
                (case
                    WHEN a.payment_type != 2 THEN (select sum(real_amount_part * valid_curs) from view_pph where id_form_bd=no_form_bd)
                    else (select sum(real_amount_part * valid_curs) from view_pph_soa where id_form_bd=no_form_bd)
                    end) as WHT,
                (case
                 WHEN a.payment_type = 1 THEN 'Full Payment'
                 WHEN a.payment_type = 2 THEN 'Advance'
                 WHEN a.payment_type = 3 then 'Partial'
                 end) as payment_type,
                e.name as divisi,
                (select account_name from vendor_banking WHERE id_vendor_banking=vendor_banking_id) as account_name,
                (select account_number from vendor_banking WHERE id_vendor_banking=vendor_banking_id) as account_number,
                (select bank_name from vendor_banking WHERE id_vendor_banking=vendor_banking_id) as bank_name,
                f.invoice_number as invoice_number,
                b.id_currency as currency,
                g.curs_finance as curs_finance,
                h.name as author,
                i.name as requestor
            FROM form_bd a  
            join form_bd_item b on a.id_form_bd=b.id_form_bd
            join vendor c ON b.id_vendor=c.id_vendor
            join vendor_category d on c.id_category_vendor=d.id_vendor_category
            join divisi e on a.id_divisi=e.id_divisi
            left join invoice f on a.bd_number=f.bd_number
            left join invoice_payment g on f.id_invoice=g.id_invoice
            join auth_user h on a.id_auth_user=h.id_auth_user
            join requestor i on i.id_requestor=a.id_requestor
            WHERE a.bd_number != 0 and a.is_delete = 0  
           ";
        
        $group_by = "b.id_vendor,a.bd_number,g.bd_paid_number"; 
        //echo $query;
        $this->data = query_grid($query, $alias,$group_by);

        
        
        $this->data['paging'] = paging($this->data['total'],3);
    }
    private function export_to_csv( $post = array() ){
    	$this->load->model('Bd_form_model');
        //$this->layout = 'none';
        $post = $post;

        $record = $this->Bd_form_model->GetResultReport($post);
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
           $this->load->helper('csv');
		   array_to_csv($list, 'report.csv');
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
    	$this->load->model('Payment_model');
        $this->layout = 'none';
        $post = $post;

        $record = $this->Payment_model->GetDataReportFinance($post);
        // echo '<pre>';
        // print_r($record);
        // die();
        $file_name = 'Rekap_BD_Finance'.date('Y');
        if($record){
            $no = 0;
            foreach ($record as $key => $value) {
                $no++;
                $curs_finance = (isset($value['curs_finance'])) ? $value['curs_finance'] : 1 ;
                $total = ($value['dpp'] * $curs_finance) + $value['VAT'] - round($value['WHT']);
                $list[] = array(
                    'no'=>$no,
                    'bd_date'=>(isset($value['bd_date']))? date('d-M-Y',strtotime($value['bd_date'])) : " ",
                    'bd_number'=>"'".$value['no_bd'],
                    'bank_paid'=>(isset($value['date_of_paid']))? date('d-M-Y',strtotime($value['date_of_paid'])) : " ",
                    'bd_paid_number'=>$value['bd_paid_number'],
                    'divisi'=>$value['divisi'],
                    'category'=>$value['payment_type'],
                    'no_invoice'=>$value['invoice_number'],
                    'description'=>$value['description'],
                    'usd'=>($value['currency']==2) ? $value['dpp'] : " ",
                    'dpp'=>$value['dpp'] * $curs_finance,
                    'vat'=>$value['VAT'],
                    'wht'=>round($value['WHT']),
                    'net_total'=>$total,
                    'vendor'=>$value['vendor'],
                    'account_name'=>$value['account_name'],
                    'account_number'=>$value['account_number'],
                    'bank_name'=>$value['bank_name'],
                    'author'=>$value['author'],
                    'requestor'=>$value['requestor'],
                    'spending_amount'=>$value['spending_amount']
                    );
            }
            
        }
        
        $this->data = array(
            'list'=>$list
            
        );
       
        $ouput_file_name = $file_name.'.xls';
        
        $this->load->library('parser');
        $this->parser->parse(TEMPLATE_DIR.'/report_finance/excel.html', $this->data);
        export_excel($ouput_file_name);
        
    }
}