<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '发放卡券' ,
	'funcname'=> 'discount',
));
?>
<div class="bs-example" data-id="<?=$discountInfo->id?>">
      <table class="table ">
        <thead>
          <tr>
            <th><?=$discountInfo->name?></th>
            <th><?=$discountType[$discountInfo->type]?> 
            </th>
          </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="2">号码：<b><?=$info->id?></b></td>
          </tr>
          <tr>
            <td>折扣：<?=$discountInfo->discount?></td>
            <td>过期时间：<?=$info->expire_time?></td>
          </tr>
          <?if($discountInfo->type==1){?>
          <tr>
            <td colspan="2">打折菜品名：<?=$discountInfo->dish_name?></td>
          </tr>
          <?}?>
          <tr>
            <td colspan="2">卡券说明：<?=$discountInfo->desc?></td>
          </tr>
          <tr>
            <td colspan="2"><img src="/index.php/discount/pic_show?id=<?=$info->id?>" width="100%"/></td>
          </tr>
        </tbody>
      </table>
  </div>

<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>



<?php $this->load->view ( 'common/footer' )?> 