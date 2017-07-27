<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/4
 * Time: 21:17
 */
class Show_preferential_model extends CI_Model{
    public function getAllPreferential($data){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('preferential_information');
        $bool = $this->db->limit(4,$data*4)->get()->result();
        return $bool;
    }
    public function getAllPreferential_count(){
        $this->db->select('*');
        $this->db->from('preferential_information');
        $bool = $this->db->get()->result();
        return $bool;
    }
    public function getOnePreferential($id){
        $this->db->select('*');
        $this->db->from('preferential_information');
        $this->db->where('preferential_id',$id);
        $bool = $this->db->get()->row();
        return $bool;
    }
}