<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function twitter_callback() {
		echo 'twitter callback';
		echo '<br><br><br>';
		$this->layout = 'none';
	}
	
	public function instagram_callback() {
		
	}
	
	public function facebook_callback() {
		
	}
	
}
