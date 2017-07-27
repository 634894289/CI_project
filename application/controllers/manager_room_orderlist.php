<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 13:20
 */
class Manager_room_orderlist extends CI_Controller{
    public function index(){
        $offset = intval($this->uri->segment(4));
        $switch = intval($this->uri->segment(3));
        if($switch == 1 || $switch == 0){
            $checked = 'all';
        }elseif ($switch == 2){
            $checked = '已处理';
        }
        elseif ($switch == 3){
            $checked = '未处理';
        }
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('order_id', 'order_id', 'trim|required',
            array('required' => '订单号不能为空 ',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->model('Manager_model');
            $data['data'] = $this->Manager_model->getRoomOrder($offset,$checked);
            $data['flag'] = $switch;
            $count = $this->Manager_model-> getRoomOrder_count($checked);
            $config['base_url'] = site_url('manager_room_orderlist/index/'.$switch);
            $config['first_url'] = site_url('manager_room_orderlist/index/'.$switch.'/1');
            $config['total_rows'] = count($count);
            $config['per_page'] = 8;
            $this->pagination->initialize($config);
            $data['link'] = $this->pagination->create_links();
            $this->load->view('common/manager_header.html');
            $this->load->view('manager/room_orderList.html',$data);
        }
        else
        {
            $order_id = trim($this->input->post('order_id'));
            $this->load->model('Exits');
            $bool = $this->Exits->getRoomOrder($order_id);
            if($bool){
                $this->load->view('common/manager_header.html');
                $this->load->view('manager/room_orderList.html',array('data'=>$bool,'link'=>'','flag'=>$switch));
            }else{
                $this->load->view('common/manager_header.html');
                $this->load->view('manager/room_orderList.html',array('data'=>$bool,'link'=>'','flag'=>$switch));
            }
        }
    }
    public function change_order_done(){
        $order_id = trim($this->input->post('order_id'));
        $this->load->model('Manager_model');
        $bool = $this->Manager_model->changeOrderDone($order_id);
        if($bool){
            echo 'success';
        }
        else{
            echo 'false';
        }
    }

    public function change_order_state(){
        $order_id = trim($this->input->post('order_id'));
        $this->load->model('Manager_model');
        $bool = $this->Manager_model->changeOrderState($order_id);
        if($bool){
            echo 'success';
        }
        else{
            echo 'false';
        }
    }

    public function change_order_state_one(){
        $order_id = trim($this->input->post('order_id'));
        $room_id = trim($this->input->post('room_id'));
        $this->load->model('Manager_model');
        $bool = $this->Manager_model->changeOrderStateOne($order_id);
        if($bool){
            $change_room_bool = $this->Manager_model->changeRoom($room_id);
            if($change_room_bool){
                echo 'success';
            }
            else{
                echo 'false';
            }
        }
        else{
            echo 'false';
        }
    }

    public function delete_one_orde(){
        $order_id = trim($this->input->post('order_id'));
        $need_money = trim($this->input->post('need_money'));
        $phone = trim($this->input->post('phone'));
        $curr_time = trim($this->input->post('curr_time'));
        $room_id = trim($this->input->post('room_id'));
        $this->load->model('Manager_model');
        $bool = $this->Manager_model->deleteOneOrder($order_id);
        if($bool){
            $balance = $this->Manager_model->getUserBalance($phone)->balance;
            $all_balance = (int)$balance + (int)$need_money;
            $change_bool = $this->Manager_model->change_balance($phone,$all_balance);
            if($change_bool){
                $newBalance = array(
                    'phone' => $phone,
                    'balance_time' =>$curr_time,
                    'balance_explain' =>'退房',
                    'balance_num' =>$need_money,
                    'balance_state' =>'收入'
                );
                $this->load->model('Add_model');
                $balance_bool = $this->Add_model->addBalance($newBalance);
                if($balance_bool){
                    $change_room_bool = $this->Manager_model->changeRoom($room_id);
                    if($change_room_bool){
                        echo 'success';
                    }
                    else{
                        echo 'false';
                    }
                }
                else{
                    echo 'false';
                }
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