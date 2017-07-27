<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 21:49
 */
class Change_room extends CI_Controller{
    public function index(){
        $_SESSION["tabs_text"]='';
        $id = intval($this->uri->segment(3));
        $offsert = $this->uri->segment(4);
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('room_id', 'room_id', 'trim|required|max_length[8]',
            array('required' => '房间号不能为空 ',
                'max_length'=>'房间号应长度小于9位'
            )
        );
        $this->form_validation->set_rules('house_price', 'house_price', 'trim|required',
            array('required' => '房间价格不能为空 '
            )
        );
        $this->form_validation->set_rules('room_type', 'room_type', 'trim|required|max_length[6]',
            array('required' => '房间类型不能为空 ',
                'max_length'=>'房间类型应长度小于9位'
            )
        );
        $this->form_validation->set_rules('floor', 'floor', 'trim|required',
            array('required' => '楼层不能为空 ')
        );
        $this->form_validation->set_rules('bed_type', 'bed_type', 'trim|required|max_length[6]',
            array('required' => '床型不能为空 ',
                'max_length'=>'床型应长度小于7位'
            )
        );
        $this->form_validation->set_rules('number', 'number', 'trim|required',
            array('required' => '可居住人数不能为空 '
            )
        );
//        $this->form_validation->set_rules('room_image', 'room_image', 'trim|required',
//            array('required' => '上传照片不能为空 '
//            )
//        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->model('Manager_model');
            $one['data'] = $this->Manager_model->getOneRoom($id);
            $one['message'] = '';
            $one['flag'] = $id;
            $one['offsert'] = $offsert;
            $one['add_bed'] =  $one['data']->add_bed;
            $this->load->view('common/manager_header.html');
            $this->load->view('manager/change_room.html',$one);
        }
        else
        {
            if (!empty($_FILES['room_image']['tmp_name'])){
                $config['upload_path'] = './uploads/add_room/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '1024';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $config['overwrite'] = 'false';
                $config['encrypt_name'] = 'true';
                $config['remove_spaces'] = 'true';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('room_image')) {
                    echo $this->upload->display_errors();
                }else{
                    $this->load->model('Manager_model');
                    $imgPath = $this->Manager_model->getOneRoom($id)->room_image;
                    unlink($imgPath);
                    $data['upload_data']=$this->upload->data();  //文件的一些信息
                    $img=$data['upload_data']['full_path'];  //取得文件路径
                }
            }else{
                $this->load->model('Manager_model');
                $img = $this->Manager_model->getOneRoom($id)->room_image;
            }
            $room_id = trim($this->input->post('room_id'));
            $house_price = trim($this->input->post('house_price'));
            $room_type = trim($this->input->post('room_type'));
            $floor = trim($this->input->post('floor'));
            $bed_type = trim($this->input->post('bed_type'));
            $number = trim($this->input->post('number'));
            $add_bed = trim($this->input->post('add_bed'));
            $checkIn_state = '空';
            $room_image = $img;
            $data = array(
                'room_id' => $room_id,
                'house_price' => $house_price,
                'room_type' => $room_type,
                'floor' => $floor,
                'bed_type' => $bed_type,
                'number' => $number,
                'add_bed' =>$add_bed,
                'checkIn_state' => $checkIn_state,
                'room_image' => $room_image
            );
            $this->load->model('Manager_model');
            $bool = $this->Manager_model->alertAllRoom($data);
            if($bool){
                session_start();
                $_SESSION["tabs_text"]='1';
               redirect(site_url('all_room/index/').$offsert);
            }else{
                $this->load->view('common/manager_header.html');
                $this->load->view('manager/change_room.html',array('message'=>'修改失败','flag' => $id));
            }
        }
    }
    public function changeSeeeion(){
        if(!isset($_SESSION)){session_start();}
        $_SESSION["tabs_text"]='1';
    }
}