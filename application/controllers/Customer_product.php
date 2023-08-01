<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customer_product Class
 * @author fadilah.ajiq.surya@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Customer_product Controller
 * 
 */
class Customer_product extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->class_path_name = $this->router->fetch_class();
		$this->load->model('Product_model');
		$this->load->model('Customer_model');
	}

	public function index($id=0, $slug='') {

		$product = $this->Customer_model->getCustomerProductById($id);
		$products = $this->Product_model->getAllCars();
		
		/*echo '<pre>';
		print_r($product);
		die();*/

		$this->data['page_title'] = $product['title'];
		$this->data['product'] = $product;
		$this->data['products'] = $products;
	}

	public function form_sewa($id_product=0) {
		$product = $this->Product_model->getAllCars();
		$this->data['product'] = $product;

		if($this->input->post()) {

			$post = $this->input->post();

			if(isset($post['quick_booking'])) {
				$this->data['quick_booking_nama'] = $post['nama'];
				$this->data['quick_booking_email'] = $post['email'];
				$this->data['quick_booking_hp'] = $post['hp'];
			} else {
				if ($this->validateForm()) {
					$post['start_date'] = date('Y-m-d', strtotime($post['start_date']));
					$post['end_date'] = date('Y-m-d', strtotime($post['end_date']));
					$is_saved = $this->Customer_model->saveDataRental($post);

					if($is_saved) {
						$mailto = $post['email'];
						$bcc = array( /*admin*/
							'rentalmobilaliza@gmail.com',
							'fadilah.ajiq.surya2@gmail.com',
							'prasodjo.23@gmail.com',
							'tri.yono.ty21@gmail.com',
							'imamkenzies@gmail.com'
						);
						$data_email = array();
						$data_email['nama'] = $post['nama'];
						$data_email['hp'] = $post['hp'];
						$data_email['email'] = $post['email'];
						$data_email['product'] = $this->Customer_model->getCustomerProductById($post['id_product']);
						$data_email['id_customer'] = $is_saved;
						$data_email['customer_detail'] = $this->Customer_model->getCustomerbyId($is_saved);

						$is_mail_sent = custom_send_email_ci('cs@alizarentalmobil.com', $mailto, $bcc, 'Konfirmasi Sewa Mobil Aliza Rental Mobil', '', '', $data_email, 'smtp');

						if($is_mail_sent) {
							redirect(base_url().'form-sewa-mobil/success');
						} else {
							echo 'sent status: ' . $is_mail_sent;
						}

						

					} else {
						$this->data['form_message'] = alert_box('Terjadi kesalahan pada server, silahkan hubungi administrator.', 'danger');
					}
				} else {
					$this->data['form_message'] = 'Form validation error';
				}
			}
		}
		if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
	}

	public function success() {
		$this->data['template'] = $this->class_path_name.'/success';
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
                'field' => 'start_date',
                'label' => 'Tanggal Booking',
                'rules' => 'required'
            ),
            array(
                'field' => 'end_date',
                'label' => 'Tanggal Selesai',
                'rules' => 'required'
            ),
            array(
                'field' => 'nama',
                'label' => 'Nama lengkap anda',
                'rules' => 'required'
            ),
            array(
                'field' => 'hp',
                'label' => 'Nomor handphone',
                'rules' => 'required|is_natural'
            ),
            array(
                'field' => 'email',
                'label' => 'Alamat email',
                'rules' => 'required|valid_email'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
        	return TRUE;
        }
    }

}