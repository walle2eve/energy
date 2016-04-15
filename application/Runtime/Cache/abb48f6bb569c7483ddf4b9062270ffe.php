<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HTML>
<HEAD>
<META http-equiv='Content-Type' content="text/html; charset=utf-8">
<TITLE><?php echo C('SITE_SUBJECT');?></TITLE>
<script type="text/javascript">
window.frames['main'].href = window.location.href;
window.history.forward(1); 
</script>
<META http-equiv='Pragma' content='no-cache'>
<META http-equiv='Cache-Control' content='no-cache'>
<META http-equiv='Expires' content='-1000'>
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
</HEAD>
<FRAMESET border=0 frameSpacing='0' rows="60, *" frameBorder='0'>
<FRAME name='header' src="<?php echo U('Main/header');?>" frameBorder='0' noResize scrolling='no'>
<FRAMESET cols="180, *">
<FRAME name='menu' src="<?php echo U('Main/menu');?>" frameBorder='0' noResize  scrolling='auto'>
<FRAME name='main' src="<?php echo U('Main/showAddStatus');?>" frameBorder='0' noResize scrolling='yes'>
</FRAMESET>
</FRAMESET>
<noframes>
</noframes>
</HTML>