<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '我的报销' ,
	'funcname'=> 'invoice',
));
?>
<a href="/index.php/invoice/add"><button class="btn btn-primary btn-block" style="width:100%"><span class="glyphicon glyphicon-plus"></span> 我要报销</button></a>
<table class="table table-striped">
      <thead>
        <tr>
          <th>日期</th>
          <th>入账类型</th>
          <th>金额</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      <?foreach($list as $k=>$v){?>
        <tr>
          <td><?=$k?></td>
          <td><?=$typeName?></td>
          <td><?=$v?></td>
          <td>
          <a href="show?date=<?=$k?>"><button type="button" class="btn btn-sm btn-success">查看</button></a>
          </td>
        </tr>
        <?}?>
      </tbody>
    </table>
<script src="<?php echo $_cdn_host?>/resource/js/admin.js"></script>


<?php $this->load->view ( 'common/footer' )?> 
