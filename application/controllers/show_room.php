<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/2
 * Time: 17:11
 */
class Show_room extends CI_Controller{
    public function index(){
//        if($this->input->post('price')){
//            if(!isset($_SESSION)){
//                session_start();
//            }
//            $_SESSION['peice'] = $this->input->post('price');
//            $_SESSION['room_type'] = $this->input->post('room_type');
//        }
        $peice= intval($this->uri->segment(3));
        $room_type= $this->uri->segment(4);
        $offset = intval($this->uri->segment(5));
        $this->load->model('Room_service_model');
        $data['data'] = $this->Room_service_model->getAllRoom($offset,$peice, $room_type);
        $count = $this->Room_service_model-> getAllRoom_count($peice,$room_type);
        $config['base_url'] = site_url('show_room/index/'.$peice.'/'.$room_type.'/');
        $config['first_url'] = site_url('show_room/index/'.$peice.'/'.$room_type.'/1');
        $config['total_rows'] = count($count);
        $config['per_page'] = 6;
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $this->load->view('user/show_room.html',$data);
    }
}