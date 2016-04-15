<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv='Content-Type content="text/html; charset=utf-8"'>
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<LINK href="__PUBLIC__/css/select2.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="__PUBLIC__/js/lhgcalendar/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/lhgcalendar/lhgcalendar.min.js"></script>
<script src="__PUBLIC__/js/select2.min.js"></script>

<title>用户登录密码管理——<?php echo C('SITE_SUBJECT');?></title>
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:14px;}
#submitbtn{ cursor:pointer; }
</style>

<script>
$(function(){
	$('select').select2();
	$('#town_id').bind('change',function(){
		$('#school_id').empty();
		var town_id = this.value;
		if(town_id == 0)return false;
		url = "<?php echo U('Ajax/getSchoolSelect');?>";
		url += '?town_id='+town_id;
		$.get(url, function(result){
			if(result.errno==0){
				$('#school_id').html('<option value=0>请选择学校</option>'+result.data);
			}else{
				alert(result.errtitle);return false;
			}
		});
	});
	/**
	$('#school_id').bind('change',function (){
		$('#school_type').empty();
		$('#school_code').empty();
		var school_id = this.value;
		if(school_id == 0)return false;
		url = "<?php echo U('Ajax/getSchoolOtherInfo');?>";
		url += '?school_id='+school_id;
		$.get(url, function(result){
			if(result.errno==0){
				$('#school_type').html('<option value='+result.data.school_type+'>'+result.data.school_type_name+'</option>');
				$('#school_code').html('<option value='+result.data.school_code+'>'+result.data.school_code+'</option>');
			}else{
				alert(result.errtitle);return false;
			}
		});
	});
	*/
	$('#submitbtn').bind('click',function (){
		if($("#town_id").val() == 0 || ($("#town_id").val() == 110000 && $("#school_id").val() == 0)){
			alert('请选择要管理的用户');
			return false;
		}
		$('form').submit();
	});
});
</script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align='center' border=0 style="border:1px #9AD452 solid; background-color:##F3FFE3; margin-left:0px;"  height='100%'>
  <TR>
    <TD valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="62" style="background-image:url(__PUBLIC__/images/right-bj.gif)"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="28"><img src="__PUBLIC__/images/right0.gif" width="16" height="13"></td>
            <td style="color:#43860C; font-size:16px; font-weight:bold;"><?php echo C('SITE_SUBJECT');?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="480" valign="top" bgcolor="#F3FFE3"><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="16" bgcolor="#FFFFFF">&nbsp;
            </td>
          </tr>
        </table>
		
          <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" bgcolor="#FFFFFF"><table width="840" border="0" cellspacing="0" cellpadding="0">
			  <form action="" method="get" id="addfrom">
                <tr>
                  <td height="30" colspan="1" align="right">区县&nbsp;&nbsp;&nbsp;
					<label>
                      <select name="town_id" id="town_id" style="width:144px;">
                        <option value="0">请选择区县</option>
						<?php echo ($townSelect); ?>
                      </select>
                    </label>
				  </td>
                  <td height="30" colspan="1" align="left">&nbsp;&nbsp;&nbsp;学校&nbsp;&nbsp;&nbsp;
					<select name="school_id" id="school_id"  style="width:244px;">
                      <option value="0">请选择学校</option>
					  <?php echo ($schoolSelect); ?>
                    </select>
					</td>
					<td colspan="2" align="left"><img src="__PUBLIC__/images/tijiao.gif" width="100" height="29" id="submitbtn"></td>
                </tr>
				</form> 
                <tr>
                  <td height="20" colspan="4">
                  </td>
                  </tr>
                <tr>
                  
                </tr>
                <tr>
					<td colspan="4" align="left">
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
						  <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="right3">
							<tr>
							  <td height="16"><table width="760" border="0" cellspacing="0" cellpadding="0">
								<tr>
								  <td height="10">
								  </td>
								</tr>
							  </table>
							  </td>
							</tr>
							<tr>
							  <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc;">
								<tr class="right22">
								  <td width="56" height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">用户ID</td>
								  <td width="91"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">登录名</td>
								  <td width="80"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">用户类别</td>
								  <td width="178"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">所属单位</td>
								  <td width="97"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">最后一次登录时间</td>
								  <td width="110"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">最后一次登录IP</td>
								  <td  height="26" colspan="1" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">登录次数</td>
								  <td  height="26" colspan="1" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">是否可用</td>
								  <td  height="26" colspan="1" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">重置登录密码</td>
								  </tr>
								<?php if($userInfo): ?><tr>
								  <td align="center" bgcolor="#FFFFFF"><label>
									<?php echo ($userInfo["user_id"]); ?>
								  </label></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($userInfo["login_name"]); ?></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($userInfo["user_type"]); ?></a></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($userInfo["unit_name"]); ?></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($userInfo["last_login_time"]); ?></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($userInfo["last_login_ip"]); ?></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($userInfo["login_count"]); ?></td>
								  <td  align="center" bgcolor="#FFFFFF"><?php if(($userInfo[status]) == "1"): ?>可用<?php else: ?>不可用<?php endif; ?></td>
								   <td  align="center" bgcolor="#FFFFFF"><a href="<?php echo U('Main/setUserPass',array('login_name'=>$userInfo['login_name']));?>">重置密码</a></td>
								</tr><?php endif; ?>
							  </table></td>
							</tr>
							<tr>
							  <td height="60"><?php echo ($page); ?></td>
							</tr>
						  </table></td>
						</tr>
					  </table>
					</td>
                </tr>
                </table></td>
            </tr>
          </table>
		 
		 </td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height='1'></TD></TR>
</TABLE></BODY></HTML>