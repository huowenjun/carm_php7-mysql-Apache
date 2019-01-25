<?php
namespace app\admin\controller;

class Upload extends \think\Controller
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

    /**base64
     * @return int|string
     */
    public function base64(){
        header('Access-Control-Allow-Origin:*');
        set_time_limit(0);
        $data = $this->request->post();
        $up_dir = './base64/images/';
        if(!file_exists($up_dir)){
            mkdir($up_dir,0777,true);
        }
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $data['img'], $result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                $new_file = $up_dir.time().rand_number($len = 6).'.'.$type;

                if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $data['img'])))){
                    $img_path = str_replace('../../..', '', $new_file);
                    $img_path = trim($img_path,'.');//文件路劲

                    $res = ['data'=>$img_path,'code'=>200,'msg'=>'上传成功'];

                }else{
                    $res = ['data'=>'','code'=>0,'msg'=>'网络错误'];
                }
            }else{
                //文件类型错误
                $res = ['data'=>'','code'=>0,'msg'=>'图片上传类型错误'];
            }

        }else{
            //文件错误
            $res = ['data'=>'','code'=>0,'msg'=>'文件错误'];
        }

        return json($res);
    }
}
