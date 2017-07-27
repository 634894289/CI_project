<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/6
 * Time: 17:00
 */
class Point_exchange extends CI_Controller{
    public function index(){
        $this->load->view('common/header.html');
        $this->load->view('user/point_exchange.html');
    }
    public function exchage_delete(){
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $exchange_id= $this->input->post('exchange_id');
        $this->load->model('Exchange_model');
        $bool = $this->Exchange_model->deleteOneExchange($exchange_id);
        if($bool){
            $good_count = (int) $_SESSION['good_count'] - 1;
            $this->load->model('Member_info_model');
            $exchange_bool = $this->Member_info_model->change_good_num($good_count);
            if($exchange_bool){
                $_SESSION['good_count'] = $good_count;
                echo 'true';
            }
            else{
                echo 'false';
            }
        }
        else{
            echo 'false';
        }
    }
    public function exchage_delete_all(){
        $this->load->model('Exchange_model');
        $bool = $this->Exchange_model->deleteAllExchange();
        if($bool){
            $this->load->model('Member_info_model');
            $exchange_bool = $this->Member_info_model->change_good_num(0);
            if($exchange_bool){
                $_SESSION['good_count'] = 0;
                echo 'true';
            }
            else{
                echo 'false';
            }
        }else{
            echo 'false';
        }
        echo 'false';
    }
    public function exchage_change(){
        $exchange_id= $this->input->post('exchange_id');
        $good_num= $this->input->post('good_num');
        $this->load->model('Exchange_model');
        $bool = $this->Exchange_model->changeOneExchange($exchange_id,$good_num);
        if($bool){
            echo 'true';
        }
        else{
            echo 'flase';
        }
    }
}