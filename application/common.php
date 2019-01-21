<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
use think\Cache;
class Tree
{
	private static $pk = 'id';
    private static $pid = 'pid';
    private static $child = 'child';
	
	public static function makeTree(&$data, $index = 0)
    {
        $childs = self::findChild($data, $index);
        if (empty($childs)) {
            return $childs;
        }
        foreach ($childs as $k => &$v) {
            if (empty($data)) break;
            $child = self::makeTree($data, $v[self::$pk]);
            if (!empty($child)) {
                $v[self::$child] = $child;
            }
        }
        unset($v);
        return $childs;
    }
	public static function findChild(&$data, $index)
    {
        $childs = [];
        foreach ($data as $k => $v) {
            if ($v[self::$pid] == $index) {
                $childs[] = $v;
                unset($v);
            }
        }
        return $childs;
    }
	public static function getTreeNoFindChild($data)
    {
        $map = [];
        $tree = [];
        foreach ($data as &$it) {
            $map[$it[self::$pk]] = &$it;
        }
        foreach ($data as $key => &$it) {
            $parent = &$map[$it[self::$pid]];
            if ($parent) {
                $parent['child'][] = &$it;
            } else {
                $tree[] = &$it;
                //$tree[]['child'] = null;
            }
        }
        return $tree;
    }
	// 向上查找
	public static function getParents($data, $catId)
    {
        $tree = array();
        foreach ($data as $item) {
            if ($item[self::$pk] == $catId) {
                if ($item[self::$pid] > 0)
				$tree = array_merge($tree, self::getParents($data, $item[self::$pid]));
				$tree[] = $item;
				break;
            }
        }
        return $tree;
    }
}
/**
 * 驼峰命名转下划线命名
 * @param $str
 * @return string
 */
function toUnderScore($str)
{
    $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) {
        return '_' . strtolower($matchs[0]);
    }, $str);
    return trim(preg_replace('/_{2,}/', '_', $dstr), '_');
}

/**
 * 字符串切割工具
 *
 * @param unknown $str_cut
 * @param unknown $length
 * @return string
 */
function string_cut($str, $n, $s = "...") {
    $length = mb_strlen ( $str, 'UTF8' );
    if ($n < $length) {
        return mb_substr ( $str, 0, $n, 'UTF-8' ) . $s;
    } else {
        return mb_substr ( $str, 0, $n, 'UTF-8' );
    }
}
/**
 *字符串切割工具,
 */
function string_cut_nohtml($str, $n,$s="..."){
    $str=html_entity_decode($str);
    $str = strip_tags ( $str);
    $str = html($str,1);
    $str =  string_cut ($str , $n );
    //$str =  string_cut ( preg_replace ( "/\s/", "", $str ), $n );
    return string_cut($str, $n,$s);

}

function html($val,$sta=0){
    if($sta==1){

    }else{
        $val = html_entity_decode($val);
    }

    $val = str_replace("&nbsp;", "", $val);
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
        $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
    }

    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link',  'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound',  'base');
    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true;
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(&#0{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
            $val = preg_replace($pattern, $replacement, $val);
            if ($val_before == $val) {
                $found = false;
            }
        }
    }
    return $val;
}
//添加缓存
function SetCache($key,$value,$time = 86400){
    if(!$key || !$value){
        return false;
    }
    Cache::set($key,$value,$time);
}
//获取缓存
function GetCache($key)
{
    if(!Cache::has($key))
    {
        return false;
    }
    if(!Cache::get($key))
    {
        return false;
    }else{
        return Cache::get($key);
    }
}
//随机N位数字
 function rand_number($len = 6)
    {
        $chars = '01234567890123456789012345678901234567890123456789';
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
        return $str;
    }
//json 返回数据

    function msg_ok($code = 1,$msg = '',$url = '')
    {
        return json(['ret'=>$code,'msg'=>$msg,'url'=>$url]);
    }
function p($str){
    echo '<pre>';
    print_r($str);
    die;
}