<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_teacher extends MY_Model
{

  public function get_teacher_list($filter)
  {
    $this->db->select('u.*');
    $this->db->from('aauth_users u');
    $this->db->join('aauth_user_to_group g', 'g.user_id =u.id');
    $this->db->where('g.group_id', 2);
    if ($filter) {
      $this->db->like('u.full_name', $filter);
    }
    return $this->db->get()->result();
  }

  public function get_teacher_detail($id)
  {
    $this->db->where('id', $id);
    return $this->db->get('aauth_users')->row();
  }
}

/* End of file Model_sp_mcq_question.php */
/* Location: ./application/models/Model_sp_mcq_question.php */