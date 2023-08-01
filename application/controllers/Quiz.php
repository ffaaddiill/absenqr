<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quiz Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Quiz Controller
 * 
 */
class Quiz extends CI_Controller {
    
    private $class_path_name;
    private $error;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Quiz_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
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
            $count_all_records = $this->Quiz_model->CountAllQuiz();
            $count_filtered_records = $this->Quiz_model->CountAllQuiz($param);
            $records = $this->Quiz_model->GetAllQuizData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;
                    <a href="'.site_url($this->class_path_name.'/answer/'.$record['id']).'"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['quiz_title'] = $record['quiz_title'];
                $return['data'][$row]['start_date'] = ($record['start_date'] != '') ? custDateFormat($record['start_date'],'d M Y') : '-';
                $return['data'][$row]['end_date'] = ($record['end_date']) ? custDateFormat($record['end_date'],'d M Y') : '-';
                $return['data'][$row]['quiz_status'] = ($record['quiz_status'] == 1) ? 'Active' : 'Not Active';
                $return['data'][$row]['count_responder'] = $this->Quiz_model->GetCountResponden($record['id']);
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
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['sites'] = get_sites();
        if ($this->input->post()) {
            $post = $this->input->post();
            
            if ($this->validateForm()) {
                $post['quiz_status'] = (isset($post['quiz_status'])) ? 1 : 0;
                $post['is_question'] = (isset($post['is_question'])) ? 1 : 0;
                $post_question = $post['question'];
                $id_site = $post['id_site'];
                unset($post['id_site']);
                unset($post['question']);
                // update data
                $id = $this->Quiz_model->InsertRecord($post);
                
                // if question is set/add
                $quiz_question = array();
                if (isset($post_question) && count($post_question)>0) {
                    foreach ($post_question as $question) {
                        $answers='';
                        if($question['question_type']==3){
                            foreach ($question['answer'] as $key => $answer) {
                                if( $key < count($question['answer'])-1 ){
                                    $answers .= $answer.','.$key . '|';
                                }else{
                                    $answers .= $answer.','.$key;
                                }
                            }
                        }else{
                            $answers = '';
                        }
                        $quiz_question[] = array(
                            'id_quiz'=>$id,
                            'question'=>$question['question'],
                            'question_type'=>$question['question_type'],
                            'position'=>$question['position'],
                            'answer'=>$answers 
                        );
                    }
                }
                
                if (count($quiz_question)>0) {
                    $this->Quiz_model->InsertQuestionBatch($quiz_question);
                }
                if($id){
                    // if Sites  is set/add
                    $sites = array();
                    if (isset($id_site) && count($id_site)>0) {
                        foreach ($id_site as $site) {
                            $sites[] = array(
                                'id_quiz'=>$id,
                                'id_site'=>$site
                            );
                        }
                    }
                    if (count($sites)>0) {
                        $this->Quiz_model->InsertSitesBatch($sites);
                    }
                }
                $post_image = $_FILES;
                
                if ($post_image['quiz_image']['tmp_name']) {
                    $filename = url_title($post['quiz_title'],'_',true);
                    /**
                     * disabled
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.'slideshow/', $filename);
                    $this->Slideshow_model->UpdateRecord($id,array('primary_image'=>$picture_db));
                     * 
                     */
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['quiz_image'],AZURE_FOLDER_QUIZ,$filename);
                        $this->Quiz_model->UpdateRecord($id,array('quiz_image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_QUIZ.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'kuis/',AZURE_FOLDER_QUIZ,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Quiz',
                    'desc' => 'Add Quiz; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name);
            }
            $this->data['post'] = $post;
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
        $record = $this->Quiz_model->GetQuiz($id);
        // echo '<pre>';
        // print_r($record);
        // die();
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['sites'] = get_sites();
        $this->data['list_site'] = array_column($this->Quiz_model->GetSitesById($id),'id_site');
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['quiz_status'] = (isset($post['quiz_status'])) ? 1 : 0;
                $post['is_question'] = (isset($post['is_question'])) ? 1 : 0;
                $id_site = $post['id_site'];
                $post_question = $post['question'];
                unset($post['question']);
                unset($post['id_site']);
                // if question is set/add
                // $quiz_question = array();
                // if (isset($post['question']) && count($post['question'])>0) {
                //     $post_question = $post['question'];
                    
                //     foreach ($post_question as $question) {
                //         $quiz_question[] = array(
                //             'id_quiz'=>$id,
                //             'question'=>$question['question'],
                //             'question_type'=>$question['question_type'],
                //             'position'=>$question['position'],
                //         );
                //     }
                // }
                
                // update data
                $this->Quiz_model->UpdateRecord($id,$post);
                
                foreach ($post_question as $key => $value) {
                    $answers='';
                    if($value['question_type']==3){
                        foreach ($value['answer'] as $a => $answer) {
                            if( $a < count($value['answer'])-1 ){
                                $answers .= $answer.','.$a . '|';
                            }else{
                                $answers .= $answer.','.$a;
                            }
                            
                        }
                    }else{
                        $answers = '';

                    }
                    $data_question = array(
                        'question'=>$value['question'],
                        'question_type'=>$value['question_type'],
                        'position'=>$value['position'],
                        'id_quiz' =>$id,
                        'answer'=>$answers
                        );
                    if($value['id_quiz_question']!=0){
                        $this->Quiz_model->UpdateRecordQuestion($value['id_quiz_question'],$data_question);
                    }else{
                        $this->Quiz_model->InsertRecordQuestion($data_question);
                    }
                }
                
                // if (count($quiz_question)>0) {
                //     $this->Quiz_model->InsertQuestionBatch($quiz_question);
                // }
                $post['question'] = $post_question;
                $sites = array();
                if (isset($id_site) && count($id_site)>0) {
                    foreach ($id_site as $site) {
                        $sites[] = array(
                            'id_quiz'=>$id,
                            'id_site'=>$site
                        );
                    }
                }
                if (count($sites)>0) {
                    $this->Quiz_model->DeleteSite($id);
                    $this->Quiz_model->InsertSitesBatch($sites);
                }
                $post_image = $_FILES;
                
                if ($post_image['quiz_image']['tmp_name']) {
                    
                    $filename = url_title($post['quiz_title'],'_',true);
                    
                    try {
                        //Upload blob
                        $picture_db = $this->azure->UploadFileToStorage($post_image['quiz_image'],AZURE_FOLDER_QUIZ,$filename);
                        $this->Quiz_model->UpdateRecord($id,array('quiz_image'=>$picture_db));
                        // resize image
                        $thumb_prefix = 'thumb/';
                        $source_file = AZURE_BLOB_URLPREFIX.AZURE_FOLDER_QUIZ.'/'.$picture_db;
                        $this->azure->ResizeUploadImage($source_file,UPLOAD_DIR.'kuis',AZURE_FOLDER_QUIZ,$thumb_prefix,$filename,IMG_THUMB_WIDTH,IMG_THUMB_HEIGHT);
                    } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code . ": " . $error_message . "<br />";
                        exit;
                    }
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Quiz',
                    'desc' => 'Edit Quiz; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Quiz_model->GetQuiz($id);
                        if ($record) {
                            if ($record['quiz_image'] != '' && file_exists(UPLOAD_DIR.'quiz/'.$record['quiz_image'])) {
                                unlink(UPLOAD_DIR.'quiz/'.$record['quiz_image']);
                                @unlink(UPLOAD_DIR.'quiz/tmb_'.$record['quiz_image']);
                                @unlink(UPLOAD_DIR.'quiz/sml_'.$record['quiz_image']);
                            }
                            $this->Quiz_model->DeleteRecord($id);
                            // insert to log
                            $data_log = array(
                                'id_user' => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action' => 'Delete Quiz',
                                'desc' => 'Delete Quiz; ID: '.$id.';',
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
        redirect($this->class_path_name);
    }
    
    /**
     * delete picture
     */
    public function delete_picture() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = array();
            $post = $this->input->post();
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $detail = $this->Quiz_model->GetQuiz($post['id']);
                if ($detail && ($detail['quiz_image'] != '' && file_exists(UPLOAD_DIR.'quiz/'.$detail['quiz_image']))) {
                    $id = $post['id'];
                    unlink(UPLOAD_DIR.'quiz/'.$detail['quiz_image']);
                    @unlink(UPLOAD_DIR.'quiz/tmb_'.$detail['quiz_image']);
                    @unlink(UPLOAD_DIR.'quiz/sml_'.$detail['quiz_image']);
                    $data_update = array('quiz_image' =>'');
                    $this->Quiz_model->UpdateRecord($post['id'],$data_update);
                    $json['success'] = alert_box('File hase been deleted.','success');
                    // insert to log
                    $data_log = array(
                        'id_user' => id_auth_user(),
                        'id_group' => id_auth_group(),
                        'action' => 'User Quiz',
                        'desc' => 'Delete Picture User Quiz; ID: '.$id.';',
                    );
                    insert_to_log($data_log);
                    // end insert to log
                } else {
                    $json['error'] = alert_box('Failed to remove File. Please try again.','danger');
                }
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
        redirect($this->class_path_name);
    }
    
    /**
     * answer page
     * @param int $id
     */
    public function answer($id=0) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Quiz_model->GetQuiz($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['export_excel_url']=site_url('quiz/export_excel_answer/'.$id);
        $this->data['page_title'] = 'Customer Answer';
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data_answer/'.$id);
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
    
    /**
     * list data answer
     * @param int $id
     */
    public function list_data_answer($id=0) {
        $this->layout = 'none';
        $id = (int)$id;
        $record = $this->Quiz_model->GetQuiz($id);
        if ($record && $id && $this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $param['search_value'] = $post['search']['value'];
            $param['search_field'] = $post['columns'];
            $param['where_prefix_field'] = 'id_quiz';
            $param['where_prefix_value'] = $id;
            $param_pref['where_prefix_field'] = 'id_quiz';
            $param_pref['where_prefix_value'] = $id;
            if (isset($post['order'])) {
                $param['order_field'] = $post['columns'][$post['order'][0]['column']]['data'];
                $param['order_sort'] = $post['order'][0]['dir'];
            }
            $param['row_from'] = $post['start'];
            $param['length'] = $post['length'];
            $count_all_records = $this->Quiz_model->CountAllQuizAnswer($param_pref);
            $count_filtered_records = $this->Quiz_model->CountAllQuizAnswer($param);
            $records = $this->Quiz_model->GetAllQuizAnswerData($param);

/*            echo '<pre>';
            print_r($record);
            die('<br>die</pre>');*/

            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['id_pelanggan'] = ($record['no_pelanggan']==0) ? 'Non-pelanggan' : $record['no_pelanggan'] ;//($record['id_pelanggan'] != '' && $record['id_pelanggan'] != '0') ? $record['id_pelanggan'] : 'Non-Pelanggan';
                $return['data'][$row]['name'] = $record['name'];
                $return['data'][$row]['email'] = $record['email'];
                $return['data'][$row]['socmed'] = '';
                $return['data'][$row]['no_hp'] = $record['no_hp'];
                $return['data'][$row]['alamat'] = nl2br($record['alamat']);
                $return['data'][$row]['answer'] = '';
                foreach ($record['answer'] as $answer) {
                    $return['data'][$row]['answer'] .= '
                        <ul style="padding-left: 10px;">
                            <li>
                                <strong>'.$answer['question'].'</strong><br/>
                                '.$answer['answer'].'
                            </li>
                        </ul>
                    ';
                }
                foreach ($record['socmed'] as $socmed) {
                    $return['data'][$row]['socmed'] .= '
                        <ul style="padding-left: 10px;">
                            <li>
                                <strong>' . $socmed['field'] . ': ' .$socmed['value'].'</strong>
                            </li>
                        </ul>
                    ';
                }
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
     * validate form
     * @param int $id
     * @return boolean
     */
    private function validateForm($id=0) {
        $post = $this->input->post();
        $config = array(
            array(
                'field' => 'quiz_title',
                'label' => 'Quiz Title',
                'rules' => 'required'
            ),
            array(
                'field' => 'start_date',
                'label' => 'Start Date',
                'rules' => 'required'
            ),
            array(
                'field' => 'end_date',
                'label' => 'End Date',
                'rules' => 'required'
            ),
            array(
                'field' => 'id_site[]',
                'label' => 'Sites',
                'rules' => 'required'
            ),
        );
        

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            $post_image = $_FILES;
            if (!$id) {
                if($post['is_question'] && $post['is_question']==1){
                    
                    if (!isset($post['question']) || count($post['question'])==0) {
                        echo '<pre>';
                        echo 'is question : ' . $post['is_question'] . '<br><br>';
                        echo 'isset question : not isset';
                        print_r($post['question']);
                        $this->error = 'Please Add Question.';
                        
                    } else {
                        foreach ($post['question'] as $question) {
                            if ($question['question'] == '') {
                                $this->error = 'Please input Question.';
                                echo 'asd';
                                break;
                            }
                        }
                    }
                }
            }
            
            if (!$this->error) {
                if (!empty($post_image['image']['tmp_name'])) {
                    $check_picture = validatePicture('image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture,'danger');
                        return FALSE;
                    }
                }
                return TRUE;
            } else {
                $this->error = alert_box($this->error,'danger');
                return FALSE;
            }
        }
    }
    function export_excel_answer($id=0){
        $this->layout = 'none';
        $list=array();
        $post=$this->input->post();
        $id = $id;
        $quiz = $this->Quiz_model->GetQuiz($id);
        $param['where_prefix_field'] = 'id_quiz';
        $param['where_prefix_value'] = $id;
        $record = $this->Quiz_model->GetAllQuizAnswerData($param);
        $name_file=url_title($quiz['quiz_title'],'_',true);
        
        if(count($record)>0){
            $no=0;
            foreach($record as $row){
                $answer = '';
                foreach ($row['answer'] as $key => $value) {
                    $answer .= '
                    <table>
                        <tr>
                            <td>'.$value['question'].'</td>
                            
                        </tr>
                        <tr>
                            <td>'.$value['answer'].'</td>

                        </tr>
                    </table>'; 
                }
                $sosmed ='';
                foreach ($row['socmed'] as $socmed) {
                    $sosmed .= '
                        <ul style="padding-left: 10px;">
                            <li>
                                <strong>' . $socmed['field'] . ': ' .$socmed['value'].'</strong>
                            </li>
                        </ul>
                    ';
                }
                $no++;
                $list[]=array(
                                        'no'=>$no,
                                        'ID'=>$row['id_pelanggan'],
                                        'name'=>$row['name'],
                                        'email'=>$row['email'],
                                        'no_hp'=>$row['no_hp'],
                                        'alamat'=>$row['alamat'],
                                        'answer'=>$answer,
                                        'sosmed'=>$sosmed,
                                        'create_date'=>date('d F Y',strtotime($row['create_date'])),
                                         );
            }
        }
        
         
        $this->data = array(
            'list'=>$list,
        );
       
        $ouput_file_name = 'report_quiz_'.$name_file.'.xls';
        
        $this->load->library('parser');
        $this->parser->parse(TEMPLATE_DIR.'/quiz/excel.html', $this->data);
        export_to($ouput_file_name);
    }
}
/* End of file Quiz.php */
/* Location: ./application/controllers/Quiz.php */