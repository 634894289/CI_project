<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 13:04
 */
class Manager_model extends CI_Model{
    /*住房订单*/
    public function getRoomOrder($data,$checked){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('order_information');
        $this->db->join('room_reservation', 'order_information.room_id = room_reservation.room_id');
        if($checked != 'all'){
            $this->db->where('done_state',$checked);
        }
        $bool = $this->db->limit(8,$data*8)->order_by('order_id','DESC')->get()->result();
        return $bool;
    }
    /*住房订单数量*/
    public function getRoomOrder_count($checked){
        $this->db->select('*');
        $this->db->from('order_information');
        $this->db->join('room_reservation', 'order_information.room_id = room_reservation.room_id');
        if($checked != 'all'){
            $this->db->where('done_state',$checked);
        }
        $bool = $this->db->get()->result();
        return $bool;
    }
    /*积分订单*/
    public function getPointOrder($data,$checked){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('good_exchange');
        $this->db->join('integral_exchange', 'good_exchange.good_id = integral_exchange.good_id');
        if($checked != 'all'){
            $this->db->where('done_state',$checked);
        }
        $bool = $this->db->where('exchange_state','已支付')->limit(8,$data*8)->order_by('exchange_id','DESC')->get()->result();
        return $bool;
    }
    /*积分订单数量*/
    public function getPointOrder_count($checked){
        $this->db->select('*');
        $this->db->from('good_exchange');
        $this->db->join('integral_exchange', 'good_exchange.good_id = integral_exchange.good_id');
        if($checked != 'all'){
            $this->db->where('done_state',$checked);
        }
        $bool = $this->db->where('exchange_state','已支付')->get()->result();
        return $bool;
    }
    /*房间信息*/
    public function getAllRoom($data){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('room_reservation');
        $bool = $this->db->limit(7,$data*7)->get()->result();
        return $bool;
    }
    /*房间数量*/
    public function getAllRoom_count(){
        $this->db->select('*');
        $this->db->from('room_reservation');
        $bool = $this->db->get()->result();
        return $bool;
    }
    /*删除一条酒店住房信息*/
    public function deleteOneRoom($id){
        $this->db->where('room_id', $id);
        $bool = $this->db->delete('room_reservation');
        return $bool;
    }
    /*获取一条酒店信息*/
    public function getOneRoom($id){
        $this->db->where('room_id', $id);
        $bool = $this->db->get('room_reservation')->row();
        return $bool;
    }
    /*修改酒店住房信息*/
    public function alertAllRoom($data){
        $this->db->where('room_id', $data['room_id']);
        $bool = $this->db->update('room_reservation', $data);
        return $bool;
    }
    /*优惠信息*/
    public function getAllPreferential($data){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('preferential_information');
        $bool = $this->db->limit(7,$data*7)->get()->result();
        return $bool;
    }
    /*优惠数量*/
    public function getAllPreferential_count(){
        $this->db->select('*');
        $this->db->from('preferential_information');
        $bool = $this->db->get()->result();
        return $bool;
    }
    /*删除一条优惠信息*/
    public function deleteOnePreferential($id){
        $this->db->where('preferential_id', $id);
        $bool = $this->db->delete('preferential_information');
        return $bool;
    }
    /*获取一条优惠信息*/
    public function getOnePreferential($id){
        $this->db->where('preferential_id', $id);
        $bool = $this->db->get('preferential_information')->row();
        return $bool;
    }
    /*修改优惠信息*/
    public function alertAllPreferential($data){
        $this->db->where('preferential_id', $data['preferential_id']);
        $bool = $this->db->update('preferential_information', $data);
        return $bool;
    }
    /*商品信息*/
    public function getAllExchange($data){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('integral_exchange');
        $bool = $this->db->limit(7,$data*7)->get()->result();
        return $bool;
    }
    /*商品数量*/
    public function getAllExchange_count(){
        $this->db->select('*');
        $this->db->from('integral_exchange');
        $bool = $this->db->get()->result();
        return $bool;
    }
    /*删除一条商品信息*/
    public function deleteOneExchange($id){
        $this->db->where('good_id', $id);
        $bool = $this->db->delete('integral_exchange');
        return $bool;
    }
    /*获取一条商品信息*/
    public function getOneExchange($id){
        $this->db->where('good_id', $id);
        $bool = $this->db->get('integral_exchange')->row();
        return $bool;
    }
    /*修改商品信息*/
    public function alertAllExchange($data){
        $this->db->where('good_id', $data['good_id']);
        $bool = $this->db->update('integral_exchange', $data);
        return $bool;
    }
    /*修改房间订单处理状态*/
    public  function changeOrderDone($order_id){
        $this->db->where('order_id',$order_id);
        $data = array(
            'done_state' => '已处理'
        );
        $bool = $this->db->update('order_information', $data);
        return $bool;
    }
    /*修改房间订单入住状态*/
    public  function changeOrderState($order_id){
        $this->db->where('order_id',$order_id);
        $data = array(
            'order_state' => '已入住'
        );
        $bool = $this->db->update('order_information', $data);
        return $bool;
    }

    /*修改房间订单入住状态*/
    public  function changeOrderStateOne($order_id){
        $this->db->where('order_id',$order_id);
        $data = array(
            'order_state' => '已退房'
        );
        $bool = $this->db->update('order_information', $data);
        return $bool;
    }

    /*删除一条房间订单*/
    public  function deleteOneOrder($order_id){
        $this->db->where('order_id',$order_id);
        $bool = $this->db->delete('order_information');
        return $bool;
    }

    /*修改余额*/
    public function change_balance($phone,$balance){
        $arr = array(
            'balance' => $balance
        );
        $bool = $this->db->where('phone',$phone)->update('user',$arr);
        return $bool;
    }

    /*用户余额信息*/
    public function getUserBalance($phone){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('phone',$phone);
        $bool = $this->db->get()->row();
        return $bool;
    }
    public function changeRoom($room_id){
        $arr = array(
            'checkIn_state' => '空'
        );
        $bool = $this->db->where('room_id',$room_id)->update('room_reservation',$arr);
        return $bool;
    }

    /*修改积分订单处理状态*/
    public  function changePointOrderDone($exchange_id){
        $this->db->where('exchange_id',$exchange_id);
        $data = array(
            'done_state' => '已处理'
        );
        $bool = $this->db->update('good_exchange', $data);
        return $bool;
    }


    /*会员信息*/
    public function getAllMenber($data){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('user');
        $bool = $this->db->limit(7,$data*7)->get()->result();
        return $bool;
    }
    /*会员数量*/
    public function getAllMenber_count(){
        $this->db->select('*');
        $this->db->from('user');
        $bool = $this->db->get()->result();
        return $bool;
    }

    /*删除一条会员信息*/
    public function deleteOneMenber($id){
        $this->db->where('phone', $id);
        $bool = $this->db->delete('user');
        return $bool;
    }
    /*获取一条会员信息*/
    public function getOneMenber($id){
        $this->db->where('phone', $id);
        $bool = $this->db->get('user')->row();
        return $bool;
    }
}