<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="__PUBLIC__/js/lhgcalendar/jquery-1.7.1.min.js"></script>
<title>对比————<?php echo C('SITE_SUBJECT');?></title>
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{ font-size:14px;}
</style>
<script type="text/javascript">
function checkForm(){
	var errnum = 0;
	$('input[type=radio]').each(function (i,item){
		if(item.checked == true || item.checked == 'checked')errnum++;
	});
	if(errnum==0){
		alert('请选择要对比的单位');
		return false;
	}
	return true;
}
</script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align='center' border=0 style="border:1px #9AD452 solid; background-color:##F3FFE3; margin-left:0px;"  height='100%'>
  <TR>
    <TD valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="62" style="background-image:url(__PUBLIC__/images/right-bj.gif)"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="28"><img src="__PUBLIC__/images/right0.gif" width="16" height="13"></td>
            <td style="color:#43860C; font-size:16px; font-weight:bold;"><?php echo C('SITE_SUBJECT');?>数据统计分析</td>
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
              <td bgcolor="#FFFFFF"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0" class="right3">
                <tr>
                  <td height="16" width="200">
                  </td><td><td>
                </tr>
                <tr>
                  <td height="36"></td>
                </tr>
                <tr>
                  <td height="44" class="right2" width="100" align="center">选择数据对比项</td>
                </tr>
				<form action="<?php echo U('Main/contrast_show');?>" method="post" name="form_info_unit" onsubmit="return checkForm()" target="_blank">
				<input type="hidden" name="town" value="<?php echo ($town); ?>" />
				<tr>
				<td height="300">
					<table width="96%" border="0" align="right" cellpadding="0" cellspacing="0" >	
					<tr><td><input type="radio" name="infounit" value="101001">建筑面积（万平方米）</td><td></td><td><input type="radio" name="infounit" value="101018">液化石油气消耗量（吨）</td><td><input type="radio" name="infounit" value="101019">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101002">用能教师数（人）</td><td></td><td><input type="radio" name="infounit" value="101020">人工煤气消耗量（万升）</td><td><input type="radio" name="infounit" value="101021">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101003">用能学生数（人）</td><td></td><td><input type="radio" name="infounit" value="101022">汽油消耗量（万升）</td><td><input type="radio" name="infounit" value="101023">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101004">其中 编制人数（人）</td><td></td><td><input type="radio" name="infounit" value="101024">其中 车辆用油量（万升）</td><td><input type="radio" name="infounit" value="101025">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101005">公车数量（辆）</td><td></td><td><input type="radio" name="infounit" value="101026">其他用油（万升）</td><td><input type="radio" name="infounit" value="101027">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101006">其中 编制数量（辆）</td><td></td><td><input type="radio" name="infounit" value="101028">柴油消耗量（万升）</td><td><input type="radio" name="infounit" value="101029">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101007">汽油车数量（辆）</td><td></td><td><input type="radio" name="infounit" value="101030">其中 车辆用油量（万升）</td><td><input type="radio" name="infounit" value="101031">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101008">柴油车数量（辆）</td><td></td><td><input type="radio" name="infounit" value="101032">其他用油（万升）</td><td><input type="radio" name="infounit" value="101033">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101009">新能源车数量（辆）</td><td></td><td><input type="radio" name="infounit" value="101034">煤油消耗量（万升）</td><td><input type="radio" name="infounit" value="101035">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101010">电消耗量（万千瓦时）</td><td><input type="radio" name="infounit" value="101011">费用（万元）</td><td><input type="radio" name="infounit" value="101036">热力消耗量（百万千焦耳）</td><td><input type="radio" name="infounit" value="101037">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101042">其中 机房用电量</td><td><input type="radio" name="infounit" value="101043">费用（万元）</td><td><input type="radio" name="infounit" value="101038">供暖面积（万平方米）</td><td><!--<input type="radio" name="infounit" value="101039">费用（万元）--></td></tr>
					<tr><td><input type="radio" name="infounit" value="101012">水消耗量（万吨）</td><td><input type="radio" name="infounit" value="101013">费用（万元）</td><td><input type="radio" name="infounit" value="101040">其他能源消耗量（万吨）</td><td><input type="radio" name="infounit" value="101041">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101014">煤消耗量（万吨）</td><td><input type="radio" name="infounit" value="101015">费用（万元）</td><td><input type="radio" name="infounit" value="101098">综合能耗</td><td><input type="radio" name="infounit" value="101099">费用（万元）</td></tr>
					<tr><td><input type="radio" name="infounit" value="101016">天然气消耗量（万立方米）</td><td><input type="radio" name="infounit" value="101017">费用（万元）</td><td></td><td></td></tr>
					</table>
				</td>
				</tr>
                <tr>
                  <td height="90">　　　　　　　　　　　　　　　　　　　　　　　　　　　　　
				  <a href="javascript:history.go(-1);"><img src="__PUBLIC__/images/bak.gif" width="100" height="29" border="0"></a>　 <a href="javascript:form_info_unit.submit();"><img src="__PUBLIC__/images/next.gif" width="100" height="29" border="0"></a></td>
                </tr>
				</form>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height='1'></TD></TR>
</TABLE></BODY></HTML>