<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/17
 * Time: 10:56
 */
class Reset_password extends CI_Controller{
    public function index(){
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('origin_password', 'origin_password', 'trim|required|callback_password_check',
            array('required' => '原始密码不能为空 ')
        );
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|max_length[20]',
            array('required' => '密码不能为空 ',
                'max_length'=>'密码应长度小于21位'
            )
        );
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password1]|max_length[20]',
            array('required' => '确认密码不能为空 ',
                'matches' => '密码不一致',
                'max_length'=>'密码长度应小于21位'
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('common/header.html');
            $this->load->view('user/personal/resetPassword.html');
        }
        else
        {
            $password = trim($this->input->post('password1'));;
            $data = array(
                'phone' =>$_SESSION['user_phone'],
                'user_password' => $password,
            );
            $this->load->model('member_info_model');
            $bool = $this->member_info_model->change_password($data);
            if($bool){
                $this->session->unset_userdata('user_phone');
                $this->session->unset_userdata('nickname');
                $this->session->sess_destroy();
                redirect( site_url('login'));
            }else{
                $this->load->view('common/header.html');
                $this->load->view('user/personal/resetPassword.html');
            }
        }
    }
    public  function password_check($str){
        $this->load->model('Member_info_model');
        $bool = $this->Member_info_model->get_password();
        if ($bool != $str){
            $this->form_validation->set_message('password_check', '原始密码不正确');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}