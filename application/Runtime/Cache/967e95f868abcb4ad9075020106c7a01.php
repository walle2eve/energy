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

<SCRIPT language=javascript>
	function expand(el)
	{
		childObj = document.getElementById("child" + el);

		if (childObj.style.display == 'none')
		{
			childObj.style.display = 'block';
		}
		else
		{
			childObj.style.display = 'none';
		}
		return;
	}
</SCRIPT>
</HEAD>
<BODY>
<TABLE width=180 height="100%" align="left" cellPadding=0 cellSpacing=0 style="border:1px #9AD452 solid; background-color:#ffffff; margin-left:0px;">
  <TR>
    <TD vAlign='top' align='center'>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        
        <TR>
          <TD></TD></TR>
        <TR>
          <TD height='26'  style="background-image:url(__PUBLIC__/images/left1.gif);font-size:13px; color:#ffffff;">　　<strong>管理选项</strong></TD>
        </TR>
        <TR>
          <TD height=10></TD>
        </TR>
      </TABLE>
	  <?php if(($user_kind_s) != "s"): if(is_array($menulist)): $i = 0; $__LIST__ = $menulist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><TABLE cellSpacing='0' cellPadding='0' width='150' border='0'>
        <TR height='22'>
        <TD height="22" background='__PUBLIC__/images/menu_bt.jpg' style="PADDING-LEFT: 30px; color:#9AD452; font-weight:bold;"><A 
            class=menuParent target=main
			<?php if(($vo[menuid]) == "2011"): ?>href="<?php echo U('Main/infolist',array('town_id'=>110000));?>" 
			<?php else: ?>onclick=expand(<?php echo ($vo["menuid"]); ?>) 
            href="<?php echo U('Main/showAddStatus',array('town_id'=>$vo[menuid]));?>"<?php endif; ?>><?php echo ($vo["menuname"]); ?></A></TD></TR>
        <TR height='4'>
          <TD></TD></TR></TABLE>
      <TABLE id='child<?php echo ($vo["menuid"]); ?>' style="DISPLAY: none" cellSpacing='0' cellPadding='0' 
      width='150' border='0'>
	  <?php switch($vo["menuid"]): case "110000": if(is_array($high_school_menu)): $i = 0; $__LIST__ = $high_school_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><TR height='20'>
			<TD align=middle width=30>
			<?php echo ($vo["levelstr"]); ?>
			<?php if($vo['level'] == '9999'): ?><IMG height=9 src="__PUBLIC__/images/menu_icon.gif" width=9>
			<?php else: ?>
			<IMG height=9 src="__PUBLIC__/images/menu_bt.jpg" width=9><?php endif; ?>
			</TD>
			<TD>
			<?php if($vo['level'] == '9999'): ?><A class='menuChild' href="<?php echo U('Main/infolist',array('town_id'=>$vo['town_id'],'school_type'=>$vo['type_id']));?>" target='main'><?php echo ($vo["type_name"]); ?></A>
			<?php else: ?>
			<?php echo ($vo["type_name"]); endif; ?>
			</TD>
		</TR><?php endforeach; endif; else: echo "" ;endif; ?>
        <TR height=4>
             <TD colSpan=2></TD></TR><?php break;?>
			 <?php case "110100": ?><TR height='20'>
          <TD align='middle' width=30><IMG height='9' 
            src="__PUBLIC__/images/menu_icon.gif" width='9'></TD>
          <TD><A class='menuChild' 
            href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>'201201'));?>" 
            target='main'>直管单位</A></TD></TR>
        <TR height='20'>
          <TD align='middle' width='30'><IMG height='9' 
            src="__PUBLIC__/images/menu_icon.gif" width='9'></TD>
          <TD><A class='menuChild' 
            href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>'201202'));?>" 
            target='main'>直属单位</A></TD></TR>

        <TR height=4>
             <TD colSpan=2></TD></TR><?php break;?>
			 <?php default: ?>
		<TR height='20'>
          <TD align='middle' width='30'><IMG height='9' 
            src="__PUBLIC__/images/menu_icon.gif" width='9'></TD>
          <TD><A 
            class='menuChild' target='main' href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>201300));?>"><?php echo ($vo["menuname"]); ?>教委机关</A></TD></TR>
        <TR height='20'>
          <TD align='middle' width='30'><IMG height='9' 
            src="__PUBLIC__/images/menu_icon.gif" width='9'></TD>
          <TD><A class='menuChild' 
            href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>'201061'));?>" 
            target='main'>区级直属单位</A></TD></TR>
        <TR height='20'>
          <TD align='middle' width='30'><IMG height='9' 
            src="__PUBLIC__/images/menu_icon.gif" width='9'></TD>
          <TD><A class='menuChild' 
            href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>'201001'));?>" 
            target='main'>幼儿园</A></TD></TR>
        <TR height='20'>
          <TD align='middle' width=30><IMG height='9' 
            src="__PUBLIC__/images/menu_icon.gif" width='9'></TD>
          <TD><A class='menuChild' 
            href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>'201011'));?>" 
            target='main'>小学</A></TD></TR>
        <TR height='20'>
          <TD align=middle width=30><IMG height=9 
            src="__PUBLIC__/images/menu_icon.gif" width=9></TD>
          <TD><A class='menuChild' 
            href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>'201021'));?>" 
            target='main'>中学</A></TD></TR>
        <TR height='20'>
          <TD align=middle width=30><IMG height=9 
            src="__PUBLIC__/images/menu_icon.gif" width=9></TD>
          <TD><A class='menuChild' 
            href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>'201041'));?>" 
            target='main'>九年一贯制</A></TD></TR>
        <TR height='20'>
          <TD align=middle width=30><IMG height=9 
            src="__PUBLIC__/images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>'201051'));?>" 
            target=main>中等职业学校</A></TD></TR>
        <TR height='20'>
          <TD align=middle width=30><IMG height=9 
            src="__PUBLIC__/images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="<?php echo U('Main/infolist',array('town_id'=>$vo[menuid],'school_type'=>'201031'));?>" 
            target=main>特殊教育学校</A></TD></TR>
			<?php if(($user_kind) == "301020"): ?><TR height='20'>
          <TD align=middle width=30><IMG height=9 
            src="__PUBLIC__/images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="<?php echo U('Main/towncollectlist');?>" 
            target=main>全区能耗数据汇总</A></TD></TR><?php endif; ?>
        <TR height=4>
             <TD colSpan=2></TD></TR><?php endswitch;?></TABLE><?php endforeach; endif; else: echo "" ;endif; ?>
			 <?php else: ?>
      <TABLE cellSpacing=0 cellPadding=0  width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="__PUBLIC__/images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="<?php echo U('Main/infolist',array('school_id'=>$menulist[school_id]));?>" 
            target=main><?php echo ($menulist["school_name"]); ?></A></TD></TR>
		</TABLE><?php endif; ?>
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
       
        </TABLE></TD><TD width=1 bgColor=#d1e6f7></TD>
</TR></TABLE></BODY></HTML>