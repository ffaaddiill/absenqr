<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Login Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Login Controller
 * 
 */
class Login extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
    
    /**
     * login page
     */
    public function index() {
        $this->load->model('Auth_model');
        $this->layout = 'login';
        $this->data['page_title'] = 'Login';
        $this->data['form_action'] = site_url('login');
        
        //reCaptcha -start

        $secret_key="6LfG1QoTAAAAAF0wO5pCbtvdzLp70CEBCk7UYj7r";
        $ip_user=$this->input->ip_address();
        $str = trim($this->input->post('g-recaptcha-response') ?? '');
        $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret_key."&response=".$str."&remoteip=".$ip_user;    
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $data = curl_exec($ch);
        curl_close($ch);
        $status= json_decode($data,true);

        //reCaptcha -end
        
        if ($this->input->post()) {
            $post = $this->input->post();
            
            /*echo '<pre>';
            print_r($post);
            die('post !');*/

            if (isset($post['username']) && isset($post['password']) && $post['username'] != '' && $post['password'] != '' ) {

                $this->Auth_model->CheckAuth($post['username'],$post['password']);
            } else {
                $error_login = alert_box('Username/Password isn\'t valid or reCaptcha unsuccessfull. Please try again.','danger');
            }
        }
        if (isset($error_login)) {
            $this->data['error_login'] = $error_login;
        }
        if ($this->session->flashdata('flash_message')) {
            $this->data['error_login'] = $this->session->flashdata('flash_message');
        }
    }
    
    /**
     * lougout page
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
        exit;
    }
}
/* End of file Login.php */
/* Location: ./application/controllers/Login.php */