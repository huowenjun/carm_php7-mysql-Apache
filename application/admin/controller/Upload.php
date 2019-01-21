<?php
namespace app\admin\controller;

class Upload extends Controller
{
    private $config;
	
	/**
     * 图片上传接口
     */
    public function upimages()
    {
		if ($this->request->file()) {
			$config = [
				'size' => 20 * 1024 * 1024,
				'ext'  => 'jpg,png,jpeg'
			];
			$file = $this->request->file('file');
			$upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads');
			$save_path   = '/uploads/';
			$info        = $file->validate($config)->move($upload_path);
			if($info){
				$result = [
					'error' => 0,
					'url'   => str_replace('\\', '/', $save_path . $info->getSaveName())
				];
			}
			else{
				$result = [
					'error'   => 1,
					'msg' => $file->getError()
				];
			}
		}
		else{
			$result = [
				'error'   => 1,
				'msg' => '请求失败'
			];
		}
        return json($result);
    }
	/**
	 * 图片裁剪上传接口上传接口
	 */
	public function co_upimages()
	{
		if ($this->request->file()) {
			$config = [
				'size' => 20 * 1024 * 1024,
				'ext'  => 'jpg,png,jpeg'
			];
			$file = $this->request->file('file');
			$upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads');
			$save_path   = '/uploads/';
			$info        = $file->validate($config)->move($upload_path);
			if($info){
				$data['src'] = str_replace('\\', '/', $save_path . $info->getSaveName());
				$this->result($data,0,'上传成功');
			}
			else{
				$this->result('',200,$file->getError());
			}
		}
		else{
			$this->result('',200,'请求失败');
		}
	}
}
