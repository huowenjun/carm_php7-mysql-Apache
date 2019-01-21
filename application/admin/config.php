<?php
//配置文件
return [
	// 默认输出类型
    'default_return_type'    => 'html',
	
	'template'               => [
	    // layout布局
        'layout_on'     =>  true,
        'layout_name'   =>  'layouts/layout',
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
    ],
    'activity_type'=>[
        1=>'发车车源',
        2=>'搜索车辆',
        3=>'车源查看',
        4=>'拨打电话',
        5=>'收藏车源',
        6=>'发布求购',
        7=>'分享列表/车源',
    ],
];