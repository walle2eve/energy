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

<title>用户登录密码管理——<?php echo C('SITE_SUBJECT');?></title>
<script>
$(function(){
	//$('select').select2();
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
				layer.alert(result.errtitle,{icon:2});return false;
			}
		});
	});
	$('#submitbtn').bind('click',function (){
		if($("#town_id").val() == 0 || (($("#town_id").val() == 110000 || $("#town_id").val() == 110100) && $("#school_id").val() == 0)){
			layer.alert('请选择要管理的用户');
			return false;
		}
		$('form').submit();
	});
	//
	$('#adduser').bind('click',function(){
		layer.open({
		  type: 2,
		  title: '账号添加',
		  area: ['700px', '530px'],
		  fix: true, //不固定
		  maxmin: false,
		  content: '<?php echo U('Manager/addUser');?>'
		});
	});
	//设置是否可用
	$('.setStatus').bind('click',function(){
		var ob = $(this);
		var status = $(this).attr('status') == '1' ? '禁用' : '启用';
		var uid = $(this).attr('uid');
		if(!uid){
			layer.msg('参数错误，请刷新后重试！',{icon:2});
			return false;
		}
		
		layer.confirm('您确定要设置登录用户['+ $(this).attr('uname') +']的状态为：'+ status + '?', {
		  btn: ['确定','取消'] //按钮
		}, function(){
		  //layer.msg('的确很重要', {icon: 2});
		  $.post('<?php echo U('Ajax/setUserStatus');?>',{id:uid},function(response){
				if(response.errno != 0){
					layer.msg(response.errtitle,{icon:2});
					return false;
				}
				ob.html(response.data);
				layer.msg(response.errtitle,{icon:1});
				return;
		  });
		}, function(){
		  layer.close();
		});
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
              <td align="left" bgcolor="#FFFFFF"><!--<table width="840" border="0" cellspacing="0" cellpadding="0">--><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
					<td colspan="2" align="left">
					<img src="__PUBLIC__/images/tijiao.gif" width="100" height="29" id="submitbtn">
					<!--<a href="javascript:void(0)" id="adduser">添加账号</a>-->
					<img src="__PUBLIC__/images/tjzh.gif" width="100" height="29" id="adduser">
					<?php if(($user_kind) == "301010"): ?><a href="<?php echo U('Manager/highSchool');?>" id=""><img src="__PUBLIC__/images/glgx.gif" width="100" height="29" id="adduser"></a><?php endif; ?>
					</td>
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
							<tr height="14">
							  <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc;">
								<tr class="right22">
								  <td width="56" height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">用户ID</td>
								  <td width="91"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">登录名</td>
								  <td width="80"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">用户类别</td>
								  <td width="178"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">所属单位</td>
								  <td width="97"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">最后一次登录时间</td>
								  <td width="110"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">最后一次登录IP</td>
								  <td  height="26" colspan="1" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">登录次数</td>
								  <td  height="26" colspan="1" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">启用状态</td>
								  <td  height="26" colspan="1" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">重置登录密码</td>
								  </tr>
								<?php if($userInfo): if(is_array($userInfo)): $i = 0; $__LIST__ = $userInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								  <td align="center" height="36" bgcolor="#FFFFFF"><label>
									<?php echo ($vo["user_id"]); ?>
								  </label></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["login_name"]); ?></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["user_type"]); ?></a></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["unit_name"]); ?></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["last_login_time"]); ?></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["last_login_ip"]); ?></td>
								  <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["login_count"]); ?></td>
								  <td  align="center" bgcolor="#FFFFFF"><a href="javascript:void(0);" class="setStatus" status="<?php echo ($vo["status"]); ?>" uid="<?php echo ($vo["user_id"]); ?>" uname="<?php echo ($vo["login_name"]); ?>"><?php if(($vo[status]) == "1"): ?><font color="green">启用</font><?php else: ?><font color="red">禁用</font><?php endif; ?></a></td>
								   <td  align="center" bgcolor="#FFFFFF"><a href="<?php echo U('Main/setUserPass',array('login_name'=>$vo['login_name']));?>">重置密码</a></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
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