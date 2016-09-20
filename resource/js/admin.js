var Page = {  //分页方法
    init:function(param){
        var args = {
            divId:'pagination',
            items: 100,
            itemsOnPage: 10,
            prevText: '上页',
            nextText:'下页',
            currentPage:1,
            hrefTextPrefix:'javascript:;',
            selectOnClick:false,
            onPageClick:function(number){

            }
        };
        $.extend(args,param);
        // console.log(args);
        $('#'+args.divId).pagination(args);
    },
    getUrlParam:function(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    }
};
var Report = {
	/*dateReport: function(startTime,endTime){
		startTime = startTime+' 00:00:01';

		endTime = endTime+' 23:59:59';
		$.ajax({
             type: 'post',
             url: '../report/dateReport',
             data: {startTime: startTime,endTime:endTime},
             dataType: 'json',
             success: function(json){
             	if (json._ret == 0) {
					console.log(json.list);
				} else {
					alert(json._log);
				}
             }

        });
	}*/
};
var Income = {
	add:function(data){
		$.ajax({
             type: 'post',
             url: '../income/add',
             data: data,
             dataType: 'json',
             success: function(json){
             	if (json._ret == 0) {
             		alert('添加记录成功！');
					window.location.reload();
				} else {
					alert(json._log);
				}
             }

        });
	}
};
var Invoice = {
    add:function(data){
        $.ajax({
             type: 'post',
             url: '../invoice/addnew',
             data: data,
             dataType: 'json',
             success: function(json){
                if (json._ret == 0) {
                    alert('创建报销单成功！');
                    window.location.href='/index.php/invoice/index';
                } else {
                    alert(json._log);
                }
             }

        });
    },
    cancel:function(id){
        $.ajax({
             type: 'post',
             url: '../invoice/cancel',
             data:{id:id},
             dataType: 'json',
             success: function(json){
                if (json._ret == 0) {
                    alert('撤销报销单成功！');
                    window.location.reload();
                } else {
                    alert(json._log);
                }
             }

        });
    },
    done:function(id){
        $.ajax({
             type: 'post',
             url: '../invoice/done',
             data:{id:id},
             dataType: 'json',
             success: function(json){
                if (json._ret == 0) {
                    alert('结算报销单成功！');
                    window.location.reload();
                } else {
                    alert(json._log);
                }
             }

        });
    }
};
var Reverve = {
    add:function(data){
        $.ajax({
             type: 'post',
             url: '../reserve/addnew',
             data: data,
             dataType: 'json',
             success: function(json){
                if (json._ret == 0) {
                    alert('创建预订单成功！');
                    window.location.href='/index.php/reserve/index';
                } else {
                    alert(json._log);
                }
             }

        });
    },
    edit:function(data){
        $.ajax({
             type: 'post',
             url: '../reserve/edit',
             data: data,
             dataType: 'json',
             success: function(json){
                if (json._ret == 0) {
                    alert('修改预订单成功！');
                    window.location.reload;
                } else {
                    alert(json._log);
                }
             }

        });
    },
    cancel:function(id){
        $.ajax({
             type: 'post',
             url: '../reserve/cancel',
             data:{id:id},
             dataType: 'json',
             success: function(json){
                if (json._ret == 0) {
                    alert('撤销订单成功！');
                    window.location.reload();
                } else {
                    alert(json._log);
                }
             }

        });
    },
    done:function(id){
        $.ajax({
             type: 'post',
             url: '../reserve/done',
             data:{id:id},
             dataType: 'json',
             success: function(json){
                if (json._ret == 0) {
                    alert('确认订单成功！');
                    window.location.reload();
                } else {
                    alert(json._log);
                }
             }

        });
    },
    send:function(data){
        $.ajax({
             type: 'post',
             url: '../reserve/send',
             data:data,
             dataType: 'json',
             success: function(json){
                if (json._ret == 0) {
                    alert('发货成功！');
                    window.location.reload();
                } else {
                    alert(json._log);
                }
             }

        });
    }
};
var Discount = {
    addInit:function(){
        $('#type').change(function(){
            var val = $(this).val();
            var $dish_id = $('#dish_id');   
            $dish_id.val('');       
            if(val==1){
                $dish_id.parents('.input-group').show();
            }else{
                $dish_id.parents('.input-group').hide();
            }
        });

        
    },
    add:function(){
        var data = {
                name: $('#name').val(),
                type: $('#type').val(),
                desc: $('#desc').val(),
                pic: $('#pic').val(),
                discount: $('#discount').val(),
                dish_id: $('#dish_id').val(),
                expire_day: $('#expire_day').val()
            }

            $.ajax({
                 type: 'post',
                 url: '/index.php/discount/add',
                 data:data,
                 dataType: 'json',
                 success: function(json){
                    if (json._ret == 0) {
                        alert('创建优惠券成功！');
                        window.location.href='/index.php/discount/listall';
                    } else {
                        alert(json._log);
                    }
                 }

            });
    },
    edit:function(){
        var data = {
                name: $('#name').val(),
                desc: $('#desc').val(),
                pic: $('#pic').val(),
                expire_day: $('#expire_day').val(),
                id: $('#id').val(),
                status: $('#status').val(),
            }

            $.ajax({
                 type: 'post',
                 url: '/index.php/discount/edit_config',
                 data:data,
                 dataType: 'json',
                 success: function(json){
                    if (json._ret == 0) {
                        alert('编辑优惠券成功！');
                        window.location.href='/index.php/discount/index';
                    } else {
                        alert(json._log);
                    }
                 }

            });
    },
    getCard: function(id){
        $.ajax({
             type: 'post',
             url: '/index.php/discount/get_card',
             data:{id:id},
             dataType: 'json',
             success: function(json){
                if (json._ret == 0) {
                    alert('生成优惠券成功！');
                    var cardId = json.cardId;
                    window.location.href = '/index.php/discount/show?id='+cardId;
                } else {
                    alert(json._log);
                }
             }

        });
    }
}