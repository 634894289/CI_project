/**
 * Created by hp on 2017/4/11.
 */
var JQuery=jQuery.noConflict();
JQuery(function () {

    if(getBrowser().isMobile){
        JQuery('.stored_value_point').css('display','none');
        var height = parseInt(JQuery('.personal_left').css('height'))+100;
        JQuery('.personal_left').css('height',height);
        JQuery('.personal_right').css('height',height);
        JQuery('.menber_personal_right').css('height',height+70);

    }else {
        var height = parseInt(JQuery('.personal_left').css('height'))+100;
        JQuery('.personal_left').css('height',height);
        JQuery('.personal_right').css('height',height);
    }

    if(JQuery('.js_login_message').val() != 1){
        JQuery('.js_out').css('display','inline-block');
        JQuery('.js_logined').css('display','none');
    } else{
        JQuery('.js_logined').css('display','inline-block');
        JQuery('.js_out').css('display','none');
    }

    /*我的订单*/
    JQuery('.js_orderList_one').click(function () {
       location.href = ' http://[::1]/CI/order_list/index/1/1';
    });
    JQuery('.js_orderList_two').click(function () {
        location.href = ' http://[::1]/CI/order_list/index/2/1';
    });
    JQuery('.js_orderList_three').click(function () {
        location.href = ' http://[::1]/CI/order_list/index/3/1';
    });


    /*我的余额*/
    JQuery('.js_storedValue_one').click(function () {
        location.href = ' http://[::1]/CI/stored_value/index/1/1';
    });
    JQuery('.js_storedValue_two').click(function () {
        location.href = ' http://[::1]/CI/stored_value/index/2/1';
    });
    JQuery('.js_storedValue_three').click(function () {
        location.href = ' http://[::1]/CI/stored_value/index/3/1';
    });
    /*我的积分*/
    JQuery('.js_point_one').click(function () {
        location.href = ' http://[::1]/CI/point/index/1/1';
    });
    JQuery('.js_point_two').click(function () {
        location.href = ' http://[::1]/CI/point/index/2/1';
    });
    JQuery('.js_point_three').click(function () {
        location.href = ' http://[::1]/CI/point/index/3/1';
    });
    // /*客房服务*/
    // var js_price = JQuery('.js_price').val();
    // if(js_price == 1){
    //     JQuery(":radio[value = 1]").attr('checked',true);
    // }
    // else if(js_price == 2){
    //     JQuery(":radio[value = 2]").attr('checked',true);
    // }
    // else if(js_price == 3){
    //     JQuery(":radio[value = 3]").attr('checked',true);
    // }
    // else if(js_price == 4){
    //     JQuery(":radio[value = 4]").attr('checked',true);
    // }
    // else if(js_price == 5){
    //     JQuery(":radio[value = 5]").attr('checked',true);
    // }
    // var js_room_type = JQuery('.js_room_type').val();
    // if(js_price == 1){
    //     JQuery(":radio[value = 1]").attr('checked',true);
    // }
    // else if(js_price == '经济型'){
    //     JQuery(":radio[value = '经济型']").attr('checked',true);
    // }
    // else if(js_price == '舒适型'){
    //     JQuery(":radio[value = '舒适型]").attr('checked',true);
    // }
    // else if(js_price == '高档型'){
    //     JQuery(":radio[value = '高档型]").attr('checked',true);
    // }
    // else if(js_price == '豪华型'){
    //     JQuery(":radio[value = '豪华型]").attr('checked',true);
    // }
    JQuery(":radio").click(function () {
        var price = JQuery("input[name='prices']:checked").val();
        var room_type = JQuery("input[name='room_type']:checked").val();
        var $url = "http://[::1]/CI/show_room/index/"+price + '/'+room_type+'/1';
        JQuery(window.parent.document).find("iframe[id='show_room']").attr('src',$url);
        setTimeout(IframeLoadEND,10);
        // JQuery.ajax({
        //     type:"post",
        //     url:$url,
        //     data:{
        //         price: price,
        //         room_type:room_type
        //     },
        //     success:function(data){
        //         // console.log(data);
        //         var doc = document.getElementById("show_room").contentDocument || document.frames["show_room"].document;
        //         doc.body.innerHTML = data;
        //         setTimeout(IframeLoadEND,10);
        //
        //         return true;
        //     },
        //     error:function(err){
        //         alert('Failed');
        //         return false;
        //     }
        // });
    });
    window.onresize = function () {
        window.location.reload();
    }
    /*客房服务*/
    var js_room_order = JQuery('.js_room_order').val()
    if(js_room_order){
        alert(js_room_order);
    }

    /*订房*/
    JQuery('.js_leave').click(function () {                 //点击退房时间时的点击事件
        var minDate = new Date();
        minDate = new Date((minDate/1000+86400)*1000);
        var minMonth = (minDate.getMonth() + 1)<10?'0'+ (minDate.getMonth() + 1):(minDate.getMonth() + 1);
        var min = minDate.getDate()<10?'0'+ minDate.getDate(): minDate.getDate()
        var minData = minDate.getFullYear() + '-' + minMonth + '-' + min;
        JQuery('.js_leave').attr('min',minData);
        if(JQuery('.js_checkIn').val()){
            var date  = new Date(JQuery('.js_checkIn').val());
            var data =  new Date((date/1000+86400)*1000);
             var newdata = data.getDate()<10?'0'+data.getDate():data.getDate();
             var newmonth = data.getMonth()+1<10?'0'+(data.getMonth()+1):data.getMonth()+1;
             var newdate = data.getFullYear() + '-' +newmonth + '-' + newdata;
            JQuery('.js_leave').attr('min',newdate);
        }
    });
    JQuery('.js_leave').change(function () {            //退房时间发生变化时触发的事件
        if(JQuery('.js_checkIn').val() && JQuery('.js_leave').val()){
            JQuery('.js_order_all').attr('disabled',false);
            var days = DateDiff(JQuery('.js_leave').val(),JQuery('.js_checkIn').val());
            var money = days * JQuery('.js_order_price').text();
            JQuery('.js_need_money').html(money);
            JQuery('#need_money').val(money);
        }
    });
    JQuery('.js_checkIn').change(function () {           //入住时间发生变化时触发的事件
        if(JQuery('.js_checkIn').val() && JQuery('.js_leave').val()){
            JQuery('.js_order_all').attr('disabled',false);
            var days = DateDiff(JQuery('.js_leave').val(),JQuery('.js_checkIn').val());
            var money = days * JQuery('.js_order_price').text();
            JQuery('.js_need_money').html(money);
            JQuery('#need_money').val(money);
        }
    });

    JQuery('.js_checkIn').click(function () {           //点击入住时间时的点击事件
        var minDate = new Date();
        minDate = new Date((minDate/1000+86400)*1000);
        var minMonth = (minDate.getMonth() + 1)<10?'0'+ (minDate.getMonth() + 1):(minDate.getMonth() + 1);
        var min = minDate.getDate()<10?'0'+ minDate.getDate(): minDate.getDate()
        var minData = minDate.getFullYear() + '-' + minMonth + '-' + min;
        JQuery('.js_checkIn').attr('min',minData);
        if(JQuery('.js_leave').val()){
            var date  = new Date(JQuery('.js_leave').val());
            var data =  new Date((date/1000-86400)*1000);
            var newdata = data.getDate()<10?'0'+data.getDate():data.getDate();
            var newmonth = data.getMonth()+1<10?'0'+(data.getMonth()+1):data.getMonth()+1;
            var newdate = data.getFullYear() + '-' +newmonth + '-' + newdata;
            JQuery('.js_checkIn').attr('max',newdate);
        }
        else {
            JQuery('.js_checkIn').removeAttr('max');
        }
    });

    /*控制房间照片高度*/

});
/*控制客房服务网页高度*/
function IframeLoadEND(){
    var iframe = document.getElementById("show_room");
    var num = JQuery(window.frames["show_room"].document).find(".showRoom").length;
    try{
        var bHeight = iframe.contentWindow.document.body.scrollHeight;
        var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
        var height = num>7?(bHeight+60):(dHeight+60);
        if(num == 0){
            height = 0;
            JQuery('.js_room_none').css('display','block');
        }else {
            JQuery('.js_room_none').css('display','none');
        }
        iframe.height = height;
    }catch (ex){}
}
/*两个日期之间的天数差*/
function  DateDiff(sDate1,  sDate2){    //sDate1和sDate2是2002-12-18格式
    var  aDate,  oDate1,  oDate2,  iDays
    aDate  =  sDate1.split("-")
    oDate1  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])    //转换为12-18-2002格式
    aDate  =  sDate2.split("-")
    oDate2  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])
    iDays  =  parseInt(Math.abs(oDate1  -  oDate2)  /  1000  /  60  /  60  /24)    //把相差的毫秒数转换为天数
    return  iDays
}
/*检查入住信息*/
function checkForm() {
    var form = JQuery('.order_room_form');
    if(form.checkIn_time.value == "") {
        form.checkIn_time.focus();
        return false;
    }
    if(form.leave_time.value == "") {
        form.leave_time.focus();
        return false;
    }
    return true;
}
/*检查余额*/
function checkMoney() {
    var banlance = parseInt(JQuery('.js_order_balance').val());
    var money = parseInt(JQuery('.js_need_money').text());
    if(banlance < money){
        alert('余额不足');
        return false;
    }
    return true;
}

/*点击优惠精选中的某一个活动触发的事件*/
function show_preferential_content(id) {
    window.location.href = "http://[::1]/CI/preferential_content/index/"+id;
}

/*点击积分商城中的某一个活动触发的事件*/
function showOneGood (data) {
    top.location.href  ="http://[::1]/CI/show_good/index/"+data;
};

/*积分商城点击减少按钮事件*/
function count_reduce() {
    var count = parseInt(JQuery('.js_good_count').val());
    if(count>1){
        count  -= 1;
    }
    JQuery('.js_good_count').val(count);
}

/*积分商城点击增加按钮事件*/
function count_increase() {
    var count = parseInt(JQuery('.js_good_count').val());
    var allCount = parseInt(JQuery('.js_rest_count').text());
    if(count<allCount){
        count  += 1;
    }
    JQuery('.js_good_count').val(count);
}

/*加入购物车按钮事件*/
function add_show_good(id) {
    var $url = "http://[::1]/CI/show_good/add_exchange";
    var num = JQuery('.js_good_count').val();
    JQuery.ajax({
        type:"post",
        url:$url,
        dataType:'text',
        data:{
            good_id: id,
            good_num : num
        },
        success:function(data){
            if(data != 'false'){
                JQuery('.js_add_show_good_num').html(data);
                return true;
            }
            else {
                alert(data);
            }
        },
        error:function(err){
            alert('Failed');
            return false;
        }
    });
}

/*控制购物车网页高度*/
function exchangeIframeLoadEND(){
    var iframe = document.getElementById("show_ex");
    var num = JQuery(window.frames["show_ex"].document).find(".js-show-exchange").length;
    try{
        var bHeight = iframe.contentWindow.document.body.scrollHeight;
        var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
        var height = num>4?(bHeight):(dHeight);
        if(num == 0){
            // JQuery('.js_room_none').css('display','block');
        }else {
            // JQuery('.js_room_none').css('display','none');
        }
        iframe.height = height;
    }catch (ex){}
}
/*判断是否是移动端*/
function getBrowser(){
    var ua = navigator.userAgent.toLowerCase();
    var btypeInfo = (ua.match( /firefox|chrome|safari|opera/g ) || "other")[ 0 ];
    if( (ua.match( /msie|trident/g ) || [] )[ 0 ] )
    {
        btypeInfo = "msie";
    }
    var pc = "";
    var prefix = "";
    var plat = "";
    //如果没有触摸事件 判定为PC
    var isTocuh = ("ontouchstart" in window) || (ua.indexOf( "touch" ) !== -1) || (ua.indexOf( "mobile" ) !== -1);
    if( isTocuh )
    {
        if( ua.indexOf( "ipad" ) !== -1 )
        {
            pc = "pad";
        } else if( ua.indexOf( "mobile" ) !== -1 )
        {
            pc = "mobile";
        } else if( ua.indexOf( "android" ) !== -1 )
        {
            pc = "androidPad";
        } else
        {
            pc = "pc";
        }
    } else
    {
        pc = "pc";
    }
    switch( btypeInfo )
    {
        case "chrome":
        case "safari":
        case "mobile":
            prefix = "webkit";
            break;
        case "msie":
            prefix = "ms";
            break;
        case "firefox":
            prefix = "Moz";
            break;
        case "opera":
            prefix = "O";
            break;
        default:
            prefix = "webkit";
            break
    }
    plat = (ua.indexOf( "android" ) > 0) ? "android" : navigator.platform.toLowerCase();
    return {
        version: (ua.match( /[\s\S]+(?:rv|it|ra|ie)[\/: ]([\d.]+)/ ) || [])[ 1 ],     //版本
        plat: plat,                   //系统
        type: btypeInfo,              //浏览器
        pc: pc,
        prefix: prefix,                //前缀
        isMobile: (pc == "pc") ? false : true              //是否是移动端
    };
};