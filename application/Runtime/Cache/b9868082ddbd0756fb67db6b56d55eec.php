<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
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

<title>年度汇总数据上报——<?php echo C('SITE_SUBJECT');?></title>

<script>
$(function(){
	$("input").numeral();

	$('#submitbtn').bind('click',function (){
		var is_error = 0;
		$('input[type=text]').each(function(i,item){
			if(item.value==''){
				is_error++;
			}
		});
		$('select').each(function(i,item){
			if(item.value==0){is_error++;}
		});
		if(is_error >0){layer.alert('所有选项都不能为空',{icon:2});return false;}
		$('form').submit();
	});
});
</script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align='center' border=0 style="border:1px #9AD452 solid; background-color:##F3FFE3; margin-left:0px;"  height='100%'>
  <TR>
    <TD valign="top"><table align='center' width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="62" style="background-image:url(__PUBLIC__/images/right-bj.gif)"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="28"><img src="__PUBLIC__/images/right0.gif" width="16" height="13"></td>
            <td style="color:#43860C; font-size:16px; font-weight:bold;"><?php echo C('SITE_SUBJECT');?>数据<?php if(($ac) == "edit"): ?>修改<?php else: ?>上报<?php endif; ?>--区县年度汇总</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="480" valign="top" bgcolor="#F3FFE3"><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="16" bgcolor="#FFFFFF">&nbsp;
            </td>
          </tr>
        </table>
		<form action="" method="POST" id="addfrom">
			<?php if(($ac) == "edit"): ?><input type="hidden" name="id" value="<?php echo ($info["id"]); ?>"><?php endif; ?>
          <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" bgcolor="#FFFFFF"><table width="840" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="30" colspan="2" align="right">区县
					<label>
					<?php if(($ac) == "edit"): ?><input type="text" style="width:200px;" value="<?php echo ($info["town_name"]); ?>" disabled=true>
					<?php else: ?>
                      <select name="town_id" id="town_id" style=" width:204px;">
                        <option value="0">请选择区县</option>
						<?php echo ($townSelect); ?>
                      </select><?php endif; ?>
                    </label>
					</td>
                  <td colspan="2" align="right">年度
                    <label>
					<?php if(($ac) == "edit"): ?><input type="text" style="width:200px;" value="<?php echo ($info["year"]); ?>" disabled=true>
					<?php else: ?>
                      <select name="year" id="year" style="width:204px;">
                        <option>请选择</option>
						<?php echo ($years); ?>
                      </select><?php endif; ?>
                    </label>
					</td>
                </tr>
                <tr>
                  <td colspan="2" align="right">建筑面积（万平方米）
                    <label>
                      <input type="text" name="info_101001" id="info_101001"  style=" width:200px;" value="<?php echo ($info["info_101001"]); ?>">
                      <br>
                   <span  style="color:#999999;"> 建筑面积不包含教师住宅的住宅面积</span></label></td>
                  <td colspan="2" align="right">供暖面积（万平方米）
                    <input type="text" name="info_101038" id="info_101038"  value="<?php echo ($info["info_101038"]); ?>"  style="width:200px;">
                    <br />
                    <span style="color:#666666;">供暖面积不包含教师住宅面积</span></td>
					<!--
                  <td align="right">费用（万元）
                    <input type="text" name="info_101039" id="info_101039"   value="<?php echo ($info["info_101039"]); ?>" style=" width:80px;"></td>
					-->
                </tr>
                <tr>
                  <td colspan="2" align="right">用能教师数（人）
                    <input type="text" name="info_101002" id="info_101002"   style=" width:200px;"  value="<?php echo ($info["info_101002"]); ?>"></td>
				<td colspan="2" align="right">公车数量（辆）
                    <input type="text" name="info_101005" id="info_101005"  value="<?php echo ($info["info_101005"]); ?>"  style=" width:200px;"></td>
                </tr>
                <tr>
                  <td colspan="2" align="right">基中 编制人数（人）
                    <input type="text" name="info_101004" id="info_101004"  value="<?php echo ($info["info_101004"]); ?>"  style=" width:200px;"></td>
                  <td align="right">其中 编制数量（辆）
                    <input type="text" name="info_101006" id="info_101006"  value="<?php echo ($info["info_101006"]); ?>"  style=" width:40px;"></td>
					<td align="right">汽油车数量（辆）
                    <input type="text" name="info_101007" id="info_101007"  value="<?php echo ($info["info_101007"]); ?>"  style=" width:40px;"></td>
                <tr>
                  <td colspan="2" align="right">用能学生数（人）
                    <input type="text" name="info_101003" id="info_101003"  value="<?php echo ($info["info_101003"]); ?>"  style=" width:200px;"></td>
					<td height="28" align="right">柴油车数量（辆）
                    <input type="text" name="info_101008" id="info_101008"  value="<?php echo ($info["info_101008"]); ?>"  style=" width:40px;"></td>
					<td align="right">新能源车数量（辆）
                    <input type="text" name="info_101009" id="info_101009"  value="<?php echo ($info["info_101009"]); ?>"  style=" width:40px;"></td>
                </tr>

				<tr><td colspan="5" height="20px"><hr size=1 style="color: green;border-style:dashed ;width:100%"></td></tr>

                <tr>
                  <td align="right">水消耗量（万吨）
                    <input type="text" name="info_101012" id="info_101012"  value="<?php echo ($info["info_101012"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101013" id="info_101013"  value="<?php echo ($info["info_101013"]); ?>"  style=" width:80px;"></td>
				                  <td align="right">汽油消耗量（万升）
                    <input type="text" name="info_101022" id="info_101022"  value="<?php echo ($info["info_101022"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101023" id="info_101023"  value="<?php echo ($info["info_101023"]); ?>"  style=" width:80px;"></td>
				</tr>
                <tr>
                  <td align="right">其中中水消耗量（万吨）
                    <input type="text" name="info_101048" id="info_101048"  value="<?php echo ($info["info_101048"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101049" id="info_101049"  value="<?php echo ($info["info_101049"]); ?>"  style=" width:80px;"></td>
                  <td align="right">其中 车辆用油量（万升）
                    <input type="text" name="info_101024" id="info_101024"  value="<?php echo ($info["info_101024"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101025" id="info_101025"  value="<?php echo ($info["info_101025"]); ?>"  style=" width:80px;"></td>
				</tr>
                <tr>
                  <td align="right">总用电量（万千瓦时）
                    <input type="text" name="info_101010" id="info_101010"  value="<?php echo ($info["info_101010"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101011" id="info_101011"  value="<?php echo ($info["info_101011"]); ?>"  style=" width:80px;"></td>
                  <td align="right">其他用油（万升）
                    <input type="text" name="info_101026" id="info_101026"  value="<?php echo ($info["info_101026"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101027" id="info_101027"  value="<?php echo ($info["info_101027"]); ?>"  style=" width:80px;"></td>
				 </tr>
                <tr>
                  <td align="right">市电用电量
                    <input type="text" name="info_101044" id="info_101044"  value="<?php echo ($info["info_101044"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101045" id="info_101045"  value="<?php echo ($info["info_101045"]); ?>"  style=" width:80px;"></td>
                  <td align="right">柴油消耗量（万升）
                    <input type="text" name="info_101028" id="info_101028"  value="<?php echo ($info["info_101028"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101029" id="info_101029"  value="<?php echo ($info["info_101029"]); ?>"  style=" width:80px;"></td>
				</tr>
                <tr>
                  <td align="right">机房用电量
                    <input type="text" name="info_101042" id="info_101042"  value="<?php echo ($info["info_101042"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101043" id="info_101043"  value="<?php echo ($info["info_101043"]); ?>"  style=" width:80px;"></td>
                  <td align="right">其中 车辆用油量（万升）
                    <input type="text" name="info_101030" id="info_101030"  value="<?php echo ($info["info_101030"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101031" id="info_101031"  value="<?php echo ($info["info_101031"]); ?>"  style=" width:80px;"></td>
				</tr>
				<tr>
                  <td align="right">太阳能、水力风力等发电用电量
                    <input type="text" name="info_101046" id="info_101046"  value="<?php echo ($info["info_101046"]); ?>"  style=" width:80px;">
				</td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101047" id="info_101047"   value="<?php echo ($info["info_101047"]); ?>" style=" width:80px;"></td>
                  <td align="right">其他用油（万升）
                    <input type="text" name="info_101032" id="info_101032"  value="<?php echo ($info["info_101032"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101033" id="info_101033"  value="<?php echo ($info["info_101033"]); ?>"  style=" width:80px;"></td>
                </tr>
                <tr>
                  <td align="right">煤消耗量（万吨）
                    <input type="text" name="info_101014" id="info_101014"  value="<?php echo ($info["info_101014"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101015" id="info_101015"  value="<?php echo ($info["info_101015"]); ?>"  style=" width:80px;"></td>
                  <td align="right">煤油消耗量（万升）
                    <input type="text" name="info_101034" id="info_101034"  value="<?php echo ($info["info_101034"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101035" id="info_101035"  value="<?php echo ($info["info_101035"]); ?>"  style=" width:80px;"></td>
                </tr>
				<tr>
                  <td align="right">天然气消耗量（万立方米）
                    <input type="text" name="info_101016" id="info_101016"  value="<?php echo ($info["info_101016"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101017" id="info_101017"  value="<?php echo ($info["info_101017"]); ?>"  style=" width:80px;"></td>
                  <td align="right">热力消耗量（百万千焦耳）
                    <input type="text" name="info_101036" id="info_101036"  value="<?php echo ($info["info_101036"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101037" id="info_101037"  value="<?php echo ($info["info_101037"]); ?>"  style=" width:80px;"></td>
                </tr>
				<tr>
                 <td align="right">液化石油气消耗量（吨）
                    <input type="text" name="info_101018" id="info_101018" style=" width:80px;"  value="<?php echo ($info["info_101018"]); ?>"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101019" id="info_101019" style=" width:80px;"  value="<?php echo ($info["info_101019"]); ?>"></td>
                  <td align="right">其他能源消耗量（吨标准煤）                    
					<input type="text" name="info_101040" id="info_101040"  value="<?php echo ($info["info_101040"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101041" id="info_101041"  value="<?php echo ($info["info_101041"]); ?>"  style=" width:80px;"></td>
                </tr>

				<tr>
					<td align="right">人工煤气消耗量（万升）
                    <input type="text" name="info_101020" id="info_101020"  value="<?php echo ($info["info_101020"]); ?>"  style=" width:80px;"></td>
                  <td align="right">费用（万元）
                    <input type="text" name="info_101021" id="info_101021"  value="<?php echo ($info["info_101021"]); ?>"  style=" width:80px;"></td>
				</tr>
				
                <tr>
                  <td height="20" colspan="4">
                  </td>
                  </tr>
                <tr>
                  <td colspan="4" align="center"><img src="__PUBLIC__/images/tijiao.gif" width="100" height="29" id="submitbtn"></td>
                </tr>
                <tr>
                  <td colspan="4" align="center">&nbsp;</td>
                </tr>
                </table></td>
            </tr>
          </table>
		</form>  
		 </td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height='1'></TD></TR>
</TABLE></BODY></HTML>