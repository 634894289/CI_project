<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/7
 * Time: 11:25
 */
class Exchange_order extends CI_Controller{
    public function index(){
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|callback_phone_check',
            array('required' => '手机号码不能为空 ')
        );
        $this->form_validation->set_rules('con_address', 'con_address', 'trim|required',
            array('required' => '地址不能为空 ',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('common/user_header.html');
            $this->load->view('user/exchange_order.html',array('message'=>''));
        }
        else {
            $phone = trim($this->input->post('phone'));
            $con_address = trim($this->input->post('con_address'));
            $finish_need = trim($this->input->post('finish_need'));
            $curr_time = trim($this->input->post('curr_time'));
            $integral_num = (int)$_SESSION['odd_integral'] - (int)$finish_need;
            $this->load->model('Exchange_model');
            $bool = $this->Exchange_model->changeAllExchange($phone,$con_address,$curr_time,$integral_num);
            if($bool){
                $this->load->model('Member_info_model');
                $odd_integral_bool = $this->Member_info_model->change_odd_integral($finish_need);
                if( $odd_integral_bool){
                    $newBalance = array(
                        'phone' => $_SESSION['user_phone'],
                        'integral_time' =>$curr_time,
                        'integral_explain' =>'兑换商品',
                        'integral_num' =>$integral_num,
                        'integral_state' =>'支出'
                    );
                    $this->load->model('Add_model');
                    $balance_bool = $this->Add_model->add_integral_Order($newBalance);
                   if($balance_bool){
                       $_SESSION['odd_integral'] = $finish_need;
                       $good_num_bool = $this->Member_info_model->change_good_num(0);
                       if($good_num_bool){
                           $_SESSION['good_count'] = 0;
                           $this->load->view('common/user_header.html');
                           $this->load->view('user/submit_success.html',array('message'=>'false'));
                       }
                   }
                }
            }else{
                $this->load->view('common/user_header.html');
                $this->load->view('user/exchange_order.html',array('message'=>'false'));
            }
        }
    }
    public  function phone_check($str){
        preg_match_all("/^1[34578]\d{9}$/", $str, $mobiles);
        if ($mobiles[0] == null)
        {
            $this->form_validation->set_message('phone_check', '请输入正确的手机号码');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}