<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/11
 * Time: 11:44
 */
class  Register extends CI_Controller{
    public function index(){
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|callback_phone_check',
            array('required' => '手机号码不能为空 ')
        );
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[8]',
            array('required' => '姓名不能为空 ',
                    'max_length'=>'姓名应长度小于9个字'
            )
        );
        $this->form_validation->set_rules('sex', 'Sex', 'trim|required|callback_sex_check',
            array('required' => '性别不能为空 ')
        );
        $this->form_validation->set_rules('ID_card', 'ID_card', 'trim|required|callback_ID_card_check',
            array('required' => '身份证号码不能为空 ')
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
            $this->load->view('user/register.html');
        }
        else
        {
            $phone = trim($this->input->post('phone'));
            $name = trim($this->input->post('name'));
            $sex = trim($this->input->post('sex'));
            $ID_card = trim($this->input->post('ID_card'));
            $password = trim($this->input->post('password1'));
            $nickname = "自定义昵称";
            $all_integral = 50;
            $balance = 0;
            $good_count = '0';
            $odd_integral = 50;
            $data = array(
                'phone' => $phone,
                'nickname' => $nickname,
                'user_name' => $name,
                'sex' => $sex,
                'ID_card' => $ID_card,
                'user_password' => $password,
                'all_integral' =>$all_integral,
                'odd_integral' => $odd_integral,
                'balance' => $balance,
                'good_count' => $good_count
            );
            $this->load->model('Register_model');
            $bool = $this->Register_model->insert($data);
            if($bool){
                $this->session->set_userdata(array(
                    'user_phone' => $phone,
                    'nickname' => $nickname,
                    'odd_integral'=>$odd_integral,
                    'balance'=>$balance,
                    'good_count' =>$good_count
                ));
                session_write_close();
                redirect('home');
            }else{
                $this->load->view('common/header.html');
                $this->load->view('user/register.html');
            }
        }
    }
    public  function phone_check($str){
        preg_match_all("/^1[34578]\d{9}$/", $str, $mobiles);
        $this->load->model('Register_model');
        $bool = $this->Register_model->exits($str);
        if ($mobiles[0] == null)
        {
            $this->form_validation->set_message('phone_check', '请输入正确的手机号码');
            return FALSE;
        }
        elseif ($bool){
            $this->form_validation->set_message('phone_check', '该手机号码已注册');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    public  function sex_check($str){
        if ($str != '男'&& $str != '女')
        {
            $this->form_validation->set_message('sex_check', '请输入正确的性别');
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