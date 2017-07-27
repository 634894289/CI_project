<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/17
 * Time: 9:40
 */
class Point extends CI_Controller{
    public function index(){
        $offset = intval($this->uri->segment(4));
        $switch = intval($this->uri->segment(3));
        $this->load->model('Member_info_model');
        if($switch == 1){
            $checked = 'all';
        }elseif ($switch == 2){
            $checked = '支出';
        }elseif ($switch == 3){
            $checked = '收入';
        }
        $data['data'] = $this->Member_info_model-> getPoint($offset,$checked);
        $count = $this->Member_info_model-> getPoint_count($checked);
        $config['base_url'] = site_url('point/index/'.$switch);
        $config['first_url'] = site_url('point/index/'.$switch.'/1');
        $config['total_rows'] = count($count);
        $config['per_page'] = 4;
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $this->load->view('common/header.html');
        $this->load->view('user/personal/point.html',$data);
    }
}