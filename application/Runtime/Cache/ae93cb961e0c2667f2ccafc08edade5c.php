<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="__PUBLIC__/js/lhgcalendar/jquery-1.7.1.min.js"></script>
<title>排序————<?php echo C('SITE_SUBJECT');?></title>
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:14px;}
</style>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align='center' border=0 style="border:1px #9AD452 solid; background-color:##F3FFE3; margin-left:0px;"  height='100%'>
  <TR>
    <TD valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="62" style="background-image:url(__PUBLIC__/images/right-bj.gif)"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="28"><img src="__PUBLIC__/images/right0.gif" width="16" height="13"></td>
            <td style="color:#43860C; font-size:16px; font-weight:bold;"><?php echo C('SITE_SUBJECT');?>数据统计分析</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="480" valign="top" bgcolor="#F3FFE3"><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="8">
            </td>
          </tr>
        </table>
          <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td bgcolor="#FFFFFF"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0" class="right3">
                <tr>
                  <td height="16">
                  </td>
                </tr>
                <tr>
                  <td height="36" class="right1">按<?php if(($ct) == "time"): ?>时间<?php else: ?>单位<?php endif; ?>排序</td>
                </tr>
                <tr>
                  <td height="44" class="right2">选择区县排序</td>
                </tr>
				<form action="<?php echo U('Main/orderby');?>" method="get" name="form_unit_time" onsubmit="return checkForm(this)">
				<input type="hidden" name="ct" value="<?php echo ($ct); ?>">
				<input type="hidden" name="town" value="<?php echo ($town); ?>">
                <tr>
                  <td>
				  		<select id="schooltype" style="width:200px;">
							<option value="0">--请选择学校类型--</option>
							<?php if(is_array($schoolTypes)): $i = 0; $__LIST__ = $schoolTypes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["dict_id"]); ?>"><?php echo ($vo["dict_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						  <div class="centent"> 
							<select <?php if(($parm[unitFormType]) != ""): ?>multiple<?php else: ?>name=<?php echo ($parm["unitFormName"]); endif; ?> id="select1" style="width:200px;<?php if(($parm[unitFormType]) != ""): ?>height:250px;<?php endif; ?>">    
							</select>  
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
							<?php if(($parm[unitFormType]) != ""): ?><select <?php echo ($parm["unitFormType"]); ?> id="select2" name="<?php echo ($parm["unitFormName"]); ?>" style="width:200px;height:250px;">    
							</select><?php endif; ?>
						  </div>  

						  <?php if(($parm[unitFormType]) != ""): ?><div style="margin-top:10px">  
							<span id="add" style="cursor:pointer;">选中添加到右边 &gt;</span>   
							<span id="remove" style="cursor:pointer;margin-left:124px">&lt; 选中添加到左边</span><br/>  
							<span id="addAll" style="cursor:pointer;">全部添加到右边 &gt;&gt;</span>  
							<span id="removeAll"  style="cursor:pointer;margin-left:120px">&lt;&lt; 全部添加到左边</span>  
						  </div><?php endif; ?>
					</td>
                </tr>
                <tr>
                  <td height="54" class="right2">选择时间排序</td>
                </tr>
                <tr>
                  <td>
					<p>
						<?php if(is_array($timeList)): $i = 0; $__LIST__ = $timeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="<?php echo ($parm["timeFormType"]); ?>" name="<?php echo ($parm["timeFormName"]); ?>" value="<?php echo ($vo["year"]); ?>_<?php echo ($vo["quarter"]); ?>">
                          <?php echo ($vo["yearStr"]); ?>    &nbsp;&nbsp;&nbsp;&nbsp;　
							<?php if(($i%4) == "0"): ?></p><p><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</p>
					</td>
                </tr>
                <tr>
                  <td height="90">　　　　　　　　　　　　　　　　　　　　　　　　　　　　　<a href="javascript:history.go(-1);"><img src="__PUBLIC__/images/bak.gif" width="100" height="29" border="0"></a>　 <a href="javascript:form_unit_time.submit();"><img src="__PUBLIC__/images/next.gif" width="100" height="29" border="0"></a></td>
                </tr>
				</form>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height=1></TD></TR>
</TABLE></BODY></HTML>
<script type="text/javascript"> 
    $(document).ready(function(){ 
		//学校下拉菜单
		$('#schooltype').bind('change',function(){
			$('#select1').empty();
			$('#select2').empty();
			var school_type = this.value;
			if(school_type == 0)return false;
			url = "<?php echo U('Ajax/getSchoolSelect');?>";
			url += '?town_id=<?php echo ($town); ?>&school_type='+school_type;
			$.get(url, function(result){
				if(result.errno==0){
					$('#select1').html(result.data);
				}else{
					alert(result.errtitle);return false;
				}
			});
		});

        $('#add').click(function(){  
            var $options = $('#select1 option:selected');//获取当前选中的项  
            var $remove = $options.remove();//删除下拉列表中选中的项  
            $remove.appendTo('#select2');//追加给对方  
        });  
        $('#remove').click(function(){  
            var $removeOptions = $('#select2 option:selected');  
            $removeOptions.appendTo('#select1');//删除和追加可以用appendTo()直接完成  
        });  
          
        $('#addAll').click(function(){  
            var $options = $('#select1 option');  
            $options.appendTo('#select2');  
			$("#select2 option").attr("selected", true);   //设置Select全部项选中 	
        });  
          
        $('#removeAll').click(function(){  
            var $options = $('#select2 option');  
            $options.appendTo('#select1');  
        });  
          
        //双击事件  
        $('#select1').dblclick(function(){  
            var $options = $('option:selected', this);
            $options.appendTo('#select2');  
        });  
          
        $('#select2').dblclick(function(){  
            $('#select2 option:selected').appendTo('#select1');  
        });       
    });  
</script>