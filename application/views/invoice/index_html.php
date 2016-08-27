<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '我的报销' ,
	'funcname'=> 'invoice',
));
?>
<a href="/index.php/invoice/add"><button class="btn btn-primary btn-block" style="width:100%;margin-bottom:15px;"><span class="glyphicon glyphicon-plus"></span> 我要报销</button></a>
<?if(count($list)>0){?>
  <?foreach($list as $k=>$v){?>
  <div class="bs-example" data-id="<?=$v['id']?>">
      <table class="table ">
        <thead>
          <tr>
            <th><?=$v['invoiceTypeName']?></th>
            <th style="color:<?=$v['invoiceStatusColor']?>"><?=$v['invoiceStatusName']?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>金额：<?=$v['amount']?></td>
            <td><?=$v['ctime']?></td>
          </tr>
          <tr>
            <td colspan="2">事由：<?=$v['desc']?></td>
          </tr>
        </tbody>
      </table>
  </div>
  <?}?>
<?}?>

<script src="<?php echo $_cdn_host?>/resource/js/admin.js"></script>
<script>
  $('.bs-example').click(function(){
    var id = $(this).data('id');
    window.location.href='/index.php/invoice/show?id='+id;
  });

</script>

<?php $this->load->view ( 'common/footer' )?> 
