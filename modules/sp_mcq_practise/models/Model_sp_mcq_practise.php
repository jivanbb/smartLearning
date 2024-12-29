<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_mcq_practise extends MY_Model
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
        $this->db->where('banned', 0);
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
        $this->db->select('q.id,c.name as course_name,ch.name as chapter_name,t.name as topic_name,s.name as set_name');
        $this->db->from('sp_mcq_question q');
        $this->db->join('sp_course c', 'q.course_id =c.id');
        $this->db->join('sp_chapter ch', 'q.chapter_id =ch.id', 'left');
        $this->db->join('sp_topic t', 'q.topic_id =t.id', 'left');
        $this->db->join('sp_set s', 'q.set_id =s.id', 'left');
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
        $this->db->where('mcq_id', $id);
        $this->db->order_by('id', 'RANDOM');
        return $this->db->get('sp_mcq_detail')->result();
    }

    public function get_practice_list($filter)
    {
        $this->db->select('q.*,c.name as course_name,c.image,a.full_name as creator_name,COUNT(q.course_id) as sets');
        $this->db->from('sp_mcq_question q');
        $this->db->join('sp_course c', 'q.course_id =c.id');
        $this->db->join('aauth_users a', 'q.created_by =a.id');
        if ($filter) {
            $this->db->like('c.name', $filter);
        }
        $this->db->group_by('q.course_id');
        return $this->db->get()->result();
    }

    public function get_chapter_detail($course_id)
    {
        $this->db->select('q.id,c.name,q.chapter_id');
        $this->db->from('sp_mcq_question q');
        $this->db->join('sp_chapter c', 'q.chapter_id =c.id');
        $this->db->where('q.course_id', $course_id);
        $this->db->group_by('q.chapter_id');
        return $this->db->get()->result();
    }

    public function get_study_detail($course_id)
    {
        $this->db->select('c.name,m.materials,m.chapter_id');
        $this->db->from('sp_materials m');
        $this->db->join('sp_course c', 'm.course_id =c.id', 'left');
        $this->db->where('m.course_id', $course_id);
        $this->db->group_by('m.chapter_id');
        return $this->db->get()->result();
    }

    public function get_course_detail($course_id)
    {
        $this->db->select('c.name as course_name,a.full_name,a.email,a.address,a.specialization');
        $this->db->from('sp_course c');
        $this->db->join('aauth_users a', 'c.created_by=a.id');
        $this->db->where('c.id', $course_id);
        return $this->db->get()->row();
    }
}

/* End of file Model_sp_mcq_question.php */
/* Location: ./application/models/Model_sp_mcq_question.php */