<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/12
 * Time: 13:43
 */
class Room_service extends CI_Controller{
    public function index(){
//        if(!isset($_SESSION)){
//            session_start();
//        }
//        $_SESSION['peice'] = 1;
//        $_SESSION['room_type'] = 1;
        $this->load->view('common/header.html');
        $this->load->view('user/room_service.html');
    }
}