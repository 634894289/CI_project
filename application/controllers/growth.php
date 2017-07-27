<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/17
 * Time: 9:44
 */
class Growth extends CI_Controller{
    public function index(){
        $this->load->view('common/header.html');
        $this->load->view('user/personal/growth.html');
    }
}