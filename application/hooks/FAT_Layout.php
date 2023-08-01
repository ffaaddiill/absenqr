<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Layout Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Hook
 * @desc hook class that load to display layouts
 * 
 */
class FAT_Layout {
    
    protected $CI;
    
    /**
     * print layout based on controller class and function
     * @return string view layout
     */
    public function layout() {
        $this->CI = & get_instance();

        if (isset($this->CI->layout) && $this->CI->layout == 'none') {
            return;
        }

        if(isset($_GET['debuginfo']) && !empty($_GET['debuginfo']) && $_GET['debuginfo'] == 1) {
            $CI = & get_instance();
            $CI->load->database();

            if(empty($id_site)) {
                //$CI->db->where('is_default', '1');
                $where['is_default'] = '1'; 
            } else {
                $where = array(
                    'id_site'=>$id_site,
                    'is_default'=>1
                );
            }
            $return = $CI->db
                    ->where($where)
                    ->limit(1)
                    ->order_by('id_site', 'desc')
                    ->get('sites')->row_array();

            echo '<pre>';
            print_r($CI->db->last_query());
            echo '<br><br>';
            print_r($return);
            die();
        }
        
        // set data
        $dir = $this->CI->router->directory;
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
        $method = ($method == 'index') ? $class : $method;
        $data = (isset($this->CI->data)) ? $this->CI->data : array();
        $data['current_controller'] = base_url() . $dir . $class . '/';
        $data['base_url'] = base_url();
        $data['current_url'] = current_url();
        $data['get_site_info'] = get_site_info();
       // $data['flash_message'] = $this->CI->session->flashdata('flash_message');
        $data['persistent_message'] = $this->CI->session->userdata('persistent_message');
        
        //$data['site_setting'] = get_sitesetting();
        //$data['site_info'] = get_site_info();
        $data['head_title'] = '';
        if (isset($data['page_title']) && $data['page_title'] != '') {
            $data['head_title'] .= $data['page_title'];
        }
		$data['top_menu'] = getTopMenus();
		
        if(isset($_GET['debuginfo']) && !empty($_GET['debuginfo']) && $_GET['debuginfo'] == 2) {
    		echo '<pre>';
    		print_r(getTopMenus());
    		print_r($this->CI->db->last_query());
    		die();
        }
		
        // tarik database
        $this->CI->load->database();
        // tarik menu dari database
        $navmenus = $this->getAllActivePage();
        $data['navmenus'] = $navmenus; //lempar ke front-end

        if (isset($data['template'])) {
            $data['content'] = $this->CI->load->view(TEMPLATE_DIR.'/'.$data['template'], $data, true);
        } else {
            $data['content'] = $this->CI->load->view(TEMPLATE_DIR.'/'.$class . '/' . $method, $data, true);
        }
        if (isset($this->CI->layout)) {
            $layout = TEMPLATE_DIR.'/layout/'.$this->CI->layout;
        } elseif ($this->CI->input->is_ajax_request()) {
            $layout = TEMPLATE_DIR.'/layout/blank';
        } else {
            $layout = TEMPLATE_DIR.'/layout/default';
        }
        $this->CI->load->view($layout, $data);
    }

    function getAllActivePage($id_page=0) {
        $this->CI = & get_instance();
        $this->CI->load->database();

        $data = $this->CI->db
                ->where('pages.is_delete', 0)
                ->where('pages.is_active', 1)
                ->where('pages.is_child', 0)
                /*->where('pages_sites.id_parent', $id_page)
                ->join('pages_sites', 'pages.id_page = pages_sites.id_page', 'left')*/
                ->get('pages')
                ->result_array();

        foreach($data as $row => $val) {
            $data[$row]['children'] = $this->CI->db
                                    ->where('pages.parent_page', $val['id_page'])
                                    //->where('pages_sites.id_parent', $val['id_page'])
                                    //->join('pages_sites', 'pages.id_page = pages_sites.id_page', 'left')
                                    ->get('pages')
                                    ->result_array();
        }

        /*echo '<pre>';
        print_r($data);
        die();*/

        return $data;
    }

}

/* End of file FAT_Layout.php */
/* Location: ./application/hooks/FAT_Layout.php */
