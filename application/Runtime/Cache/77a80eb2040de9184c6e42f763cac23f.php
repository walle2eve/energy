<?php if (!defined('THINK_PATH')) exit();?><HTML><HEAD>
<META http-equiv='Content-Type content="text/html; charset=utf-8"'>
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<LINK href="__PUBLIC__/css/select2.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="__PUBLIC__/js/lhgcalendar/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/lhgcalendar/lhgcalendar.min.js"></script>
<script src="__PUBLIC__/js/select2.min.js"></script>
<script src="__PUBLIC__/js/layer/layer.js"></script>
<script src="__PUBLIC__/js/number.js"></script>
<script src="__PUBLIC__/js/jquery.form.js"></script>
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:14px;}
.right22 td{line-height:180%;}
img{ cursor:pointer; }
</style>

<title>设置单价——<?php echo C('SITE_SUBJECT');?></title>
<style>
.right22{ font-size:13px; color:#43860C; font-weight:bold; line-height:180%;}
</style>

</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align='center' border='0' style="border:1px #9AD452 solid; background-color:##F3FFE3; margin-left:0px;"  height='100%'>
  <TR>
    <TD valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="62" style="background-image:url(__PUBLIC__/images/right-bj.gif)"><table width="96%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="10%"><img src="__PUBLIC__/images/right0.gif" width="16" height="13"></td>
            <td width="62%" height="60" align="left" style="color:#43860C; font-size:16px; font-weight:bold;"><?php echo C('SITE_SUBJECT');?></td>
            <td align="" valign="bottom" style="color:#43860C; font-size:16px; font-weight:bold;">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="480" valign="top" bgcolor="#F3FFE3"><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="8">
            </td>
          </tr>
        </table>
          <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0" class="right3">
                <tr>
                  <td height="16"><table width="760" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="10">
                      </td>
                    </tr>
                  </table>
                  </td>
                </tr>
                <tr>
                  <td>
					<table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc;">
                    <tr class="right22">
                      <td width="7%" height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">能源ID</td>
                      <td width="9%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">能源名称</td>
                      <td width="10%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">平均低位发热量</td>
                      <td width="6%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">单位</td>
                      <td width="9%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">折标准煤系数</td>
					  <td width="11%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">单位</td>
                      <td width="7%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">描述</td>
					  <td width="8%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">单位系数</td>
					  <td width="8%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">最小单价</td>
					  <td width="8%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">最大单价</td>
					  <td width="8%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">单价单位</td>
					   <td width="8%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">操作</td>
                      </tr>
				<?php if(is_array($stdlists)): $i = 0; $__LIST__ = $stdlists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					  <td align="center" height="36"  bgcolor="#FFFFFF"><?php echo ($vo["std_id"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["std_name"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["pjdwfrl"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["pjdwfrldw"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF">
					  <?php echo ($vo["zbzmxs"]); ?>
					  </td>
                      <td align="center" bgcolor="#FFFFFF">
					  <?php echo ($vo["zbzmxsdw"]); ?>
					  </td>
					  <td align="center" bgcolor="#FFFFFF">
						<?php echo ($vo["zbzmxsdwmc"]); ?>
					  </td>
					  <td align="center" bgcolor="#FFFFFF">
						<?php echo ($vo["coef"]); ?>
					  </td>
					  <td align="center" bgcolor="#FFFFFF">
						<input type="text" name="min_price" value="<?php echo ($vo["min_price"]); ?>" data="<?php echo ($vo["min_price"]); ?>" style="width:50px"/>
					  </td>
					  <td align="center" bgcolor="#FFFFFF">
						<input type="text" name="max_price" value="<?php echo ($vo["max_price"]); ?>" data="<?php echo ($vo["max_price"]); ?>" style="width:50px"/>
					  </td>
					  <td align="center" bgcolor="#FFFFFF">
						<?php echo ($vo["price_unit"]); ?>
					  </td>
					  <td align="center" bgcolor="#FFFFFF">
						<a href="javascript:void(0);" class="editPrice" data="<?php echo ($vo["std_id"]); ?>">修改</a>
					  </td>					  
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                  </table></td>
                </tr>
                <tr>
                  <td height="60"><?php echo ($page); ?></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height='1'></TD></TR>
</TABLE></BODY>
<script type="text/javascript">
$(function(){
	$("input").numeral();
	$('.editPrice').on('click',function(){
		//console.log($(this).attr('data'));
		var min_price;
		var min_price_base;
		var max_price;
		var max_price_base;
		var st = $(this).attr('data');
		if(!st){
			layer.alert('参数错误，请刷新后重试！',{icon:2});return false;
		}
		var content = $(this).parent().parent().find('input');
		$.each(content,function(i,index){
			//console.log($(this).attr('name'));
			if($(this).attr('name') == 'min_price'){
				min_price = parseFloat($(this).val());
				min_price_base = $(this).attr('data');
			}else if($(this).attr('name') == 'max_price'){
				max_price = parseFloat($(this).val());
				max_price_base = $(this).attr('data');
			}
		});
		if(min_price == 'undefined' || max_price == 'undefined'){
			layer.alert('参数错误，请刷新后重试！',{icon:2});return false;
		}
		if(min_price == min_price_base && max_price == max_price_base){
			layer.alert('无修改！',{icon:2});return false;
		}
		if(min_price == 0 || max_price == 0){
			layer.alert('设置的单价区间不可以从0开始！',{icon:2});return false;
		}
		if(min_price > max_price){
			layer.alert('设置的最小值不能大于最大值',{icon:2});return false;
		}
		$.post('<?php echo U('Manager/setStd');?>', {st:st,min_price:min_price,max_price:max_price}, function(result){
			if(result.errno==0){
				layer.alert('修改成功！！',{icon:1});return true;
			}else{
				layer.alert(result.errtitle,{icon:2});return false;
			}
		});
	});
});
</script>
</HTML>