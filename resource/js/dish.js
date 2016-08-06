/*点餐和购物车操作js
 @author nickfu  2016.07。24
*/

//操作localStorage方法
var Data = {
	get: function(key,type){
		//检测用户是否输入键
	    if(key==''){
	        return '';
	    }
	    if(window.localStorage){
	        var value = localStorage.getItem(key);
	        if(value==null||value==''){
	        	if(typeof type !='undefined' && type=='string' ){
	        		return '';
	        	}else{
	        		return {};
	        	}
	        }else{
	        	if(typeof type !='undefined' && type=='string' ){
	        		return value;
	        	}else{
	        		return JSON.parse(value);
	        	}
	        }
	    }else{
	        return false;
	    }
	},
	set: function(key,val){
		if(window.localStorage){
	        if(key=='' || val==''){ 
	            return false;
	        }
	        localStorage.setItem(key,val);
	        return true;
	    }else{
	        return false;
	    }
	},
	del:function(key){
		localStorage.removeItem(key);
	},
	objLength: function(obj){ //获取object length
		var count = 0;
		for (var i in obj) {
		    if (obj.hasOwnProperty(i)) {
		        count++;
		    }
		}
		return count;
	},
	floatAdd: function accAdd(arg1,arg2){ //浮点运算加法
	    var r1,r2,m;
	    try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}
	    try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
	    m=Math.pow(10,Math.max(r1,r2))
	    return (arg1*m+arg2*m)/m
	}

}
var Template = {
	getHtml: function(scriptId, data){
		var html = template(scriptId ,data);
		return html;
	}
}


var Dish = {
	dish_list:{},  //菜品列表
	getKey: function(pre){
		var key = pre + '_' + new Date().getTime() + '_' + Math.ceil(Math.random()*1000000) ;
		return key;
	},
	//下单页初始化
	init: function(){
		Data.del('dish_option_list');
		var dish_list = Data.get('dish_list');
		var length = Data.objLength(dish_list);
		$('#dish_num').find('span').text(length);
	},
	add: function(dish_id){  //添加菜品
		// //step1. 先从离线存储看看该菜品有没有点过
		// this.dish_list = Data.get('dish_list');
		// if(typeof this.dish_list == 'undefined'){ //假如该菜品还没点
		// 	this.dish_list[dish_id] = [];
		// }else{   //若该菜品已经被点了，则添加进去
		// 	this.dish_list[dish_id][] = {};
		// }
		this.dish_list = Data.get('dish_list');
		//菜品名称
		var dishName = $('#dish_'+dish_id).find('.dishName').text();
		//菜品价格
		var dishPrice = $('#dish_'+dish_id).find('.dishPrice').text();
		var dishKey = this.getKey('dish');
		this.dish_list[dishKey] = {dishId:dish_id,name:dishName,dishPrice:dishPrice,options:[]};
		//step2. 将菜品放入列表，并存入离线存储
		Data.set('dish_list',JSON.stringify(this.dish_list));

		
		//step4. 获取菜品附加选项
		var option = Dishoption.get(dish_id);

		//step5. 判断选项是否为空，不为空，则弹窗让下单的人选择
		if(option.length>0){
			Dishoption.selectOption(dish_id,dishKey);	
		}else{
			//step3. 生成动画效果
			this.animate(dish_id);
		}
	},
	del:function(){  //删除菜品

	},
	animate: function(dish_id){
		//创建+1
		var $animateContent = $('<div class="animateNum">+1</div>');
		$animateContent.insertAfter($('#dish_'+dish_id).find('button'));
		window.setTimeout(function() {
            $animateContent.remove()
        },1000);
        var dishLength = Data.objLength(this.dish_list);
		$('#dish_num').find('span').hide().text(dishLength).fadeIn();
	},
	dataFormat:function(dishData){ //一个菜的数据格式化，将附加选项之类的价格之类的开始算
		var dishOptions = Dishoption.get(dishData.dishId);
		var newOptions = [];
		var totalPrice = parseFloat(dishData.dishPrice);
		// console.log('2222',dishOptions);
		// $.each(dishOptions,function(k,v){
		// 	alert(v.id);
		// 	if($.inArray(v.id,dishData.options)>-1){
		// 		newOptions.push(v);
		// 		dishPrice = Data.floatAdd(dishPrice, parseFloat(v.price));
		// 	}
		// });
		for(var i=0;i<dishOptions.length;i++){
			//if($.inArray(dishOptions[i].id, dishData.options)>-1){
			if(dishData.options.indexOf(parseInt(dishOptions[i].id))>-1){
				newOptions.push(dishOptions[i]);
				totalPrice = Data.floatAdd(totalPrice, parseFloat(dishOptions[i].price));
			}
		}
		dishData.totalPrice = totalPrice;
		dishData.options = newOptions;

		return dishData;

	}
	

}
var Dishoption = {
	dish_option_list: {},  //菜品附加选项列表
	get: function(dish_id){  //获取当前菜品的附件项, return obj
		//从localStorage 里读取 dish_option_list
		this.dish_option_list = Data.get('dish_option_list');
		if(typeof this.dish_option_list[dish_id] != 'undefined'){//假如该菜品附加项已经初始化了，直接使用
			return this.dish_option_list[dish_id];
		}
		var self = this;
		var list = [];
		$.ajax({
             type: 'post',
             url: '../dishoption/getList',
             data: {dishId: dish_id},
             dataType: 'json',
             async: false,
             success: function(json){
             	if (json._ret == 0) {
					// console.log(data);
					self.dish_option_list[dish_id] = json.list;
					//写入离线存储
					Data.set('dish_option_list', JSON.stringify(self.dish_option_list));
					list = json.list;
					
				} else {
					alert("操作失败，请刷新重试！");
				}
             }

        });
		return list;
	},
	selectOption: function(dish_id,dishKey){ //菜品id和菜品唯一Key
		// this.dish_option_list = Data.get('dish_option_list');
		var options = Dishoption.get(dish_id);
		// if(typeof this.dish_option_list[dish_id] == 'undefined'){
		// 	return false;
		// }
		// var options = this.dish_option_list[dish_id]; //当前菜品的所有选项
		var select_options = []; //选中的需要选项

		var content = '';
		var optionsLen = Data.objLength(options);
		for (var i=0;i<optionsLen;i++) {
			// console.log(options[i]);
			// alert(i);
			content += '<button data-id="'+options[i].id+'" data-name="'+options[i].name+'" data-price="'+options[i].price+'" type="button" class="option-btn btn btn-default btn-sm">';
			content += ' <span class="option-name">&nbsp;<b>'+options[i].name+'</b>('+options[i].price+')</span></button>';
		};

		var dialog = $.dialog({
	        title: '请选择菜品附加选项',
	        content:'<div id="option-dialog">'+content+'</div>',
	        okValue: '确定',
	        lock: true,
		    fixed:true,
	        ok: function () {
	        	var $selected = $('#option-dialog').find('.selected');
	        	if($selected.length>0){
	        		$selected.each(function(){
		        		var id = $(this).data('id');
		        		select_options.push(id);
		        	});
		        	var dish_list = Data.get('dish_list'); //离线存储读取已经选中的菜品

		        	dish_list[dishKey].options = select_options;   //将附件选项写进去
		        	// console.log('xxx',dish_list);
		        	Data.set('dish_list',JSON.stringify(dish_list)); //写回去离线存储
	        	}

	        	// this.content('保存成功，窗口自动关闭').time(500);
	        	this.close();
		        Dish.animate(dish_id);

		        return false;
		    },
		    cancel: function(){
		    	Dish.animate(dish_id);
		    }
    	});
    	$('.option-btn').unbind('click').click(function(){
    		var optionId = $(this).data('id');
    		var optionName = $(this).data('name');
    		var optionPrice = $(this).data('price');

    		if($(this).hasClass('selected')){ //取消
    			$(this).find('.glyphicon').remove();
    			$(this).removeClass('btn-success').removeClass('selected').addClass('btn-default');
    		}else{  //选中
    			$(this).removeClass('btn-default').addClass('btn-success').addClass('selected');
    			$('<span class="glyphicon glyphicon-ok"></span>').insertBefore($(this).find('.option-name'));
    		}
    		
    	});
		
	},
}
var Cart = {
	init: function(){
		var dish_list = Data.get('dish_list');
		var length = Data.objLength(dish_list);
		if(length<1){
			var html = Template.getHtml('dishListHtml',{list:[]});
			$('#dishList').html(html);
			return false;
		}
		$('body').delegate('.del_dish','click',function(){
			var id = $(this).parents('tr').attr('id');
			if(confirm('确定要删除该菜品？')){
			 	Cart.delDish(id);
			}
		});
		$('body').delegate('.edit_dish','click',function(){
			var id = $(this).parents('tr').attr('id');
			Cart.editDish(id);
		});
		$('#checkOrder').click(this.submit);
		$('#order_src').change(function(){
			var order_src = $(this).val();
			if(order_src==1){
				$('#order_table_seat').show();
			}else{
				$('#order_table_seat').hide();
			}
			Data.set('order_src',order_src);
		});
		$('#order_table_seat').find('input').blur(function(){
			var order_table_seat = $(this).val();

			Data.set('order_table_seat',order_table_seat);
		});
		var order_src = Data.get('order_src','string');
		var order_table_seat = Data.get('order_table_seat','string');
		if(order_src != ''){
			$('#order_src').val(order_src);
		}
		if(order_src == 1 || order_src == ''){
			$('#order_table_seat').show();
		}
		if(order_table_seat != ''){
			$('#order_table_seat').find('input').val(order_table_seat);
		}

		this.renderDish(dish_list);

	},
	renderDish: function(dish_list){
		var data = {list:[]}
		$.each(dish_list,function(k,v){
	 	//初始化附加选项
	 	var dishData = Dish.dataFormat(v);
		var _obj = {
						id:k,
						dishId:dishData.dishId,
						name:dishData.name,
						dishPrice:dishData.dishPrice,
						totalPrice:dishData.totalPrice,
						options: dishData.options
					};
			data.list.push(_obj);

		});
		// console.log('qqqq',data);
		var html = Template.getHtml('dishListHtml',data);
		
		$('#dishList').html(html);
		$('#dish_num').find('span').text(data.list.length);
	},
	delDish: function(dishKey){//删除菜品
		var dish_list = Data.get('dish_list');
		delete dish_list[dishKey];
		Data.set('dish_list',JSON.stringify(dish_list));
		$('.'+dishKey).fadeOut();
		var $dishNum = $('#dish_num').find('span').text();
		$('#dish_num').find('span').text(parseInt($dishNum)-1);
		
	},
	editDish: function(dishKey){
		var dish_id = $('#'+dishKey).data('dishid');

		var options = Dishoption.get(dish_id);

		var dish_list = Data.get('dish_list');
		// console.log('wwwwwwwwww',dish_list);
		var select_options = dish_list[dishKey].options; //选中的需要选项
		var content = '';
		var optionsLen = Data.objLength(options);
		if(optionsLen<1){
			alert('该菜品无附加选项！');
			return false;
		}else{
			// console.log('aaaa',select_options);
			for (var i=0;i<optionsLen;i++) {
				var selected = '';
				var buttonStyle = 'btn-default';
				var selectBtn = '';
				if(select_options.indexOf(parseInt(options[i].id))>-1){
					selected = 'selected';
					buttonStyle = 'btn-success';
					selectBtn = '<span class="glyphicon glyphicon-ok"></span>';
				}
				content += '<button data-id="'+options[i].id+'" data-name="'+options[i].name+'" data-price="'+options[i].price+'" type="button" class="option-btn btn '+buttonStyle+' btn-sm '+selected+'">';
				content += selectBtn+' <span class="option-name">&nbsp;<b>'+options[i].name+'</b>('+options[i].price+')</span></button>';
			};
		}
		
		// console.log(content);
		var dialog = $.dialog({
	        title: '请选择菜品附加选项',
	        content:'<div id="option-dialog">'+content+'</div>',
	        okValue: '确定',
	        lock: true,
		    fixed:true,
	        ok: function () {
	        	var $selected = $('#option-dialog').find('.selected');
	        	select_options = [];
	        	if($selected.length>0){
	        		$selected.each(function(){
		        		var id = $(this).data('id');
		        		select_options.push(id);
		        	});
		        	
	        	}
	        	var dish_list = Data.get('dish_list'); //离线存储读取已经选中的菜品
	        	dish_list[dishKey].options = select_options;   //将附件选项写进去
	        	// console.log('xxx',dish_list);
	        	Data.set('dish_list',JSON.stringify(dish_list)); //写回去离线存储
	        	this.close();
	        	// console.log('xxxx',dish_list);
	        	Cart.renderDish(dish_list);
		        return false;
		    },
		    cancel: function(){
		    	// Dish.animate(dish_id);
		    }
    	});
    	$('.option-btn').unbind('click').click(function(){
    		var optionId = $(this).data('id');
    		var optionName = $(this).data('name');
    		var optionPrice = $(this).data('price');

    		if($(this).hasClass('selected')){ //取消
    			$(this).find('.glyphicon').remove();
    			$(this).removeClass('btn-success').removeClass('selected').addClass('btn-default');
    		}else{  //选中
    			$(this).removeClass('btn-default').addClass('btn-success').addClass('selected');
    			$('<span class="glyphicon glyphicon-ok"></span>').insertBefore($(this).find('.option-name'));
    		}
    		
    	});
	},
	submit:function(){
		//字段检测
		var order_src = $('#order_src').val();
		var order_table_seat = $('#order_table_seat').find('input').val();
		if(order_src==1 && order_table_seat.length<1){
			alert('座位号不能为空！');
			return false;
		}
		//获取菜品
		var dish_list = Data.get('dish_list');
		var listLength = Data.objLength(dish_list);
		if(listLength<1){
			alert('您还未点菜！');
			return false;
		}
		var data = {
			order_src: order_src,
			dish_list: JSON.stringify(dish_list),
			order_table_seat: order_table_seat
		}
		$.ajax({
             type: 'post',
             url: '../order/add',
             data: data,
             dataType: 'json',
             success: function(json){
             	if (json._ret == 0) {
					alert('订单提交成功！');
					Data.del('dish_list');
					Data.del('order_src');
					Data.del('order_table_seat');

					window.location.href = '../menu/index';
					
				} else {
					alert("操作失败，请刷新重试！");
				}
             }

        });
	}
}

var Order = {
	init: function(){
		this.getList();
	},
	getList: function(){
		$.ajax({
             type: 'post',
             url: '../menu/order_list',
             // data: data,
             dataType: 'json',
             success: function(json){
             	if (json._ret == 0) {
					var html = Template.getHtml('dishListHtml',json);
					$('#dishList').html(html);
					
				} else {
					alert("操作失败，请刷新重试！");
				}
             }

        });
	}
}

var Chef = {
	init:function(){
		this.getList();
		window.setInterval(this.getList, 3000);
	},
	getList:function(){
		$.ajax({
             type: 'post',
             url: '../menu/chef_get_list',
             data: {update:1},
             dataType: 'json',
             success: function(json){
             	if (json._ret == 0) {
					var html = Template.getHtml('dishListHtml',json);
					$('#chef_dish_list').html(html);
					
				} else {
					alert("系统出现问题，请刷新重试");
				}
             }

        });
	}
}
Serving_interval = '';
var Serving = {
	interval: false,
	init:function(){
		this.getList();
		$('body').delegate('.serving','click',this.updateStatus);
		Serving_interval = window.setInterval(Chef.getList, 3000);
	},
	getList:function(){
		$.ajax({
	         type: 'post',
	         url: '../menu/chef_get_list',
	         dataType: 'json',
	         data:{update:0},
	         success: function(json){
	         	if (json._ret == 0) {
					var html = Template.getHtml('dishListHtml',json);
					$('#chef_dish_list').html(html);
					
				} else {
					alert("系统出现问题，请刷新重试");
				}
	         }

	    });
	},
	updateStatus:function(){
		//清除掉定时器，防止操作的时候自动刷新
		window.clearInterval(Serving_interval);
		var id = $(this).data('id');
		var orderId = $(this).data('orderid');
		$.ajax({
             type: 'post',
             url: '../order/doneDish',
             data:{id:id,orderId:orderId},
             dataType: 'json',
             success: function(json){
             	if (json._ret == 0) {
					$('#'+id).fadeOut();
					Serving_interval = window.setInterval(Chef.getList, 3000);
					
				} else {
					alert("系统出现问题，请刷新重试");
				}
             }

        });
	}
}
var OrderShow = {
	init:function(){
		$('.del_dish').click(function(){
			var id = $(this).data('id');
			var orderId = $(this).data('orderid');
			var dishKey = $(this).data('dishkey');
			if(confirm('确定要删除该菜品？删除后会导致订单价格改变，需要重新打印订单给顾客付款！')){
			 	OrderShow.delDish(id,orderId,dishKey);
			}
		});
	},
	delDish: function(id, orderId, dishKey){
		$.ajax({
             type: 'post',
             url: '../order/delDish',
             data:{dishId:id,orderId:orderId,dishKey:dishKey},
             dataType: 'json',
             success: function(json){
             	if (json._ret == 0) {
					alert('菜品删除成功，请重新打印订单给顾客结算！');
					window.location.reload();
					
				} else {
					alert(json._log);
				}
             }

        });
	}
}