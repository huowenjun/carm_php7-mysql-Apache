<?php
/**
 * 车龄
 * User: 霍文俊
 * Date: 2019/1/25
 * Time: 11:07
 */

namespace app\admin\controller;


use think\Request;

class CarAge extends Controller
{
    private $dir;
    const KEY='car_age';//文件key
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->dir=config('dir');
    }

    public function index()
    {
        $data = file_get_contents($this->dir);
        $res='';
        if (isset($data)) {
            $data = unserialize($data);
            if(isset($data[self::KEY])){
               $res=$data[self::KEY];
            }
        }
        return $this->fetch('', ['list' => $res]);
    }

    public function edit()
    {
        if ($this->request->isAjax()) {
            $post = $this->postData();
            $data = file_get_contents($this->dir);
            if (isset($data)) {
                $data = unserialize($data);
            }
            $post['start'] = $post['start'] == 0 ? $post['start'] : ltrim($post['start'], '0');
            $post['end'] = $post['end'] == 0 ? $post['end'] : ltrim($post['end'], '0');
            $v = $post['start'] . '-' . $post['end'] . '年';
            if ($post['start'] == 0 && $post['end'] == 0) {
                $v = '1年以内';
            }
            if ($post['start'] == 0 && $post['end'] != 0) {
                $v = $post['end'] . '年以上';
            }
            if(isset($post['id'])){
               unset($data[self::KEY][$post['id']]);
            }
            $data[self::KEY][$post['start'] . '-' . $post['end']] = $v;
            $res = serialize($data);
            $car_age_file = fopen($this->dir, "w") or die("Unable to open file!");
            $bool = fwrite($car_age_file, $res);
            fclose($car_age_file);
            if ($bool) {
                $this->add_SystemLog('车龄', '编辑', isset($post['Pname'])?$post['Pname']:'编辑');
                return ['ret' => 200, 'msg' => '操作成功'];
            } else {
                return ['ret' => 0, 'msg' => '操作失败'];
            }
        } else {
            $get = $this->getData();
            $title = isset($get['id']) ? 1 : 0;
            $res = array();
            if($title) {
                $data = file_get_contents($this->dir);
                if (isset($data)) {
                    $data = unserialize($data);
                    if (isset($data[self::KEY])) {
                        if (isset($data[self::KEY][$get['id']])) {
                            $res['v'] = $data[self::KEY][$get['id']];
                            $k = explode('-', $get['id']);
                            $res['start'] = $k[0];
                            $res['end'] = $k[1];
                        }
                    }
                }
            }
            return $this->fetch('', ['title' => $title, 'list' => $res]);
        }
    }

    public function del(){
        if ($this->request->isAjax()) {
            $post = $this->postData();
            $data = file_get_contents($this->dir);
            if (isset($data)) {
                $data = unserialize($data);
            }
            if(isset($post['pkid'])){
                unset($data[self::KEY][$post['pkid']]);
            }
            $res = serialize($data);
            $car_age_file = fopen($this->dir, "w") or die("Unable to open file!");
            $bool = fwrite($car_age_file, $res);
            fclose($car_age_file);
            if ($bool) {
                $this->add_SystemLog('车龄', '删除', $post['beName']);
                return ['msg' => '删除成功'];
            } else {
                return ['ret' => 0, 'msg' => '删除失败'];
            }
        } else {
            return ['ret' => 0, 'msg' => '非法请求'];
        }
    }
}