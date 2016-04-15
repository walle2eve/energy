<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<title>对比————<?php echo C('SITE_SUBJECT');?></title>
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:14px;}
</style>
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
                  <td height="16">
                  </td>
                </tr>
                <tr>
                  <td height="36" class="right1">按<?php if(($ct) == "time"): ?>时间<?php else: ?>单位<?php endif; ?>对比</td>
                </tr>
                <tr>
                  <td height="44" class="right2">选择对比区县</td>
                </tr>
				<form action="<?php echo U('Main/contrast');?>" method="get" name="form_unit_time" onsubmit="return checkForm(this)">
				<input type="hidden" name="ct" value="<?php echo ($ct); ?>">
                <tr>
                  <td>　<p>
						<?php if(is_array($townList)): $i = 0; $__LIST__ = $townList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="<?php echo ($parm["unitFormType"]); ?>" name="<?php echo ($parm["unitFormName"]); ?>" value="<?php echo ($vo["town_id"]); ?>" id="checkbox">
                          <?php echo ($vo["town_name"]); ?>    &nbsp;&nbsp;&nbsp;&nbsp;　
							<?php if(($i%6) == "0"): ?></p><p><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</p>
					</td>
                </tr>
                <tr>
                  <td height="54" class="right2">选择对比时间</td>
                </tr>
                <tr>
                  <td>
					<p>
						<?php if(is_array($timeList)): $i = 0; $__LIST__ = $timeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="<?php echo ($parm["timeFormType"]); ?>" name="<?php echo ($parm["timeFormName"]); ?>" value="<?php echo ($vo["year"]); ?>_<?php echo ($vo["quarter"]); ?>">
                          <?php echo ($vo["yearStr"]); ?>    &nbsp;&nbsp;&nbsp;&nbsp;　
							<?php if(($i%4) == "0"): ?></p><p><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</p>
					</td>
                </tr>
                <tr>
                  <td height="90">　　　　　　　　　　　　　　　　　　　　　　　　　　　　　<a href="javascript:history.go(-1);"><img src="__PUBLIC__/images/bak.gif" width="100" height="29" border="0"></a>　 <a href="javascript:form_unit_time.submit();"><img src="__PUBLIC__/images/next.gif" width="100" height="29" border="0"></a></td>
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
    <TD bgColor='#b1ceef' height=1></TD></TR>
</TABLE></BODY></HTML>