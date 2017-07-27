<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/5
 * Time: 17:13
 */
class Home_model extends CI_Model{
    public function  getPreferential(){
        $this->db->select('*');
        $this->db->from('preferential_information');
        $bool = $this->db->limit(4,0)->get()->result();
        return $bool;
    }
    public function getGood(){
        $this->db->select('*');
        $this->db->from('integral_exchange');
        $bool = $this->db->limit(3,0)->get()->result();
        return $bool;
    }
}