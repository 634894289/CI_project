<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/5
 * Time: 15:04
 */
class Show_good extends CI_Controller{
    public function index(){
        $id = intval($this->uri->segment(3));
        $this->load->model('Point_shopping_model');
        $room['value'] = $this->Point_shopping_model->getOneGood($id);
        $this->load->view('common/header.html');
        $this->load->view('user/show_good.html',$room);
    }
    public function add_exchange(){
        $good_id = trim($this->input->post('good_id'));
        $good_num = trim($this->input->post('good_num'));
        $phone  = $_SESSION['user_phone'];
        $exchange_state = '待支付';
        $data = array(
            'phone' => $phone,
            'good_id' => $good_id,
            'good_num' => $good_num,
            'con_phone'=>'空',
            'address'=> '空',
            'exchange_state' =>$exchange_state,
            'done_state' =>'未处理'
        );
        $this->load->model('Add_model');
        $bool = $this->Add_model->add_good_exchange($data);
        if($bool){
            $good_count = (int) $_SESSION['good_count'] + 1;
            $this->load->model('Member_info_model');
            $exchange_bool = $this->Member_info_model->change_good_num($good_count);
           if($exchange_bool){
               $_SESSION['good_count'] = $good_count;
               echo $good_count;
           }
           else{
               echo 'false';
           }
        }
        else{
            echo 'false';
        }
    }
}