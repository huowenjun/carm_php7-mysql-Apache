<?php
/**
 * Created by PhpStorm.
 * User: 霍文俊
 * Date: 2019/1/22
 * Time: 14:25
 */

namespace app\car\validate;


use think\Validate;

class Activity extends Validate
{
    protected $rule = [
        'activity_id' => 'require|[0-9]*',
        'type'        => 'require|in:1,2,3,4,5',
        'u_id'        => 'require|[0-9]*',

    ];

    protected $message = [
        'activity_id.require' => '缺少活动ID参数',
        'activity_id.[0-9]*'=>'活动ID数据不合法',
        'type.require' => '缺少活动类型参数',
        'type.in' => '活动类型数据不合法',
        'u_id.require' => '缺少用户ID参数',
        'u_id.[0-9]*' => '用户ID数据不合法',
    ];

    protected $scene = [
        'add' => ['activity_id', 'type', 'u_id'],
    ];

    protected function checkphone($value, $rule, $data)
    {
        $rule = '/^1[3-9]{1}[0-9]{9}$/';
        $msg = '联系电话格式不正确';
        return preg_match($rule, (string)$value) === 1 ? true : $msg;
    }
}