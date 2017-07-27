<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/12
 * Time: 14:32
 */
class Order_list extends CI_Controller{
    public function index(){
        $offset = intval($this->uri->segment(4));
        $switch = intval($this->uri->segment(3));
        $this->load->model('Member_info_model');
        if($switch == 1){
            $checked = 'all';
        }elseif ($switch == 2){
            $checked = '已入住';
        }
        elseif ($switch == 3){
            $checked = '待入住';
        }

        $data['data'] = $this->Member_info_model-> getOrderList($offset,$checked);
        $count = $this->Member_info_model-> getOrderList_count($checked);
        $config['base_url'] = site_url('order_list/index/'.$switch);
        $config['first_url'] = site_url('order_list/index/'.$switch.'/1');
        $config['total_rows'] = count($count);
        if(is_mobile()){
            $config['per_page'] = 2;
        }
        else{
            $config['per_page'] = 8;
        }
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $this->load->view('common/header.html');
        $this->load->view('user/personal/orderList.html',$data);
    }

}