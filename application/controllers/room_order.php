<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/3
 * Time: 16:13
 */
class Room_order extends CI_Controller{
    public function index(){
        $room_id = intval($this->uri->segment(3));
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('checkIn_time', 'checkIn_time', 'trim|required',
            array('required' => '入住时间不能为空 '
            )
        );
        $this->form_validation->set_rules('leave_time', 'leave_time', 'trim|required',
            array('required' => '退房时间不能为空 '
            )
        );
        $this->form_validation->set_rules('con_name', 'con_name', 'trim|required|max_length[8]',
            array('required' => '姓名不能为空 ',
                'max_length'=>'姓名应长度小于9个字'
            )
        );
        $this->form_validation->set_rules('con_phone', 'con_phone', 'trim|required|callback_phone_check',
            array('required' => '手机号码不能为空 ')
        );
        $this->form_validation->set_rules('user_card', 'user_card', 'trim|required|callback_ID_card_check',
            array('required' => '身份证号码不能为空 ')
        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->model('Room_service_model');
            $room['data'] = $this->Room_service_model->getOneRoom($room_id);
            $room['message'] = '';
            $room['flag'] = $room_id;
            $this->load->view('common/header.html');
            $this->load->view('user/room_order.html',$room);
        }
        else
        {
            $curr_time = trim($this->input->post('curr_time'));
            $need_money = trim($this->input->post('need_money'));
            $checkIn_time = trim($this->input->post('checkIn_time'));
            $leave_time = trim($this->input->post('leave_time'));
            $con_name = trim($this->input->post('con_name'));
            $con_phone = trim($this->input->post('con_phone'));
            $user_card = trim($this->input->post('user_card'));
            $checkIn_state = '待入住';
            $data = array(
                'phone' => $_SESSION['user_phone'],
                'checkIn_time' =>$checkIn_time,
                'leave_time' =>$leave_time,
                'con_name' =>$con_name,
                'con_phone'=>$con_phone,
                'ID_card'=>$user_card,
                'room_id' => $room_id,
                'order_state' =>$checkIn_state,
                'done_state' =>'未处理',
                'need_money' => $need_money
            );
            $this->load->model('Room_service_model');
            $bool = $this->Room_service_model->changeRoom($room_id);
            if($bool){
                $this->load->model('Add_model');
                $isadd = $this->Add_model->addOrder($data);
                if($isadd){
                    $balance =   $_SESSION['balance'] - $need_money;
                    $_SESSION['balance'] =  $balance;
                    $this->load->model('Member_info_model');
                    $integral_bool = $this->Member_info_model->change_balance($balance);
                    $newBalance = array(
                        'phone' => $_SESSION['user_phone'],
                        'balance_time' =>$curr_time,
                        'balance_explain' =>'订房',
                        'balance_num' =>$need_money,
                        'balance_state' =>'支出'
                    );
                    $this->load->model('Add_model');
                    $balance_bool = $this->Add_model->addBalance($newBalance);
                    if($integral_bool && $balance_bool){
                        $this->load->model('Room_service_model');
                        $change_roon_bool = $this->Room_service_model->changeRoom($room_id);
                        if($change_roon_bool){
                            redirect(site_url('room_service/index'));
                        }
                    }
                }
                else{
                    $this->load->model('Room_service_model');
                    $room['data'] = $this->Room_service_model->getOneRoom($room_id);
                    $room['message'] = '预定失败';
                    $room['flag'] = $room_id;
                    $this->load->view('common/header.html');
                    $this->load->view('user/room_order.html',$room);
                }
            }else{
                $this->load->model('Room_service_model');
                $room['data'] = $this->Room_service_model->getOneRoom($room_id);
                $room['message'] = '预定失败';
                $room['flag'] = $room_id;
                $this->load->view('common/header.html');
                $this->load->view('user/room_order.html',$room);
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

    public  function ID_card_check($str){
        preg_match_all("/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/", $str, $mobiles);
        if ($mobiles[0] == null)
        {
            $this->form_validation->set_message('ID_card_check', '请输入正确的身份证号码');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}