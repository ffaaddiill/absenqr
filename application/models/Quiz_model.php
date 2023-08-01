<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quiz_model extends CI_Model {

    function GetQuizByID($id_quiz) {
        $data = $this->db
                ->where('id_quiz', $id_quiz)
                ->where('quiz_status', 1)
                ->limit(1)
                ->get('quiz')
                ->row_array();
        if ($data) {
            $data['questions'] = $this->db
                    ->where('id_quiz', $data['id_quiz'])
                    ->order_by('position', 'asc')
                    ->get('quiz_question')
                    ->result_array();
        }
        return $data;
    }
    function GetActiveQuizByPath($path) {
        $data = $this->db
                //->where('id_quiz', $id_quiz)
                ->where('start_date <=', date('Y-m-d'))
                ->where('end_date >=', date('Y-m-d'))
                ->where('quiz_status', 1)
                ->where('lcase(uri_path)', strtolower($path))
                ->limit(1)
                ->order_by('id_quiz', 'desc')
                ->get('quiz')
                ->row_array();
                // print_r($this->db->last_query());
                // print_r($data);
                // die();
        if ($data) {
            $data['questions'] = $this->db
                    ->where('id_quiz', $data['id_quiz'])
                    ->order_by('position', 'asc')
                    ->get('quiz_question')
                    ->result_array();
        }
        return $data;
    }
    function GetActiveQuiz() {
        $data = $this->db
                //->where('id_quiz', $id_quiz)
                ->where('start_date >=', date('Y-m-d'))
                ->where('end_date >=', date('Y-m-d'))
                ->where('quiz_status', 1)
                ->limit(1)
                ->order_by('id_quiz', 'desc')
                ->get('quiz')
                ->row_array();
                ///print_r($this->db->last_query());
        if ($data) {
            $data['questions'] = $this->db
                    ->where('id_quiz', $data['id_quiz'])
                    ->order_by('position', 'asc')
                    ->get('quiz_question')
                    ->result_array();
        }
        return $data;
    }
    function GetPageContent($category) {
        $data = $this->db
                ->where('category', $category)
                ->get('page_contents')
                ->result_array();
        return $data;
    }
    function ListActiveQuiz(){
        $data = $this->db
                //->where('id_quiz', $id_quiz)
                ->where('start_date <=', date('Y-m-d'))
                ->where('end_date >=', date('Y-m-d'))
                ->where('quiz_status', 1)
                ->order_by('id_quiz', 'desc')
                ->get('quiz')
                ->result_array();
        return $data;
    }
    function InsertCustomer($data) {
        $this->db->insert('quiz_customer', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    function InsertCustomerAnswer($data) {
       $this->db->insert('quiz_customer_answer', $data);
        /*$last_id = $this->db->insert_id();
        return $last_id;*/
    }

    function GetCustomerAnswer($id_quiz) {
        $return = array();
        $data = $this->db
                ->select('quiz_customer.*,quiz_customer_answer.answer,quiz_customer_answer.create_date as answer_date')
                ->join('quiz_customer', 'quiz_customer.id_quiz_customer=quiz_customer_answer.id_quiz_customer', 'left')
                ->where('quiz_customer_answer.id_quiz', $id_quiz)
                ->order_by('create_date', 'desc')
                ->group_by('id_quiz_customer')
                ->get('quiz_customer_answer')
                ->result_array();
        if ($data) {
            $a = 0;
            foreach ($data as $row) {
                $return[$a] = $row;
                $return[$a]['answers'] = $this->db
                        ->select('quiz_customer_answer.answer, quiz_question.question')
                        ->join('quiz_question', 'quiz_question.id_quiz_question=quiz_customer_answer.id_quiz_question', 'left')
                        ->where('id_quiz_customer', $row['id_quiz_customer'])
                        ->order_by('quiz_question.position', 'asc')
                        ->get('quiz_customer_answer')
                        ->result_array();
                $a++;
            }
        }
        return $return;
    }

}
