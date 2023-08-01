<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payment Model Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Payment model
 * 
 */
class Payment_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }


    /**
     * Get Bd Form  detail by bd_number
     * @param int $bd_number
     * @return array data
     */
    function GetBd_formByBdNUmber($bd_number) {
        $data = $this->db
                ->where('bd_number',$bd_number)
                ->limit(1)
                ->get('form_bd')
                ->row_array();
        $data['item_bds'] = $this->db
                            ->select('form_bd_item.*,currency.iso_1,currency.iso_2,currency.value as factor_curs')
                            ->where('id_form_bd',$data['id_form_bd'])
                            ->join('currency','currency.id_currency=form_bd_item.id_currency','left')
                            ->where('is_delete',0)
                            ->get('form_bd_item')
                            ->result_array();
        foreach ($data['item_bds'] as $key => $value) {
            $data['item_bds'][$key]['pph_item'] = $this->db
                                                  ->select('form_bd_item_pph.*,sub_tax.name as tax_name')  
                                                  ->join('sub_tax','sub_tax.id_sub_tax=form_bd_item_pph.id_sub_tax','left')
                                                  #->where()
                                                  ->where('form_bd_item_pph.is_delete',0)
                                                  ->where('id_form_bd_item',$value['id_form_bd_item'])
                                                  ->get('form_bd_item_pph')
                                                  ->result_array();
        }
        return $data;
    }


    function UpdateDataPayment($condition,$data){
    	$this->db->where($condition);
    	$this->db->update('form_bd',$data);
    }
    function GetNetAmountItem($id_form_bd_item){
    	$sql = "select (a.real_amount + (case when (a.id_status_pajak = 1) then (10/100) * a.real_amount else 0 end) - ((case when(select sum(a.real_amount * b.percentage/100) from form_bd_item a left join form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item where a.id_form_bd_item=$id_form_bd_item is null) then (select sum(a.real_amount * b.percentage/100) from form_bd_item a left join form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item where a.id_form_bd_item=$id_form_bd_item) else 0 end))) as net_amount from form_bd_item a join currency c on a.id_currency=c.id_currency where a.id_form_bd_item=$id_form_bd_item";
    	$data = $this->db->query($sql)->row_array();

		return $data;

    }
    function GetTotalAmountBdByFinance($id_form_bd){
    	$sql ="select 
a.form_id,sum(a.amount) as total_amount,
sum(b.total_pph) as total_pph, 
sum(b.total_ppn) as total_ppn,
(select sum(case when (a.id_status_pajak = 1) then (10/100) * a.real_amount * b.curs_finance else 0 end ) from form_bd_item a join form_bd b on a.id_form_bd=b.id_form_bd where a.id_form_bd = $id_form_bd) as ppn,
sum(a.amount) + (select sum(case when (a.id_status_pajak = 1) then (10/100) * a.real_amount * b.curs_finance else 0 end ) from form_bd_item a join form_bd b on a.id_form_bd=b.id_form_bd where a.id_form_bd = $id_form_bd) - sum(b.total_pph) as net_amount 
from 
        (select distinct

                
                form_id,
                id_form_bd_item,
                amount from (SELECT a.id_form_bd as form_id,
                a.id_form_bd_item,(a.real_amount * e.curs_finance) as amount , 
                (a.real_amount * b.percentage / 100 * e.curs_finance) as pph ,
                e.curs_finance

        FROM `form_bd_item` a 
        left join form_bd_item_pph b on a.id_form_bd_item = b.id_form_bd_item
        
        join form_bd e on e.id_form_bd=a.id_form_bd
        where a.id_form_bd = $id_form_bd) as table_ahay
        ) a 
inner join
        (select 
                form_id,
                id_form_bd_item , 
                sum(pph)  as total_pph , 
                sum(ppn) as total_ppn  
        from 
                (SELECT 
                        e.curs_finance,
                        a.id_form_bd as form_id ,
                        a.id_form_bd_item,
                        (a.real_amount * e.curs_finance) as amount , 
                        (a.real_amount * b.percentage / 100 * e.curs_finance) as pph ,
                        (case when (a.id_status_pajak = 1) then (10/100) * (a.real_amount * e.curs_finance) else 0 end ) as ppn

        FROM `form_bd_item` a 
        left join form_bd_item_pph b on a.id_form_bd_item = b.id_form_bd_item
        
        join form_bd e on e.id_form_bd=a.id_form_bd
        where a.id_form_bd = $id_form_bd) as tabel_pph
        group by id_form_bd_item) b on a.form_id = b. form_id and a.id_form_bd_item = b.id_form_bd_item";

		$data = $this->db->query($sql)->row_array();

		return $data;
		
    }


    function InsertRecordInvoice($post){
        $this->db->insert('invoice',$post);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    function InsertBatchItemInvoice($data){
        $this->db->insert_batch('invoice_item',$data);

    }
    function InsertItemPaymentInvoice($data){
        $this->db->insert('invoice_payment',$data);
    }
    function UpdateDataBDForm($id,$data){
        $this->db->where('id_form_bd',$id);
        $this->db->update('form_bd',$data);
    }

    function GetDataReportFinance($param){
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
            WHERE a.bd_number != 0 and a.is_delete = 0 GROUP BY b.id_vendor,a.bd_number,g.bd_paid_number order by a.bd_number asc  
           ";
        $data = $this->db
                ->query($query)->result_array();

        return $data;
    }


    /**
    * get history payment 
    */
    function GetHistoryPayment($param){

        $data = $this->db
                ->where($param)
                ->get('invoice')
                ->result_array();
                #echo $this->db->last_query();
        if($data){
            foreach ($data as $key => $value) {
                $data[$key]['invoice_payment'] = $this->db
                                            ->where('id_invoice',$value['id_invoice'])
                                            ->where('is_delete',0)
                                            ->get('invoice_payment')
                                            ->result_array();
            }

        }

        return $data;
    }


    function UpdateInvoicePayment($id,$data){
        $this->db->where('id_invoice_payment',$id);
        $this->db->update('invoice_payment',$data);
    }

    function GetInvoiceById($id){
        $data = $this->db
                ->where('id_invoice',$id)
                ->get('invoice')
                ->row_array();
        return $data;

    }

    function GetInvoiceByIdPayment($id){
        $data = $this->db
                ->where('id_invoice_payment',$id)
                ->get('invoice_payment')
                ->row_array();
        return $data;

    }

    function UpdateRecordInvoice($id,$data){
         $this->db->where('id_invoice',$id);
        $this->db->update('invoice',$data);
    }
    function UpdateRecordInvoicePayment($id,$data){
         $this->db->where('id_invoice_payment',$id);
        $this->db->update('invoice_payment',$data);
    }
}