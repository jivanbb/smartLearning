<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Blog Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Sp_mcq_practise extends Front
{
	
	public function __construct()
	{
		parent::__construct();
        $this->load->model('model_sp_mcq_practise');
	}


 
    public function index($offset = 0) 
    {
        $filter =$this->input->get('q');
        $this->data['practice_list'] = $this->model_sp_mcq_practise->get_practice_list($filter);
        if( $this->data['practice_list']){
            $this->template->build('sp_mcq_practise/index', $this->data);
        }else{
            $this->template->build('error_page', $this->data);
        }
      
    }

    public function detail($id){
        $this->data['id']=$id;  
        $id = decrypt_string($id);
        $this->data['course_detail'] =$this->model_sp_mcq_practise->get_course_detail($id);
        $this->data['chapter_detail']=$this->model_sp_mcq_practise->get_chapter_detail($id);
        $this->template->build('sp_mcq_practise/detail', $this->data);
    }

    public function study($id){
        $this->data['id']=$id;  
        $id = decrypt_string($id);
        $this->data['course_detail'] =$this->model_sp_mcq_practise->get_course_detail($id);
        $this->data['study_detail']=$this->model_sp_mcq_practise->get_study_detail($id);
        $this->template->build('sp_mcq_practise/study', $this->data);
    }

    public function practice($id){  
        $this->data['id']=$id;      
        $id = decrypt_string($id);
        $question_arr = [];
		$questions = $this->model_sp_mcq_practise->get_questions($id);
		foreach ($questions as $res) {
			$question_arr[] = [
				'question' => $res->question,
				'answers' => [
					["text" => $res->option_1, "correct" => $res->correct_option == 1],
					["text" => $res->option_2, "correct" => $res->correct_option == 2],
					["text" => $res->option_3, "correct" => $res->correct_option == 3],
					["text" => $res->option_4, "correct" => $res->correct_option == 4]

				],
				'explanation'=>$res->explanation
			];
		}
		$this->data['questions'] = json_encode($question_arr);
        $this->template->build('sp_mcq_practise/practice', $this->data);
    }

}


/* End of file Blog.php */
/* Location: ./application/controllers/Blog.php */