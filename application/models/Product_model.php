<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Product model
 * 
 */
class Product_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
	
	function getCategory($id='', $slug='') {
		if(empty($id) && !empty($slug)) {
			$this->db->where('product_category.slug', $slug);
		} elseif($empty($slug) && !empty($id)) {
			$this->db->where('product_category.id', $id);
		}
		$data = $this->db
			->where('is_active', 1)
			->where('is_delete', 0)
			->get('product_category')->row_array();
		
		return $data;
	}

	function getAllCars() {
		$data = $this->db
                ->select('
                    product.id_product,
                    product.title,
                    product.teaser,
                    product.description,
                    product.primary_image,
                    product.thumbnail_image,
                    product.image_alt,
                    product.meta_keyword,
                    product.meta_description,
                    product.picture_file_name,
                    product.picture_content_type,
                    product.slug,
                    product.ext_link,
                    product.with_register,
                    product.product_type,
                    product.price,
                    product.video_url,
                    product.video_id,
                    product.id_status,
                    product.is_productheadline,
                    product.is_delete,
                    product.is_twitter,
                    product.publish_date,
                    product.modify_date,
                    product.create_date,
                    product.position,
                    product_category.category_name,
                    product_category.slug product_category_slug,
                    product_package.package_name,
                    product_package.is_driver,
                    product_package.is_bbm,
                    product_package.is_tol,
                    product_package.is_parkir,
                    area.area_name,
                    area.slug area_slug,
                    area.is_active area_is_active
                    ')
                ->join('product_category', 'product.id_product_category = product_category.id', 'LEFT')
                ->join('product_package', 'product.id_package = product_package.id', 'LEFT')
                ->join('area', 'product.id_area = area.id', 'LEFT')
                ->where('product.is_delete', 0)
                ->where('product.id_status', 1)
                ->get('product')
                ->result_array();

        return $data;          
	}
    
    function GetAllNewPromoByType($type=1,$limit=0){
        if ($limit) {
            $this->db->limit($limit);
        }
        //echo $type;
        if($type){
            $this->db->where('id_product_category',$type);
        }
        $now = date("Y-m-d");
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('publish_date <=',$now)
                ->where("(end_date >= '{$now}' OR end_date IS NULL || end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->order_by('id_product','desc')
                ->get('product')
                ->result_array();
               // echo $this->db->last_query();
        return $data;
    }

    /**
     * get channel list by status
     * @param int $limit
     * @return array data
     */
    function GetProductData($limit=0, $category='', $slug="", $not_equal_to = '', $not_equal_to_category='', $order_by_column='product.publish_date', $order_position='desc') {
        if ($limit) {
            $this->db->limit($limit);
        }
        // if($id_product_category) {
            // $this->db->where('product.id_product_category', $id_product_category);
        // }
        if(!empty($slug)) {
        	$this->db->where('product_category.slug', $slug);
        }

        if(!empty($category)) {
			$this->db->where('product_category.slug', $category);
		}
		
		if(!empty($not_equal_to)) {
			$this->db->where_not_in('product.id_product', $not_equal_to);
		}
		
		if(!empty($not_equal_to_category)) {
			$this->db->where_not_in('product_category.slug', $not_equal_to_category);
		}

		if(!empty($order_position) && !empty($order_by_column)) {
                $this->db->order_by($order_by_column, $order_position);
		} else {
			$this->db->order_by('product.publish_date', 'desc');  
		}
		
        $now = date("Y-m-d H:i:s");
        $data = $this->db
                ->where('product.id_status',1)
                ->where('product.is_delete',0)
                //->where('product.product_type !=' ,'video')
				//->where('product_category.slug !=' ,'video')
                ->where('product.publish_date <=',$now)
                //->where("(product.end_date >= '{$now}' OR product.end_date IS NULL || product.end_date = '0000-00-00')")
                //->order_by('publish_date','desc')
                ->join('product_category', 'product.id_product_category = product_category.id', 'left')
                ->get('product')
                ->result_array();
        return $data;
	}
	
	function getProductTerkini($limit=0, $slug="", $not_equal_to = '', $order_by_column='N.publish_date', $order_position='desc') {
		
		$where = '';
		
		if (empty($limit)) {
            $limit = 5;
        }
		
        if(!empty($slug)) {
        	$where .= ' AND NC.slug = "' . $slug . '"';
        }
		
		if(!empty($not_equal_to)) {
			$where .= ' AND N.id_product NOT IN('.$not_equal_to.')';
		}

		if(empty($order_position) && !empty($order_by_column)) {
            $order_by_column = 'N.publish_date';
			$order_position = 'desc';
		}
		
        $now = date("Y-m-d");
        $data = $this->db
				->from("(select 
						N.id_product,
						N.id_product_category,
						N.title,
						N.teaser,
						N.description,
						N.publish_date,
						N.end_date,
						N.primary_image,
						N.thumbnail_image,
						N.image_alt,
						N.meta_keyword,
						N.meta_description,
						N.picture_file_name,
						N.picture_content_type,
						N.uri_path,
						N.ext_link,
						N.with_register,
						N.product_type,
						N.video_url,
						N.video_id,
						N.id_status,
						N.is_delete,
						N.modify_date,
						N.create_date,
						N.position,
						NC.id,
						NC.category_name,
						NC.slug,
						NC.is_active nc_is_active,
						NC.is_delete nc_is_delete,
						NC.created_date nc_created_date,
						NC.modified_date nc_modified_date,
						NC.deleted_date nc_deleted_date
						 	from product N
							LEFT JOIN `product_category` NC ON N.`id_product_category` = NC.`id` 
							WHERE N.`id_status` = 1 
							AND N.`is_delete` = 0 
							AND N.`publish_date` <= NOW()".$where." 
							ORDER BY ".$order_by_column." ".$order_position." LIMIT ".$limit.") NT")
				->order_by('NT.publis_date', 'ASC')
                ->get()
                ->result_array();
        return $data;
	}

    /**
     * get only product list by status
     * @param int $limit
     * @return array data
     */
    function GetProductOnlyData($limit=0, $id_product_category=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        if($id_product_category) {
            $this->db->where('id_product_category', $id_product_category);
        }
        $now = date("Y-m-d H:i:s");
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('publish_date <=',$now)
                ->where("(end_date >= '{$now}' OR end_date IS NULL || end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->order_by('id_product','desc')
                ->get('product')
                ->result_array();
        return $data;
    }
    /**
     * get product by url/slug
     * @param string $uri_path
     * @return array data
     */
    function GetProductByUriPath($uri_path) {
        $now = date("Y-m-d H:i:s");
        $data = $this->db
                ->where('LCASE(product.uri_path)',strtolower($uri_path))
                ->where('product.id_status',1)
                ->where('product.is_delete',0)
                ->where('product.publish_date <=',$now)
                ->where("(product.end_date >= '{$now}' OR product.end_date IS NULL || product.end_date = '0000-00-00')")
                ->order_by('product.id_product','desc')
                ->limit(1)
                ->join('product_category', 'product.id_product_category = product_category.id', 'left')
                ->get('product')
                ->row_array();
        return $data;
    }
	
	function GetProductById($id) {
        $now = date("Y-m-d H:i:s");
        $data = $this->db
                ->where('product.id_product', $id)
                ->where('product.id_status',1)
                ->where('product.is_delete',0)
                ->where('product.publish_date <=',$now)
                ->where("(product.end_date >= '{$now}' OR product.end_date IS NULL || product.end_date = '0000-00-00')")
                ->order_by('product.id_product','desc')
                ->limit(1)
                ->join('product_category', 'product.id_product_category = product_category.id', 'left')
                ->get('product')
                ->row_array();
        return $data;
    }
	
	function getHeadlineProduct($category='') {
		$now = date('Y-m-d H:i:s');
		//$this->db->where('product_category.category_name', 'nasional');
		$this->db->where('product.id_status', 1);
		$this->db->where('product.is_delete', 0);
		$this->db->where('product.product_type !=' ,'video');
		$this->db->where('product_category.slug !=' ,'video');
		$this->db->where('product.publish_date <=', $now);
		
		if(empty($category)) {
			$this->db->limit(7);
		}
		$this->db->join('product_category', 'product.id_product_category = product_category.id', 'LEFT');
		$this->db->order_by('product.publish_date', 'DESC');
		$data = $this->db->get('product')->result_array();
		return $data;
	}
	
	function getProductVideo($limit='') {

		if(empty($limit)) {
			$limit = 1;
		}

		$data = $this->db
				->where('product.is_delete', 0)
				->where('product.id_status', 1)
				->where('product.product_type', 'video')
				->where('product.video_id !=', '')
				->join('product_category', 'product.id_product_category=product_category.id', 'left')
				->limit($limit)
				->get('product')->result_array();
		
		$count_data = count($data);

		if($count_data % 3 != 0) {
			$limit = $count_data - ($count_data % 3);
		}

		$data_video = array();
		$flag = 0;
		foreach($data as $key=>$val) {
			if($key%3==0 && $key!=0) {
				$flag++;
			} 
			$data_video[$flag][] = $val;
		}		
		return $data_video;
	}
	
	function getSingleVideo($id) {
		$data = $this->db
				->where('id_product', $id)
				->where('is_delete', 0)
				->where('id_status', 1)
				->where('product_type', 'video')
				->limit(1)
				->get('product')->row_array();
				
		return $data;
	}
	
	function getVideos($limit, $product_type='', $slug='') {
		if(!empty($product_type)) {
			$this->db->where('product.product_type', $product_type);
		}
		
		if(!empty($slug)) {
			$this->db->where('product.uri_path', $slug);
		}

		if(!empty($limit) && is_numeric($limit)) {
			$this->db->limit($limit);
		}
		
		$data = $this->db
			->where('product.is_delete', 0)
			->where('product.id_status', 1)
			->join('product_category', 'product_category.id=product.id_product', 'LEFT')
			->get('product')->result_array();
				
		return $data;
	}

	function search($key='') {
		$now = date("Y-m-d H:i:s");
		$data = $this->db
				->where('product.id_status',1)
                ->where('product.is_delete',0)
                ->where('product.product_type !=' ,'video')
				->where('product_category.slug !=' ,'video')
				->where('product.publish_date <=',$now)
				->like('product.title', $key)
				->or_like('product.description', $key)
                
                //->where("(product.end_date >= '{$now}' OR product.end_date IS NULL || product.end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->join('product_category', 'product.id_product_category = product_category.id', 'left')
                ->get('product')
                ->result_array();
				
		return $data;
	}
	
	function countProductByCategory($category = '') {
		$now = date("Y-m-d H:i:s");
		$data = $this->db
                ->where('product.id_status',1)
                ->where('product.is_delete',0)
				->where('product_category.slug', $category)
                //->where('product.product_type !=' ,'video')
				//->where('product_category.slug !=' ,'video')
                ->where('product.publish_date <=',$now)
                //->where("(product.end_date >= '{$now}' OR product.end_date IS NULL || product.end_date = '0000-00-00')")
                //->order_by('publish_date','desc')
                ->join('product_category', 'product.id_product_category = product_category.id', 'left')
                ->from('product')
                ->count_all_results();
        return $data;
	}
	
	function countVideos($category='') {
		$now = date("Y-m-d H:i:s");
		
		if(!empty($category)) {
			$this->db->where('product_category.slug', $category);
		}
		
		$data = $this->db
                ->where('product.id_status',1)
                ->where('product.is_delete',0)
                ->where('product.product_type' ,'video')
				//->where('product_category.slug !=' ,'video')
                ->where('product.publish_date <=',$now)
                //->where("(product.end_date >= '{$now}' OR product.end_date IS NULL || product.end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->join('product_category', 'product.id_product_category = product_category.id', 'left')
                ->from('product')
                ->count_all_results();
        return $data;
	}

	function getProductByPagination($product_type='', $category='', $exclude_limit=0, $limit=5, $start=0) {
		$now = date("Y-m-d H:i:s");
		$exclude_product_arr = $exclude_product_arr_single = array();
		
		if(!empty($exclude_limit) || $exclude_limit!=0) {
			if(!empty($category)) {
					$this->db->where('product_category.slug', $category);
			}
			$exclude_product_arr = $this->db
					->select('product.id_product')
	                ->where('product.id_status',1)
	                ->where('product.is_delete',0)
	                ->where('product.publish_date <=',$now)
					->order_by('product.create_date', 'desc')
					->limit($exclude_limit)
	                ->join('product_category', 'product.id_product_category = product_category.id', 'left')
	                ->get('product')
	                ->result_array();
	                
	    		foreach($exclude_product_arr as $key=>$val) {
	    			array_push($exclude_product_arr_single, $val['id_product']);
	    		}
		}

		if(!empty($product_type)) {
			$this->db->where('product.product_type', $product_type);
		}
		
		if(!empty($exclude_limit) || $exclude_limit!=0) {
			$this->db->where_not_in('product.id_product', $exclude_product_arr_single);
		}
		
		if(!empty($category)) {
			$this->db->where('product_category.slug', $category);
		}
		
		$data = $this->db
				//->select('product.title, product.id_product')
                ->where('product.id_status',1)
                ->where('product.is_delete',0)
                ->where('product.publish_date <=',$now)
				->limit($limit,$start)
                //->where("(product.end_date >= '{$now}' OR product.end_date IS NULL || product.end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->join('product_category', 'product.id_product_category = product_category.id', 'left')
                ->get('product')
                ->result_array();
                
        return $data;
	}

	
    
}
/* End of file Product_model.php */
/* Location: ./application/models/Product_model.php */