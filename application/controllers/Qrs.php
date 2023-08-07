<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Qrs extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Qrs_model');
    }

    public function index() {

    }

    public function qs() {
        $dtnow = date("H:i:s");
        $dtmasuk = date("H:i:s", strtotime('09:00:00'));
        $dtpulang = date("H:i:s", strtotime('15:00:00'));

        $this->data['dtmasuk'] = $dtmasuk;
        $this->data['dtpulang'] = $dtpulang;

        $this->data['disable_input'] = false;

        if($dtnow >= date("H:i:s", strtotime('00:00:00')) && $dtnow < $dtmasuk) { //jam masuk
            $this->data['disable_input'] = false;
        } elseif($dtnow >= $dtpulang && $dtnow < date("H:i:s", strtotime('20:00:00'))) { //jam pulang
            $this->data['disable_input'] = false;
        } else {
            $this->data['disable_input'] = true;
        }

    	//$this->data['template'] = 'qrs/qrs';
        $dtsample = '1689536900';
        echo 'Today: '.strtotime(date("Y-m-d H:i:s")) . '<br>'.date("Y-m-d H:i:s").'<br><br>';
       // echo round(round( abs(strtotime(date("Y-m-d H:i:s")) - $dtsample) / 60, 2) / 60, 2) . ' jam';
    	$this->layout = '../qrs/qs.php';
    }

    public function submit() {
        $this->layout = 'none';
        date_default_timezone_set('Asia/Jakarta');
        if($this->input->post()) {
            $post = $this->input->post();

            $qr_arr = explode("\n", $post['qr']);

            //$getdate = $this->Qrs_model->testdate(['nis'=>$qr_arr[0]]);

            $dtnow = date("H:i:s");
            $dtmasuk = date("H:i:s", strtotime('09:00:00'));
            $dtpulang = date("H:i:s", strtotime('15:00:00'));

            if($dtnow >= date("H:i:s", strtotime('00:00:00')) && $dtnow < $dtmasuk) { //jam masuk
                if(count($qr_arr) > 1) {
                    foreach($qr_arr as $key=>$val) {
                        $val = trim($val);
                        if(!empty($val) && $this->Qrs_model->check_nis($val) > 0) {
                            $this->Qrs_model->save_in(['nis'=>$val]);
                            //echo $this->db->last_query().'<br>';
                        }
                    }
                } else {
                    ( !empty(trim($qr_arr[0])) )?$this->Qrs_model->save_in(['nis'=>$qr_arr[0]]):'';
                    //echo $this->db->last_query().'<br>';
                }
            } elseif($dtnow >= $dtpulang && $dtnow < date("H:i:s", strtotime('20:00:00'))) { //jam pulang
                if(count($qr_arr) > 1) {
                    foreach($qr_arr as $key=>$val) {
                        $val = trim($val);
                        if(!empty($val) && $this->Qrs_model->check_nis($val) > 0) {
                            $this->Qrs_model->save_out(['nis'=>$val]);
                            //echo $this->db->last_query() . '<br>';
                        }
                    }
                } else {
                    ( !empty(trim($qr_arr[0])) )?$this->Qrs_model->save_out(['nis'=>trim($qr_arr[0])]):'';
                    //echo $this->db->last_query().'<br>';
                }
            }
            
            echo '<pre>';
            print_r($qr_arr);
            print_r(count($qr_arr));
        }
    }
}