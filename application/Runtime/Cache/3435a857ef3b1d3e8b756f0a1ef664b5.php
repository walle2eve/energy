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
                  <td height="36" class="right1">选择数据对比方式</td>
                </tr>
                <tr>
                  <td height="54"></td>
                </tr>
			<form action="<?php echo U('Main/contrast');?>" method="get" NAME="changeForm">
			<input type="hidden" name="town" value="<?php echo ($town); ?>">
                <tr>
				  <td height="104" align="center">
				  <b><input type="radio" name="ct" value='unit' checked/>按单位对比</b>

				  <b style="margin-left:150px"><input type="radio" name="ct" value='time' />按时间对比</b>
				  </td> 
                </tr>
                <tr>
                  <td height="54"></td>
                </tr>
                <tr>
                  <td height="90" align="right1">　　　　　　　　　　　　　　　　　　　　　　　　　　<img src="__PUBLIC__/images/next.gif" width="100" height="29" border="0" style="padding-left:90px;cursor:pointer" onclick="changeForm.submit();"> 
				  </td>
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