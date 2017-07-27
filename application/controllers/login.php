<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/11
 * Time: 11:51
 */
class  Login extends CI_Controller{
    public function index(){
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login_phone', 'Phone', 'trim|required|callback_phone_check',
            array('required' => '手机号码不能为空 ')
        );
        $this->form_validation->set_rules('login_password', 'Password', 'trim|required|max_length[20]',
            array('required' => '密码不能为空 ',
                'max_length'=>'密码应长度小于21位'
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $data['err_mess'] = "0";
            $this->load->view('common/header.html');
            $this->load->view('user/login.html',$data);
        }
        else
        {
            $phone = trim($this->input->post('login_phone'));
            $password = trim($this->input->post('login_password'));
            $this->load->model('Login_model');
            $bool = $this->Login_model->check_password($phone);
            if($bool->user_password == $password){
                $this->session->set_userdata(array(
                    'user_phone' => $phone,
                    'nickname' => $bool->nickname,
                    'odd_integral'=>$bool->odd_integral,
                    'balance'=>$bool->balance,
                    'good_count' =>$bool->good_count
                ));
                session_write_close();
                redirect(site_url('home'));
            }else{
                $data['err_mess'] = "1";
                $this->load->view('common/header.html');
                $this->load->view('user/login.html',$data);
            }
        }
    }

    public  function phone_check($str){
        preg_match_all("/^1[34578]\d{9}$/", $str, $mobiles);
        $this->load->model('Register_model');
        $bool = $this->Register_model->login_exits($str);
        if ($mobiles[0] == null)
        {
            $this->form_validation->set_message('phone_check', '请输入正确的手机号码');
            return FALSE;
        }
        elseif (!$bool){
            $this->form_validation->set_message('phone_check', '该手机号码没注册');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function lg_out(){
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $this->session->unset_userdata('user_phone');
        $this->session->unset_userdata('nickname');
        $this->session->unset_userdata('odd_integral');
        $this->session->unset_userdata('balance');
        $this->session->sess_destroy();
        echo "success";
    }
}