<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/5/5
 * Time: 9:33
 */
class Preferential_content extends CI_Controller{
    public function index(){
        $id = intval($this->uri->segment(3));
        $this->load->model('Show_preferential_model');
        $room['value'] = $this->Show_preferential_model->getOnePreferential($id);
        $this->load->view('common/header.html');
        $this->load->view('user/preferential_content.html',$room);
    }
}