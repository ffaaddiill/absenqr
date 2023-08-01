<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Package Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Package model
 * 
 */
class Package_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get package data
     * @return array data
     */
    function GetPackageData() {
        $data = $this->db
                ->where('is_delete',0)
                ->where('id_status',1)
                ->order_by('position','asc')
                ->order_by('id_package','desc')
                ->get('package')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get addon data
     * @param bool $is_featured
     * @return array data
     */
    function GetAddonData($is_featured=0) {
        if ($is_featured==1) {
            $this->db->where('is_featured',1);
        }
        $data = $this->db
                ->where('is_delete',0)
                ->where('id_status',1)
                ->order_by('position','asc')
                ->order_by('id_package_addon','desc')
                ->get('package_addon')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get addon channel data
     * @param bool $is_featured
     * @return array data
     */
    function GetAddonChannel($is_featured=0) {
        $data = $this->GetAddonData($is_featured);
        foreach ($data as $row => $val) {
            $data[$row]['channel_list'] = $this->db
                    ->select('channel.*')
                    ->join('channel','channel.id_channel=package_addon_channel.id_channel','left')
                    ->where('package_addon_channel.id_package_addon',$val['id_package_addon'])
                    ->where('channel.is_delete',0)
                    ->order_by('channel.position','asc')
                    ->order_by('channel.id_channel','desc')
                    ->get('package_addon_channel')
                    ->result_array();
        }
        return $data;
    }
    
    /**
     * get decoder data
     * @param int $is_featured
     * @return array data
     */
    function GetDecoderData($is_featured=0) {
        $data = $this->db
                ->where('is_delete',0)
                ->where('id_status',1)
                ->where('is_featured',$is_featured)
                ->order_by('position','asc')
                ->order_by('id_package_decoder','desc')
                ->get('package_decoder')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get channel category
     * @return array data
     */
    function GetChannelCategoryData() 
    {
        $data = $this->db
                ->order_by('position','asc')
                ->get('channel_category')
                ->result_array();
        return $data;
    }
    
    /**
     * get channel list hierarchy by category
     * @return array data
     */
    function GetChannelHierarchyData() 
    {
        $data = $this->GetChannelCategoryData();
        foreach ($data as $row => $val) {
            $data[$row]['channels'] = $this->db
                    ->join(
                        "
                            (
                                select {$this->db->dbprefix('channel')}.id_channel as channel_id,
                                    max(case when {$this->db->dbprefix('package')}.id_package='1' then 1 else 0 end) as big_universe,
                                    max(case when {$this->db->dbprefix('package')}.id_package='2' then 1 else 0 end) as big_star,
                                    max(case when {$this->db->dbprefix('package')}.id_package='3' then 1 else 0 end) as big_sun,
                                    max(case when {$this->db->dbprefix('package')}.id_package='4' then 1 else 0 end) as big_fun,
                                    max(case when {$this->db->dbprefix('package')}.id_package='5' then 1 else 0 end) as big_deal
                                from channel
                                left join channel_category on channel_category.id_channel_category=channel.id_channel_category
                                left join package_channel on package_channel.id_channel=channel.id_channel
                                left join package on package.id_package=package_channel.id_package
                                group by {$this->db->dbprefix('channel_category')}.category_name, {$this->db->dbprefix('channel')}.name
                            ) as {$this->db->dbprefix('channel_all')}
                        ",
                        'channel_all.channel_id=channel.id_channel',
                        'left'
                    )
                    ->where("{$this->db->dbprefix('channel')}.id_channel_category IS NOT NULL",null,false)
                    ->where("{$this->db->dbprefix('channel')}.id_channel_category",$val['id_channel_category'])
                    ->where("{$this->db->dbprefix('channel')}.is_delete",0)
                    ->order_by("{$this->db->dbprefix('channel')}.position","asc")
                    ->order_by("{$this->db->dbprefix('channel')}.id_channel","desc")
                    ->get('channel')
                    ->result_array();
        }
        return $data;
    }
    
    /**
     * get channel list by status
     * @param string $status
     * @return array data
     */
    function GetChannelByStatusData($status) {
        $data = $this->db
                ->where($status,1)
                ->get('channel')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get package by id
     * @param int $id_package
     * @return array data
     */
    function GetPackageByIdData($id_package) {
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('id_package',$id_package)
                ->limit(1)
                ->get('package')
                ->row_array();
        return $data;
    }
    
    /**
     * get package addon by id
     * @param int $id_package
     * @return array data
     */
    function GetPackageAddonByIdData($id_package) {
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('id_package_addon',$id_package)
                ->limit(1)
                ->get('package_addon')
                ->row_array();
        return $data;
    }
    
    /**
     * get package decoder by id
     * @param int $id_package
     * @return array data
     */
    function GetPackageDecoderByIdData($id_package) {
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('id_package_decoder',$id_package)
                ->limit(1)
                ->get('package_decoder')
                ->row_array();
        return $data;
    }
    
    /**
     * get addon/decoder name info
     * @param string $table
     * @param array $packages
     * @return string name
     */
    function GetAddonDecoderNameData($table,$packages) {
        $return = '';
        $package_id = explode(',', $packages);
        if (is_array($package_id)) {
            $package_id=array_map('trim',$package_id);
            $this->db->where_in('id_package_'.$table,$package_id);
        } else {
            $this->db->where('id_package_'.$table,$package_id);
        }
        $data = $this->db
                ->select($table.'_name as name')
                ->get('package_'.$table)
                ->result_array();
        if ($data) {
            $arr = array();
            foreach ($data as $row => $val) {
                $arr[] = $val['name'];
            }
            $return = implode(',', $arr);
        }
        return $return;
    }
    
    /**
     * get package and channel list it's package
     * @return array data
     */
    function GetChannelByMainPackage() {
        $data = $this->GetPackageData();
        
        // get list channel
        foreach ($data as $row => $package) {
            $data[$row]['channel_list'] = $this->db
                                    ->select('channel.*')
                                    ->join('channel','channel.id_channel=package_channel.id_channel','left')
                                    ->where('id_package',$package['id_package'])
                                    ->where('channel.is_delete',0)
                                    ->order_by('position','asc')
                                    ->order_by('id_channel','desc')
                                    ->get('package_channel')
                                    ->result_array();
        }
        
        return $data;
    }
    
}
/* End of file Package_model.php */
/* Location: ./application/models/Package_model.php */