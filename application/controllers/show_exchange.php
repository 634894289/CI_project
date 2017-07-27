<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/6
 * Time: 16:27
 */
class Show_exchange extends CI_Controller{
    public function index(){
        $this->load->model('Exchange_model');
        $data['data'] = $this->Exchange_model-> getAllExchange_count();
        $this->load->view('common/user_header.html');
        $this->load->view('user/show_exchange.html',$data);
    }
}