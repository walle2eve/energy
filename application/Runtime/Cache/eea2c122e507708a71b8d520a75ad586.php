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

<title><?php echo C('SITE_SUBJECT');?></title>
<script type="text/javascript">
$(function(){
	$('#setHighSchoolType').bind('click',function(){
		layer.open({
		  type: 2,
		  title: '高等院校分类管理',
		  area: ['700px', '530px'],
		  fix: true, //不固定
		  maxmin: false,
		  content: '<?php echo U('Manager/setHighSchoolType');?>'
		});
	});
});
</script>
</HEAD>
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
                  <td height="40" valign="top" class="right1">欢迎登陆 <?php echo C('SITE_SUBJECT');?>！</td>
                </tr>
                <tr>
                  <td style="line-height:300%;">
				  <p>
				  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><strong><?php if(($user_kind) == "301010"): echo ($vo["town_name"]); else: if(($user_kind) == "301020"): echo ($vo["school_type_name"]); else: echo ($vo["school_name"]); endif; endif; ?></strong>上报数据 <a href="<?php if(($user_kind) == "301010"): echo U('Main/infolist',array('town_id'=>$vo[town_id])); else: if(($user_kind) == "301020"): echo U('Main/infolist',array('school_type'=>$vo[school_type])); else: echo U('Main/infolist',array('school_id'=>$vo[school_id])); endif; endif; ?>" class="ling"><?php echo ($vo["total"]); ?></a> 条&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php if($key % 4 == 3): ?></p><p><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				  </p>
				  　　    </td>
                </tr>
				<?php if($user_kind == 301010 AND $town_id == 110000): ?><tr>
                  <td height="40" valign="top" class="right1"><a id="setHighSchoolType" href="javascript:void(0);">高等院校分类管理</a></td>
                </tr><?php endif; ?>
              </table>
                <table width="760" border="0" cellspacing="0" cellpadding="0">
                  <tr> </tr>
                  <tr>
                    <td height="80"><a href="<?php echo U('Main/addInfo');?>"><img src="__PUBLIC__/images/sbsj0.gif" width="136" height="40" border="0"></a> <?php if($town_id != 0 AND $user_kind == '301010' OR $user_kind == '301020' ): ?><a href="<?php echo U('Main/collect',array('town'=>$town_id));?>"><img src="__PUBLIC__/images/sjhz0.gif" width="136" height="40" border="0"></a><?php endif; ?> <a href="<?php echo U('Main/contrast',array('town'=>$town_id));?>"><img src="__PUBLIC__/images/sjdb0.gif" width="136" height="40" border="0"></a> <a href="<?php echo U('Main/orderby',array('town'=>$town_id));?>"><img src="__PUBLIC__/images/sjpx0.gif" width="136" height="40" border="0"></a><?php if(($user_kind) == "301010"): if($town_id == 0 ): ?>&nbsp;<a href="<?php echo U('Main/collect',array('ac'=>'TownYearCollect'));?>"><img src="__PUBLIC__/images/townYearCollectButton.jpg" width="136" height="40" border="0"></a><?php endif; endif; ?></td>
                    </tr>
                </table></td>
            </tr>
        </table></td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height='1'></TD></TR>
</TABLE></BODY></HTML>