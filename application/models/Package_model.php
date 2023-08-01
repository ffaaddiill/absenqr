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
    function GetPackageByIdDataGroup($id_package,$type) {
        if($type==1){
            $data = $this->db
                ->select('package_name AS name,price AS price')
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('id_package',$id_package)
                ->limit(1)
                ->get('package')
                ->row_array();
        }else{
            $data = $this->db
                ->select('addon_name as name,price_addon AS price')
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('id_package_addon',$id_package)
                ->limit(1)
                ->get('package_addon')
                ->row_array();
        }
        
        return $data;
    }

    /**
    * get package data
    * @return array data
    */
    function GetPackageComboData(){
        $data = $this->db
                ->where('is_delete',0)
                ->where('id_status',1)
                ->order_by('position','asc')
                ->get('package_group')
                ->result_array();
        
        if($data){
            foreach ($data as $key=>$package_combo) {
                $data[$key]['item'] = $this->db
                            ->where('id_package_group',$package_combo['id_package_group'])
                            ->get('package_group_item')
                            ->result_array();

                //echo 'real price anu : ' . $package_combo['price'] . '<br><br>';
                //for christmas discount
                $real_price = $package_combo['price'];
                $total_diskon_10 = floor( ( $real_price / 100) * 10 );
                
                $harga_natal = $real_price - $total_diskon_10; // 10% off for discount
                $data[$key]['real_price'] = $real_price;
                $data[$key]['price_diskon_10percent'] = $total_diskon_10;
                $data[$key]['price_natal'] = $harga_natal;
                 
                foreach ($data[$key]['item'] as $key2 => $value) {
                    $detail = $this->GetPackageByIdDataGroup($value['id_package'],$value['type']);
                    $data[$key]['item'][$key2]['name'] = $detail['name'];
                    $data[$key]['item'][$key2]['price'] = $detail['price']; // real price of each item
                } 
            }

            /*echo '<pre>';
            print_r($data);
            die();*/
        }
    
        return $data;
    }

    /**
    * get package data
    * @param string $path
    * @return singel array data
    */
    function GetPackageComboDataByPath($path){
        $data = $this->db
                ->where('is_delete',0)
                ->where('id_status',1)
                ->where('lcase(uri_path)',$path)
                ->order_by('position','asc')
                ->get('package_group')
                ->row_array();

        if($data){
            //for christmas discount
            $real_price = $data['price'];
            $total_diskon_10 = floor( ( $real_price / 100) * 10 );
            
            $harga_natal = $real_price - $total_diskon_10; // 10% off for discount
            $data['real_price'] = $real_price;
            $data['price_diskon_10percent'] = $total_diskon_10;
            $data['price_natal'] = $harga_natal;

            $data['item'] = $this->db
                            ->where('id_package_group',$data['id_package_group'])
                            ->get('package_group_item')
                            ->result_array();

            //echo $this->db->last_query();
            //echo '<br>';

            $categories = $this->db
                        ->select('*')
                        ->where('is_delete', 0)
                        ->order_by('position', 'asc')
                        ->get('channel_category')
                        ->result_array();

            /*echo '<pre>';
            print_r($categories);
            echo 'dies<br><br>';*/
            $a = 0; $b = 0;
            foreach($categories as $key_category => $category) {

                $data['category_channel'][$key_category] = $category;

                foreach ($data['item'] as $key => $item) {
                    $detail = $this->GetPackageByIdDataGroup($item['id_package'],$item['type']);
                    $data['item'][$key]['name'] = $detail['name'];
                    $data['item'][$key]['price'] = $detail['price'];
                    //$channel[] = $this->GetChannelForPackageCombo( $item['id_package'],$item['type'], $category['id_channel_category'] );
                    $data['category_channel'][$key_category]['channel_list'][$key] = $this->GetChannelForPackageCombo( $item['id_package'],$item['type'], $category['id_channel_category'] );
                    $data['category_channel'][$key_category]['item_type'] = $item['type'];
                    $data['category_channel'][$key_category]['id_package_channel_or_addon'] = $item['id_package'];
                    $data['category_channel'][$key_category]['last_query'] = $this->db->last_query();
                    //echo $category['id_channel_category'] . '<br>';

                    $a++;
                    /*echo 'item type : ' . $item['type'] . '<br>';
                    echo 'package/addon : ' . $item['id_package'] . '<br>';
                    echo $this->db->last_query() . '<br><br>';*/
                }

                $b++;
            }
            //$data['category_channel'][$key_category]['channel'] = $channel;

            /*foreach ($data['item'] as $key => $item) {
                    $detail = $this->GetPackageByIdDataGroup($item['id_package'],$item['type']);
                    $data['item'][$key]['name'] = $detail['name'];
                    $data['item'][$key]['price'] = $detail['price'];
                    $channel[] = $this->GetChannelForPackageCombo($item['id_package'],$item['type']);
                }
                $data['channel'] = $channel;*/
        }    
        //echo $this->db->last_query();
        /*echo '<pre>';
        print_r($data);
        die();*/

        return $data;


    }


    function GetChannelForPackageCombo($id_package,$type, $category_id){
        if($type==1){
            $data = $this->GetChannelByIdMainPackage($id_package, $category_id);
        }else{
            $data = $this->GetAddonChannelById($id_package, $category_id);
        }
        return $data;
    }

    /**
     * get addon channel data by id addon
     * @param int $id_addon
     * @return array data
     */
    function GetAddonChannelById($id_addon, $category_id) {
        
        $data= $this->db
                    ->select('
                        channel.*,
                        package_addon_channel.id_package_addon
                        ')
                    ->join('channel','channel.id_channel = package_addon_channel.id_channel','left')
                    //->join('channel_category', 'channel_category.id_channel_category = channel.id_channel_category', 'left')
                    ->where('package_addon_channel.id_package_addon',$id_addon)
                    ->where('channel.is_delete',0)
                    ->where('channel.id_channel_category', $category_id)
                    //->order_by('channel_category.position','asc')
                    //->order_by('channel_category.id_channel_category','asc')
                    ->order_by('channel.position_in_type','asc')
                    ->order_by('channel.id_channel','desc')
                    ->get('package_addon_channel')
                    ->result_array();
        
        return $data;
    }

    /**
     * get channel bu id main package
     * @param int $id_package
     * @return array data
     */
    function GetChannelByIdMainPackage($id_package, $category_id) {
        
        
            $data= $this->db
                    ->select('
                        channel.*,
                        package_channel.id_package
                        ')
                    ->join('channel','channel.id_channel = package_channel.id_channel','left')
                    //->join('channel_category', 'channel_category.id_channel_category = channel.id_channel_category', 'left')
                    ->where('package_channel.id_package',$id_package)
                    ->where('channel.is_delete',0)
                    ->where('channel.id_channel_category', $category_id)
                    //->order_by('channel_category.position', 'asc')
                    //->order_by('channel_category.id_channel_category','asc')
                    ->order_by('channel.position_in_type','asc')
                    ->order_by('channel.id_channel','desc')
                    ->get('package_channel')
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
                    //->order_by('channel.id_channel','desc')
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
                                where channel.is_delete = 0
                                group by {$this->db->dbprefix('channel_category')}.category_name, {$this->db->dbprefix('channel')}.name
                            ) as {$this->db->dbprefix('channel_all')}
                        ",
                        'channel_all.channel_id=channel.id_channel',
                        'left'
                    )
    
                    ->where("{$this->db->dbprefix('channel')}.id_channel_category IS NOT NULL",null,false)
                    ->where("{$this->db->dbprefix('channel')}.id_channel_category",$val['id_channel_category'])
                    ->where("{$this->db->dbprefix('channel')}.is_delete",0)
                    ->where("{$this->db->dbprefix('channel')}.id_channel_category !=",0)
                    ->order_by("{$this->db->dbprefix('channel')}.position","asc")
                    ->order_by("{$this->db->dbprefix('channel')}.id_channel","desc")
                    ->get('channel')
                    ->result_array();
        }
        #echo $this->db->last_query();
        return $data;
    }
    
    /**
     * get channel list by status
     * @param string $status
     * @return array data
     */
    function GetChannelByStatusData($status) {
        $order = 'position';
        if($status=='is_free'){
            $order= 'position_sd';
        }elseif($status=='is_hd'){
            $order= 'position_hd';

        }elseif ($status=='is_exclusive') {
            $order= 'position_ekslusif';
            # code...
        }
        $data = $this->db
                ->where($status,1)
                ->where('is_delete',0)
                ->order_by($order,'asd')
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
     * get package by id
     * @param int $id_package
     * @return array data
     */
    function GetPackageGroupDataById($id_package) {
        
        $data = $this->db
                ->where('is_delete',0)
                ->where('id_status',1)
                ->where('id_package_group',$id_package)
                ->order_by('position','asc')
                ->get('package_group')
                ->row_array();
        
        if($data){
            // foreach ($data as $key=>$package_combo) {
                $data['item'] = $this->db
                            ->where('id_package_group',$data['id_package_group'])
                            ->get('package_group_item')
                            ->result_array();

                //for christmas discount
                $real_price = $data['price'];
                $total_diskon_10 = floor( ( $real_price / 100) * 10 );
                
                $harga_natal = $real_price - $total_diskon_10; // 10% off for discount
                $data['real_price'] = $real_price;
                $data['price_diskon_10percent'] = $total_diskon_10;
                //$data['price_natal'] = $harga_natal;
                $data['price'] = $harga_natal; //final price

                foreach ($data['item'] as $key2 => $value) {
                    $detail = $this->GetPackageByIdDataGroup($value['id_package'],$value['type']);
                    $data['item'][$key2]['name'] = $detail['name'];
                    $data['item'][$key2]['price'] = $detail['price'];
                }
                
                /*echo '<pre>';
                print_r($data);
                die();*/

            //}
              
        }
    
        
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
                ->select($table.'_name as name,price_'.$table.' as price')
                ->get('package_'.$table)
                ->result_array();
        // if ($data) {
        //     $arr = array();
        //     foreach ($data as $row => $val) {
        //         $arr[] = $val['name'].'( '.$val['price'] .' )';
        //     }
        //     $return = implode(',', $arr);
        // }
        return $data;
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