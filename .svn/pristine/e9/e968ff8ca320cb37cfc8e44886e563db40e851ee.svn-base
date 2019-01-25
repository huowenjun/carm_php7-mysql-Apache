<?php
namespace app\admin\model;

// use think\Model;
use think\model\Merge;
use think\Request;
class CarSource extends Merge
{
    // protected $table = 't_users'; //'users_info_utime','users_info_ctime','users_money_utime','users_money_ctime'
    protected $insert = ['id','ctime','utime'];
    protected $createTime = 'ctime';
    protected $updateTime = 'utime';
    // 定义关联模型列表
    // protected  $relationModel = [
    //     'UsersInfo' =>  't_users_info',
    //     'UsersMoney' => 't_users_money',
    // ];
    // protected $fk = 'users_id';
    // protected $mapFields = [
    //     // 为混淆字段定义映射
    //     'id'        =>  'Users.id',
    //     'users_info_id' =>  'UsersInfo.id',
    //     'users_money_id' =>  'UsersMoney.id',
    //     'ctime' =>  'Users.ctime',
    //     'utime' =>  'Users.utime',
    //     'users_info_ctime' =>  'UsersInfo.ctime',
    //     'users_info_utime' =>  'UsersInfo.utime',
    //     'users_info_users_id' =>  'UsersInfo.users_id',
    //     'users_money_ctime' =>  'UsersMoney.ctime',
    //     'users_money_utime' =>  'UsersMoney.utime',
    //     'users_money_users_id' =>  'UsersMoney.users_id',
    // ];
    protected function setCtimeAttr(){
        return time();
    }
    protected function setUsersInfoCtimeAttr(){
        return time();
    }
    protected function setUsersInfoUtimeAttr(){
        return time();
    }
    protected function setUsersMoneyCtimeAttr(){
        return time();
    }
    protected function setUtimeAttr(){
        return time();
    }
     
     protected function setUsersMoneyUtimeAttr(){
        return time();
    }
    public function GetAllList()
    {
        return $this->all();
    }
    protected $pk = 'id';
    //,room_city room_city_name,market market_name,review review_name,status status_name,level level_name,review_time review_times,start_time start_times,end_time end_times
	public function allList($where = array(),$page = 15)
	{
		$data = $this->where($where)->with('usermoney')->field('*')->order('id DESC')
			->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
		return $data;
	}
    //编辑资料
    public function geteditinfo($id)
    {
       return $this->field('shop_name,user_name,user_tel,room_city,room_city room_city_name,market,market market_name,address,img,photo,province_id')
       ->where('id',$id)->find();
    }
	public function edit($data)
    {
		$data['last_time'] = time();
        return $this->allowField(true)->save($data);
    }
     protected function getRoomCityNameAttr($ids){
    	return db('cities')->where('area_code',$ids)->value('area_name');
    }
     protected function getMarketNameAttr($ids){
        return db('market')->where('id',$ids)->value('name');
    }
    /*审核状态 1: 待审核  2审核通过  4审核未通过*/
    protected function getReviewNameAttr($sta){
        switch ($sta) {
            case '1':
                return '待审核';
                break;
            case '2':
                return '通过';
                break;
            case '4':
                return '拒绝';
                break;
            default:
                return '异常';
                break;
        }
    }
    /*账号状态 1：正常   3：到期  5：黑名单*/
    protected function getStatusNameAttr($sta){
         switch ($sta) {
            case '0':
                return '注册未完成';
                break;
            case '1':
                return '正常';
                break;
            case '3':
                return '到期';
                break;
            case '5':
                return '黑名单';
                break;
            default:
                return '异常';
                break;
        }
    }
    /*1:普通会员   5：调度会员   10 充值会员*/
     protected function getLevelNameAttr($sta){
         switch ($sta) {
            case '0':
                return '非会员';
                break;
            case '1':
                return '普通会员';
                break;
            case '5':
                return '调度会员';
                break;
            case '10':
                return '充值会员';
                break;
            default:
                return '异常';
                break;
        }
    }
    //审核时间
     protected function getReviewTimesAttr($time){
        return $time?date('Y-m-d H:i',$time):'未审核';
    }
    //开通时间
    protected function getStartTimesAttr($time){
        return $time?date('Y-m-d H:i',$time):'未开通';
    }
     //到期时间
    protected function getEndTimesAttr($time){
        return $time?date('Y-m-d H:i',$time):'未开通';
    }
    // 手机号中间四位数标*
    protected function getTelSta($tel){
        return !empty($tel) ? substr_replace($tel, '****', 3, 4) : '';
    }
    //随机生成车商编码  唯一
    function addcode($num = 6,$str = 200)
    {
    	$code = 'C'.rand_number($num);
    	$code_id = $this->where('code',$code)->value('id');
        if($str <1 ){
            return '编号重复太多';
        }
    	if(!$code_id){
    		return $code;
    	}else{
    		self::addcode($num,$str+1);
    	}
    }

    // 关联 车商资金表
    public function usermoney()
    {
        return $this->hasOne('UsersMoney','users_id')->bind('gold,money,cash');
    }
    public function user_info(){
        return $this->hasOne('UsersInfo','users_id')->bind('zaishou,cheyuanchakan,dianhuaboda,zhongjiekanche');
    }
}