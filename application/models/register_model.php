<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/11
 * Time: 16:18
 */
class Register_model extends  CI_Model{
    public function insert($register_data){
       $bool = $this->db->insert('user',$register_data);
        return $bool;
    }
    public function exits($data){
        $bool = $this->db->where('phone',$data)->from('user')->get()->result();
        return $bool;
    }
    public function login_exits($data){
        $bool = $this->db->where('phone',$data)->from('user')->get()->result();
        return $bool;
    }
    public function manager_login_exits($data){
        $bool = $this->db->where('manager_id',$data)->from('manager')->get()->result();
        return $bool;
    }
}