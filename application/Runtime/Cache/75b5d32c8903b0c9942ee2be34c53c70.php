<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<title>管理页面-<?php echo C('SITE_SUBJECT');?></title>
<style type="text/css">
.headMenu{
	font-size: 12px;
	height:28px;
	line-height:12px;
	
	/**vertical-align:bottom;**/
}
.headMenu a{
	color:#000;
	text-decoration:none;
}
.headMenu a:hover{
	color:#000;
	text-decoration:none;
}
.headMenu a:link{
	color:#000;
	text-decoration:none;
}
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="97" height="61" style="background-image:url(__PUBLIC__/images/top1.gif)"><table width="97" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40" height="34">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td style="font-size:12px; color:#43860C"><?php echo ($login_name); ?></td>
      </tr>
    </table></td>
    <td width="546" style="background-image:url(__PUBLIC__/images/top2.gif)">&nbsp;</td>
    <td style="background-image:url(__PUBLIC__/images/top-bj.gif);text-align:right;padding-right:20px;">&nbsp;<p class="headMenu"><a href="<?php echo U('Main/showAddStatus');?>" target="main">首页</a>&nbsp;&nbsp;
	<?php if(($user_kind) == "301010"): ?><!--<a href="<?php echo U('Main/setStandard');?>" target="main">设置达标标准</a>--><a href="<?php echo U('Manager/setStd');?>" target="main">设置单价</a>&nbsp;&nbsp;<?php endif; if($user_kind == 301010 OR $user_kind == 301020): ?><a href="<?php echo U('Main/manager');?>" target="main">用户管理</a>&nbsp;&nbsp;<?php endif; ?>
	<a href="<?php echo U('Index/editUserInfo');?>" target="main">个人信息</a>&nbsp;&nbsp;
	<a href="<?php echo U('Index/editPass');?>" target="main">修改密码</a>&nbsp;&nbsp;<a href="<?php echo U('Index/logout');?>" target="_parent">退出登录</a></p></td>
    <td width="200" style="background-image:url(__PUBLIC__/images/top3.gif)"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="10" colspan="2"></td>
        </tr>
      <tr>
        <td width="24">&nbsp;</td>
        <td style=" font-size:12px; color:#43860C"><span id='localtime'></span>	
<script type="text/javascript"  charset="utf-8">
function showLocale(objD)
{
	var str,colorhead,colorfoot;
	var yy = objD.getYear();
	if(yy<1900) yy = yy+1900;
	var MM = objD.getMonth()+1;
	if(MM<10) MM = '0' + MM;
	var dd = objD.getDate();
	if(dd<10) dd = '0' + dd;
	var hh = objD.getHours();
	if(hh<10) hh = '0' + hh;
	var mm = objD.getMinutes();
	if(mm<10) mm = '0' + mm;
	var ss = objD.getSeconds();
	if(ss<10) ss = '0' + ss;
	var ww = objD.getDay();
	if  ( ww==0 )  colorhead="<font color=\"#FF0000\">";
	if  ( ww > 0 && ww < 6 )  colorhead="<font color=\"#373737\">";
	if  ( ww==6 )  colorhead="<font color=\"#008000\">";
	if  (ww==0)  ww="星期日";
	if  (ww==1)  ww="星期一";
	if  (ww==2)  ww="星期二";
	if  (ww==3)  ww="星期三";
	if  (ww==4)  ww="星期四";
	if  (ww==5)  ww="星期五";
	if  (ww==6)  ww="星期六";
	colorfoot="</font>"
	str = colorhead + yy + "-" + MM + "-" + dd + " " + hh + ":" + mm + ":" + ss + "  " + ww + colorfoot;
	return(str);
}
function tick()
{
	var today;
	today = new Date();
	document.getElementById("localtime").innerHTML = showLocale(today);
	window.setTimeout("tick()", 1000);
}
tick();
</script>
</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>