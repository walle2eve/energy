<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv='Content-Type content="text/html; charset=utf-8"'>
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<title>排序结果</title>
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right22{ font-size:13px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:13px;}

</style>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align='center' border='0' style="border:1px #9AD452 solid; background-color:##F3FFE3; margin-left:0px;"  height='100%'>
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
                  <td height="36"><strong>单位</strong>：<?php echo ($list["unit"]); ?><br>
				<strong>时间</strong>：<?php echo ($list["time"]); ?></td>
                </tr>
                <tr>
                  <td height="10"></td>
                </tr>
                <tr>
                  <td><table width="760" border="0" cellspacing="1" cellpadding="0" style="background-color:#cccccc">
                    <tr class="right22">
                      <td width="30" height="26" align="center" bgcolor="#FFFFFF" style="background-image:url(images/tab-bj.gif)">排序</td>
                      <td width="150" align="center" bgcolor="#FFFFFF" style="background-image:url(images/tab-bj.gif)"><?php if(($ct) == "time"): ?>时间<?php else: if(($town) > "0"): ?>学校<?php else: ?>区县<?php endif; endif; ?></td>
                      <td width="182" align="center" bgcolor="#FFFFFF" style="background-image:url(images/tab-bj.gif)">数据类型</td>
                      <td width="100" align="center" bgcolor="#FFFFFF" style="background-image:url(images/tab-bj.gif)">消耗量</td>
					  <td width="60" align="center" bgcolor="#FFFFFF" style="background-image:url(images/tab-bj.gif)">生均数</td>
					  <td width="60" align="center" bgcolor="#FFFFFF" style="background-image:url(images/tab-bj.gif)">面均数</td>
                      <td width="59" align="center" bgcolor="#FFFFFF" style="background-image:url(images/tab-bj.gif)">合格情况</td>
                    </tr>
					<?php if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["num"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php if(($ct) == "time"): echo ($vo["yearStr"]); else: echo ($vo["town"]); endif; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($list["infounit"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["total"]); ?></td>
					  <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["avgs"]); ?></td>
					  <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["avgm"]); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo ($vo["dabiao"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                  </table></td>
                </tr>
                <tr>
                  <td height="60">　　　　　　　　　　　　　　　　　<a href="<?php echo U('Main/showAddStatus');?>"><img src="__PUBLIC__/images/close.gif" width="100" height="29" border="0"></a>　
				  <a href="<?php echo U('Main/exportOrderBy',array('info_unit'=>$info_unit,'ct'=>$ct));?>"><img src="__PUBLIC__/images/daochu.gif" width="100" height="29" border="0"></a></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
    </table></TD></TR>
  <TR>
    <TD bgColor='#b1ceef' height='1'></TD></TR>
</TABLE></BODY></HTML>