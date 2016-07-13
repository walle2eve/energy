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

<script type="text/javascript">
//var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
$(document).ready(function(){
  $('#submitBtn').click(function(){
    var link_man = $('#link_man').val();
    var link_phone = $('#link_phone').val();
    var link_email = $('#link_email').val();

    if($.trim(link_man) == ''){
      layer.alert('请填写姓名！',{icon:2});
      return false;
    }

    if($.trim(link_phone) == ''){
      layer.alert('请填写联系电话！',{icon:2});
      return false;
    }

    if($.trim(link_email) == ''){
      layer.alert('请填写email！',{icon:2});
      return false;
    }
<?php if($user_kind != 301010): ?>var leader_man = $('#leader_man').val();
    var leader_phone = $('#leader_phone').val();
    var leader_email = $('#leader_email').val();

    if($.trim(leader_man) == ''){
      layer.alert('请填写信息填报负责人姓名！',{icon:2});
      return false;
    }

    if($.trim(leader_phone) == ''){
      layer.alert('请填写信息填报负责人联系电话！',{icon:2});
      return false;
    }

    if($.trim(leader_email) == ''){
      layer.alert('请填写信息填报负责人email！',{icon:2});
      return false;
    }<?php endif; ?>
    $('#editForm').submit();
  });
});
</script>
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
					<form action="<?php echo U('User/editUserInfo');?>" method="post">
						<table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc;">
								<tr class="right22">
								  <td width="40%" height="36" >姓名：</td>
								  <td width="60%" align="center"><input type="text" name="link_man" id="link_man" value="<?php echo ($info["link_man"]); ?>" maxlength="30"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36"><font color="red">*</font>联系电话：</td>
								  <td width="60%"><input type="text" name="link_phone" id="link_phone" value="<?php echo ($info["link_phone"]); ?>" maxlength="40"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36"><font color="red">*</font>email：</td>
								  <td width="60%"><input type="text" name="link_email" id="link_email" value="<?php echo ($info["link_email"]); ?>" maxlength="50"></td>
								  </tr>
								<?php if($user_kind != 301010): ?><tr class="right22">
								  <td width="40%" height="36" >信息上报负责人姓名：</td>
								  <td width="60%" align="center"><input type="text" name="leader_man" id="leader_man" value="<?php echo ($info["leader_man"]); ?>" maxlength="30"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36"><font color="red">*</font>信息上报负责人联系电话：</td>
								  <td width="60%"><input type="text" name="leader_phone" id="leader_phone" value="<?php echo ($info["leader_phone"]); ?>" maxlength="40"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36"><font color="red">*</font>信息上报负责人email：</td>
								  <td width="60%"><input type="text" name="leader_email" id="leader_email" value="<?php echo ($info["leader_email"]); ?>" maxlength="50"></td>
								  </tr><?php endif; ?>
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