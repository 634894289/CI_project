<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/15
 * Time: 9:18
 */
class Recharge extends CI_Controller{
    public function index(){
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('money', 'money', 'trim|required',
            array('required' => '充值金额不能为空 ')
        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('common/header.html');
            $this->load->view('user/recharge.html',array('message'=>''));
        }
        else {
            $money = trim($this->input->post('money'));
            $phone = $_SESSION['user_phone'];
            $curr_time = trim($this->input->post('curr_time'));
            $this->load->model('Add_model');
            $data = array(
                'phone' =>$phone,
                'balance_time'=>$curr_time,
                'balance_explain' => '充值',
                'balance_num' => $money,
                'balance_state' =>  '收入'
            );
            $first_bool = $this->Add_model->addBalance($data);
            if($first_bool){
                $all_balance  = (int)$_SESSION['balance'] + (int)$money;
                $this->load->model('Member_info_model');
                $balance_bool = $this->Member_info_model->change_balance($all_balance);
                if( $balance_bool){
                    $_SESSION['balance'] = $all_balance;
                    $newBalance = array(
                        'phone' => $phone,
                        'integral_time' =>$curr_time,
                        'integral_explain' =>'金额充值',
                        'integral_num' =>(int)$money * 10,
                        'integral_state' =>'收入'
                    );
                    $this->load->model('Add_model');
                    $integral_bool = $this->Add_model->add_integral_Order($newBalance);
                    if($integral_bool){
                        $this->load->model('Exits');
                        $integral = $this->Exits->all_integral($phone);
                        $all_integral  = (int)$integral + (int)$money *10;
                        $all_integral_bool = $this->Member_info_model->change_all_integral($all_integral);
                       if($all_integral_bool){
                           $odd_integral = (int)$_SESSION['odd_integral'] + (int)$money *10;
                           $odd_integral_bool = $this->Member_info_model->change_odd_integral($odd_integral);
                           if($odd_integral_bool){
                               $_SESSION['odd_integral'] = $odd_integral;
                               $this->load->view('common/header.html');
                               $this->load->view('user/recharge.html',array('message'=>'success'));
                           }
                       }
                       else{
                           $this->load->view('common/header.html');
                           $this->load->view('user/recharge.html',array('message'=>'false'));
                       }
                    }
                    else{
                        $this->load->view('common/header.html');
                        $this->load->view('user/recharge.html',array('message'=>'false'));
                    }
                }
                else{
                    $this->load->view('common/header.html');
                    $this->load->view('user/recharge.html',array('message'=>'false'));
                }
            }else{
                $this->load->view('common/header.html');
                $this->load->view('user/recharge.html',array('message'=>'false'));
            }
        }
    }
}