<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 22:30
 */
class Add_model extends CI_Model{
    /*增加一条房间信息*/
    public function add_roon($data){
        $bool = $this->db->insert('room_reservation',$data);
        return $bool;
    }

    /*增加一条优惠信息*/
    public function add_preferential($data){
        $bool = $this->db->insert('preferential_information',$data);
        return $bool;
    }

    /*增加一条商品信息*/
    public function add_exchange($data){
        $bool = $this->db->insert('integral_exchange',$data);
        return $bool;
    }

    /*增加一条住房订单信息*/
    public function addOrder($data){
        $bool = $this->db->insert('order_information',$data);
        return $bool;
    }
    /*增加一条余额收支信息*/
    public function addBalance($data){
        $bool = $this->db->insert('balance_information',$data);
        return $bool;
    }

    /*增加一条积分—商品交换信息*/
    public function add_good_exchange($data){
        $bool = $this->db->insert('good_exchange',$data);
        return $bool;
    }

    /*增加一条积分收支信息*/
    public function add_integral_Order($data){
        $bool = $this->db->insert('integral_information',$data);
        return $bool;
    }
}