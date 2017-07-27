/**
 * Created by hp on 2017/5/8.
 */
/*房间订单处理状态点击事件*/
$(function () {
    var currDate = new Date();
    var currMonth = (currDate.getMonth() + 1)<10?'0'+ (currDate.getMonth() + 1):(currDate.getMonth() + 1);
    var currData = currDate.getDate()<10?'0'+ currDate.getDate(): currDate.getDate();
    var newData = currDate.getFullYear() + '-' + currMonth + '-' + currData;
   $('#curr_time').val(newData);

});
/*房间订单处理点击事件*/
function orderDoneBtn(id) {
    var $url = "http://[::1]/CI/manager_room_orderlist/change_order_done";
    var $data  = {order_id:id};
    request($url,$data);
}
/*房间入住状态点击事件*/
function orderStateBtn(id,state,room_id) {
    if(state == '待入住'){
        var $url = "http://[::1]/CI/manager_room_orderlist/change_order_state";
        var $data  = {order_id:id};
    }
    else {
        var $url = "http://[::1]/CI/manager_room_orderlist/change_order_state_one";
        var $data  = {order_id:id,room_id:room_id};
    }
    request($url,$data);
}

/*房间订单退订点击事件*/
function orderDeleteBtn(id,money,phone,room_id) {
    var $url = "http://[::1]/CI/manager_room_orderlist/delete_one_orde";
    var current = $('#curr_time').val();
    var $data  = {order_id:id,need_money:money,phone:phone,room_id:room_id,curr_time:current};
    request($url,$data);
}

/*积分订单处理点击事件*/
function pointOrderDoneBtn(id) {
    var $url = "http://[::1]/CI/manager_point_orderlist/change_order_done";
    var $data  = {exchange_id:id};
    request($url,$data);
}

function request($url,$data) {
    $.ajax({
        type:"post",
        url:$url,
        dataType:"text",
        data:$data,
        success:function(data){
            if(data == 'false'){
                alert('出错');
                return false;
            }
            window.location.reload();
            return true;
        },
        error:function(err){
            alert('Failed');
            return false;
        }
    });
}

$('.js_orderList_one').click(function () {
    location.href = ' http://[::1]/CI/manager_room_orderlist/index/1/1';
});
$('.js_orderList_two').click(function () {
    location.href = ' http://[::1]/CI/manager_room_orderlist/index/2/1';
});
$('.js_orderList_three').click(function () {
    location.href = ' http://[::1]/CI/manager_room_orderlist/index/3/1';
});

$('.js_point_orderList_one').click(function () {
    location.href = ' http://[::1]/CI/manager_point_orderlist/index/1/1';
});
$('.js_point_orderList_two').click(function () {
    location.href = ' http://[::1]/CI/manager_point_orderlist/index/2/1';
});
$('.js_point_orderList_three').click(function () {
    location.href = ' http://[::1]/CI/manager_point_orderlist/index/3/1';
});