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
		this.dish_option_list = Data.get('dish_option_list');
		if(typeof this.dish_option_list[dish_id] == 'undefined'){
			return false;
		}
		var options = this.dish_option_list[dish_id]; //当前菜品的所有选项
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