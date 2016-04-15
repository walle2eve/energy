<?php
return array(
    'DB_HOST'               => 'localhost',
    'DB_NAME'               => 'energy',
    'DB_USER'               => 'jn_soft',
    'DB_PWD'                => 'jn_soft@)!$',
    //'DB_USER'               => 'root',
    //'DB_PWD'                => 'root',
    'DB_PORT'               => '3306',
    'DB_PREFIX'             => 'energy_',
	//'DB_PARAMS'=>array('persist'=>true),//数据库其他参数

    /* URL设置 */
    'URL_CASE_INSENSITIVE'  => false,
    'URL_MODEL'             => 1,
	/*DEBUG*/
    'LOG_RECORD'			=>	false,  // 进行日志记录
    'LOG_EXCEPTION_RECORD'  => 	true,    // 是否记录异常信息日志


	'SHOW_PAGE_TRACE' =>false, // 显示页面Trace信息

    /* 分页设置 */
	'VAR_PAGE'			=>'p',
	'PAGE_ROLLPAGE'         => 5,						// 分页显示页数
	'PAGE_LISTROWS'         => 10,					// 分页每页显示记录数

	/* 系统设置 */
	'SITE_SUBJECT' => '北京市教育系统节能减排应用平台',
);
?>