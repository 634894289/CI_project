<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/12
 * Time: 14:32
 */
class Point_order_list extends CI_Controller{
    public function index(){
        $offset = intval($this->uri->segment(3));
        $this->load->model('Member_info_model');
        $data['data'] = $this->Member_info_model-> getPointOrderList($offset);
        $count = $this->Member_info_model-> getPointOrderList_count();
        $config['base_url'] = site_url('point_order_list/index');
        $config['first_url'] = site_url('point_order_list/index/'.'/1');
        $config['total_rows'] = count($count);
        if(is_mobile()){
            $config['per_page'] = 5;
        }
        else{
            $config['per_page'] = 8;
        }
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $this->load->view('common/header.html');
        $this->load->view('user/personal/point_order_list.html',$data);
    }
}