<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/23
 * Time: 13:43
 */
class Manager_change_info extends CI_Controller{
    function all_room_delete(){
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $room_id = $this->input->post('room_id');
        $this->load->model('Manager_model');
        $bool = $this->Manager_model->deleteOneRoom($room_id);
        echo $bool;
    }
    function all_preferential_delete(){
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $preferential_id = $this->input->post('preferential_id');
        $this->load->model('Manager_model');
        $bool = $this->Manager_model->deleteOnePreferential($preferential_id);
        echo $bool;
    }
    function all_exchange_delete(){
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $good_id= $this->input->post('good_id');
        $this->load->model('Manager_model');
        $bool = $this->Manager_model->deleteOneExchange($good_id);
        echo $bool;
    }
    function all_menber_delete(){
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $phone= $this->input->post('phone');
        $this->load->model('Manager_model');
        $bool = $this->Manager_model->deleteOneMenber($phone);
        echo $bool;
    }
}