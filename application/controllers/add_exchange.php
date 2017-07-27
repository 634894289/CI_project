<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 21:49
 */
class Add_exchange extends CI_Controller{
    public function index(){
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('good_name', 'good_name', 'trim|required',
            array('required' => '商品名称不能为空 '
            )
        );
        $this->form_validation->set_rules('good_introduce', 'good_introduce', 'trim|required',
            array('required' => '商品介绍不能为空 '
            )
        );
        $this->form_validation->set_rules('need_integral', 'need_integral', 'trim|required',
            array('required' => '所需积分不能为空 ',
            )
        );
        $this->form_validation->set_rules('rest_count', 'rest_count', 'trim|required',
            array('required' => '商品数量不能为空 ')
        );
//        $this->form_validation->set_rules('room_image', 'room_image', 'trim|required',
//            array('required' => '上传照片不能为空 '
//            )
//        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('common/manager_header.html');
            $this->load->view('manager/add_exchange.html',array('message'=>''));
        }
        else
        {
            $config['upload_path'] = './uploads/add_exchange/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '1024';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['overwrite'] = 'false';
            $config['encrypt_name'] = 'true';
            $config['remove_spaces'] = 'true';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('goods_image')) {
                echo $this->upload->display_errors();
            }else{
                $data['upload_data']=$this->upload->data();  //文件的一些信息
                $img=$data['upload_data']['full_path'];  //取得文件名
                $good_name = trim($this->input->post('good_name'));
                $good_introduce = trim($this->input->post('good_introduce'));
                $need_integral = trim($this->input->post('need_integral'));
                $rest_count = trim($this->input->post('rest_count'));
                $goods_image = $img;
                $data = array(
                    'good_name' => $good_name,
                    'good_introduce' => $good_introduce,
                    'need_integral' => $need_integral,
                    'rest_count' => $rest_count,
                    'goods_image' => $goods_image
                );
                $this->load->model('Add_model');
                $bool = $this->Add_model->add_exchange($data);
                if($bool){
                    $this->load->view('common/manager_header.html');
                    $this->load->view('manager/add_exchange.html',array('message'=>'添加成功'));
                }else{
                    $this->load->view('common/manager_header.html');
                    $this->load->view('manager/add_exchange.html',array('message'=>'添加失败'));
                }
            }

        }
    }
}