<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Currency Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Currency Controller
 * 
 */

class Currency extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Currency_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        //$this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['page'] = 0;
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
            $count_all_records = $this->Currency_model->CountAllCurrency();
            $count_filtered_records = $this->Currency_model->CountAllCurrency($param);
            $records = $this->Currency_model->GetAllCurrencyData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id_currency'];
                $return['data'][$row]['actions'] = '<a href="'.site_url($this->class_path_name.'/edit/'.$record['id_currency']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                $return['data'][$row]['iso_1'] = $record['iso_1'];
                $return['data'][$row]['iso_2'] = $record['iso_2'];
                /*$return['data'][$row]['value'] = $record['value'];*/

                $return['data'][$row]['update_date'] = custDateFormat($record['update_date'],'d M Y H:i:s');
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
        $this->data['vendors'] = $this->Currency_model->GetVendor();
        
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            // echo '<pre>';
            // print_r($post);
            // die();
            if ($this->validateForm()) {
                $id = $this->Currency_model->InsertRecord($post);
                
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Currency',
                    'desc' => 'Add  Currency; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                redirect($this->class_path_name);
            }
            $this->data['post'] = $post;
                // echo '<pre>';
                // print_r($this->data['post']);
                // die();
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
        $record = $this->Currency_model->GetCurrency($id);
        
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['vendors'] = $this->Currency_model->GetVendor();
        // echo '<pre>';
        // print_r($this->data['vendors']);
        // die();
        //$this->load->model('Vendor_model');
        //$this->data['category_vendor'] = $this->Vendor_model->GetCategoryVendor();
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        //$this->data['pph_type']     = $this->Currency_model->GetPPH();
        if ($this->input->post()) {
            $post = $this->input->post();

            if ($this->validateForm($id)) {

                $this->Currency_model->UpdateRecord($id,$post);

                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Currency',
                    'desc' => 'Edit Currency; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Currency_model->GetCurrency($id);
                        if ($record) {
                            $this->Currency_model->DeleteRecord($id);
                            $json['success'] = alert_box('Data has been deleted','success');
                            $this->session->set_flashdata('flash_message',$json['success']);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'User Currency',
                                'desc' => 'Delete  Currency; ID: '.$id.';',
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
        //redirect($this->class_path_name);
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
                'field' => 'iso_1',
                'label' => 'Currency Code',
                'rules' => 'required'
            ),
            array(
                'field' => 'iso_2',
                'label' => 'Currency Symbol',
                'rules' => 'required'
            )

        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            
            if (!$id) {
                
            } else {
                
            }
            if (!$this->error) {
                
                return TRUE;
            } else {
                $this->error = alert_box($this->error,'danger');
                return FALSE;
            }
        }
    }

    public function getCurrency() {
        $this->layout = 'none';
        $grep = new DOMDocument();
        @$grep->loadHTMLFile("http://www.kemenkeu.go.id/Page/kurs-pajak");
        $finder = new DOMXpath($grep);

        $data_insert = $currency_value_arr = array();
        $nodes = $finder->query("

            //table/tr/td
        ");
        foreach ($nodes as $td) {
            echo '<pre>';
            print_r($td);
            echo '</pre>';
        }
       

            //table[@class='table-bordered']
       

        echo '<pre>';
        print_r($nodes);
        echo '</pre>';
        die();

        if($nodes->length > 0) {
            $a = $b = 0;
            foreach($nodes as $td) {
                $node_list = $td->childNodes;

                echo '<pre>';
                print_r($td);
                echo '</pre>';
                foreach($node_list as $node) {

                    if($a > 0) {
                        $tampung_node = explode('%', $node->nodeValue);

                        $a = explode(')', $tampung_node[0]);

                        $price = explode(' ', $a[count($a)-1]);
                        $price = $price[0];
                        
                        $key = explode('(', $a[0]);
                        
                        $temp_key = $key;
                        $key = $key[1];

                        if($key == 'USD') {
                            $id_currency = 2;
                            $data_insert[] = array(
                                                'id_currency' => $id_currency,
                                                'value' => str_replace(',', '', $price),
                                                'valid_date' => date('Y-m-d')
                                                );
                        } else {
                            $id_currency = '';
                        }

                        




                    }
                    $a++;
                }

                $b++;
            }
            $data_IDR[] = array(
                                                'id_currency' => 1,
                                                'value' => 1,
                                                'valid_date' => date('Y-m-d')
                                                );
            $data_inserts = array_merge($data_insert,$data_IDR);
            echo '<pre>';
            print_r($data_inserts);
            die();
            //$this->Currency_model->insertBatchCurrencyValue($data_inserts);

            //$this->Currency_model->
        }
    }

}
/* End of file Currency.php */
/* Location: ./application/controllers/Currency.php */