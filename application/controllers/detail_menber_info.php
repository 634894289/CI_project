<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/22
 * Time: 21:49
 */
class Detail_menber_info extends CI_Controller{
    public function index(){
        $_SESSION["tabs_text"]='';
        $id = $this->uri->segment(3);
        $offsert = $this->uri->segment(4);
        $this->load->model('Manager_model');
        $one['data'] = $this->Manager_model->getOneMenber($id);
        $one['flag'] = $id;
        $one['offsert'] = $offsert;
        $this->load->view('common/manager_header.html');
        $this->load->view('manager/detail_menber_info.html',$one);
    }
    public function changeSeeeion(){
        if(!isset($_SESSION)){session_start();}
        $_SESSION["menber_text"]='1';
    }
}