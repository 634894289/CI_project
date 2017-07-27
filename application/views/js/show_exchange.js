/**
 * Created by hp on 2017/5/7.
 */
var flag =-1;
$(function () {
    var elemt = $('.exchange_table').find("input[class = 'need_integral']");
    var odd_integral = parseInt($('.odd_integral').text());
    var need_integral = 0;
    for(var i=0; i<elemt.length;i++){
        need_integral += parseInt($(elemt[i]).val());
    }
    var rest_integral = odd_integral-need_integral;
    $('.rest_integral').html(rest_integral);
    $('.need_all_integral').html(need_integral);

    /*监听积分是否足够*/
    var title = $("b.facility");
    var title = $('.rest_integral');//the element I want to monitor
    if(parseInt(title.text()) >= 0) {
        $('.js_settle_btn').attr('disabled',false);
        $('.js_wanning').css('display','none');
    }
    else {
        $('.js_settle_btn').attr('disabled',true);
        $('.js_wanning').css('display','block');
    }
    title.bind('DOMNodeInserted', function(e) {
        if(parseInt(title.text()) >= 0) {
           $('.js_settle_btn').attr('disabled',false);
            $('.js_wanning').css('display','none');
        }
        else {
            $('.js_settle_btn').attr('disabled',true);
            $('.js_wanning').css('display','block');
        }
    });
});
/*购物车点击减少按钮事件*/
function exchange_count_reduce(evn,price) {
    var isSuccess = true;
    var count = parseInt($('#'+evn).val());
    if(flag == -1){
        flag = evn;
    }
    if(count>0){
        count  -= 1;
    }
    if(flag != evn){
        isSuccess = change();
        flag = evn;
    }
    if(isSuccess && count>0){
        var need_integral = parseInt($('.need_all_integral').text()) - parseInt(price);
        var odd_integral = parseInt($('.odd_integral').text());
        var rest_integral = odd_integral-need_integral;
        $('.rest_integral').html(rest_integral);
        $('.need_all_integral').html(need_integral);
        $('#'+evn).val(count);
    }

}

/*购物车点击增加按钮事件*/
function exchange_count_increase(evn,price) {
    var isSuccess = true;
    var count = parseInt($('#'+evn).val());
    var allCount = parseInt($('.show_exchange'+evn).text()) + 1;
    if(flag == -1){
        flag = evn;
    }
    if(count<allCount){
        count  += 1;
    }
    if(flag != evn){
        isSuccess = change();
        flag = evn;
    }
    if(isSuccess && count<allCount){
        var need_integral = parseInt($('.need_all_integral').text()) + parseInt(price);
        var odd_integral = parseInt($('.odd_integral').text());
        var rest_integral = odd_integral-need_integral;
        $('.rest_integral').html(rest_integral);
        $('.need_all_integral').html(need_integral);
        $('#'+evn).val(count);
    }

}
/*删除购物车按钮按钮点击事件*/
function exchageDeleteBtn(data) {
    var result = confirm('您确认删除此消息');
    if(result){
        var $url = "http://[::1]/CI/point_exchange/exchage_delete";
        $.ajax({
            type:"post",
            url:$url,
            dataType:"text",
            data:{exchange_id: data},
            success:function(data){
                if(data != 'false'){
                    window.location.reload();
                    return true;
                }else {
                    alert(data);
                }
            },
            error:function(err){
                alert('Failed');
                return false;
            }
        });
    }
}

function change() {
    var isSuccess = true ;
    var preCount = parseInt($('#'+flag).val());
    var $url = "http://[::1]/CI/point_exchange/exchage_change";
    $.ajax({
        type:"post",
        url:$url,
        dataType:"text",
        data:{
            exchange_id: flag,
            good_num: preCount
        },
        success:function(data){
            if(data == 'false'){
                isSuccess =  false;
            }
        },
        error:function(err){
            alert('Failed');
            isSuccess =  false;
        }
    });
    return isSuccess;
}

/*清空购物车*/
function delete_all_exchange() {
    var $url = "http://[::1]/CI/point_exchange/exchage_delete_all";
    $.ajax({
        type:"post",
        url:$url,
        dataType:"text",
        success:function(data){
            if(data != 'false'){
                window.location.reload();
                return true;
            }else {
                alert(data);
            }
        },
        error:function(err){
            alert('Failed');
            return false;
        }
    });
}

/*返回按钮点击事件*/
function cb_check() {
    var url = top.location.href;
    var offset = url.split('/').pop();
    var isSuccess = change();
    if(isSuccess){
        top.location.href = 'http://[::1]/CI/show_good/index/'+offset;
    }
}

/*结算按钮点击事件*/
function settleBtn() {
    $('.js_memory_need', window.parent.document).val($('.rest_integral').text());
    var isSuccess = change();
    if(isSuccess){
        $('#show_ex', window.parent.document).attr('src','http://[::1]/CI/exchange_order/index');
        $('.js_point_exchane_one', window.parent.document).removeClass('active_state');
        $('.js_point_exchane_one', window.parent.document).addClass('nomal_state');
        $('.js_point_exchane_two', window.parent.document).removeClass('nomal_state');
        $('.js_point_exchane_two', window.parent.document).addClass('active_state');
    }
}

/*返回上一步按钮事件*/
function cb_pre() {
    $('#show_ex', window.parent.document).attr('src','http://[::1]/CI/show_exchange/index');
    $('.js_point_exchane_two', window.parent.document).removeClass('active_state');
    $('.js_point_exchane_two', window.parent.document).addClass('nomal_state');
    $('.js_point_exchane_one', window.parent.document).removeClass('nomal_state');
    $('.js_point_exchane_one', window.parent.document).addClass('active_state');

}


