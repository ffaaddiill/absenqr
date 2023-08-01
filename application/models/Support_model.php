<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Support Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Support model
 * 
 */
class Support_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get support content data
     * @param string $category
     * @return array data
     */
    function GetSupportData($category='Tab Support Content') {
        $data = $this->db
                ->where('LCASE(category)',strtolower($category))
                ->get('page_contents')
                ->result_array();
        return $data;
    }
    
    /**
     * get package data
     * @return array data
     */
    function GetPackageData() {
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
     * get channel per package
     * @return array data
     */
    function GetChannelPerPackageData() 
    {

        $sql = "SELECT 
            b.name as channel_name,
            a.channel_number as channel_number,
            b.logo_file_name as  logo_file_name,
            b.is_hd as status_hd,
            g.addon_group as addon_group,
            b.genre as genre,
            b.id_channel as id_channel,
            b.id_channel_category as id_channel_category,
            max(case when upper(f.package_name) like '%UNIVERSE%' then 1 else 0 end) as big_universe, 
            max(case when upper(f.package_name) like '%STAR%' then 1 else 0 end) as big_star, 
            max(case when upper(f.package_name) like '%SUN%' then 1 else 0 end) as big_sun,
            max(case when upper(f.package_name) like '%FUN%' then 1 else 0 end) as big_fun, 
            max(case when upper(f.package_name) like '%DEAL%' then 1 else 0 end) as big_deal FROM `channel_number` a 
            left join channel b on a.id_channel=b.id_channel 
            left join view_addon_group g on g.id_channel=b.id_channel
            left join `package_addon_channel` c on a.id_channel=c.id_channel 
            left join package_addon d on d.id_package_addon=c.id_package_addon 
            left join package_channel e on a.id_channel=e.id_channel 
            left join package f on f.id_package=e.id_package where b.is_delete = 0 GROUP BY `a`.`channel_number`, `a`.`id` ";
        $data = $this->db->query($sql)->result_array();
        
        // $data = $this->db
        //         ->select("
        //             {$this->db->dbprefix('channel_number')}.channel_number as channel_number,
        //             {$this->db->dbprefix('channel_number')}.id_channel,
        //             {$this->db->dbprefix('channel')}.name as channel_number,
        //             {$this->db->dbprefix('channel')}.is_hd as status_hd,
        //             max(case when upper({$this->db->dbprefix('package')}.package_name) like '%UNIVERSE%' then 1 else 0 end) as big_universe,
        //             max(case when upper({$this->db->dbprefix('package')}.package_name) like '%STAR%' then 1 else 0 end) as big_star,
        //             max(case when upper({$this->db->dbprefix('package')}.package_name) like '%SUN%' then 1 else 0 end) as big_sun,
        //             max(case when upper({$this->db->dbprefix('package')}.package_name) like '%FUN%' then 1 else 0 end) as big_fun,
        //             max(case when upper({$this->db->dbprefix('package')}.package_name) like '%DEAL%' then 1 else 0 end) as big_deal
        //             ",FALSE)
        //         ->join('channel','channel_number.id_channel=channel.id_channel','left')
        //         ->join('package_addon_channel','package_addon_channel.id_channel=channel_number.id_channel','left')
        //         ->join('package_addon','package_addon.id_package_addon=package_addon_channel.id_package_addon','left')
        //         ->join('package_channel','channel_number.id_channel=package_channel.id_channel','left')
        //         ->join('package','package.id_package=package_channel.id_channel','left')
        //         ->group_by('channel_number.channel_number','channel_number.id')
        //         ->order_by('channel_number.channel_number')
        //         ->get('channel_number')
        //         ->result_array();

        // $data = $this->db
        //         ->select("
        //             {$this->db->dbprefix('master_channel_number')}.channel_number,{$this->db->dbprefix('master_channel_number')}.id unit_item_id,
        //             {$this->db->dbprefix('unit_items')}.name as channel_name,{$this->db->dbprefix('unit_items')}.logo_file_name,
        //             {$this->db->dbprefix('unit_items')}.status_hd,{$this->db->dbprefix('v_addon_group')}.addon_group,
        //             max(case when upper({$this->db->dbprefix('memberships')}.name) like '%UNIVERSE%' then 1 else 0 end) as big_universe,
        //             max(case when upper({$this->db->dbprefix('memberships')}.name) like '%STAR%' then 1 else 0 end) as big_star,
        //             max(case when upper({$this->db->dbprefix('memberships')}.name) like '%SUN%' then 1 else 0 end) as big_sun,
        //             max(case when upper({$this->db->dbprefix('memberships')}.name) like '%FUN%' then 1 else 0 end) as big_fun,
        //             max(case when upper({$this->db->dbprefix('memberships')}.name) like '%DEAL%' then 1 else 0 end) as big_deal
        //         ",FALSE)
        //         ->join('unit_items','unit_items.id=master_channel_number.unit_item_id','left')
        //         ->join('group_items','group_items.id=unit_items.group_item_id','left')
        //         ->join('membership_items','membership_items.unit_item_id=unit_items.id','left')
        //         ->join('memberships','memberships.id=membership_items.membership_id','left')
        //         ->join('v_addon_group','v_addon_group.unit_item_id=master_channel_number.unit_item_id','left')
        //         ->group_by('master_channel_number.channel_number,master_channel_number.id,unit_items.logo_file_name,unit_items.status_hd')
        //         ->order_by('master_channel_number.channel_number')
        //         ->get('master_channel_number')
        //         ->result_array();
        return $data;
    }
    
    /**
     * insert request for addon package
     * @param array $post
     * @return int last inserted id
     */
    function InsertRequestAddon($post) {
        $this->db->insert('upgrade_addon',$post);
        return $this->db->insert_id();
    }
    
    /**
     * insert request for service
     * @param array $post
     * @return int last inserted id
     */
    function InsertRequestService($post) {
        $this->db->insert('services',$post);
        return $this->db->insert_id();
    }
    
    /**
     * insert data to voucher fisik
     * @param array $data
     */
    function InsertVoucherFisik($data) {
        $this->db->insert('voucher_fisik', $data);
    }
}
/* End of file Support_model.php */
/* Location: ./application/models/Support_model.php */