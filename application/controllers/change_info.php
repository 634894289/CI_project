<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/17
 * Time: 14:06
 */
class Change_info extends CI_Controller{
    public function index(){
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nickname', 'nickName', 'trim|required|max_length[8]|min_length[2]',
            array('required' => '昵称不能为空 ',
                'max_length'=>'昵称应长度小于十六个字',
                'min_length'=>'昵称长度大于一个字'
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('common/header.html');
            $this->load->view('user/personal/changeInfo.html');
        }
        else
        {
            $nickname = trim($this->input->post('nickname'));;
            $data = array(
                'phone' =>$_SESSION['user_phone'],
                'nickname' => $nickname,
            );
            $this->load->model('member_info_model');
            $bool = $this->member_info_model->changeInfo($data);
            if($bool){
                $this->session->set_userdata(array(
                    'nickname' => $nickname
                ));
                session_write_close();
               redirect(site_url('member_info'));
            }else{
                $this->load->view('common/header.html');
                $this->load->view('user/personal/changeInfo.html');
            }
        }
    }
}