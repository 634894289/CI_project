<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/18
 * Time: 13:15
 */
class Contact_us extends CI_Controller{
    public function index(){
        $this->load->view('common/header.html');
        $this->load->view('user/contact_us.html');
    }
}