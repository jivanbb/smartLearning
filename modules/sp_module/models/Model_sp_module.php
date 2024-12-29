<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_sp_module extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'sp_module';
	private $field_search 	= ['name'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
			'table_name' 	=> $this->table_name,
			'field_search' 	=> $this->field_search,
		);

		parent::__construct($config);
	}

	public function count_all($q = null, $field = null)
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);

		if (empty($field)) {
			foreach ($this->field_search as $field) {
				if ($iterasi == 1) {
					$where .= "sp_module.".$field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "sp_module.".$field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '('.$where.')';
		} else {
			$where .= "(" . "sp_module.".$field . " LIKE '%" . $q . "%' )";
		}

		$this->join_avaiable()->filter_avaiable();
		$this->db->where($where);
		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);

		if (empty($field)) {
			foreach ($this->field_search as $field) {
				if ($iterasi == 1) {
					$where .= "sp_module.".$field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "sp_module.".$field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '('.$where.')';
		} else {
			$where .= "(" . "sp_module.".$field . " LIKE '%" . $q . "%' )";
		}

		if (is_array($select_field) AND count($select_field)) {
			$this->db->select($select_field);
		}
		
		$this->join_avaiable()->filter_avaiable();
		$this->db->where($where);
		// $this->db->limit($limit, $offset);
		$this->db->order_by('sp_module.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		
		$this->db->select('sp_module.*');


		return $this;
	}

	public function filter_avaiable() {
		
		return $this;
	}

// function get_all_modules(){
//       $this->db->select('*');
//       $this->db->where('is_deleted', 0);
//       $this->db->order_by('id','DESC');
//        $result = $this->db->get('sp_module')->result();
//       return $result;  
//     }
	public function get_all_modules(){

		$this->db->select('*');
		$this->db->from('sp_module');
		$this->db->where('is_deleted', 0);
		$this->db->where('parent', 0);

		$parent = $this->db->get();

		$categories = $parent->result();
		$i=0;
		foreach($categories as $main_cat){

			$categories[$i]->sub = $this->sub_module($main_cat->id);
			$i++;
		}
		return $categories;
	}

	public function sub_module($id){

		$this->db->select('*');
		$this->db->from('sp_module');
		$this->db->where('is_deleted', 0);
		$this->db->where('parent', $id);

		$child = $this->db->get();
		$categories = $child->result();
		$i=0;
		foreach($categories as $sub_cat){

			$categories[$i]->sub = $this->sub_module($sub_cat->id);
			$i++;
		}
		return $categories;       
	}

	public function update_child_menu_by_parent($parent)
	{
		$this->db->where('parent', $parent);
		$result = $this->db->update($this->table_name, ['parent' => '0']);

		return $result;
	}


	public function get_id_menu_type_by_flag($flag = '')
	{
		$flag = str_replace('-', ' ', $flag);

		$query = $this->db->get_where('menu_type', ['name' => $flag]);

		if ($query->row()) {
			return $query->row()->id;
		}

		return 0;
	}

	public function get_color_icon()
	{
		
		$color_icon = ['text-red', 'text-yellow', 'text-aqua', 'text-blue', 'text-black', 'text-light-blue', 'text-green', 'text-gray', 'text-navy', 'text-teal', 'text-olive', 'text-lime', 'text-orange', 'text-fuchsia', 'text-purple', 'text-maroon',];

		return $color_icon;
	}

}

/* End of file Model_sp_module.php */
/* Location: ./application/models/Model_sp_module.php */