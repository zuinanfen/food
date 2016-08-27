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
}
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
}
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
    }
}