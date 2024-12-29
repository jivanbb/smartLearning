<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    function check_role_exist_or_not($module_id, $actions = [])
    {
        $CI = &get_instance();
        $CI->load->model('role/model_role');
        $roles_arr = array();
        $data = array();
        $count = 0;
    
        if (empty($actions)) {
            return true;
        }
        $id =$CI->session->userdata('id');
        $positions =$CI->model_role->get_user_position($id);
        foreach ($positions as $position) {
            if($position->group_id ==1){
                return true;
            }
            $roles_details = $CI->model_role->GetAllRoles($position->group_id);
    
    
            foreach ($actions as $action) {
                if (isset($roles_details[$module_id][$action]) && $roles_details[$module_id][$action]) {
                        // return true;
                    $count++;
                }
            }
        }
    
        return $count > 0 ? true : false;
    
        // }
    
        return false;
    }

    function get_mcq_detail($id){
        $CI = &get_instance();
        $CI->load->database();
        return $CI->db->get_where('sp_mcq_question', array('id' => $id))->row();
    }

    function get_company_detail(){
        $CI = &get_instance();
        $CI->load->database();
        return $CI->db->get_where('sp_company', array('id' => 1))->row();
    }

    function get_education($id){
        $CI = &get_instance();
        $CI->load->database();
        return $CI->db->get_where('sp_education', array('id' => $id))->row('name');
    }

    function get_no_of_question($id){
        $CI = &get_instance();
        $CI->load->database();
        $CI->db->where('is_deleted',0);
        $CI->db->where('mcq_id',$id);
        return $CI->db->get('sp_mcq_detail')->num_rows();   
    }

    function get_courses($board_id){
        $CI = &get_instance();
        $CI->load->model('sp_mcq_question/model_sp_mcq_question');
        return $CI->model_sp_mcq_question->getCourseByUniversity($board_id);
    }

    function get_teacher_course($teacher_id){
        $CI = &get_instance();
        $CI->db->where('is_deleted',0);
        $CI->db->where('created_by',$teacher_id);
        return $CI->db->get('sp_course')->result(); 
    }

    function get_chapters($course_id){
        $CI = &get_instance();
        $CI->load->model('sp_mcq_question/model_sp_mcq_question');
        return $CI->model_sp_mcq_question->getChapterByCourse($course_id);
    }

    function get_topics($chapter_id){
        $CI = &get_instance();
        $CI->load->model('sp_mcq_question/model_sp_mcq_question');
        return $CI->model_sp_mcq_question->getTopicByChapter($chapter_id);
    }

    function get_mcq_topics($chapter_id){
        $CI = &get_instance();
        $CI->db->select('q.id as mcq_id,t.name');
        $CI->db->from('sp_mcq_question q');
        $CI->db->join('sp_topic t','q.topic_id=t.id');
        $CI->db->where('q.chapter_id',$chapter_id);
        return $CI->db->get()->result();
    }

    function check_enable_or_not($modulearray, $modulename)
{
    if (!in_array($modulename, $modulearray))
        return "disabled";

    return '';
}

function get_user_position()
{
    $CI = &get_instance();
    $CI->load->model('role/model_role');
    $id = $CI->session->userdata('id');
    $positions = $CI->model_role->get_user_position($id);
    return $positions;
}

function check_user_position($position_id)
{
    $CI = &get_instance();
    $id = $CI->session->userdata('id');
    $CI->db->where('user_id',$id);
    $CI->db->where('group_id',$position_id);
    return $CI->db->get('aauth_user_to_group')->row();
}

function get_ad_list(){
    $CI = &get_instance();
    $CI->db->where('is_deleted',0);
    $CI->db->order_by('order','acs');
    return $CI->db->get('sp_ad')->result();   
}


function get_popular_teacher(){
    $CI = &get_instance();
    $CI->db->select('a.*');
    $CI->db->from('aauth_users a');
    $CI->db->join('aauth_user_to_group ag','ag.user_id =a.id');
    $CI->db->where('ag.group_id',2);
    return $CI->db->get()->result();   
}

function encrypt_string($string)
{
    $encrypt_method = "AES-256-CBC";
    $secret_key = '#!!@@';
    $secret_iv = 'puskar@123';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
}

function decrypt_string($string){
    $encrypt_method = "AES-256-CBC";
    $secret_key = '#!!@@';
    $secret_iv = 'puskar@123';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0,$iv);
    return $output;
}

function get_qustion_detail($id){
    $CI = &get_instance();
    $CI->db->select('qd.*,q.no_of_options');
    $CI->db->from('sp_mcq_detail qd');
    $CI->db->join('sp_mcq_question q','qd.mcq_id=q.id');
    $CI->db->where('qd.id',$id);
    return $CI->db->get()->row();
}

function get_wrong_ans_detail($id,$question_id){
    $CI = &get_instance();
    $CI->db->where('question_id',$question_id);
    $CI->db->where('result_id',$id);
    return $CI->db->get('sp_result_detail')->row();
}

function count_total_exam_attended($exam_id){
    $CI = &get_instance();
    $CI->db->where('exam_id', $exam_id);
    return $CI->db->get('sp_exam_result')->num_rows();
}

function get_exam_attempts($user_id,$exam_id){
    $CI = &get_instance();
    $CI->db->where('user_id', $user_id);
    $CI->db->where('exam_id', $exam_id);
    return $CI->db->get('sp_exam_result')->num_rows();
}

function get_teachers(){
    $CI = &get_instance();
    $CI->load->model('sp_mcq_exam/model_sp_mcq_exam');
    return $CI->model_sp_mcq_exam->get_teachers();
}

function get_student_rank($exam_id, $user_id,$exam_result_id){
    $CI = &get_instance();
   $CI->db->select('id,user_id, score, time_taken');
   $CI->db->from('sp_exam_result');
   $CI->db->where('exam_id', $exam_id);
    
    // Rank students first by score, then by time taken (ascending)
   $CI->db->order_by('score', 'DESC');
   $CI->db->order_by('time_taken', 'ASC');
    
    $query =$CI->db->get();
    $students = $query->result_array();
    
    // Loop through the results to find the student's rank
    $rank = 1;
    foreach ($students as $student) {
        if ($student['user_id'] == $user_id && $student['id']==$exam_result_id) {
            break;
        }
        $rank++;
    }
    
    return $rank;  
}

function englishMonthsName()
{
    $months = array(

        4 => 'Shrawan',
        5 => 'Bhadra',
        6 => 'Ashwin',
        7 => 'Kartik',
        8 => 'Mangsir',
        9 => 'Poush',
        10 => 'Magh',
        11 => 'Falgun',
        12 => 'Chaitra',
        1 => 'Baishakh',
        2 => 'Jestha',
        3 => 'Ashadh',
    );
    return $months;
}
function monthNepaliEnglish($index)
{
    $months = array(
        1 => 'Baishakh',
        2 => 'Jestha',
        3 => 'Ashadh',
        4 => 'Shrawan',
        5 => 'Bhadra',
        6 => 'Ashwin',
        7 => 'Kartik',
        8 => 'Mangsir',
        9 => 'Poush',
        10 => 'Magh',
        11 => 'Falgun',
        12 => 'Chaitra',
    );
    return $months[$index];
}

function convertToDateYmd($inputDate) {
    // Convert the input date to a timestamp
    $timestamp = strtotime($inputDate);
    if ($timestamp === false) {
        // Handle invalid date formats
        return 'Invalid date format: ' . $inputDate;
    }
    // Format the timestamp to 'Y-m-d'
    return date('Y-m-d', $timestamp);
}


