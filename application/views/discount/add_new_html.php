<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '创建卡券' ,
	'funcname'=> 'discount',
));
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h3>创建优惠券</h3>
  <div class="input-group" >
      <span class="input-group-addon">卡券名称</span>
      <input type="text" id="name" class="form-control" placeholder="输入卡券名称" />
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">卡券类型</span>
      <select id="type" class="form-control" >
      <?foreach($discountType as $k=>$v){?>
        <option value="<?=$k?>"><?=$v?></option>
        <?}?>
      </select>
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">卡券描述</span>
      <textarea rows="3" id="desc" class="form-control" placeholder="输入卡券描述或者使用说明"></textarea>
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">背景图片</span>
      <textarea rows="3" id="pic" class="form-control" placeholder="输入卡券背景图url"></textarea>
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">折扣力度</span>
      <input type="number" id="discount" class="form-control" value="" placeholder="免费券输入0，95折输入95" />
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">关联菜品</span>
      <input type="number" id="dish_id" class="form-control"  value="" placeholder="输入关联菜品id" />
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">过期天数</span>
      <input type="number" id="expire_day" class="form-control" value="" placeholder="领券后几天内可以使用" />
    </div>
    
  <button type="button" class="btn btn-warning btn-block" style="margin-top:8px" id="add_btn">提交</button>
</div>


<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>


<script type="text/javascript">
    $(function(){
        Discount.addInit();
        $('#add_btn').click(function(){
            Discount.add();
        });
    });

</script>
<?php $this->load->view ( 'common/footer' )?>