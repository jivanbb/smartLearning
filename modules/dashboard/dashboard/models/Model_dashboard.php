<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard extends MY_Model
{

	private $primary_key 	= 'id';
	private $table_name 	= 'dashboard';
	private $field_search 	= ['title', 'slug', 'created_at'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
			'table_name' 	=> $this->table_name,
			'field_search' 	=> $this->field_search,
		);
		parent::__construct($config);
	}

	public function count_all($q = null, $field = null, $category = null, $tag = null)
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);

		if (empty($field)) {
			foreach ($this->field_search as $field) {
				if ($iterasi == 1) {
					$where .= "dashboard." . $field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "dashboard." . $field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '(' . $where . ')';
		} else {
			$where .= "(" . "dashboard." . $field . " LIKE '%" . $q . "%' )";
		}

		if ($tag) {
			$this->db->where('tags LIKE "%' . $tag . '%"');
		}

		if ($category) {
			$this->db->where('category', $category);
		}
		$this->join_avaiable()->filter_avaiable();
		$this->db->where($where);
		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = null, $field = null, $limit = 0, $offset = 0, $category = null, $tag = null)
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);

		if (empty($field)) {
			foreach ($this->field_search as $field) {
				if ($iterasi == 1) {
					$where .= "dashboard." . $field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "dashboard." . $field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '(' . $where . ')';
		} else {
			$where .= "(" . "dashboard." . $field . " LIKE '%" . $q . "%' )";
		}
		if ($tag) {
			$this->db->where('tags LIKE "%' . $tag . '%"');
		}

		if ($category) {
			$this->db->where('category', $category);
		}
		$this->join_avaiable()->filter_avaiable();
		$this->db->where($where);
		$this->db->limit($limit, $offset);
		$this->sortable();
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable()
	{
		return $this;
	}
	public function filter_avaiable()
	{
		return $this;
	}
	public function find_by_slug($slug)
	{
		return $this->db->get_where($this->table_name, ['slug' => $slug])->row();
	}

	public function get_total_course($id, $positions)
	{
		foreach ($positions as $position) {
			if ($position->group_id > 1) {
				$this->db->where('created_by', $id);
			}
		}

		$this->db->where('is_deleted', 0);
		return $this->db->get('sp_course')->num_rows();
	}
	public function get_total_visited()
	{
		return $this->db->get('sp_visit')->num_rows();
	}

	public function get_total_board($id, $positions)
	{
		foreach ($positions as $position) {
			if ($position->group_id > 1) {
				$this->db->where('created_by', $id);
			}
		}
		$this->db->where('is_deleted', 0);
		return $this->db->get('sp_board')->num_rows();
	}
	public function get_total_teacher()
	{
		$this->db->from('aauth_users a');
		$this->db->join('aauth_user_to_group ag', 'ag.user_id =a.id');
		$this->db->where('a.banned', 0);
		$this->db->where('ag.group_id', 2);
		return $this->db->get()->num_rows();
	}
	public function get_total_student()
	{
		$this->db->from('aauth_users a');
		$this->db->join('aauth_user_to_group ag', 'ag.user_id =a.id');
		$this->db->where('a.banned', 0);
		$this->db->where('ag.group_id', 3);
		return $this->db->get()->num_rows();
	}

	public function get_total_mcq($id, $positions)
	{
		$this->db->from('sp_mcq_question q');
		$this->db->join('sp_mcq_detail qd', 'qd.mcq_id=q.id');
		foreach ($positions as $position) {
			if ($position->group_id > 1) {
				$this->db->where('q.created_by', $id);
			}
		}
		$this->db->where('q.is_deleted', 0);
		return $this->db->get()->num_rows();
	}

	public function get_total_materials($id, $positions)
	{
		foreach ($positions as $position) {
			if ($position->group_id > 1) {
				$this->db->where('created_by', $id);
			}
		}
		$this->db->where('is_deleted', 0);
		return $this->db->get('sp_materials')->num_rows();
	}

	public function get_total_videos($id)
	{
		 $this->db->where('created_by', $id);
		 $this->db->where('is_deleted',0);
		 return $this->db->get('sp_video')->num_rows();
	}
}

/* End of file Model_dashboard.php */
/* Location: ./application/models/Model_dashboard.php */