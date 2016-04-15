<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv='Content-Type content="text/html; charset=utf-8"'>
<script type="text/javascript" src="__PUBLIC__/js/lhgcalendar/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/layer/layer.min.js"></script>
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<title>上报信息查看————{U:('SITE_SUBJECT')}</title>
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right22{ font-size:13px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:13px;}

</style>
<script type="text/javascript">
function selYears(year){
	//if(year == '')return;
	location.href="<?php echo U('Main/infolist',array('town_id'=>$town_id,'school_type'=>$school_type));?>?selYear="+year;
}
</script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align='center' border='0' style="border:1px #9AD452 solid; background-color:##F3FFE3; margin-left:0px;"  height='100%'>
  <TR>
    <TD valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="62" style="background-image:url(__PUBLIC__/images/right-bj.gif)"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="28"><img src="__PUBLIC__/images/right0.gif" width="16" height="13"></td>
            <td width="630" height="60" style="color:#43860C; font-size:16px; font-weight:bold;"><?php echo C('SITE_SUBJECT');?></td>
            <td align="left" valign="bottom" style="color:#43860C; font-size:16px; font-weight:bold;"><a href="<?php echo U('Main/addInfo');?>"><img src="__PUBLIC__/images/sbsj.gif" width="137" height="41" border="0"></a></td>
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
              <td><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0" class="right3">
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
                  <td><table width="760" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc;">
                    <tr class="right22">
                      <td colspan="8" height="26" align="left" bgcolor="#FFFFFF"><select onchange="selYears(this.value)"><option value="">--按时间查看--</option><?php echo ($years); ?></select></td>
                      </tr>
                    <tr class="right22">
                      <td width="56" height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">选择</td>
                      <td width="91"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">学校标识码</td>
                      <td width="177"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">学校或单位名称</td>
                      <td width="78"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">办学类型</td>
                      <td width="97"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">管理部门</td>
                      <td width="110"  height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">数据上报时间</td>
                      <td  height="26" colspan="2" align="center" bgcolor="#FFFFFF" style="background-image:url(__PUBLIC__/images/tab-bj.gif)">操作</td>
                      </tr>
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                      <td align="center" bgcolor="#FFFFFF"><label>
                        <input type="checkbox" name="school_id[]" id="school_id_<?php echo ($vo["school_id"]); ?>">
                      </label></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["school_code"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php if(($vo['id']) != ""): if(($vo['is_del']) == "1"): echo ($vo["school_name"]); else: ?><a href="<?php echo U('Main/showInfo',array('id'=>$vo[id]));?>"><?php echo ($vo["school_name"]); ?></a><?php endif; else: echo ($vo["school_name"]); endif; ?></a></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["school_type_name"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["town_name"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php if(($vo['is_del']) == "1"): else: echo ($vo["yearStr"]); endif; ?></td>
					  <?php if(($vo['id']) != ""): if(($vo['is_del']) == "1"): ?><td colspan="2" align="center" bgcolor="#FFFFFF"><a href="<?php echo U('Main/addInfo');?>" >上报</a></td>
					  <?php else: ?>
                      <td width="65" align="center" bgcolor="#FFFFFF"><img src="__PUBLIC__/images/bianji.gif" width="11" height="11"><a href="<?php echo U('Main/editInfo',array('id'=>$vo[id]));?>"> [编辑]</a></td>
                      <td width="77" align="center" bgcolor="#FFFFFF"><img src="__PUBLIC__/images/delete.gif" width="11" height="11"><a href="<?php echo U('Main/delInfo',array('id'=>$vo[id]));?>"> [删除]</a></td><?php endif; ?>
					 <?php else: ?>
						<td colspan="2" align="center" bgcolor="#FFFFFF"><a href="<?php echo U('Main/addInfo');?>" >上报</a></td><?php endif; ?>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <tr>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
                      <td colspan="7" align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;&nbsp;<a href="javascript:void(0);">全选</a>&nbsp;&nbsp;<img src="__PUBLIC__/images/sbsj1.gif" width="18" height="15"><a href="<?php echo U('Main/addInfo');?>">上报数据</a>&nbsp;&nbsp;
					  <!--
					  <img src="__PUBLIC__/images/db.gif" width="16" height="16"><a href="javascript:void(0);" class="contrast">对比</a>&nbsp;&nbsp;<img src="__PUBLIC__/images/px.gif" width="18" height="16">
					  <a href="javascript:void(0);" class="orderBy">排序</a>
					  -->
					  </td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="60"><?php echo ($page); ?></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height='1'></TD></TR>
</TABLE></BODY>
<script type="text/javascript">
$('.contrast').bind('click',function (){
	var iframeUrl = '<?php echo U("Main/contrast_t");?>';
	$.layer({
		type : 2,
		title : '选择数据对比',
		iframe : {src : iframeUrl },
		area : ['800px' , '600px'],
		offset : ['50px','']
	});
});
</script>
</HTML>