<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv='Content-Type content="text/html; charset=utf-8"'>
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:14px;}

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
              <td valign="top"><table width="760" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="40" valign="top" class="right1">重置密码（请确认后再进行此操作）</td>
                </tr>
                <tr>
                  <td style="line-height:300%;">
					<form action="<?php echo U('User/setUserPass');?>" method="post">
						登录名：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="login_name" value="<?php echo ($login_name); ?>" readonly><br />
						新密码：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="newpass"><br />
						确认新密码：<input type="password" name="repass"><br />
						<input type="submit" value="确认修改"> <input type="reset" value="重置">
					</form>
				  </td>
                </tr>
              </table>
                </td>
            </tr>
        </table></td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height='1'></TD></TR>
</TABLE></BODY></HTML>