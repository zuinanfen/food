var Page = {  //分页方法
    init:function(param){
        var args = {
            divId:'pagination',
            items: 100,
            itemsOnPage: 10,
            prevText: '上一页',
            nextText:'下一页',
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