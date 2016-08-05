<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '菜品清单' ,
	'funcname'=> 'menu'
));
?>
<table class="table" >
    <thead>
      <tr>
        <th style="text-align:center">来源</th>
        <th style="text-align:center">菜名</th>
      </tr>
    </thead>
    <tbody>
    	<tr>
    		<td id="chef_dish_list" colspan="2">
    			


    		</td>
    	</tr>
     
	</tbody>
</table>


<script id="dishListHtml" type="text/html">
	<%for(var i=0;i<list.length;i++){ var v=list[i];%>
	<div id="<%=v['id']%>" class="chef_list" <%if(v['status']==1){%>style="border-color:#eea236"<%}%>>
		<table class="table">
	    
	    <tbody>

	      <tr>
	        <td style="color:#5cb85c;font-weight:bold"><%=v['sourceName']%><%if(v['source']==1){%>(<%=v['table_id']%>号	)<%}%></td>
	        <td><b><%=v['name']%></b></td>
	      </tr>
	      <%if(v['select_options'].length>0){%>
	      <tr>
	        <td colspan="2">
	        <%for(j=0;j<v['select_options'].length;j++) {var value=v['select_options'][j];%>
	        &nbsp;<%=value['name']%>
				<%if(value['price']!=0){%>(<%=value['price']%>)<%}%>
				&nbsp;

			<%}%>	
	        </td>
	      </tr>
	      <%}%>
	    </tbody>
	  </table>
	</div>

<%}%>
</script>

<script>
$(document).ready(function(){
	Chef.init();
});

</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
