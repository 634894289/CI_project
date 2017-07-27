<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/17
 * Time: 9:42
 */
class Member_info extends CI_Controller{
    public function index(){
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $data = $_SESSION['user_phone'];
        if($data){
            $this->load->model('Member_info_model');
            $bool = $this->Member_info_model->getData($data);
            $this->load->view('common/header.html');
            $this->load->view('user/personal/memberInfo.html',array('data'=>$bool));
        }
    }
}