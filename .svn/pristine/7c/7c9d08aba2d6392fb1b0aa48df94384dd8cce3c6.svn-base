<?php
/**
 * 车龄.
 * User: 霍文俊
 * Date: 2019/1/25
 * Time: 10:51
 */

namespace app\car\controller;


use think\Request;

class CarAge extends Controller
{
    public $res;
    const KEY='car_age';//文件key
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $data = file_get_contents(config('dir'));
        if (isset($data)) {
            $data = unserialize($data);
            if(isset($data[self::KEY])){
                $this->res = $data[self::KEY];
            }
        }
    }

    public function getCarAge(){
        return $this->renderSuccess('sucess',$this->res);
    }
}