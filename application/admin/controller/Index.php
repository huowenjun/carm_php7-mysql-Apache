<?php
namespace app\admin\controller;

use app\admin\model\Admin;
use think\Cache;
class Index extends Controller
{
	public function index()
	{
        $model = new Admin();
        $admin = $this->admin_info;
        $server = [
            'server_software' => $this->request->server('SERVER_SOFTWARE'),
            'system' => PHP_OS,
            'server_addr' => $this->request->server('SERVER_ADDR'),
            'server_name' => $this->request->server('SERVER_NAME'),
            'server_port' => $this->request->server('SERVER_PORT'),
            'php' => PHP_VERSION,
            'max_execution_time' => ini_get('max_execution_time') . 'S',
            'upload_max' => @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '',
        ];
        return $this->fetch('index', ['server'=>$server]);
//		return $this->fetch();
	}

	public function cache(){
        /*清理菜单缓存*/
        Cache::set('data',null);
        Cache::set('t_data',null);
        /*end*/
        $dir='../runtime/temp';
        //先删除目录下的文件：
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }
        closedir($dh);
        return true;

    }

}
