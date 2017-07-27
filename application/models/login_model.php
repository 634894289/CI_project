<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/11
 * Time: 20:53
 */
class Login_model extends CI_Model{
    public function check_password($data){
        $res = $this->db->where('phone',$data)->from('user')->get();
        $result = $res->row();
        if (isset($result))
        {
            return $result;
        }
        return false;
    }
    public function check_manager_password($data){
        $res = $this->db->where('manager_id',$data)->from('manager')->get();
        $result = $res->row();
        if (isset($result))
        {
            return $result;
        }
        return false;
    }
}