<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/23
 * Time: 10:44
 */
class Exits extends CI_Model{
    public function room_id_exits($id,$floor){
        $bool = $this->db->where('room_id',$id)->where('floor',$floor)->from('room_reservation')->get()->result();
        return $bool;
    }
    /*住房订单*/
    public function getRoomOrder($order_id){
        $this->db->select('*');
        $this->db->where('order_id',$order_id);
        $this->db->from('order_information');
        $this->db->join('room_reservation', 'order_information.room_id = room_reservation.room_id');
        $bool = $this->db->get()->result();
        return $bool;
    }
    /*积分订单*/
    public function getExchangeOrder($exchange_id){
        $this->db->select('*');
        $this->db->where('exchange_id',$exchange_id);
        $this->db->from('good_exchange');
        $this->db->join('integral_exchange', 'good_exchange.good_id = integral_exchange.good_id');
        $bool = $this->db->get()->result();
        return $bool;
    }

    public function all_integral($phone){
        $this->db->select('*');
        $this->db->where('phone',$phone);
        $this->db->from('user');
        $bool = $this->db->get()->row()->all_integral;
        return $bool;
    }
}