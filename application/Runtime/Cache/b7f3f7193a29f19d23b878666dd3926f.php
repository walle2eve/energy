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

<script type="text/javascript">
$(document).ready(function(){
//var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	$('select').select2({ width: 'resolve' });

  $('#submitBtn').bind('click',function(){
    var school_name = $('#school_name').val();
    var school_type = $('#school_type').val();
	
	if(school_code == '' || school_code == null){
		layer.msg('学校标识码不能为空',{icon:2});
		return false;
	}
	if(school_name == '' || school_name == null){
		layer.msg('学校名称不能为空，需区分大小写！',{icon:2});
		return false;
	}
	if(school_type == '' || school_type == null || school_type == 0){
		layer.msg('请选择学校类型！',{icon:2});
		return false;
	}

	var options = {
		success : function(response){
			if(response.errno != 0){
				layer.msg(response.errtitle,{icon:2});
				return false;
			}
			layer.alert(response.errtitle,{icon:1},function(){
			//	parent.layer.close(index);
				window.location.reload();
			});
		},
		error : function(){
			layer.msg('操作失败，请刷新后重试！',{icon:2});
			return false;
		}
	};
    $('#addForm').ajaxSubmit(options);
  });
  $("#school_code").numeral();
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
                  <td height="40" valign="top" class="right1">修改学校信息</td>
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
							  <td><form action="<?php echo U('Manager/editSchool');?>" method="post" id="addForm"><table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc;">
								<tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" bgcolor="#FFFFFF" ><font color="red">*</font>学校标识码：</td>
								  <td width="60%" align="center"  vertical-align="middle" bgcolor="#FFFFFF" ><input type="text" id="school_code" value="<?php echo ($info["school_code"]); ?>" maxlength="18"><input type="hidden" name="id" value="<?php echo ($info["school_id"]); ?>"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" vertical-align="middle" bgcolor="#FFFFFF" ><font color="red">*</font>学校名称：</td>
								  <td width="60%" align="center"  vertical-align="middle" bgcolor="#FFFFFF" ><input type="text" name="school_name" id="school_name" value="<?php echo ($info["school_name"]); ?>" maxlength="200"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" vertical-align="middle" bgcolor="#FFFFFF" >学校地址：</td>
								  <td width="60%" align="center"  vertical-align="middle" bgcolor="#FFFFFF" ><input type="text" name="address" id="address" value="<?php echo ($info["address"]); ?>" maxlength="255"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" vertical-align="middle" bgcolor="#FFFFFF" >地址编码：</td>
								  <td width="60%" align="center"  vertical-align="middle" bgcolor="#FFFFFF" ><input type="text" name="address_code" id="address_code" value ="<?php echo ($info["address_code"]); ?>" maxlength="40"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" vertical-align="middle" bgcolor="#FFFFFF" ><font color="red">*</font>学校类别：</td>
								  <td width="60%" align="center"  vertical-align="middle" bgcolor="#FFFFFF" >
									<select name="school_type" id="school_type" width="200px">
										<option value="0">请选择学校类别</option>
										<?php echo ($highSchoolTypeOptions); ?>
									</select>
								  </td>
								  </tr>
								<tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" vertical-align="middle" bgcolor="#FFFFFF" >学校所属单位：</td>
								  <td width="60%"  align="center"  vertical-align="middle" bgcolor="#FFFFFF" ><input type="text" name="unit_name" id="unit_name" value="<?php echo ($info["unit_name"]); ?>" maxlength="100"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" vertical-align="middle" bgcolor="#FFFFFF" >负责人部门：</td>
								  <td width="60%"  align="center"  vertical-align="middle" bgcolor="#FFFFFF" ><input type="text" name="manage_unit" id="manage_unit"  value="<?php echo ($info["manage_unit"]); ?>"maxlength="100"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" vertical-align="middle" bgcolor="#FFFFFF" >负责人姓名：</td>
								  <td width="60%" align="center"  vertical-align="middle" bgcolor="#FFFFFF" ><input type="text" name="manage_name" id="manage_name" value="<?php echo ($info["manage_name"]); ?>" maxlength="100"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" vertical-align="middle" bgcolor="#FFFFFF" >负责人电话：</td>
								  <td width="60%" align="center"  vertical-align="middle" bgcolor="#FFFFFF" ><input type="text" name="manage_phone" id="manage_phone" value="<?php echo ($info["manage_phone"]); ?>" maxlength="100"></td>
								  </tr>
								  <tr class="right22">
								  <td width="40%" height="36" line-height="36" align="center" vertical-align="middle" bgcolor="#FFFFFF" >负责人email：</td>
								  <td width="60%" align="center"  vertical-align="middle" bgcolor="#FFFFFF" ><input type="text" name="manage_email" id="manage_email" value="<?php echo ($info["manage_email"]); ?>" maxlength="100"></td>
								  </tr>
							  </table></td>
							</tr>
							<tr>
							  <td align="center"> <img id="submitBtn"  src="__PUBLIC__/images/tijiao.gif" /></td>
							</tr>
						  </table></form></td>
						</tr>
					  </table>
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