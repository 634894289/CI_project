<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/5
 * Time: 14:02
 */
class Point_shopping_model extends CI_Model{
    public function getAllGood($data){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('integral_exchange');
        $bool = $this->db->limit(9,$data*9)->get()->result();
        return $bool;
    }
    public function getAllGood_count(){
        $this->db->select('*');
        $this->db->from('integral_exchange');
        $bool = $this->db->get()->result();
        return $bool;
    }
    public function getOneGood($id){
        $this->db->select('*');
        $this->db->from('integral_exchange');
        $this->db->where('good_id',$id);
        $bool = $this->db->get()->row();
        return $bool;
    }
}