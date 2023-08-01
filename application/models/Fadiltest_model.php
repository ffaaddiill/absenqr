<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arisan_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
 
 	function calltest() {
 		$this->db->query();
 	}   
}