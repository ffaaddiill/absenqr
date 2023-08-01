<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * News Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc News Controller
 * 
 */
class News extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('News_model');
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
		$news = $this->News_model->getAllNewsForSitemap();
		generateSitemap($news);
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
            $data['permalink'] = base_url().$post['permalink'];
            $data['title'] = $post['title'];
            $data['title_detail'] = 'Jumlah kata '.str_word_count($post['title']).',  jumlah karakter '.strlen ( $post['title'] );
            $data['meta_keyword'] = $post['meta_keyword'];
            $data['meta_keyword_detail'] = 'Jumlah kata kunci '.count($array_words);
            $data['meta_description'] = $post['meta_description'];
            $data['meta_description_detail'] = 'Jumlah kata '.str_word_count($post['meta_description']).',  jumlah karakter '.strlen ($post['meta_description']);
            
            $data['review'] = $notif;
            $json['html']   = $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/seo_check', $data, true);
            // cek on title
            // foreach ($array_words as $key => $word) {
            //     if (strpos($title, strtolower($word)) !== FALSE) { // Yoshi version
            //         $found_word_on_title ++;   
            //     }
            // }
            // if($found_word_on_title > 0){
            //     $notif .= '<li>Keyword found on title (Ceklis hijau)</li>';
            // }else{
            //     $notif .= '<li>Keyword not found on title (Ceklis merah)</li>';
            // }

            // // cek on description 
            // foreach ($array_words as $key => $word) {
            //     if (strpos($description, strtolower($word)) !== FALSE) { // Yoshi version
            //         $found_word_on_description ++; 
                    
            //     }
            // }
            // if($found_word_on_description > 0){
            //     $notif .= '<li>Keyword found on description (Ceklis hijau)</li>';
            // }else{
            //     $notif .= '<li>Keyword not found on description (Ceklis merah)</li>';
            // }


            // if($teaser){
            //     //cek on teaser
            //     foreach ($array_words as $key => $word) {
            //         if (strpos($teaser, strtolower($word)) !== FALSE) { // Yoshi version
            //             $found_word_on_teaser ++; 
            //         }
            //     }
            //     if($found_word_on_teaser > 0){
            //         $notif .= '<li>Keyword found on teaser (Ceklis hijau)</li>';
            //     }else{
            //         $notif .= '<li>Keyword not found on teaser (Ceklis merah)</li>';
            //     }   
            // }
            
            // // cek on meta desc
            // foreach ($array_words as $key => $word) {
            //     if (strpos($meta_description, strtolower($word)) !== FALSE) { // Yoshi version
            //         $found_word_on_meta_desc ++;   
            //     }
            // }
            // if($found_word_on_meta_desc > 0){
            //     $notif .= '<li>Keyword found on title (Ceklis hijau)</li>';
            // }else{
            //     $notif .= '<li>Keyword not found on title (Ceklis merah)</li>';
            // }

            //cek on all content
            

            // echo $notif;
            // die();

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
            $count_all_records = $this->News_model->CountAllNews();
            $count_filtered_records = $this->News_model->CountAllNews($param);
            $records = $this->News_model->GetAllNewsData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                ';
                	$return['data'][$row]['title'] = $record['title'];
				$return['data'][$row]['category_name'] = $record['category_name'];
				$return['data'][$row]['news_type'] = $record['news_type'];
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
        $this->data['sites'] = get_sites();
        $this->load->model('News_category_model');
        $category_news = $this->News_category_model->getCategories();
        $this->data['categorys'] = $category_news;
		
		$this->data['news_type'] = array(
			0 => array(
				'label' => 'News',
				'slug' => 'news'
			),
			1 => array(
				'label' => 'Video',
				'slug' => 'video'
			)
		);
		
        // echo '<pre>';
        // print_r(get_sites());
        // die();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['is_newsheadline'] = (isset($post['is_newsheadline'])) ? 1 : 0;

                $end_date = isset($post['end_date']) && !empty($post['end_date'])?date('Y-m-d H:i:s', strtotime($post['end_date'])):'';
                $post['publish_date'] = date('Y-m-d H:i:s', strtotime($post['publish_date']));
                
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
				
                // insert data
                $id = $this->News_model->InsertRecord($post);
                $category = $this->News_model->getCategoryById($post['id_news_category']);

                //set sebagai headline news
                if($post['is_newsheadline']) {
                    $this->News_model->setAsHeadline(['id_news'=>$id]);
                }

                if($id){
                    // if Sites  is set/add
                    $sites = array();
                    if (isset($id_site) && count($id_site)>0) {
                        foreach ($id_site as $site) {
                            $sites[] = array(
                                'id_news'=>$id,
                                'id_site'=>$site
                            );
                        }
                    }
                    if (count($sites)>0) {
                        $this->News_model->InsertSitesBatch($sites);
                    }
                }

                $post['id_site'] = $id_site; 
                
                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = $category['slug'].'-'.url_title($post['title'],'_',true);
                    
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.$this->class_path_name.'/'.$category['slug'].'/', $filename);
                    $this->News_model->UpdateRecord($id,array('primary_image'=>$this->class_path_name.'/'.$category['slug'].'/'.$picture_db,'picture_file_name'=>$picture_db));
                }

				// echo '<pre>';
				// print_r(FCPATH.$this->class_path_name . '/'. $picture_db);

				if(isset($post['is_twitter'])) {
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
                    'action' => 'News',
                    'desc' => 'Add News; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->News_model->GetNews($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
		$this->load->model('News_category_model');
		$category_news = $this->News_category_model->getCategories();
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['sites'] = get_sites();
        $this->data['list_site'] = array_column($this->News_model->GetSitesById($id),'id_site');
		
		$this->data['news_type'] = array(
			0 => array(
				'label' => 'News',
				'slug' => 'news'
			),
			1 => array(
				'label' => 'Video',
				'slug' => 'video'
			)
		);
        
        $this->data['categorys'] = $category_news;
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['id_status'] = (isset($post['id_status'])) ? 1 : 0;
                $post['is_newsheadline'] = (isset($post['is_newsheadline'])) ? 1 : 0;
                $post['end_date'] = (isset($post['forever'])) ? NULL : $post['end_date'];
                $id_site = $post['id_site'];
				$post['title'] = htmlspecialchars($post['title'], ENT_QUOTES);
                unset($post['id_site']);
                unset($post['forever']);
				
				if($post['news_type'] != 'video') {
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
				
				// echo '<pre>';
				// print_r($post);
				// die();

                $category = $this->News_model->getCategoryById($post['id_news_category']);
                
                // update data
                $this->News_model->UpdateRecord($id,$post);

                $sites = array();
                if (isset($id_site) && count($id_site)>0) {
                    foreach ($id_site as $site) {
                        $sites[] = array(
                            'id_news'=>$id,
                            'id_site'=>$site
                        );
                    }
                }
                if (count($sites)>0) {
                    $this->News_model->DeleteSite($id);
                    $this->News_model->InsertSitesBatch($sites);
                }
				$picture_db = '';
                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = $category['slug'].'-'.url_title($post['title'],'_',true);
                    
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.$this->class_path_name.'/'.$category['slug'].'/', $filename);
                    $this->News_model->UpdateRecord($id,array('primary_image'=>$this->class_path_name.'/'.$category['slug'].'/'.$picture_db,'picture_file_name'=>$picture_db));
                }

				// echo '<pre>';
				// print_r($this->class_path_name . '/'. $picture_db);
				// die();

				$category = $this->News_model->getCategoryById($record['id_news_category']);

				if(isset($post['is_twitter'])) {
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
					
					/*$media = $tw->upload('media/upload', ['media' => UPLOAD_DIR.$this->class_path_name.'/'.$category['slug'].'/'. $picture_db]);
					$parameters = [
    						'status' => $post['title'].' '.base_url().$category['slug'].'/'.$id.'/'.$post['slug'].'#twitter',
    						'media_ids' => implode(',', [$media->media_id_string])
					];
			
					$post_status = $tw->post('statuses/update', ['status'=>$parameters]);*/
				}

                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'News',
                    'desc' => 'Edit News; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->News_model->GetNews($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'slideshow_product/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'slideshow_product/'.$record['thumbnail_image']);
                            }*/
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.$record['primary_image']);
                            }
                            $this->News_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete News',
                                'desc' => 'Delete News; ID: '.$id.';',
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
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $id = $post['id'];
                $record = $this->News_model->GetNews($id);
                if ($record && $record['primary_image'] != '') {
                    unlink(UPLOAD_DIR.$record['primary_image']);
                    $this->News_model->delete_picture($id);
                    $json['success'] = true;
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
                'field' => 'id_news_category',
                'label' => 'Category',
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
                if (!check_exist_uri('news',$post['slug'])) {
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
/* End of file News.php */
/* Location: ./application/controllers/News.php */