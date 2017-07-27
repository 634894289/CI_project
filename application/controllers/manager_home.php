<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/20
 * Time: 16:44
 */
class Manager_home extends CI_Controller{
    public function index(){
        $this->load->view('common/manager_header.html');
        $this->load->view('manager/home.html');
    }
}