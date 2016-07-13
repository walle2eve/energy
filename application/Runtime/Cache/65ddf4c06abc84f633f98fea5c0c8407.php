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

<title>各单位上报情况——<?php echo C('SITE_SUBJECT');?></title>
<style>
.right22{ font-size:13px; color:#43860C; font-weight:bold; line-height:180%;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	//$('select').select2();
	$('#town_id').bind('change',function(){
		var town_id = $('#town_id').val();
		if(town_id == 0 || town_id == '' || town_id == null){
			return false;
		}
		$.post('<?php echo U('Ajax/getYearQuarter');?>',{town_id:town_id},function(response){
			if(!response || response == '' || response == null){
				layer.msg('当前区县无上报数据！',{icon:2});
				return false;
			}
			$('#year_quarter').html('<option value="">--上报时间段--</option>' + response);
			$('#year_quarter').val("").trigger("change");
		});
	});
	$('#submitBtn').bind('click',function(){
		var town_id = $('#town_id').val();
		var year_quarter = $('#year_quarter').val();
		if(town_id == 0 || town_id == '' || town_id == null){
			layer.msg('请选择要查看的区县单位！',{icon:2});
			return false;
		}
		if(year_quarter == 0 || year_quarter == '' || year_quarter == null){
			layer.msg('请选择要查看的时间段！',{icon:2});
			return false;
		}
		$('form').submit();
	});
});
</script>
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
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#cccccc;">
                    <tr class="right22">
					<form action="<?php echo U('Manager/showAddStatus');?>">
                      <td height="36" width="60%" align="left" bgcolor="#FFFFFF">
							&nbsp;&nbsp;&nbsp;
						  <select name="town_id" id="town_id"><option value="">--请选择区县--</option>
						  <?php echo ($townSelect); ?>
						  </select>
							&nbsp;&nbsp;
						  <select name="year_quarter" id="year_quarter">
						  <option value="">--上报时间段--</option>
						  <?php echo ($yearSelect); ?>
						  </select>
						  &nbsp;&nbsp;
						  <select name="add_status" id="add_status">
						  <option value="0">--上报状态--</option>
						  <option value="1" <?php if(($add_status) == "1"): ?>selected<?php endif; ?>>已上报</option>
						  <option value="-1" <?php if(($add_status) == "-1"): ?>selected<?php endif; ?>>未上报</option>
						  </select>
						  &nbsp;&nbsp;
					  </td>
					  </form>
                      <td width="" align="left" valign="middle" bgcolor="#FFFFFF" style="line-height:36px">
						<input type="image" id="submitBtn" src="__PUBLIC__/images/tijiao.gif" style="margin-bottom:5px;" />
					  </td>
                      </tr>
					 </table>
					<table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc;">
                    <tr class="right22">
                      <td width="12%" height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">管理单位</td>
                      <td width="11%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">学校标识码</td>
                      <td width="25%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">学校或单位名称</td>
                      <td width="6%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">办学类型</td>
                      <td width="5%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">上报状态</td>
					  <td width="10%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">上报时间段</td>
                      <td width="15%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">数据上报时间</td>
					  <td width="8%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">负责人</td>
					  <td width="8%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">负责人电话</td>
                      <!--<td  height="26" colspan="2" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">操作</td>-->
                      </tr>
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td align="center" height="36"  bgcolor="#FFFFFF"><?php echo ($vo["town_name"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["school_code"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["school_name"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["school_type_name"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF">
					  <?php if($vo[countid] > 0): ?><font color="green">已上报</font><?php else: ?><font color="red">未上报</font><?php endif; ?>
					  </td>
                      <td align="center" bgcolor="#FFFFFF">
					  <?php if($vo['town_id'] == '110000' OR $vo['town_id'] == '110100'): echo ($year); ?>年<?php echo ($quarter); ?>季度
					  <?php else: ?>
					  <?php echo ($year); ?>年<?php if(($quarter) == "2"): ?>下<?php else: ?>上<?php endif; ?>半年<?php endif; ?>
					  </td>
					  <td align="center" bgcolor="#FFFFFF">
						<?php echo ($vo["add_time"]); ?>
					  </td>
					  <td align="center" bgcolor="#FFFFFF">
						<?php echo ($vo["link_man"]); ?>
					  </td>
					  <td align="center" bgcolor="#FFFFFF">
						<?php echo ($vo["link_phone"]); ?>
					  </td>
						<!--<td colspan="2" align="center" bgcolor="#FFFFFF"><a href="<?php echo U('Main/addInfo');?>" >上报</a></td>-->
					  
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
$('.contrast').bind('click',function (){
	var iframeUrl = '<?php echo U("Main/contrast_t");?>';
	$.layer({
		type : 2,
		title : '选择数据对比',
		iframe : {src : iframeUrl },
		area : ['800px' , '600px'],
		offset : ['50px','']
	});
});
</script>
</HTML>