<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv='Content-Type content="text/html; charset=utf-8"'>
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:14px;}
.right22 td{text-align:center; vertical-align:middle;background:#fff;}
</style>
<title><?php echo C('SITE_SUBJECT');?></title></HEAD>
<BODY>
<TABLE cellSpacing='0' cellPadding='0' width="100%" align='center' border='0' style="border:1px #9AD452 solid; background-color:##F3FFE3; margin-left:0px;"  height='100%'>
  <TR>
    <TD valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="62" style="background-image:url(__PUBLIC__/images/right-bj.gif)">&nbsp;</td>
      </tr>
      <tr>
        <td height="480" valign="top" bgcolor="#F3FFE3"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td valign="top">
					<form action="<?php echo U('User/editPass');?>" method="post">
						<table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc;">
								<tr class="right22">
								  <td width="40%" height="36" >登录名：</td>
								  <td width="60%" align="center"><input type="text" name="login_name" value="<?php echo ($login_name); ?>" readonly></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36"><font color="red">*</font>原密码：</td>
								  <td width="60%"><input type="password" name="oldpass" maxlength="40"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36"><font color="red">*</font>新密码：</td>
								  <td width="60%"><input type="password" name="newpass" maxlength="40"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36">确认新密码：</td>
								  <td width="60%"><input type="password" name="repass" maxlength="255"></td>
								  </tr>

						</table></td>
							</tr>
							<tr>
							  <td align="center"> <input type="image" id="submitBtn"  src="__PUBLIC__/images/tijiao.gif"></td>
							</tr>
						  </table></form>
					</form>
                </td>
            </tr>
        </table></td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height='1'></TD></TR>
</TABLE></BODY></HTML>