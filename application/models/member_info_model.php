<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/17
 * Time: 11:09
 */
class Member_info_model extends CI_Model{
    /*获取个人信息*/
    public function getData($data){
        $bool = $this->db->where('phone',$data)->from('user')->get()->row();
        return $bool;
    }
    /*修改个人信息*/
    public function changeInfo($data){
        $arr = array(
            'nickname' => $data['nickname']
        );
        $bool = $this->db->where('phone',$data['phone'])->update('user',$arr);
        return $bool;
    }
    /*修改密码*/
    public function change_password($data){
        $arr = array(
            'user_password' => $data['user_password']
        );
        $bool = $this->db->where('phone',$data['phone'])->update('user',$arr);
        return $bool;
    }
    /*获取密码*/
    public function get_password(){
       $phone = $_SESSION['user_phone'];
        $bool = $this->db->where('phone',$phone)->from('user')->get()->row();
        return $bool->user_password;
    }
    /*获取订单*/
    public function getOrderList($data ,$checked){
        $is_mobile = is_mobile();
        $data = $data>0?$data-1:$data;
        $phone = $_SESSION['user_phone'];
        if($checked == 'all'){
             $this->db->where('phone',$phone)->from('order_information');
        }else{
            $array = array('phone' => $phone, 'order_state' => $checked);
             $this->db->where($array)->from('order_information');
        }
        if($is_mobile){
            $bool = $this->db->limit(2,$data*2)->order_by('order_id','DESC')->get()->result();
        }else{
            $bool = $this->db->limit(8,$data*8)->order_by('order_id','DESC')->get()->result();
        }
        return $bool;
    }
    /*获取订单数目*/
    public function getOrderList_count($checked){
        $phone = $_SESSION['user_phone'];
        if($checked == 'all') {
            $bool = $this->db->where('phone', $phone)->from('order_information')->get()->result();
        }else{
            $array = array('phone' => $phone, 'order_state' => $checked);
            $bool = $this->db->where($array)->from('order_information')->get()->result();
        }
        return $bool;
    }
    /*获取余额订单*/
    public function getStoredValue($data ,$checked){
        $data = $data>0?$data-1:$data;
        $phone = $_SESSION['user_phone'];
        if($checked == 'all'){
            $bool = $this->db->where('phone',$phone)->from('balance_information')->limit(4,$data*4)->order_by('balance_id','DESC')->get()->result();
        }else{
            $array = array('phone' => $phone, 'balance_state' => $checked);
            $bool = $this->db->where($array)->from('balance_information')->limit(4,$data*4)->order_by('balance_id','DESC')->get()->result();
        }
        return $bool;
    }
    /*获取余额订单数目*/
    public function getStoredValue_count($checked){
        $phone = $_SESSION['user_phone'];
        if($checked == 'all') {
            $bool = $this->db->where('phone', $phone)->from('balance_information')->get()->result();
        }else{
            $array = array('phone' => $phone, 'balance_state' => $checked);
            $bool = $this->db->where($array)->from('balance_information')->get()->result();
        }
        return $bool;
    }

    /*获取积分兑换订单*/
    public function getPointOrderList($data){
        $data = $data>0?$data-1:$data;
        $phone = $_SESSION['user_phone'];
        $this->db->select('*');
        $this->db->where('phone',$phone);
        $this->db->where('exchange_state','已支付');
        $this->db->from('good_exchange');
        $this->db->join('integral_exchange', 'good_exchange.good_id = integral_exchange.good_id');
        if(is_mobile()){
            $bool = $this->db->limit(5,$data*5)->order_by('exchange_id','DESC')->get()->result();
        }
        else{
            $bool = $this->db->limit(8,$data*8)->order_by('exchange_id','DESC')->get()->result();
        }
        return $bool;
    }
    /*获取积分兑换订单数目*/
    public function getPointOrderList_count(){
        $phone = $_SESSION['user_phone'];
        $this->db->where('exchange_state','已支付');
        $bool = $this->db->where('phone', $phone)->from('good_exchange')->get()->result();
        return $bool;
    }

    /*获取积分订单*/
    public function getPoint($data ,$checked){
        $data = $data>0?$data-1:$data;
        $phone = $_SESSION['user_phone'];
        if($checked == 'all'){
            $bool = $this->db->where('phone',$phone)->from('integral_information')->limit(4,$data*4)->order_by('integral_id','DESC')->get()->result();
        }else{
            $array = array('phone' => $phone, 'integral_state' => $checked);
            $bool = $this->db->where($array)->from('integral_information')->limit(4,$data*4)->order_by('integral_id','DESC')->get()->result();
        }
        return $bool;
    }
    /*获取积分订单数目*/
    public function getPoint_count($checked){
        $phone = $_SESSION['user_phone'];
        if($checked == 'all') {
            $bool = $this->db->where('phone', $phone)->from('integral_information')->get()->result();
        }else{
            $array = array('phone' => $phone, 'integral_state' => $checked);
            $bool = $this->db->where($array)->from('integral_information')->get()->result();
        }
        return $bool;
    }

    /*修改余额*/
    public function change_balance($data){
        $phone = $_SESSION['user_phone'];
        $arr = array(
            'balance' => $data
        );
        $bool = $this->db->where('phone',$phone)->update('user',$arr);
        return $bool;
    }
    /*修改商品数量*/
    public function change_good_num($data){
        $phone = $_SESSION['user_phone'];
        $arr = array(
            'good_count' => $data
        );
        $bool = $this->db->where('phone',$phone)->update('user',$arr);
        return $bool;
    }

    /*修改剩余积分信息*/
    public function change_odd_integral($data){
        $phone = $_SESSION['user_phone'];
        $arr = array(
            'odd_integral' => $data
        );
        $bool = $this->db->where('phone',$phone)->update('user',$arr);
        return $bool;
    }

    /*修改总积分信息*/
    public function change_all_integral($data){
        $phone = $_SESSION['user_phone'];
        $arr = array(
            'all_integral' => $data
        );
        $bool = $this->db->where('phone',$phone)->update('user',$arr);
        return $bool;
    }
}

/*判断是否是手机端*/
 function is_mobile()
{
    static $is_mobile;
    if (isset($is_mobile)) return $is_mobile;
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
    ) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }
    return $is_mobile;
}