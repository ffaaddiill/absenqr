<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Career Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Career Controller
 * 
 */
class Contact extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->class_path_name = $this->router->fetch_class();
        $this->load->model(array('Customer_inbox_model', 'News_model', 'Subscriber_model'));
        $this->load->helper('captcha');
        //$this->load->library('email');
        $this->load->library('phpmailer_library');
    }
    
    /**
     * index page
     */
    public function index() {        
        $contact = get_site_info();
        $this->data['contact_page'] = $this->db->where('slug', $this->uri->segment(1))->get('pages')->row_array();
        $this->data['contact'] = $contact;

        if($this->input->post()) {
            $post = $this->input->post();

            if(isset($post['g-recaptcha-response'])) {
                $captcha = $post['g-recaptcha-response'];
            } else {
                $captcha = false;
            }

            if(!$captcha) {
                //captcha false
            } else {
                $response = validate_recaptcha($captcha);
                if($response) {
                    unset($post['g-recaptcha-response']);
                    $post['customer_ip_address'] = get_client_ip();
                    $insert_status =  $this->Customer_inbox_model->add($post);

                    $admin_contact = $this->db->where('auth_group.auth_group', 'Admin Content')->join('auth_group', 'auth_group.id_auth_group = auth_user.id_auth_group', 'left')->get('auth_user')->result_array();

                    /*$email_to_arr = array();
                    foreach($admin_contact as $key=>$val) {
                        array_push($email_to_arr, $val['email']);
                    }*/

                    $email_template_body = $this->load->view(TEMPLATE_DIR.'/layout/contact_message_email_template',$post,TRUE);

                    $data_email = array(
                        'email_from'=>'marketing@borneotropicalstream.com',
                        'email_from_alias'=>'Do Not Reply',
                        //'email_to'=>implode(',', $email_to_arr),
                        'email_to'=>$admin_contact,
                        'email_bcc'=>'fadilah.ajiq.surya@gmail.com',
                        'email_subject'=>$post['customer_subject'],
                        'email_body'=>$email_template_body,
                        'email_method'=>'smtp',
                        'email_attachment'=>'',
                        'email_debug' => 0
                    );

                    // echo '<pre>';
                    // print_r($data_email);
                    // die();

                    $is_email_sent = phpmailer_sendmail($data_email);

                    if(!$is_email_sent['status']){
                        die(json_encode(array('Gagal mengirimkan email.', 'msg'=>$sent_mail['error_message'])));
                    } else {
                        if($insert_status) {
                            $this->session->set_flashdata('success_msg', 1);
                            redirect(base_url().'contact/message/success');
                        } else {
                            echo '<pre>';
                            print_r($insert_status);
                            print_r($is_email_sent);
                            die('insert error !');
                        }
                    }
                } else {
                    //captcha false
                }
            }
        }
    }

    public function test_mailsend() {
        $this->load->library('email');

        $this->email->from('donotreply@borneotropicalstream.com', 'Do Not Reply');
        $this->email->to('fadilah.ajiq.surya@gmail.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();
    }

    public function inbox_success() {
        $categories_arr = $this->News_model->getCategoriesWithNewsCount();
        $this->data['categories_arr'] = $categories_arr;
        $this->data['template'] = 'contact/inbox_success';
    }

    public function subscribe() {
        $this->layout = 'none';
        if($this->input->post()) {
            $post = $this->input->post();

            if(isset($post['g-recaptcha-response'])) {
                $captcha = $post['g-recaptcha-response'];
            } else {
                $captcha = false;
            }

            if(!$captcha) {
                $this->session->set_flashdata('captcha_false', 1);
                redirect(base_url());
            } else {
                unset($post['g-recaptcha-response']);
                $post['customer_ip_address'] = get_client_ip();

                $insert_status = $this->Subscriber_model->add($post);

                if(isset($insert_status['code'])) {
                    if($insert_status['code'] == 0) {
                        $this->session->set_flashdata('success_msg', 1);
                        redirect(base_url().'subscribe/message/success');
                    } else {
                        $this->session->set_flashdata('error_code', $insert_status['code']);
                        redirect(base_url());
                    }
                }
            }
        } else {
            redirect(base_url());
        }
    }
    
    public function subscribe_success() {
        $categories_arr = $this->News_model->getCategoriesWithNewsCount();
        $this->data['categories_arr'] = $categories_arr;
        $this->data['template'] = 'contact/subscribe_success';
    }
    
}
/* End of file Contact.php */
/* Location: ./application/controllers/Contact.php */