<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '醉南粉点餐系统' ,
	'funcname'=> 'menu'
));
?>
<h3 style="text-align:center;margin:25px 0;">欢迎使用醉南粉点餐系统</h3>
<div class="bs-glyphicons">
    <ul class="bs-glyphicons-list">
      
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
      <?if($sysData['role_id']==1||$sysData['role_id']==100){?>
        <li>
        	<a href="/index.php/report/index">
	          <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
	          <span class="glyphicon-class">数据统计</span>
	        </a>
        </li>
        <li>
        	<a href="/index.php/dish/index">
	          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
	          <span class="glyphicon-class">菜品管理</span>
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
<small>&copy; 醉南粉餐饮管理有限公司 V1.1</small>
</h6>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
