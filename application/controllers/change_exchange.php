<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 21:49
 */
class Change_exchange extends CI_Controller{
    public function index(){
        $_SESSION["exchange_text"]='';
        $id = intval($this->uri->segment(3));
        $offsert = $this->uri->segment(4);
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
            $this->load->model('Manager_model');
            $one['data'] = $this->Manager_model->getOneExchange($id);
            $one['message'] = '';
            $one['flag'] = $id;
            $one['offsert'] = $offsert;
            $this->load->view('common/manager_header.html');
            $this->load->view('manager/change_exchange.html',$one);
        }
        else
        {
            if (!empty($_FILES['activity_image']['tmp_name'])){
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
                    $this->load->model('Manager_model');
                    $imgPath = $this->Manager_model->getOneExchange($id)->goods_image;
                    unlink($imgPath);
                    $data['upload_data']=$this->upload->data();  //文件的一些信息
                    $img=$data['upload_data']['full_name'];  //取得文件名
                }
            }else{
                $this->load->model('Manager_model');
                $img = $this->Manager_model->getOneExchange($id)->goods_image;
            }
            $good_name = trim($this->input->post('good_name'));
            $good_introduce = trim($this->input->post('good_introduce'));
            $need_integral = trim($this->input->post('need_integral'));
            $rest_count = trim($this->input->post('rest_count'));
            $goods_image = $img;
            $data = array(
                'good_id'=>$id,
                'good_name' => $good_name,
                'good_introduce' => $good_introduce,
                'need_integral' => $need_integral,
                'rest_count' => $rest_count,
                'goods_image' => $goods_image
            );
            $this->load->model('Manager_model');
            $bool = $this->Manager_model->alertAllExchange($data);
            if($bool){
                session_start();
                $_SESSION["exchange_text"]='1';
                redirect(site_url('all_exchange/index/').$offsert);
            }else{
                $this->load->view('common/manager_header.html');
                $this->load->view('manager/change_exchange.html',array('message'=>'修改失败','flag' => $id));
            }
        }
    }
    public function changeExchange_text(){
        if(!isset($_SESSION)){session_start();}
        $_SESSION["preferential_text"]='1';
    }
}