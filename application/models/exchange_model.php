<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/6
 * Time: 16:30
 */
class Exchange_model extends CI_Model{
    /*积分-商品订单*/
    public function getAllExchange($data){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('good_exchange');
        $this->db->join('integral_exchange', 'good_exchange.good_id = integral_exchange.good_id');
        $bool = $this->db->limit(5,$data*5)->get()->result();
        return $bool;
    }
    /*积分-商品订单数量*/
    public function getAllExchange_count(){
        $phone = $_SESSION['user_phone'];
        $this->db->select('*');
        $this->db->from('good_exchange');
        $this->db->join('integral_exchange', 'good_exchange.good_id = integral_exchange.good_id');
        $this->db->where('exchange_state','待支付');
        $this->db->where('phone',$phone);
        $bool = $this->db->get()->result();
        return $bool;
    }
    /*删除一条购物车信息*/
    public function deleteOneExchange($id){
        $this->db->where('exchange_id', $id);
        $bool = $this->db->delete('good_exchange');
        return $bool;
    }

    /*删除所有购物车信息*/
    public function deleteAllExchange(){
        $user_phone = $_SESSION['user_phone'];
        $this->db->where('phone', $user_phone);
        $this->db->where('exchange_state', '待支付');
        $bool =  $this->db->delete('good_exchange');
        return $bool;
    }

    /*修改一条购物车信息*/
    public function changeOneExchange($id,$num){
        $arr = array(
            'good_num' => $num
        );
        $bool = $this->db->where('exchange_id',$id)->update('good_exchange',$arr);
        return $bool;
    }

    /*修改所有购物车信息*/
    public function changeAllExchange($phone,$address,$curr_time,$integral_num){
        $user_phone = $_SESSION['user_phone'];
        $arr = array(
            'con_phone'=>$phone,
            'address' => $address,
            'submit_time'=>$curr_time,
            'need_integral'=>$integral_num,
            'exchange_state'=>'已支付'
        );
        $bool = $this->db->where('phone',$user_phone)->where('exchange_state','待支付')->update('good_exchange',$arr);
        return $bool;
    }
}