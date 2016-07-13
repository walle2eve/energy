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

<title>高等学校管理——<?php echo C('SITE_SUBJECT');?></title>
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:14px;}
.right22 td{height:36px;text-align:center; vertical-align:middle;background:#fff;}
img{ cursor:pointer; }
</style>

<script>
$(function(){
	$('select').select2();

	$('#school_type').bind('change',function(){
		$('#school_id').empty();
		var school_type = this.value;
		if(school_type == 0)return false;
		url = "<?php echo U('Ajax/getSchoolSelect');?>";
		url += '?school_type='+school_type;
		$.get(url, function(result){
			if(result.errno==0){
				$('#school_id').html('<option value=0>请选择学校</option>'+result.data);
			}else{
				layer.alert(result.errtitle,{icon:2});return false;
			}
		});
	});
	
	$('#addHighSchool').bind('click',function(){
		layer.open({
		  type: 2,
		  title: '添加高校',
		  area: ['700px', '530px'],
		  fix: true, //不固定
		  maxmin: false,
		  content: '<?php echo U('Manager/addHighSchool');?>'
		});
	});
	$('.delSchool').bind('click',function(){
		var school = $(this).attr('schooldata');
		if(!school){layer.msg('学校信息错误，无法删除，请刷新页面后重试！',{icon:2});return false;}
		layer.confirm('您确定要执行删除操作吗？',{
			btn:['确定','取消']
		},function(){
			$.post('<?php echo U('Ajax/delSchool');?>',{school:school},function(response){
					if(response.errno != 0){
						layer.msg(response.errtitle,{icon:2});
						return false;
					}else{
						layer.alert(response.errtitle,{icon:1},function(){
							window.location.reload();
						});
						return false;
					}
			});
		},function(){
			layer.close();
		});
	});
	$('#submitbtn').click(function(){
		$('form').submit();
	});
	<?php if($school_type): ?>$('#school_type').trigger("change");<?php endif; ?>
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
		
          <table class="right3" width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" bgcolor="#FFFFFF"><!--<table width="840" border="0" cellspacing="0" cellpadding="0">--><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <form action="" method="get" id="addfrom">
                <tr>
                  <td height="30" colspan="1" align="right">高校类别&nbsp;&nbsp;&nbsp;
					<label>
                      <select name="school_type" id="school_type" style="width:144px;">
                        <option value="0">请选择高校类别</option>
						<?php echo ($highSchoolTypeOptions); ?>
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
					<img src="__PUBLIC__/images/tjgx.gif" width="100" height="29" id="addHighSchool" />
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
								<tr class="right2">
								  <td width="10%" height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">学校标识码</td>
								  <td width="91" align="center" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">学校名称</td>
								  <td width="80" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">高校类别</td>
								  <!--
								  <td width="178"   align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">开办单位类型</td>
								  <td width="97"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">开办单位</td>
								  -->
								  <td width="80" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">负责人</td>
								  <td width="80" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">部门</td>
								  <td width="80" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">联系电话</td>
								  <td width="80" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">Email</td>
								  <td colspan="2" width="12%" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">操作</td>
								  </tr>
								<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="right22">
								  <td><label>
									<?php echo ($vo["school_code"]); ?>
								  </label></td>
								  <td><?php echo ($vo["school_name"]); ?></td>
								  <td><?php echo ($vo["school_type_name"]); ?></a></td>
								  <!--<td><?php echo ($vo["uni_type"]); ?></td>
								  <td><?php echo ($vo["unit_name"]); ?></td>-->
								  <td><?php echo ($vo["manage_name"]); ?></td>
								  <td><?php echo ($vo["manage_unit"]); ?></td>
								  <td><?php echo ($vo["manage_phone"]); ?></td>
								  <td><?php echo ($vo["manage_name"]); ?></td>
								  <td><img src="__PUBLIC__/images/bianji.gif" width="11" height="11"><a href="<?php echo U('Manager/editSchool',array('id'=>$vo[school_id]));?>"> [编辑]</a></td>
								  <td><img src="__PUBLIC__/images/delete.gif" width="11" height="11"><a href="javascript:void(0)" class="delSchool" schooldata=<?php echo ($vo[school_id]); ?>> [删除]</a></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
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