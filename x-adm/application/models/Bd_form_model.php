<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bd_form Model Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Bd_form model
 * 
 */
class Bd_form_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    function GetItemBDById($id){
      $data = $this->db
              ->where('id_form_bd_item',$id)
              ->get('form_bd_item')
              ->row_array();
      $data['account_id'] = $this->db
                            ->where('id_vendor',$data['id_vendor'])
                            ->get('vendor_banking')
                            ->result_array();
      $data['bd_number'] = $this->db
                            ->where('id_form_bd',$data['id_form_bd'])
                            ->get('form_bd')
                            ->row()->bd_number;
      return $data;
    }

    function GetItemBDByIdSOA($id){
      $data = $this->db
              ->where('id_form_soa_item',$id)
              ->get('form_soa_item')
              ->row_array();
      
      $data['bd_number'] = $this->db
                            ->where('id_form_bd',$data['id_form_bd'])
                            ->get('form_bd')
                            ->row()->bd_number;
      return $data;
    }

    function UpdateRecordPPHItem($id,$data){
      $this->db->where('id_form_bd_item_pph',$id);
      $this->db->update('form_bd_item_pph',$data);
    }

    function UpdateRecordPPHItemSOA($id,$data){
      $this->db->where('id_form_soa_item_pph',$id);
      $this->db->update('form_soa_item_pph',$data);
    }

    function UpdateRecordItemBd($id,$data){
      $this->db->where('id_form_bd_item',$id);
      $this->db->update('form_bd_item',$data);
    }
    function UpdateRecordItemBdSOA($id,$data){
      $this->db->where('id_form_soa_item',$id);
      $this->db->update('form_soa_item',$data);
    }

    function GetPPHItemByIdBDItem($id){
      $data = $this->db
              ->select('form_bd_item_pph.*,form_bd_item.real_amount,sub_tax.name as tax_name,currency.iso_2')
              ->where('form_bd_item_pph.id_form_bd_item',$id)
              ->join('form_bd_item','form_bd_item.id_form_bd_item=form_bd_item_pph.id_form_bd_item')
              ->join('sub_tax','sub_tax.id_sub_tax=form_bd_item_pph.id_sub_tax')
              ->join('currency','currency.id_currency=form_bd_item.id_currency')
              ->where('form_bd_item_pph.is_delete',0)
              ->get('form_bd_item_pph')
              ->result_array();
      return $data;
    }

    function GetPPHItemByIdBDItemSOA($id){
      $data = $this->db
              ->select('form_soa_item_pph.*,form_soa_item.real_amount,sub_tax.name as tax_name,currency.iso_2')
              ->where('form_soa_item_pph.id_form_soa_item',$id)
              ->join('form_soa_item','form_soa_item.id_form_soa_item=form_soa_item_pph.id_form_soa_item')
              ->join('sub_tax','sub_tax.id_sub_tax=form_soa_item_pph.id_sub_tax')
              ->join('currency','currency.id_currency=form_soa_item.id_currency')
              ->where('form_soa_item_pph.is_delete',0)
              ->get('form_soa_item_pph')
              ->result_array();
      return $data;
    }

    /**
    * get detail pph item by id BD
    * @param int $id
    * @return singel array
    */
    function GetDetailPPHItemById($id){

      $data = $this->db
              ->select('form_bd_item_pph.id_form_bd_item_pph as id_item_pph,form_bd_item_pph.id_form_bd_item as id_item,form_bd_item_pph.*,form_bd_item.real_amount,form_bd_item.name as item_name')
              ->where('form_bd_item_pph.id_form_bd_item_pph',$id)
              ->join('form_bd_item','form_bd_item.id_form_bd_item=form_bd_item_pph.id_form_bd_item')
              ->get('form_bd_item_pph')
              ->row_array();
      return $data;
    }

    /**
    * get detail pph item by id BD
    * @param int $id
    * @return singel array
    */
    function GetDetailPPHItemByIdSOA($id){

      $data = $this->db
              ->select('form_soa_item_pph.id_form_soa_item_pph as id_item_pph,form_soa_item_pph.id_form_soa_item as id_item,form_soa_item_pph.*,form_soa_item.real_amount,form_soa_item.name as item_name')
              ->where('form_soa_item_pph.id_form_soa_item_pph',$id)
              ->join('form_soa_item','form_soa_item.id_form_soa_item=form_soa_item_pph.id_form_soa_item')
              ->get('form_soa_item_pph')
              ->row_array();
      return $data;
    }

    /**
    *
    */
    function getCostcenterByDivisi($id_divisi=0){
        if($id_divisi && $id_divisi != 14){
            $this->db->where('id_divisi',$id_divisi);
        }

        $data = $this->db
                ->order_by('id_cost_center','asc')
                ->where('is_delete',0)
                ->get('cost_center')
                ->result_array();
               # echo $this->db->last_query();
        return $data;
    }

    function InsertAccountVendorBatch($data){
      $this->db->insert_batch('vendor_banking',$data);
    }
    function GetRequestor($id_divisi=0){
      if($id_divisi){
        $this->db->where('id_divisi',$id_divisi);
      }
      $data = $this->db
              ->get('requestor')
              ->result_array();
      return $data;
    }
    function getCodeByCostCenter($id_cost_center){
      $data = $this->db
              ->where('id_cost_center',$id_cost_center)
              ->get('cost_center')
              ->row_array();
      return $data;
    }
    function GetVendorAccountBankingById($id_vendor_banking){
      $data = $this->db
              ->where('id_vendor_banking',$id_vendor_banking)
              ->get('vendor_banking')
              ->row_array();
      return $data;
    }
    /**
    * get divisi
    * @return arrau data
    */
     function GetDivisi(){
        $data = $this->db
                ->order_by('id_divisi','asc')
                ->where('is_delete',0)
                ->get('divisi')
                ->result_array();
        return $data;
     }
    /**
     * get vendor data
     * @return array data
     */
    function GetVendor() {
        
        $data = $this->db
                ->order_by('id_vendor','asc')
                ->join('vendor_category','vendor_category.id_vendor_category=vendor.id_category_vendor','left')
                ->get('vendor')
                ->result_array();
        
        return $data;
    }
    function GetVendorAccountBanking($id){
      $data = $this->db
              ->where('id_vendor',$id)
              ->get('vendor_banking')->result_array();
      return $data;
    }
    function GetResultReport($post=array()){
      if($post){
        if($post['bd_number']){
          $this->db->where('form_bd.bd_number',$post['bd_number']);
        }
      }
      $data = $this->db
              ->select('
                      id_form_bd_item_pph, 
                      id_form_bd,
                      bd_number as bd_number,
                      prefix_vendor,
                      name as vendor_name,
                      item_name as description,
                      round(sum(real_amount_part)) as original_amount, 
                      round(sum(amount_part)) as idr_amount,
                      percentage as rate_pph,
                      round(sum(amount_part)) as pph_amount,
                      wht_code as wht_code,
                      npwp,
                      address_npwp,
                      pph_23,
                      pph_26,
                      pph_21,
                      pph_4')
              ->group_by('id_form_bd_item_pph')
              ->get('view_pph_all')->result_array();
             // echo $this->db->last_query();
        return $data;
    }

    function GetReportPPn($post=array()){
      if($post){

      }
      $data = $this->db
              ->get('view_ppn')
              ->result_array();
      return $data;
    }
    function InsertRecordVendor($param){
      $this->db->insert('vendor',$param);
      $id = $this->db->insert_id();

      return $id;
    }

    function InsertRecordRequestor($param){
      $this->db->insert('requestor',$param);
      $id = $this->db->insert_id();

      return $id;
    }

    /**
     * check exist bd_number
     * @param string $bd_number
     * @param int $id
     * @return boolean true/false 
     */
    function checkBdNumber($bd_number,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_form_bd !=',$id);
        }
        $count_records = $this->db
                ->from('form_bd')
                ->where('is_delete',0)
                ->where('bd_number',$bd_number)
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * check exist soa_number
     * @param string $soa_number
     * @param int $id
     * @return boolean true/false 
     */
    function checkSOANumber($soa_number,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_form_bd !=',$id);
        }
        $count_records = $this->db
                ->from('form_soa')
                ->where('is_delete',0)
                ->where('soa_number',$soa_number)
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    /**
     * get all admin data
     * @param string $param
     * @return array data
     */
    function GetAllBd_formData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='main_tax'){
                            $this->db->like('LCASE(`tax`.`name`)',strtolower($param['search_value']));
                        }else{
                            $this->db->like('LCASE(`sub_tax`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                        
                    } else {
                        if($val['data']=='main_tax'){
                            $this->db->or_like('LCASE(`tax.name`)',strtolower($param['search_value']));
                        }else{
                            $this->db->or_like('LCASE(`sub_tax`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        if (isset($param['row_from']) && isset($param['length'])) {
            $this->db->limit($param['length'],$param['row_from']);
        }
        if (isset($param['order_field'])) {
            if (isset($param['order_sort'])) {
                $this->db->order_by($param['order_field'],$param['order_sort']);
            } else {
                $this->db->order_by($param['order_field'],'desc');
            }
        } else {
            $this->db->order_by('id','desc');
        }
        $data = $this->db
                ->select('sub_tax.*,tax.name as main_tax,sub_tax.id_sub_tax as id')
                ->join('tax','tax.id_tax=sub_tax.id_tax','left')
                ->where('sub_tax.is_delete',0)
                ->get('sub_tax')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllBd_form($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='main_tax'){
                            $this->db->like('LCASE(`tax`.`name`)',strtolower($param['search_value']));
                        }else{
                            $this->db->like('LCASE(`sub_tax`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                        
                    } else {
                        if($val['data']=='main_tax'){
                            $this->db->or_like('LCASE(`tax.name`)',strtolower($param['search_value']));
                        }else{
                            $this->db->or_like('LCASE(`sub_tax`.`'.$val['data'].'`)',strtolower($param['search_value']));
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                ->join('vendor','vendor.id_tax=form_bd.id_tax','left')
                ->where('form_bd.is_delete',0)
                ->from('form_bd')
                ->count_all_results();
        return $total_records;
    }
    
    /**
    * Get PPH tax 
    * @return array data
    */
    function GetPPH(){
        $data = $this->db
                ->select('sub_tax.id_sub_tax,sub_tax.name as name')
                ->join('tax','tax.id_tax=sub_tax.id_tax','left')
                ->where('tax.is_delete',0)
                ->where('sub_tax.is_delete',0)
                ->get('sub_tax')
                ->result_array();
        return $data;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetBd_form($id) {
        $data = $this->db
                ->where('id_form_bd',$id)
                ->limit(1)
                ->get('form_bd')
                ->row_array();
        $data['item_bds'] = $this->db
                            ->select('form_bd_item.*,currency.iso_1,currency.iso_2,
                              ( case when (form_bd_item.id_currency) = 0 then 1 else currency.value end
                                ) as factor_curs

                              ')
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
    function GetBd_formWithSOA($id){
      $data = $this->db
                ->where('id_form_bd',$id)
                ->limit(1)
                ->get('form_bd')
                ->row_array();
      if($data){
         $record = $this->db
                        ->where('id_form_bd',$id)
                        ->where('is_delete',0)
                        ->get('form_soa')
                        ->row_array();
          if($record){
            $data['soa_number']             = $record['soa_number'];
            $data['id_form_soa']            = $record['id_form_soa'];
            $data['spending_amount_soa']    = $record['spending_amount'];
            $data['item_soas']       = $this->db
                                      ->where('id_form_soa',$record['id_form_soa'])
                                      ->join('currency','currency.id_currency=form_soa_item.id_currency','left')
                                      ->where('is_delete',0)
                                      ->get('form_soa_item')
                                      ->result_array();
                if($data['item_soas']){
                    foreach ($data['item_soas'] as $key => $value) {
                      $data['item_soas'][$key]['pph_item'] = $this->db
                                                  ->select('form_soa_item_pph.*,sub_tax.name as tax_name')  
                                                  ->join('sub_tax','sub_tax.id_sub_tax=form_soa_item_pph.id_sub_tax','left')
                                                  #->where()
                                                  ->where('form_soa_item_pph.is_delete',0)
                                                  ->where('id_form_soa_item',$value['id_form_soa_item'])
                                                  ->get('form_soa_item_pph')
                                                  ->result_array();
                    }
                }
          }
      }
      return $data;
    }

    function UpdateRecordSOA($id,$post){
      $this->db->where('id_form_soa',$id);
      $this->db->update('form_soa',$post);
    }

    function InsertRecordSOA($data){
      $this->db->insert('form_soa',$data);
      $last_id = $this->db->insert_id();

      return $last_id;
    }


    function GetBd_itemByIdBd($id){
      $data = $this->db
              ->select('form_bd_item.*,currency.iso_1,currency.iso_2,currency.value as factor_curs')
              ->where('id_form_bd',$id)
              ->join('currency','currency.id_currency=form_bd_item.id_currency','left')
              ->where('is_delete',0)
              ->get('form_bd_item')
              ->result_array();

      foreach ($data as $key => $value) {
            $data[$key]['pph_item'] = $this->db
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
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('form_bd',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('form_bd_item',$param);
    }
    function InsertItemSOABatch($param){
        $this->db->insert_batch('form_soa_item',$param);
    }
    function InsertPPHBatch($param){
        $this->db->insert_batch('form_bd_item_pph',$param);
    }
    function InsertSOAPPHBatch($param){
        $this->db->insert_batch('form_soa_item_pph',$param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_form_bd',$id);
        $this->db->update('form_bd',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_form_bd',$id);
        $this->db->update('form_bd',array('is_delete'=>1));
    }
    
    /**
     * check exist email
     * @param string $email
     * @param int $id
     * @return boolean true/false 
     */
    function checkName($email,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_sub_tax !=',$id);
        }
        $count_records = $this->db
                ->from('tax')
                ->where('LCASE(name)',strtolower($email))
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * check exist username
     * @param string $username
     * @param int $id
     * @return boolean true/false 
     */
    function checkExistsUsername($username,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_sub_tax !=',$id);
        }
        $count_records = $this->db
                ->from('tax')
                ->where('username',$username)
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
/* End of file Bd_form_model.php */
/* Location: ./application/models/Bd_form_model.php */