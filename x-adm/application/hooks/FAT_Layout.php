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
        
        // set data
        $dir = $this->CI->router->directory;
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
        $method = ($method == 'index') ? $class : $method;
        $data = (isset($this->CI->data)) ? $this->CI->data : array();
        $data['current_controller'] = base_url() . $dir . $class . '/';
        $page_info = $this->GetPageInfoByFile($class);
        $id_auth_menu = isset($page_info['id_auth_menu'])? $page_info['id_auth_menu']:0;
        $data['base_url'] = base_url();
        $data['current_url'] = current_url();
        if (isset($_SESSION['ADM_SESS'])) {
            $data['ADM_SESSION'] = $_SESSION['ADM_SESS'];
        }
        $data['flash_message'] = $this->CI->session->flashdata('flash_message');
        $data['persistent_message'] = $this->CI->session->userdata('persistent_message');
        
        $data['auth_sess'] = $this->CI->session->userdata('ADM_SESS');
        $data['site_setting'] = get_sitesetting();
        $data['site_info'] = get_site_info();
        $data['page_title'] = (isset($data['page_title'])) ? $data['page_title'] : (isset($page_info['menu'])?$page_info['menu']:'');
        
        $menus = $this->MenusData();
        $data['left_menu'] = $this->PrintLeftMenu($menus,$class);

        $data['save_button_text'] = 'Save';
        $data['cancel_button_text'] = 'Cancel';
        
        $breadcrumbs = $this->Breadcrumbs($id_auth_menu);
        $breadcrumbs[] = array(
            'text'=>'<i class="fa fa-dashboard"></i> Dashboard',
            'url'=>site_url('dashboard'),
            'class'=>''
        );
        array_multisort($breadcrumbs,SORT_ASC,SORT_NUMERIC);
        if (isset($data['breadcrumbs'])) {
            $breadcrumbs[] = $data['breadcrumbs'];
        }
        $data['breadcrumbs'] = $breadcrumbs;
        
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

        if($this->CI->input->get('debug') == 'true') {
            echo '<pre>';
            print_r($data);
            die();
        }            

        $this->CI->load->view($layout, $data);
    }

    /**
     * get page info by file
     * @param string $class
     * @param mixed $return array or string
     * @return mixed array/string
     */
    private function GetPageInfoByFile($class,$return=array()) {
        $this->CI =& get_instance();
        $this->CI->load->database();
        if ($class == 'login') {
            $arr = array(
                'id_auth_menu'=>0,
                'menu'=>'Login',
            );
            return $arr;
        }
        $data = $this->CI->db
                ->where('LCASE(file)',strtolower($class))
                ->limit(1)
                ->get('auth_menu')
                ->row_array();
        if (is_array($return)) {
            return $data;
        } else {
            return $data[$return];
        }
    }
    
    /**
     * get all authenticated menu
     * @param int $id_parent
     * @return array data
     */
    private function MenusData($id_parent=0) {
        $i=0;
        $id_group = id_auth_group();
        if (!$id_group) {
            return;
        }
        $this->CI =& get_instance();
        $this->CI->load->database();
        $data = $this->CI->db
                ->join('auth_menu','auth_menu.id_auth_menu=auth_menu_group.id_auth_menu','left')
                ->where('auth_menu_group.id_auth_group',$id_group)
                ->where('auth_menu.parent_auth_menu',$id_parent)
                ->order_by('auth_menu.position','asc')
                ->order_by('auth_menu.id_auth_menu','asc')
                ->get('auth_menu_group')
                ->result_array();
        foreach ($data as $row => $val) {
            $data[$row]['children'] = $this->MenusData($val['id_auth_menu']);
            $i++;
        }
        return $data;
    }

    private function hasChildMenu($idmenu='') {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $data = $this->CI->db
                ->select('menu')
                ->where('parent_auth_menu', $idmenu)
                ->get('auth_menu')
                ->num_rows();

        return $data;
    }
    
    /**
     * print left menu
     * @param array $menus
     * @return string $return left menu html
     */
    private function PrintLeftMenu($menus=array(),$active_menu='') {
        $return = '';
        if ($menus) {
            foreach ($menus as $row => $menu) {
                $return .= '<li>';
                $style = $set_active = '';
                if (strlen($menu['menu'])>25) {
                    $style = 'style="font-size:12px;"';
                }
                if ($active_menu != '' && ($menu['file'] != '#' || $menu['file'] != '') && strtolower($active_menu) == strtolower($menu['file'])) {
                    $set_active = 'class="active"';
                }
                $return .= ($menu['file'] == '#' || $menu['file'] == '') ? (($menu['parent_auth_menu']<1)?'<a><i class="'.(!empty($menu['icon'])?$menu['icon']:'fa fa-clone').'"></i><span class="fa fa-chevron-down"></span>':'<a>'.($this->hasChildMenu($menu['id_auth_menu'])>0?'<span class="fa fa-chevron-down"></span>':'')) : (($menu['parent_auth_menu']<1)?'<a href="'.site_url($menu['file']).'" '.$style.'><i class="'.(!empty($menu['icon'])?$menu['icon']:'fa fa-clone').'"></i>':'<a href="'.site_url($menu['file']).'" '.$style.'>'.($this->hasChildMenu($menu['id_auth_menu'])>0?'<span class="fa fa-chevron-down"></span>':''));
                $return .= $menu['menu'];
                if (isset($menu['children']) && count($menu['children'])>0) {
                    $return .= '<span class="fa arrow"></span>';
                }
                $return .= '</a>';
                if (isset($menu['children']) && count($menu['children'])>0) {
                    $return .= '<ul class="nav child_menu" style="padding-left:15px;">';
                    $return .= $this->PrintLeftMenu($menu['children']);
                    $return .= '</ul>';
                }
                $return .= '</li>';
            }
        }
        return $return;
    }

    /*private function PrintLeftMenu($menus=array(),$active_menu='', $is_child = false) {
        $return = '';
        $set_active = '';

        if($is_child == true) {
            $li = '<li>';
        } else {
            $li = '<li ' . $set_active . '>';
        }
        
        if ($menus) {
            foreach ($menus as $row => $menu) {
                $style = $set_active = '';
                if ($active_menu != '' && ($menu['file'] != '#' || $menu['file'] != '') && strtolower($active_menu) == strtolower($menu['file'])) {
                    $set_active = 'class="active treeview"';
                } else {
                    $set_active = 'class="treeview"';
                }
                $return .= $li;
                $return .= '<a href="'.(($menu['file'] == '#' || $menu['file'] == '') ? '#' : site_url($menu['file'])).'" '.$style.'0>';
                $return .= $menu['menu'];
                if (isset($menu['children']) && count($menu['children'])>0) {
                    $return .= '<span class="fa arrow"></span>';
                }
                $return .= '</a>';
                if (isset($menu['children']) && count($menu['children'])>0) {
                    $return .= '<ul class="treeview-menu">';
                    $return .=
                    $return .= $this->PrintLeftMenu($menu['children'], true);
                    $return .= '</ul>';
                }
                $return .= '</li>';
            }
        }
        return $return;
    }*/
    
    /**
     * Breadcrumbs 
     * @param int $id_auth_menu
     * @param array $breadcrumbs
     * @return array breadcrumbs list
     */
    private function Breadcrumbs($id_auth_menu,&$breadcrumbs=array()) {
        $this->CI =& get_instance();
        $this->CI->load->database();
        if (!$id_auth_menu) {
            return;
        }
        $data = $this->CI->db
                ->select('id_auth_menu,parent_auth_menu,menu,file')
                ->where('id_auth_menu',$id_auth_menu)
                ->limit(1)
                ->get('auth_menu')
                ->row_array();
        if ($data) {
            $breadcrumbs[] = array(
                'text'=>$data['menu'],
                'url'=>($data['file'] != '' && $data['file'] != '#') ? site_url($data['file']) : '#',
                'class'=>''
            );
            if ($data['parent_auth_menu'] > 0) {
                $parent_data = $this->CI->db
                        ->select('id_auth_menu')
                        ->where('id_auth_menu',$data['parent_auth_menu'])
                        ->limit(1)
                        ->get('auth_menu')
                        ->row_array();
                if ($parent_data) {
                    $this->Breadcrumbs($parent_data['id_auth_menu'],$breadcrumbs);
                }
            }
        }
        return $breadcrumbs;
    }

}

/* End of file FAT_Layout.php */
/* Location: ./application/hooks/FAT_Layout.php */
