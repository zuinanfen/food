<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '创建卡券' ,
	'funcname'=> 'discount',
));
?>


  <a href="/index.php/discount/edit"><button class="btn btn-primary btn-block" style="width:100%;margin-bottom:15px;"><span class="glyphicon glyphicon-plus"></span> 创建优惠券</button></a>
<?foreach($list as $k=>$v){?>
<div class="bs-example" data-id="<?=$v->id?>" style="position:relative">
      <table class="table ">
        <thead>
          <tr>
            <th><?=$v->name?></th>
            <th><?=$discountType[$v->type]?> 
            <a href="/index.php/discount/edit?id=<?=$v->id?>"><button type="button" class="btn btn-xs btn-info edit-config">编辑</button></a>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>折扣：<?=$v->discount?></td>
            <td>领取后有效期：<?=$v->expire_day?> 天</td>
          </tr>
          <?if($v->type==1){?>
          <tr>
            <td colspan="2">打折菜品名：<?=$v->dish_name?></td>
          </tr>
          <?}?>
          <tr>
            <td colspan="2">卡券说明：<?=$v->desc?></td>
          </tr>
          <tr>
            <td colspan="2"><img src="<?=$v->pic?>" width="100%"/></td>
          </tr>
        </tbody>
      </table>
      <?if($v->status==0){?>
      <div style="color:red;font-size:300px;position:absolute;top:50px;left:30%;line-height:200px;height:200px;">x</div>
      <?}?>
  </div>
<?}?>

<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>


<script type="text/javascript">
    $(function(){
      
    });

</script>
<?php $this->load->view ( 'common/footer' )?> 
