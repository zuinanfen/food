<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '醉南粉点餐系统' ,
	'funcname'=> 'menu'
));
?>
<h3 style="text-align:center;margin:25px 0;">欢迎使用<?=$sysData['shop_name']?>点餐系统</h3>
<div class="bs-glyphicons">
    <ul class="bs-glyphicons-list">
        <?if(in_array($sysData['role_id'], array(1,2,3,4,90,100))){?>
        <li >
          	<a href="/index.php/menu/index">
	          <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>
	          <span class="glyphicon-class">我要点餐</span>
          	</a>
        </li>
        <li>
        	<a href="/index.php/menu/chef">
	          <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
	          <span class="glyphicon-class">我要炒菜</span>
	         </a>
        </li>
      
        <li>
        	<a href="/index.php/menu/serving">
	          <span class="glyphicon glyphicon-glass" aria-hidden="true"></span>
	          <span class="glyphicon-class">我要上菜</span>
	         </a>
        </li>
        <li>
        	<a href="/index.php/menu/order">
	          <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
	          <span class="glyphicon-class">订单列表</span>
	        </a>
        </li>
        
        <?}?>
        <li>
          <a href="/index.php/reserve/index">
            <span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
            <span class="glyphicon-class">菜品预定</span>
           </a>
        </li>
      <?if(in_array($sysData['role_id'],array(1,90,100))){?>
        <li>
        	<a href="/index.php/report/index">
	          <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
	          <span class="glyphicon-class">订单统计</span>
	        </a>
        </li>
        <li>
        	<a href="/index.php/dish/index">
	          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
	          <span class="glyphicon-class">菜品管理</span>
	         </a>
        </li>
        <li>
          <a href="/index.php/income/index">
            <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
            <span class="glyphicon-class">收入记账</span>
           </a>
        </li>
         <li>
          <a href="/index.php/invoice/index">
            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
            <span class="glyphicon-class">报销管理</span>
           </a>
        </li>
        <li>
              <a href="/index.php/discount/listall">
                <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
                <span class="glyphicon-class">卡券管理</span>
              </a>
            </li>
            <?if($sysData['role_id']==100){?>
            <li>
                <a href="/index.php/user/index">
                  <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
                  <span class="glyphicon-class">用户管理</span>
                 </a>
            </li>

            <?}?>
        <?}?>
    </ul>
  </div>
<h6 class="text-center" style="bottom:0;position:absolute;width:100%">
<?
$this->load->view ('common/version');
?>
</h6>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
