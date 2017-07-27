<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/10
 * Time: 18:53
 */
class Home extends CI_Controller{
    public function index(){
        $this->load->model('Home_model');
        $data['preferential'] = $this->Home_model->getPreferential();
        $data['good'] = $this->Home_model->getGood();
        $this->load->view('common/header.html');
        $this->load->view('user/home.html',$data);
    }
}