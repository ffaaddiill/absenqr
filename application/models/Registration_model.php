<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Registration Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Registration model
 * 
 */
class Registration_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * insert to customer web
     * @param array $data
     * @return int last inserted id
     */
    function InsertCustomerWeb($data) {
        $this->db->insert('customer_web',$data);
        return $this->db->insert_id();
    }
    
    /**
     * update data customer web
     * @param int $id
     * @param array $data
     */
    function UpdateCustomerWeb($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('customer_web',$data);
    }
    
    /**
     * count customer web
     * @return int total customer
     */
    function CountCustomerWeb() {
        $count = $this->db
                ->from('customer_web')
                ->where("date_format({$this->db->dbprefix('created_date')},  '%m%y') = date_format( NOW( ) ,  '%m%y')")
                ->count_all_results();
        return $count;
    }
    
    /**
     * get all promotion data
     * @return type
     */
    function GetPromotionsData() {
        $data = $this->db
                ->select('id, name, description')
                ->where('active',1)
                ->get('promotions')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get promo by id
     * @param int $id_promo
     * @return array data
     */
    function GetPromotionByIdData($id_promo) {
        $data = $this->db
                ->where('id',$id_promo)
                ->limit(1)
                ->get('promotions')
                ->row_array();
        
        return $data;
    }
    
    /**
     * get main package
     * @return array data
     */
    function GetMainPackageData() {
        $data = $this->db
                ->select("
                    memberships.*,
                    membership_prices.membership_id,membership_prices.price,membership_prices.total_period,
                    membership_prices.periode_name,membership_prices.free
                ")
                ->join(
                    "(
                        SELECT MAX(id) as price_id,membership_id
                        FROM {$this->db->dbprefix('membership_prices')}
                        GROUP BY membership_id
                    ) {$this->db->dbprefix('membership_prices_max')}",
                    'membership_prices_max.membership_id=memberships.id',
                    'left'
                )
                ->join('membership_prices','membership_prices.id=membership_prices_max.price_id','left')
                ->where('memberships.category_id',1)
                ->where('memberships.deleted_at IS NULL')
                ->where('memberships.is_published',1)
                ->order_by('memberships.position','asc')
                ->get('memberships')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get channel category
     * @return array data
     */
    function GetChannelCategoryData() {
        $data = $this->db
                ->order_by('position','asc')
                ->get('channel_category')
                ->result_array();
        return $data;
    }
    
    /**
     * get channel per package
     * @return array data
     */
    function GetChannelPerPackageData() {
        $data = $this->db
                ->select("
                    {$this->db->dbprefix('group_items')}.name as group_name,{$this->db->dbprefix('unit_items')}.id as unit_item_id,
                    {$this->db->dbprefix('unit_items')}.logo_file_name,
                    {$this->db->dbprefix('unit_items')}.name as channel_name, 
                    {$this->db->dbprefix('unit_items')}.status_hd, {$this->db->dbprefix('master_channel_number')}.channel_number,
                    max(case when upper({$this->db->dbprefix('memberships')}.name) like '%UNIVERSE%' then 1 else 0 end) as big_universe,
                    max(case when upper({$this->db->dbprefix('memberships')}.name) like '%STAR%' then 1 else 0 end) as big_star,
                    max(case when upper({$this->db->dbprefix('memberships')}.name) like '%SUN%' then 1 else 0 end) as big_sun,
                    max(case when upper({$this->db->dbprefix('memberships')}.name) like '%FUN%' then 1 else 0 end) as big_fun,
                    max(case when upper({$this->db->dbprefix('memberships')}.name) like '%DEAL%' then 1 else 0 end) as big_deal
                ",FALSE)
                ->join('group_items','group_items.id=unit_items.group_item_id','left')
                ->join('membership_items','membership_items.unit_item_id=unit_items.id','left')
                ->join('memberships','memberships.id=membership_items.membership_id','left')
                ->join('master_channel_number','master_channel_number.unit_item_id=unit_items.id','left')
                ->where("{$this->db->dbprefix('unit_items')}.group_item_id IS NOT NULL",null,false)
                ->group_by('group_items.name,unit_items.name')
                ->order_by('master_channel_number.channel_number,group_items.id,unit_items.name')
                ->get('unit_items')
                ->result_array();
        return $data;
    }
    
    /**
     * get addon channel group with category
     * @param int $is_featured
     * @return array data
     */
    function GetAddonChannelData($is_featured=0) {
        $return = array();
        if ($is_featured == 1) {
            $this->db->where('memberships.is_featured',$is_featured);
        }
        $data = $this->db
                ->select("
                    {$this->db->dbprefix('memberships')}.id, {$this->db->dbprefix('memberships')}.name as group_name, 
                    {$this->db->dbprefix('memberships')}.position as group_position, 
                    {$this->db->dbprefix('memberships')}.category_id as group_category, 
                    {$this->db->dbprefix('membership_prices')}.price memberships_prices
                ")
                ->join(
                    "(
                        SELECT MAX(id) as price_id,membership_id
                        FROM {$this->db->dbprefix('membership_prices')}
                        GROUP BY membership_id
                    ) {$this->db->dbprefix('membership_prices_max')}",
                    'membership_prices_max.membership_id=memberships.id',
                    'left'
                )
                ->join('membership_prices','membership_prices.id=membership_prices_max.price_id','left')
                ->where('memberships.category_id',2)
                ->where('memberships.is_published',1)
                ->order_by('position','asc')
                ->get('memberships')
                ->result_array();
        if ($data) {
            $i=0;
            foreach ($data as $row) {
                $return[$i] = $row;
                $return[$i]['channel_list'] = $this->db
                        ->select("
                            {$this->db->dbprefix('unit_items')}.*,
                            CONCAT('".FILE_SYSTEM_ASSETS."unit_items/logos/000/000/',LPAD({$this->db->dbprefix('unit_items')}.id,3,'0'),'/medium/',{$this->db->dbprefix('unit_items')}.logo_file_name) logo_file, 
                            {$this->db->dbprefix('membership_items')}.membership_id, {$this->db->dbprefix('membership_items')}.unit_item_id
                        ",FALSE)
                        ->join('unit_items','unit_items.id=membership_items.unit_item_id')
                        ->where('membership_items.membership_id',$row['id'])
                        ->order_by('position','asc')
                        ->get('membership_items')
                        ->result_array();
                $i++;
            }
        }
        return $return;
    }
    
    /**
     * get referal
     * @return array data
     */
    function GetReferalData() {
        $data = $this->db
                ->where("name <> 'Dealer'")
                ->get('referral_categories')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get provinces
     * @return array data
     */
    function GetProvinceData() {
        $data = $this->db
                ->order_by('name')
                ->get('provinces')
                ->result_array();
        return $data;
    }
    
    /**
     * get city by id province
     * @param int $id_province
     * @return array data
     */
    function GetCityByProvinceIdData($id_province) {
        $data = $this->db
                ->where('province_id',$id_province)
                ->order_by('name')
                ->get('cities')
                ->result_array();
        return $data;
    }
    
    /**
     * insert customer niaga
     * @param array $data
     * @return int last inserted id
     */
    function InsertCustomerNiaga($data) {
        $this->db->insert('niaga',$data);
        return $this->db->insert_id();
    }
    
    /**
     * insert customer doku
     * @param array $data
     * @return int last inserted id
     */
    function InsertCustomerDoku($data) {
        $this->db->insert('doku',$data);
        return $this->db->insert_id();
    }
    
    /**
     * get max refno from niaga table
     * @return string refno
     */
    function GetMaxRefNiaga() {
        $data = $this->db
                ->select('max(refno) as refno')
                ->get('niaga')
                ->row_array();
        if (isset($data['refno'])) {
            return $data['refno'];
        } else {
            return '';
        }
    }

    /**
     * get max refno from mandiri table
     * @return string refno
     */
    function GetMaxRefMandiri() {
        $data = $this->db
                ->select('max(no_transaction) as refno')
                ->get('mandiri')
                ->row_array();
        if (isset($data['refno'])) {
            return $data['refno'];
        } else {
            return '';
        }
    }
}
/* End of file Registration_model.php */
/* Location: ./application/models/Registration_model.php */