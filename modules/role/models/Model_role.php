<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model_role extends MY_Model {

//    function get_modules(){

//     $this->db->select('*');
//     $this->db->from('oms_module');
//     $this->db->where('is_deleted', 0);
//     $result = $this->db->get()->result();
//     return $result;  
// }
  public function get_modules(){

    $this->db->select('*');
    $this->db->from('sp_module');
    $this->db->where('is_deleted', 0);
    $this->db->where('parent', 0);
    $this->db->where('active', 1);
    //$this->db->where('sub_menu', 0);
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
    $this->db->where('active', 1);
   // $this->db->where('sub_menu', 0);

    $child = $this->db->get();
    $categories = $child->result();
    $i=0;
    foreach($categories as $sub_cat){

      $categories[$i]->sub = $this->sub_module($sub_cat->id);
      $i++;
    }
    return $categories;       
  }

  function GetAllRoles ($position_id)
  {
   $this->db->where('group_id', $position_id);
   $result = $this->db->get('sp_role')->result();
   $data = array();
   foreach($result as $row)
   {
     $data[$row->module_id]['add'] = $row->add;
     $data[$row->module_id]['list'] = $row->list;
     $data[$row->module_id]['edit'] = $row->edit;
     $data[$row->module_id]['delete'] = $row->delete;
     $data[$row->module_id]['self_only'] = $row->self_only;
     $data[$row->module_id]['view'] = $row->view;
     $data[$row->module_id]['mobile'] = $row->mobile;
   }
   return $data; 
 }

 function get_user_position($id){
  $this->db->select('ag.group_id');
  $this->db->from('aauth_user_to_group ag');
  $this->db->join('aauth_users a','ag.user_id =a.id');
  $this->db->where('a.id',$id);
  return $this->db->get()->result();
}


function update_role($group_id){
  $update = array('add' => 0, 'list'=>0,'view'=>0,'edit' =>0,'delete'=>0,'self_only'=>0,'mobile'=>0); 
  $this->db ->where('group_id',$group_id);
  return  $this->db->update('sp_role',$update);
}

function check_exits($module_id,$group_id){
 $this->db->select('id');
 $this->db->where('module_id',$module_id);
 $this->db->where('group_id',$group_id);
 $data = $this->db->get('sp_role')->row();
 return $data;

}

function check_enable($id){
 $this->db->select('id');
 $this->db->where('id',$id);
 $this->db->where('active',1);
 $data = $this->db->get('sp_module')->row();
 return $data;

}

function get_roles(){
 $this->db->distinct();
 $this->db->select('group_id');
 return $this->db->get('sp_role')->result();

}


function get_department_name($group_id){
  $this->db->select('name');
  $this->db->where('id',$group_id);
  return $this->db->get('aauth_groups')->row();
}


}

/* End of file Model_access.php */
/* Location: ./application/models/Model_access.php */