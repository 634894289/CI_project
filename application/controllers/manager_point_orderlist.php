<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 13:20
 */
class Manager_point_orderlist extends CI_Controller{
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
        $this->form_validation->set_rules('exchange_id', 'exchange_id', 'trim|required',
            array('required' => '订单号不能为空 ',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->model('Manager_model');
            $data['data'] = $this->Manager_model->getPointOrder($offset,$checked);
            $data['flag'] = $switch;
            $count = $this->Manager_model-> getPointOrder_count($checked);
            $config['base_url'] = site_url('manager_point_orderlist/index/'.$switch);
            $config['first_url'] = site_url('manager_point_orderlist/index/'.$switch.'/1');
            $config['total_rows'] = count($count);
            $config['per_page'] = 8;
            $this->pagination->initialize($config);
            $data['link'] = $this->pagination->create_links();
            $this->load->view('common/manager_header.html');
            $this->load->view('manager/point_orderList.html',$data);
        }
        else
        {
            $exchange_id = trim($this->input->post('exchange_id'));
            $this->load->model('Exits');
            $bool = $this->Exits->getExchangeOrder($exchange_id);
            if($bool){
                $this->load->view('common/manager_header.html');
                $this->load->view('manager/point_orderList.html',array('data'=>$bool,'link'=>'','flag'=>$switch));
            }else{
                $this->load->view('common/manager_header.html');
                $this->load->view('manager/point_orderList.html',array('data'=>$bool,'link'=>'','flag'=>$switch));
            }
        }
    }
    public function change_order_done(){
        $exchange_id = trim($this->input->post('exchange_id'));
        $this->load->model('Manager_model');
        $bool = $this->Manager_model->changePointOrderDone($exchange_id);
        if($bool){
            echo 'success';
        }
        else{
            echo 'false';
        }
    }
}