# 星POS 商户进件PHPdemo

> composer
~~~
composer require oyta/emercapp
~~~

引入
~~~
use Oyta\Emercapp\Parts;
~~~

基本配置
~~~
$parts = new Parts();
$orgNo = 'xxx';
$key = 'xxxx';
$parts->setConfig($orgNo,$key);
~~~

使用
~~~
$data=[
  'incomType'=>'2',
  ......
];
$res = $parts->MerchInco($data);
dump($res);
~~~

接口
> 商户审核查询
~~~
$parts->MerchReview();
~~~
> 商户MCC查询
~~~
$parts->MerchMcc();
~~~
> 商户区域码查询
~~~
$parts->MerchArea();
~~~
> 商户支行模糊查询
~~~
$parts->MerchBanks();
~~~
> 商户进件
~~~
$parts->MerchInco();
~~~
> 商户新增门店
~~~
$parts->MerchAddStore();
~~~
> 商户提交审核
~~~
$parts->MerchSubmit();
~~~
> 商户资料修改
~~~
$parts->MerchIncoEdit();
~~~
> 商户修改申请
~~~
$parts->MerchIcnoEditSq();
~~~
> 商户图片上传
~~~
$parts->MerchPhotoUp();
~~~
> 商户新增产品
~~~
$parts->MerchAddProd();
~~~
> 商户限额查询
~~~
$parts->MerchLimit();
~~~
> 商户资料修改-审核通过的商户修改后不用调用提交
~~~
$parts->MerchIncoEdits();
~~~
> 商户电子签约
~~~
$parts->MerchSigning();
~~~
> 商户电子签约查询
~~~
$parts->MerchContractInquiry();
~~~
> 商户公众号/小程序配置
~~~
$parts->MerchWxConfig();
~~~
> 商户公众号/小程序查询
~~~
$parts->MerchWxLimit();
~~~
> 商户授权目录报备 只支持新增 不支持修改
~~~
$parts->MerchWxCatlen();
~~~
> 商户商户资料查询
~~~
$parts->MerchLimiti();
~~~
> 商户开通/关闭 云音箱
~~~
$parts->MercgOpenYun();
~~~
> 商户云音箱绑定
~~~
$parts->MerchBindYun();
~~~
> 商户云音箱解绑
~~~
$parts->MerchUbindYun();
~~~
> 商户云音箱绑定查询
~~~
$parts->MerchGetBindYun();
~~~
> 商户查询支付宝smid,微信子商户号
~~~
$parts->MerchGetSmid();
~~~
> 商户实名注册状态查询
~~~
$parts->MerchGetReal();
~~~
> 商户实名注册修改
~~~
$parts->MerchEditReal();
~~~
> 商户实名注册修改图片
~~~
$parts->MerchEditRealImg();
~~~
> 商户实名注册修改提交
~~~
$parts->MerchEditRealSubmit();
~~~
> 商户合并入账
~~~
$parts->MerchMergeInFunds();
~~~
> 商户分级信息查询
~~~
$parts->MerchGradingInfo();
~~~
参数代码里面自己对着看! 太多了懒得写  date[]是所有参数  data[]是参与签名参数
