<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv='Content-Type content="text/html; charset=utf-8"'>
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/layer/layer.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#submitBtn').click(function(){
    var link_man = $('#link_man').val();
    var link_phone = $('#link_phone').val();
    var link_email = $('#link_email').val();

    if($.trim(link_man) == ''){
      layer.alert('请填写姓名！',2);
      return false;
    }

    if($.trim(link_phone) == ''){
      layer.alert('请填写联系电话！',2);
      return false;
    }

    if($.trim(link_email) == ''){
      layer.alert('请填写email！',2);
      return false;
    }

    $('#editForm').submit();
  });
});
</script>
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
                  <td height="40" valign="top" class="right1">个人信息设置</td>
                </tr>
                <tr>
                  <td style="line-height:300%;">
					<form action="<?php echo U('User/editUserInfo');?>" method="post" id="editForm">
						姓名：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="link_man" id="link_man" value="<?php echo ($info["link_man"]); ?>" maxlength="30"><br />
						联系电话：&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="link_phone" id="link_phone" value="<?php echo ($info["link_phone"]); ?>" maxlength="40"><br />
						email：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="link_email" id="link_email" value="<?php echo ($info["link_email"]); ?>" maxlength="50"><br />
						<input type="button" id="submitBtn" value="确认修改"> <input type="reset" value="重置">
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