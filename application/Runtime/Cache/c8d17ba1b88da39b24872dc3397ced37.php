<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo C('SITE_SUBJECT');?></title>
<style>
.login{ font-size:14px; color:#71AA28; }
.imgBtn{ cursor:pointer; }
</style>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/layer/layer.min.js"></script>
<script type="text/javascript">
$(document).ready(function (){
	var num = 0;
	$('#pass').focus(function (){
		//return false;
		if(num == 0){
    layer.tips('如您在登陆系统时，发现密码错误，请发邮件到jnjp2016@163.com申请重置，发邮件时请写明单位名称！', '#user', {
        style: ['background-color:#78BA32; color:#fff', '#78BA32'],
        maxWidth:200,
        time: 10,
        closeBtn:[0, true]
    });
		//num = 1;
		}
	});
});
function checkform(){
	var user = document.getElementById('user').value;
	var pass = document.getElementById('pass').value;
	if(user==''||pass==''){
		layer.alert('用户名和密码不能为空');
		return false;
	}
	document.getElementById('loginForm').submit();
}
</script>
</head>

<body style="background-image:url(__PUBLIC__/images/login-bj.jpg)">
<table width="487" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="131">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><img src="__PUBLIC__/images/name.png" width="427" height="79" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="355" align="center" valign="top" style="background-image:url(__PUBLIC__/images/login.jpg)">
	<form action="<?php echo U('User/login');?>" method="POST" name="loginForm" id="loginForm">
	<table width="430" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="210" height="100">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="34" align="left" class="login">用户 
          <label>
            <input name="username" type="text" id="user" size="18" />
          </label></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="34" align="left" class="login">密码
          <input name="password" type="password" id="pass" size="18" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="40" align="left">　　&nbsp;<img src="__PUBLIC__/images/dl.gif" width="40" height="22" border="0" class="imgBtn" onclick="return checkform()"/><img src="__PUBLIC__/images/cz.gif" width="41" height="22" border="0"  class="imgBtn" onclick="javascript:document.getElementById('loginForm').reset();"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
	</td>
  </tr>
</table>
</body>
</html>