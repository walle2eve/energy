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
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:14px;}
.right22 td{height:36px;text-align:center; vertical-align:middle;background:#fff;}
img{ cursor:pointer; }
</style>
<script type="text/javascript">
$(document).ready(function(){
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	//$('select').select2();
	$('#user_kind').change(function(){
		var kid = $(this).val();
		if(kid == '0' || kid == null || kid == undefined){
			layer.msg('您必须选择用户类别',{icon:2});
			return false;
		}
		
		$.post('<?php echo U('Ajax/getOrgs');?>',{user_kind:kid},function(response){
			if(response.errno != 0){
				layer.msg(response.errtitle,{icon:2});
				return false;
			}
			$('#org_id').empty();
			$('#org_id').val(null).trigger("change");
			$('#org_id').html("<option value=0>请选择账号所属单位</option>" + response.data);
		});
		return false;
	});
  $('#submitBtn').click(function(){
    var login_name = $('#login_name').val();
    var login_pwd = $('#login_pwd').val();
    var user_kind = $('#user_kind').val();
	var org_id = $('#org_id').val();

	
	if(login_name == '' || login_name == null){
		layer.msg('登录名不能为空',{icon:2});
		return false;
	}
	if(login_pwd == '' || login_pwd == null){
		layer.msg('登录密码不能为空，需区分大小写！',{icon:2});
		return false;
	}
	if(user_kind == '' || user_kind == null || user_kind == 0){
		layer.msg('请选择用户类型！',{icon:2});
		return false;
	}
	if(org_id == '' || org_id == null || org_id == 0){
		layer.msg('请选择用户所属单位！',{icon:2});
		return false;
	}
	var options = {
		success : function(response){
			if(response.errno != 0){
				layer.msg(response.errtitle,{icon:2});
				return false;
			}
			layer.alert(response.errtitle,{icon:1},function(){
				parent.layer.close(index);
			});
		},
		error : function(){
			layer.msg('操作失败，请刷新后重试！',{icon:2});
			return false;
		}
	};
    $('#addForm').ajaxSubmit(options);
  });
});
</script>
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
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="40" valign="top" class="right1">账号添加</td>
                </tr>
                <tr>
                  <td style="line-height:300%;">
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
						  <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="right3">
							<tr>
							  <td height="16"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
								  <td height="10">
								  </td>
								</tr>
							  </table>
							  </td>
							</tr>
							<tr height="14">
							  <td><form action="<?php echo U('Manager/addUser');?>" method="post" id="addForm"><table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc;">
								<tr class="right22">
								  <td width="40%" height="36" ><font color="red">*</font>登录名：</td>
								  <td width="60%" align="center"><input type="text" name="login_name" id="login_name"  maxlength="30"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36"><font color="red">*</font>登录密码：</td>
								  <td width="60%"><input type="text" name="login_pwd" id="login_pwd" maxlength="40"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36">单位地址：</td>
								  <td width="60%"><input type="text" name="address" id="address" maxlength="255"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36" bgcolor="#FFFFFF" ><font color="red">*</font>用户类别：</td>
								  <td width="60%">
									<select name="user_kind" id="user_kind">
									<option value="0">请选择用户类别</option>
									<?php if(is_array($user_kinds)): $i = 0; $__LIST__ = $user_kinds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["dict_id"]); ?>"><?php echo ($vo["dict_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
									</select>
								  </td>
								  </tr>
						
								<tr class="right22">
								  <td width="40%" height="36" ><font color="red">*</font>账号所属单位：</td>
								  <td width="60%">
									<select name="org_id" id="org_id">
									<option value="0">请选择账号所属单位</option>
									</select>
								  </td>
								  </tr>
							  </table></td>
							</tr>
							<tr>
							  <td align="center"> <img id="submitBtn"  src="__PUBLIC__/images/tijiao.gif"></td>
							</tr>
						  </table></form></td>
						</tr>
					  </table>
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