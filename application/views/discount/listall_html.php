<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '发放卡券' ,
	'funcname'=> 'discount',
));
?>
<?foreach($list as $k=>$v){?>
<div class="bs-example" data-id="<?=$v->id?>">
      <table class="table ">
        <thead>
          <tr>
            <th><?=$v->name?></th>
            <th><?=$discountType[$v->type]?> 
            <button data-id="<?=$v->id?>" type="button" class="btn btn-sm btn-info get-card">领 取</button>
          
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
  </div>
<?}?>
<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>


<script type="text/javascript">
    $(function(){
      $('.get-card').click(function(){
        var id = $(this).data('id');
        Discount.getCard(id);
      });
    });

</script>
<?php $this->load->view ( 'common/footer' )?> 