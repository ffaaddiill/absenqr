<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pages Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Pages model
 * 
 */
class Pages_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all data
     * @param string $param
     * @return array data
     */
    function GetAllPagesData($param=array()) {
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
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
                ->select("*,id_page as id")
                ->join(
                    "
                        (SELECT page_name as parent_page_title,id_page as page_id FROM {$this->db->dbprefix('pages')}) as parent_pages
                    ",
                    "parent_pages.page_id=pages.parent_page",
                    "left"
                )
                ->where('is_delete',0)
                ->get('pages')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllPages($param=array()) {
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                ->from('pages')
                ->join(
                    "
                        (SELECT page_name as parent_page_title,id_page as page_id FROM {$this->db->dbprefix('pages')}) as parent_pages
                    ",
                    "parent_pages.page_id=pages.parent_page",
                    "left"
                )
                ->where('is_delete',0)
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get detail by id
     * @param int $id
     * @return array data
     */
    function GetPages($id) {
        $data = $this->db
                ->where('id_page',$id)
                ->limit(1)
                ->get('pages')
                ->row_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('pages',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_page',$id);
        $this->db->update('pages',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_page',$id);
        $this->db->delete('pages');
    }

    function delete_picture($id) {
        $this->db->where('id_page', $id);
        $this->db->update('pages', array(
            'primary_image'=>'',
            'picture_file_name'=>''
        ));
    }
    
    /**
     * get parent menu data hierarcy
     * @param int $id_parent
     * @return array data
     */
    function MenusData($id_parent=0) {
        $data = $this->db
                ->select('id_page as id, parent_page as parent_id, page_name as menu')
                ->where('parent_page',$id_parent)
                ->where('is_delete',0)
                ->order_by('position','asc')
                ->get('pages')
                ->result_array();
        foreach ($data as $row => $parent) {
            $data[$row]['children'] = $this->MenusData($parent['id']);
        }
        return $data;
    }
    
    /**
     * print parent menu to html
     * @param array $menus
     * @param string $prefix
     * @return string $return
     */
    function PrintMenu($menus=array(),$prefix='',$selected='',$disabled=array()) {
        $return = '';
        if ($menus) {
            foreach ($menus as $row => $menu) {
                if ($disabled && in_array($menu['id'], $disabled)) {
                    $return .= '';
                } elseif ($disabled && ($selected == $menu['parent_id']) && $selected != '' && $selected != '0') { 
                    $return .= '';
                } else {
                    if ($menu['id'] == $selected && $selected != '') {
                        $return .= '<option value="'.$menu['id'].'" selected="selected">'.$prefix.'&nbsp;'.$menu['menu'].'</option>';
                    } else {
                        $return .= '<option value="'.$menu['id'].'">'.$prefix.'&nbsp;'.$menu['menu'].'</option>';
                    }
                    if (isset($menu['children']) && count($menu['children'])>0) {
                        $return .= $this->PrintMenu($menu['children'],$prefix."--",$selected,$disabled);
                    }
                }
            }
        }
        return $return;
    }
    
    /**
     * get menu children id by id menu
     * @param int $id_menu
     * @return array $return
     */
    function MenusIdChildrenTaxonomy($id_menu=0) {
        $return = array();
        $data = $this->db
                ->select('id_page')
                ->where('parent_page',$id_menu)
                ->get('pages')
                ->result_array();
        foreach ($data as $row) {
            $return[] = $row['id_page'];
            $children = $this->MenusIdChildrenTaxonomy($row['id_page']);
            $return = array_merge($return,$children);
        }
        $return[] = $id_menu;
        return $return;
    }
    
}
/* End of file Pages_model.php */
/* Location: ./application/models/Pages_model.php */