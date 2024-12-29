<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_mcq_exam extends MY_Model
{

    private $primary_key    = 'id';
    private $table_name     = 'sp_mcq_question';
    public $field_search   = ['course_id', 'chapter_id', 'topic_id', 'no_of_options', 'sp_course.name', 'sp_topic.name', 'sp_chapter.name'];
    public $sort_option = ['id', 'DESC'];

    public function __construct()
    {
        $config = array(
            'primary_key'   => $this->primary_key,
            'table_name'    => $this->table_name,
            'field_search'  => $this->field_search,
            'sort_option'   => $this->sort_option,
        );

        parent::__construct($config);
    }

    public function get_teachers()
    {
        $this->db->select('u.id,u.full_name');
        $this->db->from('aauth_users u');
        $this->db->join('aauth_user_to_group g', 'g.user_id =u.id');
        $this->db->where('g.group_id', 2);
        return $this->db->get()->result();
    }

    public function getCourseByTeacher($teacher)
    {
        return $this->db->select('*')
            ->where('created_by', $teacher)
            ->where('is_deleted', 0)
            ->get('sp_course')->result();
    }

    public function getChapterByCourse($course_id)
    {
        return $this->db->select('*')
            ->where('course_id', $course_id)
            ->where('is_deleted', 0)
            ->get('sp_chapter')->result();
    }

    public function getTopicByChapter($chapter_id)
    {
        return $this->db->select('*')
            ->where('chapter_id', $chapter_id)
            ->where('is_deleted', 0)
            ->get('sp_topic')->result();
    }

    public function get_mcq_question($filter)
    {
        if (empty($filter)) {
            return [];
        }
        $this->db->select('q.id,c.name as course_name,ch.name as chapter_name,t.name as topic_name');
        $this->db->from('sp_mcq_question q');
        $this->db->join('sp_course c', 'q.course_id =c.id');
        $this->db->join('sp_chapter ch', 'q.chapter_id =ch.id');
        $this->db->join('sp_topic t', 'q.topic_id =t.id');
        if (@$filter['course_id']) {
            $this->db->where('q.course_id', @$filter['course_id']);
        }
        if (@$filter['chapter_id']) {
            $this->db->where('q.chapter_id', @$filter['chapter_id']);
        }
        if (@$filter['topic_id']) {
            $this->db->where('q.topic_id', $filter['topic_id']);
        }
        $this->db->where('q.created_by', @$filter['teacher']);
        return $this->db->get()->result();
    }

    public function get_questions($id)
    {
        $this->db->where('mcq_id',$id);
        $this->db->order_by('id', 'RANDOM');
        return $this->db->get('sp_mcq_detail')->result();
    }

    
}

/* End of file Model_sp_mcq_question.php */
/* Location: ./application/models/Model_sp_mcq_question.php */