<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/4/25
 * Time: 23:20
 */
class Room_service_model extends CI_Model{
    public function getAllRoom($data,$price,$room_type){
        $data = $data>0?$data-1:$data;
        $this->db->select('*');
        $this->db->from('room_reservation');

        if($price != '1'){
            if($price == '2'){
                $this->db->where('house_price <','150');
            }elseif ($price == '3'){
                $this->db->where('house_price >=','150');
                $this->db->where('house_price <','300');
            }elseif ($price == '4'){
                $this->db->where('house_price >=','300');
                $this->db->where('house_price <','400');
            }elseif ($price == '5'){
                $this->db->where('house_price >=','400');
            }
        }
        if ( $room_type != "1"){
            if($room_type == '2'){
                $this->db->where('room_type','经济型');
            }elseif ($room_type == '3'){
                $this->db->where('room_type','舒适型');
            }elseif ($room_type == '4'){
                $this->db->where('room_type','高档型');
            }elseif ($room_type == '5'){
                $this->db->where('room_type','豪华型');
            }
        }
        $this->db->where('checkIn_state','空');
        $bool = $this->db->limit(6,$data*6)->get()->result();
        return $bool;
    }
    public function getAllRoom_count($price,$room_type){
        if($price != '1'){
            if($price == '2'){
                $this->db->where('house_price <','150');
            }elseif ($price == '3'){
                $this->db->where('house_price >=','150');
                $this->db->where('house_price <','300');
            }elseif ($price == '4'){
                $this->db->where('house_price >=','300');
                $this->db->where('house_price <','400');
            }elseif ($price == '5'){
                $this->db->where('house_price >=','400');
            }
        }
        if ( $room_type != "1"){
            if($room_type == '2'){
                $this->db->where('room_type','经济型');
            }elseif ($room_type == '3'){
                $this->db->where('room_type','舒适型');
            }elseif ($room_type == '4'){
                $this->db->where('room_type','高档型');
            }elseif ($room_type == '5'){
                $this->db->where('room_type','豪华型');
            }
        }
        $this->db->where('checkIn_state','空');
        $bool = $this->db->select('*')->from('room_reservation')->get()->result();
        return $bool;
    }
    public function getOneRoom($room_id){
        $bool = $this->db->where('room_id',$room_id)->from('room_reservation')->get()->row();
        return $bool;
    }
    public function changeRoom($room_id){
        $arr = array(
            'checkIn_state' => '待入住'
        );
        $bool = $this->db->where('room_id',$room_id)->update('room_reservation',$arr);
        return $bool;
    }
}