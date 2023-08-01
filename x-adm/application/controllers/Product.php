<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Product Controller
 * 
 */
class Product extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
    	
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
	
	public function generateSitemap() {
		//die(dirname(FCPATH));
		$product = $this->Product_model->getAllProductForSitemap();
		generateSitemap($product);
	}
	
	public function testbyfadil() {
		die(MAINSITE);
	}

    public function check_seo(){
        if ($this->input->post() && $this->input->is_ajax_request()) {
            //$this->layout = 'none';
            $post = $this->input->post();
            
            $keywords = $post['meta_keyword'];
            $meta_description = strtolower($post['meta_description']);
            $teaser = strtolower($post['teaser']);
            $description = strip_tags(strtolower($post['description']));
            $title = strtolower($post['title']);

            $all_content = $meta_description.' '.$title.' '.$teaser.' '.$description;

            $array_words = str_replace(',', ' ', $keywords);#(',', $keywords);
            //echo $array_words;
            $notif = '<ul>';

            if($keywords){
                $array_words = explode(' ', $array_words);
                foreach ($array_words as $key => $word) {
                    if (strpos($all_content, strtolower($word)) !== FALSE) { // Yoshi version
                        #$found_word_on_all ++;  
                        $jumlah_kata            = substr_count($all_content,strtolower($word));
                        $jumlah_kata_content    = str_word_count($all_content); 
                        $percent                = ($jumlah_kata/$jumlah_kata_content) * 100 ;
                        $notif .= '<li>Jumlah Keyword '.$word.' terdapat sebanyak '.$jumlah_kata.' kata ( '.$percent.' %)</li>'; 
                    }else{
                        $notif .= '<li>Keyword '.$word.' tidak ada dalam artikel</li>'; 
                    }
                }   
            }else{
                $array_words = array();
                $notif .= '<li>Anda Belum Memasukan Keyword</li>';
            }
            
            //echo $found_word;
            $notif .= '</ul>';
            $data['permalink'] = 'http://bigtvhd.com/'.$post['permalink'];
            $data['title'] = $post['title'];
            $data['title_detail'] = 'Jumlah kata '.str_word_count($post['title']).',  jumlah karakter '.strlen ( $post['title'] );
            $data['meta_keyword'] = $post['meta_keyword'];
            $data['meta_keyword_detail'] = 'Jumlah kata kunci '.count($array_words);
            $data['meta_description'] = $post['meta_description'];
            $data['meta_description_detail'] = 'Jumlah kata '.str_word_count($post['meta_description']).',  jumlah karakter '.strlen ($post['meta_description']);
            
            $data['review'] = $notif;
            $json['html']   = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/seo_check', $data, true);
 

            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
    }
    
    /**
     * list data
     */
    public function list_data() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $param['search_value'] = $post['search']['value'];
            $param['search_field'] = $post['columns'];
            if (isset($post['order'])) {
                $param['order_field'] = $post['columns'][$post['order'][0]['column']]['data'];
                $param['order_sort'] = $post['order'][0]['dir'];
            }
            $param['row_from'] = $post['start'];
            $param['length'] = $post['length'];
            $count_all_records = $this->Product_model->CountAllProduct();
            $count_filtered_records = $this->Product_model->CountAllProduct($param);
            $records = $this->Product_model->GetAllProductData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="fa fa-edit" aria-hidden="true"></span></a>
                ';
            	$return['data'][$row]['title'] = $record['title'];
                $return['data'][$row]['package_name'] = (empty($record['package_name'])) ? '-' : $record['package_name'];
                $return['data'][$row]['area_name'] = $record['area_name'];
                $return['data'][$row]['price'] = $record['price'];
				$return['data'][$row]['category_name'] = $record['category_name'];
				$return['data'][$row]['product_type'] = $record['product_type'];
                	$return['data'][$row]['publish_date'] = ($record['publish_date'] != '') ? custDateFormat($record['publish_date'],'d M Y H:i:s') : '-';
                	$return['data'][$row]['id_status'] = ($record['id_status'] == 1) ? 'Active' : 'Not Active';
                	$return['data'][$row]['create_date'] = custDateFormat($record['create_date'],'d M Y H:i:s');
            }
            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }
    
    /**
     * add page
     */
    public function add() {
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['class_path_name'] = $this->class_path_name;
        $this->data['sites'] = get_sites();
        $this->load->model('Product_category_model');
        $this->load->model('Product_package_model');
        $this->load->model('Area_model');

        $category_product = $this->Product_category_model->getCategories();
        $area = $this->Area_model->getAreas();
        $packages = $this->Product_package_model->getProductPackage();
        $this->data['areas'] = $area;
        $this->data['packages'] = $packages;
        $this->data['categories'] = $category_product;

        // echo '<pre>';
        // print_r(is_defaultsite());
        // echo '</pre>';
        // die();
		
		$this->data['product_type'] = array(
			0 => array(
				'label' => 'Food',
				'slug' => 'food'
			),
			1 => array(
				'label' => 'Beverage',
				'slug' => 'beverage'
			)
		);
		
        // echo '<pre>';
        // print_r(get_sites());
        // die();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['is_productheadline'] = (isset($post['is_productheadline'])) ? 1 : 0;
                $post['end_date'] = (isset($post['forever'])) ? NULL : $post['end_date'];
                $id_site = $post['id_site'];
				$post['title'] = htmlspecialchars($post['title'], ENT_QUOTES);
				
				if(isset($post['video_url'])) {
					$post['video_url'] = trim($post['video_url']);
				}
				
				if(isset($post['video_id'])) {
					$post['video_id'] = trim($post['video_id']);
				}
				
                unset($post['id_site']);
                unset($post['forever']);
                
				// echo '<pre>';
				// print_r($post);
				// die();

                /*echo '<pre>';
                print_r(url_title($post['title'],'_',true));
                die();*/
				
                // insert data
                $id = $this->Product_model->InsertRecord($post);
                $category = $this->Product_model->getCategoryById($post['id_product_category']);

                //set sebagai headline product
                if($post['is_productheadline']) {
                    $this->Product_model->setAsHeadline(['id_product'=>$id]);
                }

                if($id){
                    // if Sites  is set/add
                    $sites = array();
                    if (isset($id_site) && count($id_site)>0) {
                        foreach ($id_site as $site) {
                            $sites[] = array(
                                'id_product'=>$id,
                                'id_site'=>$site
                            );
                        }
                    }
                    if (count($sites)>0) {
                        $this->Product_model->InsertSitesBatch($sites);
                    }
                }

                $post['id_site'] = $id_site; 
                
                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = $post['slug'];
                    try {
                        //Upload blob
                        $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR .'/'. $this->class_path_name, $filename);

                        // update data
                      	$img_arr = array(
							'primary_image' => $this->class_path_name . '/'. $picture_db,
                            'picture_file_name' => $picture_db
						);
                      	$status = $this->Product_model->UpdateRecord($id, $img_arr);
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }

				// echo '<pre>';
				// print_r(FCPATH.$this->class_path_name . '/'. $picture_db);

				if(isset($post['is_twitter']) && !empty($post['is_twitter'])) {
                    $post['is_twitter'] = (isset($post['is_twitter'])) ? 1 : 0;
					$this->load->library('twitteroauth/src/TwitterOAuth');
		
					$tw = new TwitterOAuth(
						array(
							'consumerKey'=>'asFU2M5cbuHJjWWsP2dC4LtJC',
							'consumerSecret'=>'F4zygYNWUnDIEG0d9kSH6Rj8vTwJslhBWyik9ureQ2UrFYO9cl',
							'oauthToken'=>'1171730175836295170-qwjuv2b7H37XEehqJZ4iOdrYHkD7gB',
							'oauthTokenSecret'=>'gGmRKtCCJ2cVpe22rN3d6eC9YKfmuDxhrS5GWq28RRcvA'
						)
					);
					
					/*
					$media = $tw->upload('media/upload', ['media' => FCPATH.'/uploads/'.$this->class_path_name . '/'. $picture_db]);
					$parameters = [
    						'status' => $post['title'].' '.base_url().$category['slug'].'/'.$id.'/'.$post['slug'].'#twitter',
    						'media_ids' => implode(',', [$media->media_id_string])
					];
					 */
					
					//$post_status = $tw->post('statuses/update', ['status'=>'testing']);

					//$post_status = $tw->post('statuses/update', ['status'=>$post['title'].' '.base_url().$category['slug'].'/'.$id.'/'.$post['slug'].'#twitter']);
					
					// echo '<pre>';
					// print_r($parameters);
					// die();
				}
				
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Product',
                    'desc' => 'Add Product; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                	
                redirect($this->class_path_name);
            }
            $this->data['post'] = $post;
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
        $record = $this->Product_model->GetProduct($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
		$this->load->model('Product_category_model');
        $this->load->model('Product_package_model');
		$this->load->model('Area_model');
        $category_product = $this->Product_category_model->getCategories();
        $packages = $this->Product_package_model->getProductPackage();
        $area = $this->Area_model->getAreas();
        $this->data['class_path_name'] = $this->class_path_name;
        $this->data['categories'] = $category_product;
        $this->data['packages'] = $packages;
        $this->data['areas'] = $area;
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['sites'] = get_sites();
        $this->data['list_site'] = array_column($this->Product_model->GetSitesById($id),'id_site');
		
		$this->data['product_type'] = array(
			0 => array(
				'label' => 'Product',
				'slug' => 'product'
			),
			1 => array(
				'label' => 'Video',
				'slug' => 'video'
			)
		);
        
        
        if ($this->input->post()) {
            $post = $this->input->post();

            /*echo '<pre>';
            print_r($post);
            die();*/

            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['is_productheadline'] = (isset($post['is_productheadline'])) ? 1 : 0;
                $post['end_date'] = (isset($post['forever'])) ? NULL : $post['end_date'];
                $id_site = $post['id_site'];
				$post['title'] = htmlspecialchars($post['title'], ENT_QUOTES);
                unset($post['id_site']);
                unset($post['forever']);
				
				if(isset($post['product_type']) && $post['product_type'] != 'video') {
					$post['video_url'] = '';
					$post['video_id'] = '';
				} else {
					if(isset($post['video_url'])) {
						$post['video_url'] = trim($post['video_url']);
					}
					
					if(isset($post['video_id'])) {
						$post['video_id'] = trim($post['video_id']);
					}
				}
                
                // update data
                $this->Product_model->UpdateRecord($id,$post);

                $sites = array();
                if (isset($id_site) && count($id_site)>0) {
                    foreach ($id_site as $site) {
                        $sites[] = array(
                            'id_product'=>$id,
                            'id_site'=>$site
                        );
                    }
                }
                if (count($sites)>0) {
                    $this->Product_model->DeleteSite($id);
                    $this->Product_model->InsertSitesBatch($sites);
                }
				$picture_db = '';
                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
					
                    $filename = $post['slug'];
                    try {
                        //Upload blob
                        $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR .'/'. $this->class_path_name, $filename);

                        // update data
                      	$img_arr = array(
							'primary_image' => $this->class_path_name . '/'. $picture_db,
                            'picture_file_name' => $picture_db
						);
                      	$status = $this->Product_model->UpdateRecord($id, $img_arr);
                        
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }

				// echo '<pre>';
				// print_r($this->class_path_name . '/'. $picture_db);
				// die();

				$category = $this->Product_model->getCategoryById($record['id_product_category']);

				if(isset($post['is_twitter']) && !empty($post['is_twitter'])) {
                    $post['is_twitter'] = (isset($post['is_twitter'])) ? 1 : 0;
					$this->load->library('twitteroauth/src/TwitterOAuth');
		
					$tw = new TwitterOAuth(
						array(
							'consumerKey'=>'asFU2M5cbuHJjWWsP2dC4LtJC',
							'consumerSecret'=>'F4zygYNWUnDIEG0d9kSH6Rj8vTwJslhBWyik9ureQ2UrFYO9cl',
							'oauthToken'=>'1171730175836295170-qwjuv2b7H37XEehqJZ4iOdrYHkD7gB',
							'oauthTokenSecret'=>'gGmRKtCCJ2cVpe22rN3d6eC9YKfmuDxhrS5GWq28RRcvA'
						)
					);
					
					$media = $tw->upload('media/upload', ['media' => FCPATH.$this->class_path_name . '/'. $picture_db]);
					$parameters = [
    						'status' => $post['title'].' '.base_url().$category['slug'].'/'.$id.'/'.$post['slug'].'#twitter',
    						'media_ids' => implode(',', [$media->media_id_string])
					];
			
					$post_status = $tw->post('statuses/update', ['status'=>$parameters]);
				}

                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Product',
                    'desc' => 'Edit Product; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name);
            }
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
            if ($post['ids'] != '') {
                $array_id = array_map('trim', explode(',', $post['ids']));
                if (count($array_id)>0) {
                    foreach ($array_id as $row => $id) {
                        $record = $this->Product_model->GetProduct($id);
                        if ($record) {
                            $arrext = explode('.', $record['picture_file_name']);
                            $jml = count($arrext) - 1;
                            $ext = $arrext[$jml];
                            $ext = strtolower($ext);
                            if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.$record['thumbnail_image']);
                                unlink(UPLOAD_DIR.'product/'.'sml_'.$arrext[0].'-thumb'.'.'.$ext);
                            }
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.$record['primary_image']);
                                unlink(UPLOAD_DIR.'product/'.'sml_'.$record['picture_file_name']);
                            }
                            $this->Product_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Product',
                                'desc' => 'Delete Product; ID: '.$id.';',
                            );
                            insert_to_log($data_log);
                            // end insert to log
                            $json['success'] = alert_box('Data has been deleted','success');
                            $this->session->set_flashdata('flash_message',$json['success']);
                        } else {
                            $json['error'] = alert_box('Failed. Please refresh the page.','danger');
                            break;
                        }
                    }
                }
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
        redirect($this->class_path_name);
    }
    
    /**
     * delete picture
     */
    public function delete_picture() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = array();
            $post = $this->input->post();
            /*echo '<pre>';
            print_r($post);
            die();*/
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $detail = $this->Product_model->GetProduct($post['id']);
                $type = (isset($post['type'])) ? $post['type'] : 'primary';
                if ($detail && ($detail[$type.'_image'] != '')) {
                    $id = $post['id'];
                    $arrext = explode('.', $detail['picture_file_name']);
                    $jml = count($arrext) - 1;
                    $ext = $arrext[$jml];
                    $ext = strtolower($ext);
                    //unlink(UPLOAD_DIR.'product/'.$detail[$type.'_image']);
                    if ($type == 'primary') { //primary
                        unlink(UPLOAD_DIR.'product/'.$detail['picture_file_name']);
                        unlink(UPLOAD_DIR.'product/'.'sml_'.$detail['picture_file_name']);
                        $data_update = array($type.'_image' =>'');
                        $this->Product_model->UpdateRecord($post['id'],$data_update);
                        $json['success'] = alert_box('File has been deleted.','success');
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'Product',
                            'desc' => 'Delete '.ucfirst($type).' Picture Product; ID: '.$id.';',
                        );
                        insert_to_log($data_log);
                        // end insert to log
                    } elseif($type == 'thumbnail') { //thumbnail
                        unlink(UPLOAD_DIR.'product/'.$arrext[0].'-thumb'.'.'.$ext);
                        unlink(UPLOAD_DIR.'product/'.'sml_'.$arrext[0].'-thumb'.'.'.$ext);
                        $data_update = array($type.'_image' =>'');
                        $this->Product_model->UpdateRecord($post['id'],$data_update);
                        $json['success'] = alert_box('File has been deleted.','success');
                        // insert to log
                        $data_log = array(
                            'id_user' => id_auth_user(),
                            'id_group' => id_auth_group(),
                            'action' => 'Product',
                            'desc' => 'Delete '.ucfirst($type).' Picture Product; ID: '.$id.';',
                        );
                        insert_to_log($data_log);
                        // end insert to log
                    } else {
                        $json['error'] = alert_box('Failed to remove File. Please try again.','danger');
                    }
                } else {
                    $json['error'] = alert_box('Failed to remove File. Please try again.','danger');
                }
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
        redirect($this->class_path_name);
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
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required'
            ),
            array(
                'field' => 'publish_date',
                'label' => 'Publish Date',
                'rules' => 'required'
            ),
            array(
                'field' => 'slug',
                'label' => 'SEO URL',
                'rules' => 'required'
            ),
            array(
                'field' => 'id_site[]',
                'label' => 'Sites',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            if (!isset($post['forever']) && $post['end_date'] == '') {
                $this->error = 'Please input End Date.';
            }
            if(!$id){
                if (!check_exist_uri('product',$post['slug'])) {
                    $this->error = 'SEO URL is already used.';
                }
            }
           
            $post_image = $_FILES;
            if (!$this->error) {
                if (!empty($post_image['thumbnail_image']['tmp_name'])) {
                    $check_picture = validatePicture('thumbnail_image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture,'danger');
                        return FALSE;
                    }
                }
                if (!empty($post_image['primary_image']['tmp_name'])) {
                    $check_picture = validatePicture('primary_image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture,'danger');
                        return FALSE;
                    }
                }
                return TRUE;
            } else {
                $this->error = alert_box($this->error,'danger');
                return FALSE;
            }
        }
    }
}
/* End of file Product.php */
/* Location: ./application/controllers/Product.php */