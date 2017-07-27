<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/17
 * Time: 9:46
 */
class Handbook extends CI_Controller{
    public function index(){
        $this->load->view('common/header.html');
        $this->load->view('user/personal/handbook.html');
    }
}