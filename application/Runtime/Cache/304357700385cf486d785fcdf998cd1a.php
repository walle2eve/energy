<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="__PUBLIC__/css/admin.css" type="text/css" rel="stylesheet">
<title>对比结果</title>
<style>
.right1{ font-size:14px; color:#000000; font-weight:bold; line-height:180%;}
.right2{ font-size:14px; color:#43860C; font-weight:bold; line-height:180%;}
.right3{font-size:14px;}
</style>
<script type="text/javascript" src="__PUBLIC__/js/lhgcalendar/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
	$(function () {
        $('#containerTotal').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: '总量对比'
            },
            xAxis: {
                categories: [
					<?php if(($ct) == "time"): if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>['<?php echo ($vo["yearStr"]); ?>'],<?php endforeach; endif; else: echo "" ;endif; ?>
					<?php else: ?>
					<?php if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>['<?php echo ($vo["town"]); ?>'],<?php endforeach; endif; else: echo "" ;endif; endif; ?>
                ],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '8px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo ($list["infounit"]); ?>'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<?php echo ($list["infounit"]); ?>',
            },
            series: [{
                name: 'Population',
                data: [
					<?php if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["total"]); ?>,<?php endforeach; endif; else: echo "" ;endif; ?>
				],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '8px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
        });
        $('#containerAvgs').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: '生均数对比'
            },
            xAxis: {
                categories: [
					<?php if(($ct) == "time"): if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>['<?php echo ($vo["yearStr"]); ?>'],<?php endforeach; endif; else: echo "" ;endif; ?>
					<?php else: ?>
					<?php if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>['<?php echo ($vo["town"]); ?>'],<?php endforeach; endif; else: echo "" ;endif; endif; ?>
                ],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '8px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo ($list["infounit"]); ?>'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<?php echo ($list["infounit"]); ?>',
            },
            series: [{
                name: 'Population',
                data: [
					<?php if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["avgs"]); ?>,<?php endforeach; endif; else: echo "" ;endif; ?>
				],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '8px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
        });

        $('#containerAvgm').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: '面均数对比'
            },
            xAxis: {
                categories: [
					<?php if(($ct) == "time"): if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>['<?php echo ($vo["yearStr"]); ?>'],<?php endforeach; endif; else: echo "" ;endif; ?>
					<?php else: ?>
					<?php if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>['<?php echo ($vo["town"]); ?>'],<?php endforeach; endif; else: echo "" ;endif; endif; ?>
                ],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '8px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo ($list["infounit"]); ?>'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<?php echo ($list["infounit"]); ?>',
            },
            series: [{
                name: 'Population',
                data: [
					<?php if(is_array($list[data])): $i = 0; $__LIST__ = $list[data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["avgm"]); ?>,<?php endforeach; endif; else: echo "" ;endif; ?>
				],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFF000',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '8px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
        });
    });
</script>
</HEAD>
<BODY>
<script src="__PUBLIC__/Highcharts-3.0.10/js/highcharts.js"></script>
<script src="__PUBLIC__/Highcharts-3.0.10/js/modules/exporting.js"></script>
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
                  <td height="36">单位：<?php echo ($list["unit"]); ?></td>
                </tr>
                <tr>
                  <td height="44">时间：<?php echo ($list["time"]); ?></td>
                </tr>

                <tr>
                  <td height="54" class="right1"><?php echo ($list["infounit"]); ?></td>
                </tr>
                <tr>
                  <td>
				<div id="containerTotal" style="width: 330px; height: 260px; margin: 0 auto;float:left"></div><div id="containerAvgs" style="width: 330px; height: 260px; margin: 0 auto;float:left"></div><div id="containerAvgm" style="width: 330px; height: 260px; margin: 0 auto;float:left"></div>
					</td>
                </tr>
                <tr>
                  <td height="60">　　　　　　　　　　　　　　　　　<a href="<?php echo U('Main/showAddStatus');?>"><img src="__PUBLIC__/images/close.gif" width="100" height="29" border="0"></a>　
				  <a href="<?php echo U('Main/exportContrast',array('info_unit'=>$info_unit,'ct'=>$ct));?>"><img src="__PUBLIC__/images/daochu.gif" width="100" height="29" border="0"></a></td>
                </tr>
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