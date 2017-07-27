<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/4
 * Time: 21:12
 */
class Show_preferential extends CI_Controller{
    public function index(){
        $offset = intval($this->uri->segment(3));
        $this->load->model('Show_preferential_model');
        $data['data'] = $this->Show_preferential_model->getAllPreferential($offset);
        $count = $this->Show_preferential_model-> getAllPreferential_count();
        $config['base_url'] = site_url('show_preferential/index');
        $config['total_rows'] = count($count);
        $config['per_page'] = 4;
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $this->load->view('common/header.html');
        $this->load->view('user/show_preferential.html',$data);
    }
}