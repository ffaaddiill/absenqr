<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Event Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Event Controller
 * 
 */
class Event extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Event_model');
        $this->data['page_title'] = 'Event Gallery';
    }
    
    /**
     * index page
     */
    public function index() {
        $event_data = $this->Event_model->GetEventData();
        $this->data['events'] = $event_data;
        $this->data['title'] = 'Event Gallery';
    }
    
    public function detail($path='') {
        if (!$path) {
            redirect('event');
        }
        $record = $this->Event_model->GetEventByUriPath($path);
        if (!$record) {
            redirect('event');
        }
        $this->data['gallery_record'] = $record;
    }

}

/* End of file Event.php */
/* Location: ./application/controllers/Event.php */
