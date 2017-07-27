<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 21:49
 */
class Add_preferential extends CI_Controller{
    public function index(){
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('activity_name', 'activity_name', 'trim|required',
            array('required' => '活动名称不能为空 '
            )
        );
        $this->form_validation->set_rules('activity_message', 'activity_message', 'trim|required',
            array('required' => '活动内容不能为空 '
            )
        );
        $this->form_validation->set_rules('activity_start', 'activity_start', 'trim|required',
            array('required' => '活动开始时间不能为空 ',
            )
        );
        $this->form_validation->set_rules('activity_end', 'activity_end', 'trim|required',
            array('required' => '活动结束时间不能为空 ')
        );
//        $this->form_validation->set_rules('room_image', 'room_image', 'trim|required',
//            array('required' => '上传照片不能为空 '
//            )
//        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('common/manager_header.html');
            $this->load->view('manager/add_preferential.html',array('message'=>''));
        }
        else
        {
            $config['upload_path'] = './uploads/add_preferential/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '1024';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['overwrite'] = 'false';
            $config['encrypt_name'] = 'true';
            $config['remove_spaces'] = 'true';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('activity_image')) {
                echo $this->upload->display_errors();
            }else{
                $data['upload_data']=$this->upload->data();  //文件的一些信息
                $img=$data['upload_data']['full_path'];  //取得文件名
                $activity_name = trim($this->input->post('activity_name'));
                $activity_message = trim($this->input->post('activity_message'));
                $activity_start = trim($this->input->post('activity_start'));
                $activity_end = trim($this->input->post('activity_end'));
                $activity_image = $img;
                $data = array(
                    'activity_name' => $activity_name,
                    'activity_message' => $activity_message,
                    'activity_start' => $activity_start,
                    'activity_end' => $activity_end,
                    'activity_image' => $activity_image
                );
                $this->load->model('Add_model');
                $bool = $this->Add_model->add_preferential($data);
                if($bool){
                    $this->load->view('common/manager_header.html');
                    $this->load->view('manager/add_preferential.html',array('message'=>'添加成功'));
                }else{
                    $this->load->view('common/manager_header.html');
                    $this->load->view('manager/add_preferential.html',array('message'=>'添加失败'));
                }
            }

        }
    }
}