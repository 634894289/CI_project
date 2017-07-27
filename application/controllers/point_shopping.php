<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/5
 * Time: 14:00
 */
class Point_shopping extends CI_Controller{
    public function index(){
        $offset = intval($this->uri->segment(3));
        $this->load->model('Point_shopping_model');
        $data['data'] = $this->Point_shopping_model->getAllGood($offset);
        $count = $this->Point_shopping_model-> getAllGood_count();
        $config['base_url'] = site_url('point_shopping/index');
        $config['total_rows'] = count($count);
        $config['per_page'] = 9;
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $this->load->view('common/header.html',$data);
        $this->load->view('user/point_shopping.html',$data);
    }
}