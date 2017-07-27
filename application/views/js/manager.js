/**
 * Created by hp on 2017/4/21.
 */
$(function(){
    $("a[title]").click(function(){
        var text = $(this).text();
        var href = $(this).attr("title");
        var name = $(this).attr("name");
        //判断当前右边是否已有相应的tab
        if($("#tt").tabs("exists", text)) {
            if($(window.parent.document).find("iframe[id='allRoom']").attr('src')!= 'http://[::1]/CI/all_room/index'){
                $(window.parent.document).find("iframe[id='allRoom']").attr('src',href);
                $(window.parent.document).find("span:contains('号房间信息')").text('所有住房信息');
            }
            if($(window.parent.document).find("iframe[id='allPreferential']").attr('src')!= 'http://[::1]/CI/all_preferential/index'){
                $(window.parent.document).find("iframe[id='allPreferential']").attr('src',href);
                $(window.parent.document).find("span:contains('活动信息')").text('所有优惠信息');
            }
            if($(window.parent.document).find("iframe[id='allExchange']").attr('src')!= 'http://[::1]/CI/all_exchange/index'){
                $(window.parent.document).find("iframe[id='allExchange']").attr('src',href);
                $(window.parent.document).find("span:contains('商品信息')").text('所有商品信息');
            }
            if($(window.parent.document).find("iframe[id='allMenber']").attr('src')!= 'http://[::1]/CI/all_menber_info/index'){
                $(window.parent.document).find("iframe[id='allMenber']").attr('src',href);
                $(window.parent.document).find("span:contains('会员信息')").text('所有会员信息');
            }
            $("#tt").tabs("select", text);
        } else {
            //如果没有则创建一个新的tab，否则切换到当前tag
            $("#tt").tabs("add",{
                title:text,
                closable:true,
                content:'<iframe title=' + text + ' src=' + href +' id='+name +' '+' frameborder="0" width="100%" height="650px" />'
                //href:默认通过url地址加载远程的页面，但是仅仅是body部分
                //href:'send_category_query.action'
            });
        }
    });
    $("a[class = 'layout-button-right']").click(function () {
        alert('2');
    });
    $("a[class = 'layout-button-left']").click(function () {
    });
    /*房间信息添加结果*/
    var js_add_val = $('.js_add').val();
    if(js_add_val == '添加成功'){
        alert('添加成功');
    }else if(js_add_val == '添加失败'){
        alert('添加失败');
    }
    else if(js_add_val == '修改成功'){
        alert('修改成功');
    }
    else if(js_add_val == '修改失败'){
        alert('修改失败');
    }
    /*优惠信息添加结果*/
    var js_add_preferential = $('.js_add_preferential').val();
    if(js_add_preferential == '添加成功'){
        alert('添加成功');
    }else if(js_add_preferential == '添加失败'){
        alert('添加失败');
    }
    /*商品信息添加结果*/
    var js_add_exchange = $('.js_add_exchange').val();
    if(js_add_exchange == '添加成功'){
        alert('添加成功');
    }else if(js_add_exchange == '添加失败'){
        alert('添加失败');
    }

    /*更改tabs显示名称*/
    if($('.js_all').val() == '1'){
         $(window.parent.document).find("span:contains('号房间信息')").text('所有住房信息');
    }
    if($('.js_preferential').val() == '1'){
        $(window.parent.document).find("span:contains('活动信息')").text('所有优惠信息');
    }
    if($('.js_exchange').val() == '1'){
        $(window.parent.document).find("span:contains('商品信息')").text('所有商品信息');
    }
    if($('.js_menber').val() == '1'){
        $(window.parent.document).find("span:contains('会员信息')").text('所有会员信息');
    }
});

/*所有房间信息删除和详情按钮点击事件*/
function all_roomDeleteBtn(data) {
    var result = confirm('您确认删除此消息');
   if(result){
       var $url = "http://[::1]/CI/manager_change_info/all_room_delete";
       $.ajax({
           type:"post",
           url:$url,
           dataType:"text",
           data:{room_id: data},
           success:function(data){
               window.location.reload();
               return true;
           },
           error:function(err){
               alert('Failed');
               return false;
           }
       });
   }
}
function all_roomRestBtn(data) {
    var offsert = document.URL.split('/').pop();
    var $url = "http://[::1]/CI/change_room/index";
    $(window.parent.document).find("iframe[id='allRoom']").attr('src','http://[::1]/CI/change_room/index/'+data+'/'+offsert);
    $(window.parent.document).find("span:contains('所有住房信息')").text('修改'+data+'号房间信息');
}
function roomResetBtn() {
    var offsert = document.URL.split('/').pop();
    var $url = "http://[::1]/CI/change_room/changeSeeeion";
    $.ajax({
        type:"post",
        url:$url,
        success:function(data){
            return true;
        },
        error:function(err){
            alert('Failed');
            return false;
        }
    });
    $(window.parent.document).find("iframe[id='allRoom']").attr('src','http://[::1]/CI/all_room/index/'+offsert);
}

/*所有优惠信息删除和详情按钮点击事件*/
function all_preferentialDeleteBtn(data) {
    var result = confirm('您确认删除此消息');
    if(result){
        var $url = "http://[::1]/CI/manager_change_info/all_preferential_delete";
        $.ajax({
            type:"post",
            url:$url,
            dataType:"text",
            data:{preferential_id: data},
            success:function(data){
                window.location.reload();
                return true;
            },
            error:function(err){
                alert('Failed');
                return false;
            }
        });
    }
}
function all_preferentialRestBtn(data,data2) {
    var offsert = document.URL.split('/').pop();
    var $url = "http://[::1]/CI/change_preferential/index";
    $(window.parent.document).find("iframe[id='allPreferential']").attr('src','http://[::1]/CI/change_preferential/index/'+data+'/'+offsert);
    $(window.parent.document).find("span:contains('所有优惠信息')").text('修改'+data2+'活动信息');
}
function preferentialResetBtn() {
    var offsert = document.URL.split('/').pop();
    var $url = "http://[::1]/CI/change_preferential/changePreferential_text";
    $.ajax({
        type:"post",
        url:$url,
        success:function(data){
            return true;
        },
        error:function(err){
            alert('Failed');
            return false;
        }
    });
    $(window.parent.document).find("iframe[id='allPreferential']").attr('src','http://[::1]/CI/all_preferential/index/'+offsert);
}

/*所有商品信息删除和详情按钮点击事件*/
function all_exchangeDeleteBtn(data) {
    var result = confirm('您确认删除此消息');
    if(result){
        var $url = "http://[::1]/CI/manager_change_info/all_exchange_delete";
        $.ajax({
            type:"post",
            url:$url,
            dataType:"text",
            data:{good_id: data},
            success:function(data){
                window.location.reload();
                return true;
            },
            error:function(err){
                alert('Failed');
                return false;
            }
        });
    }
}
function all_exchangeRestBtn(data,data2) {
    var offsert = document.URL.split('/').pop();
    var $url = "http://[::1]/CI/change_exchange/index";
    $(window.parent.document).find("iframe[id='allExchange']").attr('src','http://[::1]/CI/change_exchange/index/'+data+'/'+offsert);
    $(window.parent.document).find("span:contains('所有商品信息')").text('修改'+data2+'商品信息');
}
function exchangeResetBtn() {
    var offsert = document.URL.split('/').pop();
    var $url = "http://[::1]/CI/change_exchange/changeExchange_text";
    $.ajax({
        type:"post",
        url:$url,
        success:function(data){
            return true;
        },
        error:function(err){
            alert('Failed');
            return false;
        }
    });
    $(window.parent.document).find("iframe[id='allExchange']").attr('src','http://[::1]/CI/all_exchange/index/'+offsert);
}

/*控制网页高度*/
function IframeLoadEND(iframe){
    try{
        var bHeight = iframe.contentWindow.document.body.scrollHeight;
        var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
        var height = Math.max(bHeight,dHeight)+100;
        iframe.height = height;
    }catch (ex){}
}

/*所有会员信息删除和详情按钮点击事件*/
function all_menberDeleteBtn(phone) {
    var result = confirm('您确认删除此消息');
    if(result){
        var $url = "http://[::1]/CI/manager_change_info/all_menber_delete";
        $.ajax({
            type:"post",
            url:$url,
            dataType:"text",
            data:{phone: phone},
            success:function(data){
                window.location.reload();
                return true;
            },
            error:function(err){
                alert('Failed');
                return false;
            }
        });
    }
}
function all_menberRestBtn(phone) {
    var offsert = document.URL.split('/').pop();
    var $url = "http://[::1]/CI/detail_menber_info/index";
    $(window.parent.document).find("iframe[id='allMenber']").attr('src','http://[::1]/CI/detail_menber_info/index/'+phone+'/'+offsert);
    $(window.parent.document).find("span:contains('所有会员信息')").text('查看'+phone+'会员信息');
}
function menberResetBtn() {
    var offsert = document.URL.split('/').pop();
    var $url = "http://[::1]/CI/detail_menber_info/changeSeeeion";
    $.ajax({
        type:"post",
        url:$url,
        success:function(data){
            return true;
        },
        error:function(err){
            alert('Failed');
            return false;
        }
    });
    $(window.parent.document).find("iframe[id='allMenber']").attr('src','http://[::1]/CI/all_menber_info/index/'+offsert);
}

