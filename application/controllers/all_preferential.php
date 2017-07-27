<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 21:49
 */
class All_preferential extends CI_Controller{
    public function index(){
        $offset = intval($this->uri->segment(3));
        $this->load->model('Manager_model');
        $data['data'] = $this->Manager_model->getAllPreferential($offset);
        $count = $this->Manager_model-> getAllPreferential_count();
        $config['base_url'] = site_url('all_preferential/index');
        $config['total_rows'] = count($count);
        $config['per_page'] = 7;
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $data['message'] = '';
        $this->load->view('common/manager_header.html');
        $this->load->view('manager/all_preferential.html',$data);
    }
}