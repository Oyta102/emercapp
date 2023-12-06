<?php
declare (strict_types=1);
/**
 * By: Oyta
 * Email: oyta@daucn.com
 * local: daucn.com
 * Version: V1.0.0
 **/

namespace Oyta\Emercapp;

use Oyta\Emercapp\Http\Respone;
use Oyta\Emercapp\Http\Sign;

class Parts
{
    public $OrgNo = null;//机构号
    public $aKeys = null;//密钥
    public $Url = 'http://sandbox.starpos.com.cn/emercapp'; //测试环境
    // https://gateway.starpos.com.cn/emercapp  正式环境
    public $heads = null;

    public function setConfig($orgno,$key){
        $this->OrgNo = $orgno;
        $this->aKeys = $key;
        $this->heads = array('Content-Type: application/json; charset=GBK');
    }

    //商户审核查询
    public function MerchReview($param){
        $data['serviceId'] = '6060300';
        $data['version'] = 'V2.0.0';
        $data['mercId'] = isset($param['mercId']) ? $param['mercId'] : null;
        $data['orgNo'] = $this->OrgNo;
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件MCC查询
    public function MerchMcc(){
        $data['serviceId'] = '6060203';
        $data['version'] = 'V2.0.0';
        $data['orgNo'] = $this->OrgNo;
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件区域码查询
    public function MerchArea(){
        $data['serviceId'] = '6060206';
        $data['version'] = 'V2.0.0';
        $data['orgNo'] = $this->OrgNo;
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件支行模糊查询
    public function MerchBanks($param){
        $data['serviceId'] = '6060208';
        $data['version'] = 'V2.0.0';
        $data['lbnkNm'] = isset($param['lbnkNm']) ? $param['lbnkNm'] : null;
        $data['orgNo'] = $this->OrgNo;
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件
    public function MerchInco($param){
        $date = [
            'serviceId'=>'6060601',
            'version'=>'V2.0.0',
            'incomType'=>isset($param['incomType']) ? $param['incomType'] : null, // 1-小微 2-企业 3-快速 4-个体工商户 5-特殊商户
            'stlTyp'=>isset($param['stlTyp']) ? $param['stlTyp'] : null, // 1-T+1  2-D+1
            'serviceFee'=>isset($param['serviceFee']) ? $param['serviceFee'] : null, //D+1费率
            'scanStoeCnm'=>isset($param['scanStoeCnm']) ? $param['scanStoeCnm'] : null, //扫码小票商户名称 1-20个中文,字母或数字
            'stlSign'=>isset($param['stlSign']) ? $param['stlSign'] : null, // 结算标志 1-对私 0-对公
            'orgNo'=>$this->OrgNo, //合作商机构号
            'stlOac'=>isset($param['stlOac']) ? $param['stlOac'] : null, //结算账户 1-25数字
            'bnkAcnm'=>isset($param['bnkAcnm']) ? $param['bnkAcnm'] : null, //户名
            'wcLbnkNo'=>isset($param['wcLbnkNo']) ? $param['wcLbnkNo'] : null, //开户行 联行行号
            'stoeNm'=>isset($param['stoeNm']) ? $param['stoeNm'] : null, //签购单=市+门店名称
            'stoeCntNm'=>isset($param['stoeCntNm']) ? $param['stoeCntNm'] : null, //联系人名称
            'stoeCntCardid'=>isset($param['stoeCntCardid']) ? $param['stoeCntCardid'] : null, //联系人身份证号码
            'stoeCntTel'=>isset($param['stoeCntTel']) ? $param['stoeCntTel'] : null, //联系人手机号
            'mccCd'=>isset($param['mccCd']) ? $param['mccCd'] : null, //商户类型 MCC码
            'stoeAreaCod'=>isset($param['stoeAreaCod']) ? $param['stoeAreaCod'] : null, //商户地区码
            'stoeAdds'=>isset($param['stoeAdds']) ? $param['stoeAdds'] : null, //详细地址
            'alipayFlg'=>isset($param['alipayFlg']) ? $param['alipayFlg'] : null, //扫码产品 Y-选择 N-不选择 与银行产品必选一个
            'yhkpayFlg'=>isset($param['yhkpayFlg']) ? $param['yhkpayFlg'] : null, //银行卡产品  Y-选择 N-不选择 与扫码产品必选一个
            'freezeVersion'=>isset($param['freezeVersion']) ? $param['freezeVersion'] : null, // 1-冻结  0-普通
            'mercNm'=>isset($param['mercNm']) ? $param['mercNm'] : null, // 商户经营名称 1-20个中文,字母或数字
            'wxAppid'=>isset($param['wxAppid']) ? $param['wxAppid'] : null, //公众号APPID
            'wxAppsecrect'=>isset($param['wxAppsecrect']) ? $param['wxAppsecrect'] : null, //公众号密钥
            'wxPayCatalog'=>isset($param['wxPayCatalog']) ? $param['wxPayCatalog'] : null, //公众号授权目录
            'recomWxAppid'=>isset($param['recomWxAppid']) ? $param['recomWxAppid'] : null, //推荐公众号APPID
            'icrpIdNo'=>isset($param['icrpIdNo']) ? $param['icrpIdNo'] : null, //结算人身份证号
            'crpEndDt'=>isset($param['crpEndDt']) ? $param['crpEndDt'] : null, //结算人身份证有限期
            'crpStartDt'=>isset($param['crpStartDt']) ? $param['crpStartDt'] : null, //结算人身份证起始日期
            'tranTyps'=>isset($param['tranTyps']) ? $param['tranTyps'] : null, //交易类型 C1-消费 C2-消费撤销 C3-预授权 C4-预授权完成 C5-预授权完成撤销 c6-预授权撤销 c7-余额查询
            'suptDbfreeFlg'=>isset($param['suptDbfreeFlg']) ? $param['suptDbfreeFlg'] : null, //免密免签 银行卡必选 0-不支持 1支持
            'cardTyp'=>isset($param['cardTyp']) ? $param['cardTyp'] : null, //卡种 银行卡必选 00-全部 01-借记卡
            'busLicNo'=>isset($param['busLicNo']) ? $param['busLicNo'] : null, //营业执照号 小微填写法人身份证
            'bseLiceNm'=>isset($param['bseLiceNm']) ? $param['bseLiceNm'] : null, //商户注册名1-36 企业小微必须
            'crpNm'=>isset($param['crpNm']) ? $param['crpNm'] : null, //法人姓名 企业小微必须
            'crpPhone'=>isset($param['crpPhone']) ? $param['crpPhone'] : null, //法人手机号
            'mercAdds'=>isset($param['mercAdds']) ? $param['mercAdds'] : null, //营业执照地址
            'busExpDt'=>isset($param['busExpDt']) ? $param['busExpDt'] : null, //营业执照有效期 永久 9999-12-31 其他填写身份证有效期
            'busEffDt'=>isset($param['busEffDt']) ? $param['busEffDt'] : null, //营业执照起始日期 小微填写身份证有效期
            'crpIdNo'=>isset($param['crpIdNo']) ? $param['crpIdNo'] : null, //法人身份证
            'crpExpDt'=>isset($param['crpExpDt']) ? $param['crpExpDt'] : null, //法人身份证有效期
            'crpEffDt'=>isset($param['crpEffDt']) ? $param['crpEffDt'] : null, //法人身份证起始日期
            'serFeeTyp'=>isset($param['serFeeTyp']) ? $param['serFeeTyp'] : null, //手续费收取方式 1-内扣 2-外扣 默认内扣
            'trmRec'=>isset($param['trmRec']) ? $param['trmRec'] : null, //POS终端数量 0-10
            'trmTp'=>isset($param['trmTp']) ? $param['trmTp'] : null, //台牌终端数量 0-10 开通扫码产品才能新增
            'pluNum'=>isset($param['pluNum']) ? $param['pluNum'] : null, //插件终端数量 0-10
            'trmScan'=>isset($param['trmScan']) ? $param['trmScan'] : null, //扫码设备终端数量 0-10
            'facePos'=>isset($param['facePos']) ? $param['facePos'] : null, //刷脸设备终端数量 0-10
            'aioPos'=>isset($param['aioPos']) ? $param['aioPos'] : null, //一体机终端数量 0-10
            'trmPos'=>isset($param['trmPos']) ? $param['trmPos'] : null, //传统POS机终端
            'mailbox'=>isset($param['mailbox']) ? $param['mailbox'] : null, //联系人邮箱
            'feeRatScan'=>isset($param['feeRatScan']) ? $param['feeRatScan'] : null, //微信费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat3Scan'=>isset($param['feeRat3Scan']) ? $param['feeRat3Scan'] : null, //支付宝费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat1Scan'=>isset($param['feeRat1Scan']) ? $param['feeRat1Scan'] : null, //银联二维码优惠费率 取值范围 0.25%-1.99%
            'feeRat2Scan'=>isset($param['feeRat2Scan']) ? $param['feeRat2Scan'] : null, //银联二维码标准费率 取值范围 0.25%-1.99%
            'feeRat'=>isset($param['feeRat']) ? $param['feeRat'] : null, //借记卡费率 默认0.55% 取值范围0.4%-1.99%
            'maxFeeAmt'=>isset($param['maxFeeAmt']) ? $param['maxFeeAmt'] : null, //借记卡封顶 默认20 最低18 0不封顶 银行卡产品必须
            'ysfcreditfee'=>isset($param['ysfcreditfee']) ? $param['ysfcreditfee'] : null, //云闪付贷记卡费率 默认0.38% 取值范围0.3%-10%
            'ysfdebitfee'=>isset($param['ysfdebitfee']) ? $param['ysfdebitfee'] : null, //云闪付借记卡费率 默认0.38% 取值范围0.3%-10%
            'feeRat1'=>isset($param['feeRat1']) ? $param['feeRat1'] : null,//贷记卡费率 默认0.6% 取值范围 0.52%-1.99%
            'stlOacPub'=>isset($param['stlOacPub']) ? $param['stlOacPub'] : null,//结算账号(对公) 三个字段必须同时有值或没有值
            'bnkAcnmPub'=>isset($param['bnkAcnmPub']) ? $param['bnkAcnmPub'] : null,//账户(对公) 三个字段必须同时有值或没有值
            'wcLbnkNoPub'=>isset($param['wcLbnkNoPub']) ? $param['wcLbnkNoPub'] : null,//开户行(对公) 三个字段必须同时有值或没有值
            'qtFlag'=>isset($param['qtFlag']) ? $param['qtFlag'] : null,//蜻蜓优惠标志 1-开通 0-不开通 默认不开通
            'qtFeeAmt'=>isset($param['qtFeeAmt']) ? $param['qtFeeAmt'] : null,//蜻蜓优惠金额
            'qtDiscountNum'=>isset($param['qtDiscountNum']) ? $param['qtDiscountNum'] : null,//蜻蜓优惠笔数
        ];
        $data = [
            'serviceId'=>'6060601',
            'version'=>'V2.0.0',
            'incomType'=>isset($param['incomType']) ? $param['incomType'] : null, // 1-小微 2-企业 3-快速 4-个体工商户 5-特殊商户
            'stlTyp'=>isset($param['stlTyp']) ? $param['stlTyp'] : null, // 1-T+1  2-D+1
            'scanStoeCnm'=>isset($param['scanStoeCnm']) ? $param['scanStoeCnm'] : null, //扫码小票商户名称 1-20个中文,字母或数字
            'stlSign'=>isset($param['stlSign']) ? $param['stlSign'] : null, // 结算标志 1-对私 0-对公
            'orgNo'=>$this->OrgNo, //合作商机构号
            'stlOac'=>isset($param['stlOac']) ? $param['stlOac'] : null, //结算账户 1-25数字
            'bnkAcnm'=>isset($param['bnkAcnm']) ? $param['bnkAcnm'] : null, //户名
            'wcLbnkNo'=>isset($param['wcLbnkNo']) ? $param['wcLbnkNo'] : null, //开户行 联行行号
            'stoeNm'=>isset($param['stoeNm']) ? $param['stoeNm'] : null, //签购单=市+门店名称
            'stoeCntNm'=>isset($param['stoeCntNm']) ? $param['stoeCntNm'] : null, //联系人名称
            'stoeCntCardid'=>isset($param['stoeCntCardid']) ? $param['stoeCntCardid'] : null, //联系人身份证号码
            'stoeCntTel'=>isset($param['stoeCntTel']) ? $param['stoeCntTel'] : null, //联系人手机号
            'mccCd'=>isset($param['mccCd']) ? $param['mccCd'] : null, //商户类型 MCC码
            'stoeAreaCod'=>isset($param['stoeAreaCod']) ? $param['stoeAreaCod'] : null, //商户地区码
            'stoeAdds'=>isset($param['stoeAdds']) ? $param['stoeAdds'] : null, //详细地址
            'alipayFlg'=>isset($param['alipayFlg']) ? $param['alipayFlg'] : null, //扫码产品 Y-选择 N-不选择 与银行产品必选一个
            'yhkpayFlg'=>isset($param['yhkpayFlg']) ? $param['yhkpayFlg'] : null, //银行卡产品  Y-选择 N-不选择 与扫码产品必选一个
        ];
        $date = $this->ArrFilter($date);
        $data = $this->ArrFilter($data);
        $date['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($date);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-新增门店
    public function MerchAddStore($param){
        $date=[
            'serviceId'=>'6060602',
            'version'=>'V2.0.0',
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'wxAppid'=>isset($param['wxAppid']) ? $param['wxAppid'] : null, //公众号APPID
            'wxAppsecrect'=>isset($param['wxAppsecrect']) ? $param['wxAppsecrect'] : null, //公众号密钥
            'wxPayCatalog'=>isset($param['wxPayCatalog']) ? $param['wxPayCatalog'] : null, //公众号授权目录
            'recomWxAppid'=>isset($param['recomWxAppid']) ? $param['recomWxAppid'] : null, //推荐公众号APPID
            'scanStoeCnm'=>isset($param['scanStoeCnm']) ? $param['scanStoeCnm'] : null, //小票商户名称
            'tranTyps'=>isset($param['tranTyps']) ? $param['tranTyps'] : null, //交易类型 C1-消费 C2-消费撤销 C3-预授权 C4-预授权完成 C5-预授权完成撤销 c6-预授权撤销 c7-余额查询
            'suptDbfreeFlg'=>isset($param['suptDbfreeFlg']) ? $param['suptDbfreeFlg'] : null, //免密免签 银行卡必选 0-不支持 1支持
            'cardTyp'=>isset($param['cardTyp']) ? $param['cardTyp'] : null, //卡种 银行卡必选 00-全部 01-借记卡
            'stlSign'=>isset($param['stlSign']) ? $param['stlSign'] : null, // 结算标志 1-对私 0-对公
            'stlTyp'=>isset($param['stlTyp']) ? $param['stlTyp'] : null, // 1-T+1  2-D+1
            'serviceFee'=>isset($param['serviceFee']) ? $param['serviceFee'] : null, // D+1服务费 D+1必须
            'orgNo'=>$this->OrgNo, //合作商机构号
            'stlOac'=>isset($param['stlOac']) ? $param['stlOac'] : null, //结算账户 1-25数字
            'bnkAcnm'=>isset($param['bnkAcnm']) ? $param['bnkAcnm'] : null, //户名
            'icrpIdNo'=>isset($param['icrpIdNo']) ? $param['icrpIdNo'] : null, //结算人身份证号
            'crpEndDt'=>isset($param['crpEndDt']) ? $param['crpEndDt'] : null, //结算人身份证起始日期
            'crpStartDt'=>isset($param['crpStartDt']) ? $param['crpStartDt'] : null, //结算人身份证有限期 永久9999-12-31
            'wcLbnkNo'=>isset($param['wcLbnkNo']) ? $param['wcLbnkNo'] : null, //开户行 联行行号
            'stoeNm'=>isset($param['stoeNm']) ? $param['stoeNm'] : null, //签购单=市+门店名称
            'serFeeTyp'=>isset($param['serFeeTyp']) ? $param['serFeeTyp'] : null, //手续费收取方式 1-内扣 2-外扣 默认内扣
            'stoeCntNm'=>isset($param['stoeCntNm']) ? $param['stoeCntNm'] : null, //联系人名称
            'stoeCntCardid'=>isset($param['stoeCntCardid']) ? $param['stoeCntCardid'] : null, //联系人身份证号码
            'stoeCntTel'=>isset($param['stoeCntTel']) ? $param['stoeCntTel'] : null, //联系人手机号
            'mccCd'=>isset($param['mccCd']) ? $param['mccCd'] : null, //商户类型 MCC码
            'stoeAreaCod'=>isset($param['stoeAreaCod']) ? $param['stoeAreaCod'] : null, //商户地区码
            'stoeAdds'=>isset($param['stoeAdds']) ? $param['stoeAdds'] : null, //详细地址
            'trmRec'=>isset($param['trmRec']) ? $param['trmRec'] : null, //POS终端数量 0-10
            'trmTp'=>isset($param['trmTp']) ? $param['trmTp'] : null, //台牌终端数量 0-10 开通扫码产品才能新增
            'pluNum'=>isset($param['pluNum']) ? $param['pluNum'] : null, //插件终端数量
            'facePos'=>isset($param['facePos']) ? $param['facePos'] : null, //扫脸终端
            'trmPos'=>isset($param['trmPos']) ? $param['trmPos'] : null, //传统POS终端
            'aioPos'=>isset($param['aioPos']) ? $param['aioPos'] : null, //一体机终端
            'trmScan'=>isset($param['trmScan']) ? $param['trmScan'] : null, //扫码终端数量0-10 开通扫码产品才能新增
            'mailbox'=>isset($param['mailbox']) ? $param['mailbox'] : null, //联系人邮箱
            'alipayFlg'=>isset($param['alipayFlg']) ? $param['alipayFlg'] : null, //扫码产品 Y-选择 N-不选择 与银行产品必选一个
            'yhkpayFlg'=>isset($param['yhkpayFlg']) ? $param['yhkpayFlg'] : null, //银行卡产品  Y-选择 N-不选择 与扫码产品必选一个
            'feeRatScan'=>isset($param['feeRatScan']) ? $param['feeRatScan'] : null, //微信费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat3Scan'=>isset($param['feeRat3Scan']) ? $param['feeRat3Scan'] : null, //支付宝费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat1Scan'=>isset($param['feeRat1Scan']) ? $param['feeRat1Scan'] : null, //银联二维码优惠费率 取值范围 0.25%-1.99%
            'feeRat2Scan'=>isset($param['feeRat2Scan']) ? $param['feeRat2Scan'] : null, //银联二维码标准费率 取值范围 0.25%-1.99%
            'feeRat'=>isset($param['feeRat']) ? $param['feeRat'] : null, //借记卡费率 默认0.55% 取值范围0.4%-1.99%
            'maxFeeAmt'=>isset($param['maxFeeAmt']) ? $param['maxFeeAmt'] : null, //借记卡封顶 默认20 最低18 0不封顶 银行卡产品必须
            'feeRat1'=>isset($param['feeRat1']) ? $param['feeRat1'] : null,//贷记卡费率 默认0.6% 取值范围 0.52%-1.99%
            'ysfcreditfee'=>isset($param['ysfcreditfee']) ? $param['ysfcreditfee'] : null, //云闪付贷记卡费率 默认0.38% 取值范围0.3%-10%
            'ysfdebitfee'=>isset($param['ysfdebitfee']) ? $param['ysfdebitfee'] : null, //云闪付借记卡费率 默认0.38% 取值范围0.3%-10%
            'qtFlag'=>isset($param['qtFlag']) ? $param['qtFlag'] : null,//蜻蜓优惠标志 1-开通 0-不开通 默认不开通
            'qtFeeAmt'=>isset($param['qtFeeAmt']) ? $param['qtFeeAmt'] : null, //蜻蜓优惠金额
            'qtDiscountNum'=>isset($param['qtDiscountNum']) ? $param['qtDiscountNum'] : null, //蜻蜓优惠笔数
        ];
        $data = [
            'serviceId'=>'6060602',
            'version'=>'V2.0.0',
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'scanStoeCnm'=>isset($param['scanStoeCnm']) ? $param['scanStoeCnm'] : null, //小票商户名称
            'stlSign'=>isset($param['stlSign']) ? $param['stlSign'] : null, // 结算标志 1-对私 0-对公
            'stlTyp'=>isset($param['stlTyp']) ? $param['stlTyp'] : null, // 1-T+1  2-D+1
            'orgNo'=>$this->OrgNo, //合作商机构号
            'stlOac'=>isset($param['stlOac']) ? $param['stlOac'] : null, //结算账户 1-25数字
            'bnkAcnm'=>isset($param['bnkAcnm']) ? $param['bnkAcnm'] : null, //户名
            'wcLbnkNo'=>isset($param['wcLbnkNo']) ? $param['wcLbnkNo'] : null, //开户行 联行行号
            'stoeNm'=>isset($param['stoeNm']) ? $param['stoeNm'] : null, //签购单=市+门店名称
            'stoeCntNm'=>isset($param['stoeCntNm']) ? $param['stoeCntNm'] : null, //联系人名称
            'stoeCntCardid'=>isset($param['stoeCntCardid']) ? $param['stoeCntCardid'] : null, //联系人身份证号码
            'stoeCntTel'=>isset($param['stoeCntTel']) ? $param['stoeCntTel'] : null, //联系人手机号
            'mccCd'=>isset($param['mccCd']) ? $param['mccCd'] : null, //商户类型 MCC码
            'stoeAreaCod'=>isset($param['stoeAreaCod']) ? $param['stoeAreaCod'] : null, //商户地区码
            'stoeAdds'=>isset($param['stoeAdds']) ? $param['stoeAdds'] : null, //详细地址
            'alipayFlg'=>isset($param['alipayFlg']) ? $param['alipayFlg'] : null, //扫码产品 Y-选择 N-不选择 与银行产品必选一个
            'yhkpayFlg'=>isset($param['yhkpayFlg']) ? $param['yhkpayFlg'] : null, //银行卡产品  Y-选择 N-不选择 与扫码产品必选一个
        ];
        $date = $this->ArrFilter($date);
        $data = $this->ArrFilter($data);
        $date['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($date);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-提交审核
    public function MerchSubmit($param){
        $data = [
            'serviceId'=>'6060603',
            'version'=>'V2.0.0',
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'orgNo'=>$this->OrgNo, //机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-商户资料修改
    public function MerchIncoEdit($param){
        $date = [
            'serviceId'=>'6060604',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'incomType'=>isset($param['incomType']) ? $param['incomType'] : null, // 1-小微 2-企业 3-快速 4-个体工商户
            'stlTyp'=>isset($param['stlTyp']) ? $param['stlTyp'] : null, // 1-T+1  2-D+1
            'serviceFee'=>isset($param['serviceFee']) ? $param['serviceFee'] : null, //D+1费率
            'wxAppid'=>isset($param['wxAppid']) ? $param['wxAppid'] : null, //公众号APPID
            'wxAppsecrect'=>isset($param['wxAppsecrect']) ? $param['wxAppsecrect'] : null, //公众号密钥
            'wxPayCatalog'=>isset($param['wxPayCatalog']) ? $param['wxPayCatalog'] : null, //公众号授权目录
            'recomWxAppid'=>isset($param['recomWxAppid']) ? $param['recomWxAppid'] : null, //推荐公众号APPID
            'scanStoeCnm'=>isset($param['scanStoeCnm']) ? $param['scanStoeCnm'] : null, //扫码小票商户名称 1-20个中文,字母或数字
            'tranTyps'=>isset($param['tranTyps']) ? $param['tranTyps'] : null, //交易类型 C1-消费 C2-消费撤销 C3-预授权 C4-预授权完成 C5-预授权完成撤销 c6-预授权撤销 c7-余额查询
            'suptDbfreeFlg'=>isset($param['suptDbfreeFlg']) ? $param['suptDbfreeFlg'] : null, //免密免签 银行卡必选 0-不支持 1支持
            'cardTyp'=>isset($param['cardTyp']) ? $param['cardTyp'] : null, //卡种 银行卡必选 00-全部 01-借记卡
            'stlSign'=>isset($param['stlSign']) ? $param['stlSign'] : null, // 结算标志 1-对私 0-对公
            'orgNo'=>$this->OrgNo, //合作商机构号
            'stlOac'=>isset($param['stlOac']) ? $param['stlOac'] : null, //结算账户 1-25数字
            'bnkAcnm'=>isset($param['bnkAcnm']) ? $param['bnkAcnm'] : null, //户名
            'icrpIdNo'=>isset($param['icrpIdNo']) ? $param['icrpIdNo'] : null, //结算人身份证号
            'crpEndDt'=>isset($param['crpEndDt']) ? $param['crpEndDt'] : null, //结算人身份证有限期
            'crpStartDt'=>isset($param['crpStartDt']) ? $param['crpStartDt'] : null, //结算人身份证起始日期
            'wcLbnkNo'=>isset($param['wcLbnkNo']) ? $param['wcLbnkNo'] : null, //开户行 联行行号
            'busLicNo'=>isset($param['busLicNo']) ? $param['busLicNo'] : null, //营业执照号 小微填写法人身份证
            'bseLiceNm'=>isset($param['bseLiceNm']) ? $param['bseLiceNm'] : null, //商户注册名1-36 企业小微必须
            'mercNm'=>isset($param['mercNm']) ? $param['mercNm'] : null, // 商户经营名称 1-20个中文,字母或数字
            'crpNm'=>isset($param['crpNm']) ? $param['crpNm'] : null, //法人姓名 企业小微必须
            'crpPhone'=>isset($param['crpPhone']) ? $param['crpPhone'] : null, //法人手机号
            'mercAdds'=>isset($param['mercAdds']) ? $param['mercAdds'] : null, //营业执照地址
            'busExpDt'=>isset($param['busExpDt']) ? $param['busExpDt'] : null, //营业执照有效期 永久 9999-12-31 其他填写身份证有效期
            'busEffDt'=>isset($param['busEffDt']) ? $param['busEffDt'] : null, //营业执照起始日期 小微填写身份证有效期
            'crpIdNo'=>isset($param['crpIdNo']) ? $param['crpIdNo'] : null, //法人身份证
            'crpExpDt'=>isset($param['crpExpDt']) ? $param['crpExpDt'] : null, //法人身份证有效期
            'crpEffDt'=>isset($param['crpEffDt']) ? $param['crpEffDt'] : null, //法人身份证起始日期
            'stoeNm'=>isset($param['stoeNm']) ? $param['stoeNm'] : null, //签购单=市+门店名称
            'serFeeTyp'=>isset($param['serFeeTyp']) ? $param['serFeeTyp'] : null, //手续费收取方式 1-内扣 2-外扣 默认内扣
            'stoeCntNm'=>isset($param['stoeCntNm']) ? $param['stoeCntNm'] : null, //联系人名称
            'stoeCntCardid'=>isset($param['stoeCntCardid']) ? $param['stoeCntCardid'] : null, //联系人身份证号码
            'stoeCntTel'=>isset($param['stoeCntTel']) ? $param['stoeCntTel'] : null, //联系人手机号
            'stoeAreaCod'=>isset($param['stoeAreaCod']) ? $param['stoeAreaCod'] : null, //商户地区码
            'stoeAdds'=>isset($param['stoeAdds']) ? $param['stoeAdds'] : null, //详细地址
            'trmRec'=>isset($param['trmRec']) ? $param['trmRec'] : null, //POS终端数量 0-10
            'trmTp'=>isset($param['trmTp']) ? $param['trmTp'] : null, //台牌终端数量 0-10 开通扫码产品才能新增
            'pluNum'=>isset($param['pluNum']) ? $param['pluNum'] : null, //插件终端数量 0-10
            'facePos'=>isset($param['facePos']) ? $param['facePos'] : null, //刷脸设备终端数量 0-10
            'trmPos'=>isset($param['trmPos']) ? $param['trmPos'] : null, //传统POS机终端
            'aioPos'=>isset($param['aioPos']) ? $param['aioPos'] : null, //一体机终端数量 0-10
            'trmScan'=>isset($param['trmScan']) ? $param['trmScan'] : null, //扫码设备终端数量 0-10
            'mailbox'=>isset($param['mailbox']) ? $param['mailbox'] : null, //联系人邮箱
            'alipayFlg'=>isset($param['alipayFlg']) ? $param['alipayFlg'] : null, //扫码产品 Y-选择 N-不选择 与银行产品必选一个
            'yhkpayFlg'=>isset($param['yhkpayFlg']) ? $param['yhkpayFlg'] : null, //银行卡产品  Y-选择 N-不选择 与扫码产品必选一个
            'feeRatScan'=>isset($param['feeRatScan']) ? $param['feeRatScan'] : null, //微信费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat3Scan'=>isset($param['feeRat3Scan']) ? $param['feeRat3Scan'] : null, //支付宝费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat1Scan'=>isset($param['feeRat1Scan']) ? $param['feeRat1Scan'] : null, //银联二维码优惠费率 取值范围 0.25%-1.99%
            'feeRat2Scan'=>isset($param['feeRat2Scan']) ? $param['feeRat2Scan'] : null, //银联二维码标准费率 取值范围 0.25%-1.99%
            'feeRat'=>isset($param['feeRat']) ? $param['feeRat'] : null, //借记卡费率 默认0.55% 取值范围0.4%-1.99%
            'maxFeeAmt'=>isset($param['maxFeeAmt']) ? $param['maxFeeAmt'] : null, //借记卡封顶 默认20 最低18 0不封顶 银行卡产品必须
            'feeRat1'=>isset($param['feeRat1']) ? $param['feeRat1'] : null,//贷记卡费率 默认0.6% 取值范围 0.52%-1.99%
            'ysfcreditfee'=>isset($param['ysfcreditfee']) ? $param['ysfcreditfee'] : null, //云闪付贷记卡费率 默认0.38% 取值范围0.3%-10%
            'ysfdebitfee'=>isset($param['ysfdebitfee']) ? $param['ysfdebitfee'] : null, //云闪付借记卡费率 默认0.38% 取值范围0.3%-10%
            'stlOacPub'=>isset($param['stlOacPub']) ? $param['stlOacPub'] : null,//结算账号(对公) 三个字段必须同时有值或没有值
            'bnkAcnmPub'=>isset($param['bnkAcnmPub']) ? $param['bnkAcnmPub'] : null,//账户(对公) 三个字段必须同时有值或没有值
            'wcLbnkNoPub'=>isset($param['wcLbnkNoPub']) ? $param['wcLbnkNoPub'] : null,//开户行(对公) 三个字段必须同时有值或没有值
            'qtFlag'=>isset($param['qtFlag']) ? $param['qtFlag'] : null,//蜻蜓优惠标志 1-开通 0-不开通 默认不开通
            'qtFeeAmt'=>isset($param['qtFeeAmt']) ? $param['qtFeeAmt'] : null,//蜻蜓优惠金额
            'qtDiscountNum'=>isset($param['qtDiscountNum']) ? $param['qtDiscountNum'] : null,//蜻蜓优惠笔数
        ];
        $data=[
            'serviceId'=>'6060604',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'incomType'=>isset($param['incomType']) ? $param['incomType'] : null, // 1-小微 2-企业 3-快速 4-个体工商户
            'stlTyp'=>isset($param['stlTyp']) ? $param['stlTyp'] : null, // 1-T+1  2-D+1
            'scanStoeCnm'=>isset($param['scanStoeCnm']) ? $param['scanStoeCnm'] : null, //扫码小票商户名称 1-20个中文,字母或数字
            'stlSign'=>isset($param['stlSign']) ? $param['stlSign'] : null, // 结算标志 1-对私 0-对公
            'orgNo'=>$this->OrgNo, //合作商机构号
            'stlOac'=>isset($param['stlOac']) ? $param['stlOac'] : null, //结算账户 1-25数字
            'bnkAcnm'=>isset($param['bnkAcnm']) ? $param['bnkAcnm'] : null, //户名
            'wcLbnkNo'=>isset($param['wcLbnkNo']) ? $param['wcLbnkNo'] : null, //开户行 联行行号
            'stoeNm'=>isset($param['stoeNm']) ? $param['stoeNm'] : null, //签购单=市+门店名称
            'stoeCntNm'=>isset($param['stoeCntNm']) ? $param['stoeCntNm'] : null, //联系人名称
            'stoeCntCardid'=>isset($param['stoeCntCardid']) ? $param['stoeCntCardid'] : null, //联系人身份证号码
            'stoeCntTel'=>isset($param['stoeCntTel']) ? $param['stoeCntTel'] : null, //联系人手机号
            'stoeAreaCod'=>isset($param['stoeAreaCod']) ? $param['stoeAreaCod'] : null, //商户地区码
            'stoeAdds'=>isset($param['stoeAdds']) ? $param['stoeAdds'] : null, //详细地址
            'alipayFlg'=>isset($param['alipayFlg']) ? $param['alipayFlg'] : null, //扫码产品 Y-选择 N-不选择 与银行产品必选一个
            'yhkpayFlg'=>isset($param['yhkpayFlg']) ? $param['yhkpayFlg'] : null, //银行卡产品  Y-选择 N-不选择 与扫码产品必选一个
        ];
        $date = $this->ArrFilter($date);
        $data = $this->ArrFilter($data);
        $date['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($date);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-商户修改申请
    public function MerchIcnoEditSq($param){
        $data=[
            'serviceId'=>'6060605',
            'version'=>'V2.0.0',
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-图片上传
    public function MerchPhotoUp($param){
        $data=[
            'serviceId'=>'6060606',
            'version'=>'V2.0.0',
            'mercId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //商户识别号
            'orgNo'=>$this->OrgNo, //机构号
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'imgTyp'=>isset($param['imgTyp']) ? $param['imgTyp'] : null, //图片类型 1-营业执照照片 2-税务登记证照 3-组织机构照/单位证明函 4-法人身份证正面 5-法人身份证反面 6-门头照 7-场景照 8-收银台照 9-结算人身份证正面照 10-结算人身份证反面照 11-银行卡照 12-开户行许可证照 13-法人手持证件照 14-商户协议 15-商户信息表 16-授权结算书
            'imgNm'=>isset($param['imgNm']) ? $param['imgNm'] : null, //图片名称
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $data['imgFile'] = isset($param['imgFile']) ? $param['imgFile'] : null; //不参与验签,图片转换16进制,小于或等于500KB
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-商户新增产品
    public function MerchAddProd($param){
        $date=[
            'serviceId'=>'6060607',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'tranTyps'=>isset($param['tranTyps']) ? $param['tranTyps'] : null, //交易类型 C1-消费 C2-消费撤销 C3-预授权 C4-预授权完成 C5-预授权完成撤销 c6-预授权撤销 c7-余额查询
            'suptDbfreeFlg'=>isset($param['suptDbfreeFlg']) ? $param['suptDbfreeFlg'] : null, //免密免签 银行卡必选 0-不支持 1支持
            'cardTyp'=>isset($param['cardTyp']) ? $param['cardTyp'] : null, //卡种 银行卡必选 00-全部 01-借记卡
            'orgNo'=>$this->OrgNo, //合作商机构号
            'mailbox'=>isset($param['mailbox']) ? $param['mailbox'] : null, //联系人邮箱
            'alipayFlg'=>isset($param['alipayFlg']) ? $param['alipayFlg'] : null, //扫码产品 Y-选择 N-不选择 与银行产品必选一个
            'yhkpayFlg'=>isset($param['yhkpayFlg']) ? $param['yhkpayFlg'] : null, //银行卡产品  Y-选择 N-不选择 与扫码产品必选一个
            'feeRatScan'=>isset($param['feeRatScan']) ? $param['feeRatScan'] : null, //微信费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat3Scan'=>isset($param['feeRat3Scan']) ? $param['feeRat3Scan'] : null, //支付宝费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat1Scan'=>isset($param['feeRat1Scan']) ? $param['feeRat1Scan'] : null, //银联二维码优惠费率 取值范围 0.25%-1.99%
            'feeRat2Scan'=>isset($param['feeRat2Scan']) ? $param['feeRat2Scan'] : null, //银联二维码标准费率 取值范围 0.25%-1.99%
            'feeRat'=>isset($param['feeRat']) ? $param['feeRat'] : null, //借记卡费率 默认0.55% 取值范围0.4%-1.99%
            'maxFeeAmt'=>isset($param['maxFeeAmt']) ? $param['maxFeeAmt'] : null, //借记卡封顶 默认20 最低18 0不封顶 银行卡产品必须
            'feeRat1'=>isset($param['feeRat1']) ? $param['feeRat1'] : null,//贷记卡费率 默认0.6% 取值范围 0.52%-1.99%
            'ysfcreditfee'=>isset($param['ysfcreditfee']) ? $param['ysfcreditfee'] : null, //云闪付贷记卡费率 默认0.38% 取值范围0.3%-10%
            'ysfdebitfee'=>isset($param['ysfdebitfee']) ? $param['ysfdebitfee'] : null, //云闪付借记卡费率 默认0.38% 取值范围0.3%-10%
            'trmRec'=>isset($param['trmRec']) ? $param['trmRec'] : null, //POS终端数量 0-10
            'trmTp'=>isset($param['trmTp']) ? $param['trmTp'] : null, //台牌终端数量 0-10 开通扫码产品才能新增
            'pluNum'=>isset($param['pluNum']) ? $param['pluNum'] : null, //插件终端数量 0-10
            'trmPos'=>isset($param['trmPos']) ? $param['trmPos'] : null, //传统POS机终端

        ];
        $data=[
            'serviceId'=>'6060607',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'orgNo'=>$this->OrgNo, //合作商机构号
            'alipayFlg'=>isset($param['alipayFlg']) ? $param['alipayFlg'] : null, //扫码产品 Y-选择 N-不选择 与银行产品必选一个
            'yhkpayFlg'=>isset($param['yhkpayFlg']) ? $param['yhkpayFlg'] : null, //银行卡产品  Y-选择 N-不选择 与扫码产品必选一个
            'feeRat1Scan'=>isset($param['feeRat1Scan']) ? $param['feeRat1Scan'] : null, //银联二维码优惠费率 取值范围 0.25%-1.99%
            'feeRat2Scan'=>isset($param['feeRat2Scan']) ? $param['feeRat2Scan'] : null, //银联二维码标准费率 取值范围 0.25%-1.99%
        ];
        $date = $this->ArrFilter($date);
        $data = $this->ArrFilter($data);
        $date['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($date);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-商户限额查询
    public function MerchLimit($param){
        $data=[
            'serviceId'=>'6060608',
            'version'=>'V2.0.0',
            'merc_id'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'stoe_id'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店号
            'orgNo'=>$this->OrgNo, //机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $data['signType'] = 'MD5';
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-商户资料修改-2
    //商户修改时商户状态（注册未完成、修改未完成、注册拒绝、修改拒绝,只修改传的参数，
    //不送默认不修改,修改后要提交；审核通过的商户修改后不用调用提交接口。）
    public function MerchIncoEdits($param){
        $date=[
            'serviceId'=>'6060809',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'incomType'=>isset($param['incomType']) ? $param['incomType'] : null, // 1-小微 2-企业 3-快速 4-个体工商户
            'wxAppid'=>isset($param['wxAppid']) ? $param['wxAppid'] : null, //公众号APPID
            'wxAppsecrect'=>isset($param['wxAppsecrect']) ? $param['wxAppsecrect'] : null, //公众号密钥
            'wxPayCatalog'=>isset($param['wxPayCatalog']) ? $param['wxPayCatalog'] : null, //公众号授权目录
            'recomWxAppid'=>isset($param['recomWxAppid']) ? $param['recomWxAppid'] : null, //推荐公众号APPID
            'mercAdds'=>isset($param['mercAdds']) ? $param['mercAdds'] : null, //营业执照地址
            'mercNm'=>isset($param['mercNm']) ? $param['mercNm'] : null, // 商户经营名称 1-20个中文,字母或数字
            'bseLiceNm'=>isset($param['bseLiceNm']) ? $param['bseLiceNm'] : null, //商户注册名1-36 企业小微必须
            'busLicNo'=>isset($param['busLicNo']) ? $param['busLicNo'] : null, //营业执照号 小微填写法人身份证
            'busExpDt'=>isset($param['busExpDt']) ? $param['busExpDt'] : null, //营业执照有效期 永久 9999-12-31 其他填写身份证有效期
            'busEffDt'=>isset($param['busEffDt']) ? $param['busEffDt'] : null, //营业执照起始日期 小微填写身份证有效期
            'crpExpDt'=>isset($param['crpExpDt']) ? $param['crpExpDt'] : null, //法人身份证有效期
            'crpEffDt'=>isset($param['crpEffDt']) ? $param['crpEffDt'] : null, //法人身份证起始日期
            'crpIdNo'=>isset($param['crpIdNo']) ? $param['crpIdNo'] : null, //法人身份证
            'crpNm'=>isset($param['crpNm']) ? $param['crpNm'] : null, //法人姓名 企业小微必须
            'crpPhone'=>isset($param['crpPhone']) ? $param['crpPhone'] : null, //法人手机号
            'stoeAreaCod'=>isset($param['stoeAreaCod']) ? $param['stoeAreaCod'] : null, //商户地区码
            'stoeNm'=>isset($param['stoeNm']) ? $param['stoeNm'] : null, //签购单=市+门店名称
            'stoeCntNm'=>isset($param['stoeCntNm']) ? $param['stoeCntNm'] : null, //联系人名称
            'stoeCntCardid'=>isset($param['stoeCntCardid']) ? $param['stoeCntCardid'] : null, //联系人身份证号码
            'stoeCntTel'=>isset($param['stoeCntTel']) ? $param['stoeCntTel'] : null, //联系人手机号
            'stoeAdds'=>isset($param['stoeAdds']) ? $param['stoeAdds'] : null, //详细地址
            'serFeeTyp'=>isset($param['serFeeTyp']) ? $param['serFeeTyp'] : null, //手续费收取方式 1-内扣 2-外扣 默认内扣
            'scanStoeCnm'=>isset($param['scanStoeCnm']) ? $param['scanStoeCnm'] : null, //扫码小票商户名称 1-20个中文,字母或数字
            'suptDbfreeFlg'=>isset($param['suptDbfreeFlg']) ? $param['suptDbfreeFlg'] : null, //免密免签 银行卡必选 0-不支持 1支持
            'cardTyp'=>isset($param['cardTyp']) ? $param['cardTyp'] : null, //卡种 银行卡必选 00-全部 01-借记卡
            'mailbox'=>isset($param['mailbox']) ? $param['mailbox'] : null, //联系人邮箱
            'stlTyp'=>isset($param['stlTyp']) ? $param['stlTyp'] : null, // 1-T+1  2-D+1
            'serviceFee'=>isset($param['serviceFee']) ? $param['serviceFee'] : null, //D+1费率
            'stlSign'=>isset($param['stlSign']) ? $param['stlSign'] : null, // 结算标志 1-对私 0-对公
            'stlOac'=>isset($param['stlOac']) ? $param['stlOac'] : null, //结算账户 1-25数字
            'bnkAcnm'=>isset($param['bnkAcnm']) ? $param['bnkAcnm'] : null, //户名
            'icrpIdNo'=>isset($param['icrpIdNo']) ? $param['icrpIdNo'] : null, //结算人身份证号
            'crpEndDt'=>isset($param['crpEndDt']) ? $param['crpEndDt'] : null, //结算人身份证有限期
            'wcLbnkNo'=>isset($param['wcLbnkNo']) ? $param['wcLbnkNo'] : null, //开户行 联行行号
            'crpStartDt'=>isset($param['crpStartDt']) ? $param['crpStartDt'] : null, //结算人身份证起始日期
            'trmRec'=>isset($param['trmRec']) ? $param['trmRec'] : null, //POS终端数量 0-10
            'trmTp'=>isset($param['trmTp']) ? $param['trmTp'] : null, //台牌终端数量 0-10 开通扫码产品才能新增
            'pluNum'=>isset($param['pluNum']) ? $param['pluNum'] : null, //插件终端数量 0-10
            'trmScan'=>isset($param['trmScan']) ? $param['trmScan'] : null, //扫码设备终端数量 0-10
            'facePos'=>isset($param['facePos']) ? $param['facePos'] : null, //刷脸设备终端数量 0-10
            'trmPos'=>isset($param['trmPos']) ? $param['trmPos'] : null, //传统POS机终端
            'aioPos'=>isset($param['aioPos']) ? $param['aioPos'] : null, //一体机终端数量 0-10
            'tranTyps'=>isset($param['tranTyps']) ? $param['tranTyps'] : null, //交易类型 C1-消费 C2-消费撤销 C3-预授权 C4-预授权完成 C5-预授权完成撤销 c6-预授权撤销 c7-余额查询
            'feeRatScan'=>isset($param['feeRatScan']) ? $param['feeRatScan'] : null, //微信费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat3Scan'=>isset($param['feeRat3Scan']) ? $param['feeRat3Scan'] : null, //支付宝费率% 默认0.38% 取值范围 0.25%-1.99%
            'feeRat1Scan'=>isset($param['feeRat1Scan']) ? $param['feeRat1Scan'] : null, //银联二维码优惠费率 取值范围 0.25%-1.99%
            'feeRat2Scan'=>isset($param['feeRat2Scan']) ? $param['feeRat2Scan'] : null, //银联二维码标准费率 取值范围 0.25%-1.99%
            'feeRat'=>isset($param['feeRat']) ? $param['feeRat'] : null, //借记卡费率 默认0.55% 取值范围0.4%-1.99%
            'maxFeeAmt'=>isset($param['maxFeeAmt']) ? $param['maxFeeAmt'] : null, //借记卡封顶 默认20 最低18 0不封顶 银行卡产品必须
            'feeRat1'=>isset($param['feeRat1']) ? $param['feeRat1'] : null,//贷记卡费率 默认0.6% 取值范围 0.52%-1.99%
            'ysfcreditfee'=>isset($param['ysfcreditfee']) ? $param['ysfcreditfee'] : null, //云闪付贷记卡费率 默认0.38% 取值范围0.3%-10%
            'ysfdebitfee'=>isset($param['ysfdebitfee']) ? $param['ysfdebitfee'] : null, //云闪付借记卡费率 默认0.38% 取值范围0.3%-10%
            'stlOacPub'=>isset($param['stlOacPub']) ? $param['stlOacPub'] : null,//结算账号(对公) 三个字段必须同时有值或没有值
            'bnkAcnmPub'=>isset($param['bnkAcnmPub']) ? $param['bnkAcnmPub'] : null,//账户(对公) 三个字段必须同时有值或没有值
            'wcLbnkNoPub'=>isset($param['wcLbnkNoPub']) ? $param['wcLbnkNoPub'] : null,//开户行(对公) 三个字段必须同时有值或没有值
            'qtFlag'=>isset($param['qtFlag']) ? $param['qtFlag'] : null,//蜻蜓优惠标志 1-开通 0-不开通 默认不开通
            'qtFeeAmt'=>isset($param['qtFeeAmt']) ? $param['qtFeeAmt'] : null,//蜻蜓优惠金额
            'qtDiscountNum'=>isset($param['qtDiscountNum']) ? $param['qtDiscountNum'] : null,//蜻蜓优惠笔数

        ];
        $data=[
            'serviceId'=>'6060809',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'logNo'=>isset($param['logNo']) ? $param['logNo'] : null, //流水号
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
        ];
        $date = $this->ArrFilter($date);
        $data = $this->ArrFilter($data);
        $date['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($date);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-电子签约
    public function MerchSigning($param){
        $data=[
            'serviceId'=>'6060105',
            'version'=>'V1.0.1',
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'orgNo'=>$this->OrgNo, //合作商机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-电子签约查询
    public function MerchContractInquiry($param){
        $data=[
            'serviceId'=>'6060106',
            'version'=>'V1.0.1',
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'orgNo'=>$this->OrgNo, //合作商机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-公众号/小程序配置
    public function MerchWxConfig($param){
        $data=[
            'serviceId'=>'6060111',
            'version'=>'V1.0.0',
            'stoe_id'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店号
            'Appid'=>isset($param['wxAppid']) ? $param['wxAppid'] : null, //微信APPID
            'appkey'=>isset($param['wxAppkey']) ? $param['wxAppkey'] : null, //APPKEY
            'PUBLIC_Appid'=>isset($param['recomWxAppid']) ? $param['recomWxAppid'] : null, //推荐关注
            'WX_TYPE'=>isset($param['wx_type']) ? $param['wx_type'] : null, //1-公众号 2-小程序
            'orgNo'=>$this->OrgNo, //合作商机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-公众号/小程序查询
    public function MerchWxLimit($param){
        $data=[
            'serviceId'=>'6060112',
            'version'=>'V1.0.0',
            'stoe_id'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店号
            'Appid'=>isset($param['wxAppid']) ? $param['wxAppid'] : null, //微信APPID
            'orgNo'=>$this->OrgNo, //合作商机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-授权目录报备 只支持新增 不支持修改
    public function MerchWxCatlen($param){
        $data=[
            'serviceId'=>'6060210',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'orgNo'=>$this->OrgNo, //合作商机构号
            'apiPath'=>isset($param['apiPath']) ? $param['apiPath'] : null, //授权目录
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-商户资料查询
    public function MerchLimiti($param){
        $data=[
            'serviceId'=>'6060822',
            'version'=>'V2.0.0',
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'orgNo'=>$this->OrgNo, //合作商机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);

    }

    //商户进件-开通/关闭 云音箱
    public function MercgOpenYun($param){
        $data = [
            'serviceId'=>'6060620',
            'version'=>'V1.0.0',
            'merc_id'=>isset($param['mercId']) ? $param['mercId'] : null, // 商户识别号
            'trm_no'=>isset($param['trmNo']) ? $param['trmNo'] : null, // 终端号
            'orgNo'=>$this->OrgNo, // 机构号
            'sn'=>isset($param['sn']) ? $param['sn'] : null, // sn号
            'lock_flag'=>isset($param['lock_flag']) ? $param['lock_flag'] : null, // 开关标志 0开通 1关闭
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $data['signType'] = 'MD5';
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-云音箱绑定
    public function MerchBindYun($param){
        $data=[
            'serviceId'=>'6060621',
            'version'=>'V1.0.0',
            'merc_id'=>isset($param['mercId']) ? $param['mercId'] : null, // 商户识别号
            'trm_no'=>isset($param['trmNo']) ? $param['trmNo'] : null, // 终端号
            'orgNo'=>$this->OrgNo, // 机构号
            'sn'=>isset($param['sn']) ? $param['sn'] : null, // sn号
            'device_no'=>isset($param['deviceNo']) ? $param['deviceNo'] : null, // 设备号
            'device_nm'=>isset($param['deviceNm']) ? $param['deviceNm'] : null, // 设备名称
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $data['signType'] = 'MD5';
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-云音箱解绑
    public function MerchUbindYun($param){
        $data = [
            'serviceId'=>'6060624',
            'version'=>'V1.0.0',
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'trmNo'=>isset($param['trmNo']) ? $param['trmNo'] : null, //终端号
            'orgNo'=>$this->OrgNo, //机构号
            'sn'=>isset($param['sn']) ? $param['sn'] : null, // sn号
            'deviceNo'=>isset($param['deviceNo']) ? $param['deviceNo'] : null, //设备号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $data['signType'] = 'MD5';
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-云音箱绑定查询
    public function MerchGetBindYun($param){
        $data = [
            'serviceId'=>'6060623',
            'version'=>'V1.0.0',
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'trmNo'=>isset($param['trmNo']) ? $param['trmNo'] : null, //终端号
            'orgNo'=>$this->OrgNo, //机构号
            'deviceNo'=>isset($param['deviceNo']) ? $param['deviceNo'] : null, //设备号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $data['signType'] = 'MD5';
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-查询支付宝smid,微信子商户号
    public function MerchGetSmid($param){
        $date=[
            'serviceId'=>'6060622',
            'version'=>'V1.0.0',
            'req_merclist'=>[
                'merc_id'=>isset($param['mercId']) ? $param['mercId'] : null, // 商户识别号
                'stoe_id'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店号
                'corg_merc_id'=>isset($param['corg_mercid']) ? $param['corg_mercid'] : null, //门店号
                'org_no'=>$this->OrgNo, //机构号
            ],
            'orgNo'=>$this->OrgNo, //机构号
        ];
        $data = [
            'serviceId'=>'6060622',
            'version'=>'V1.0.0',
            'orgNo'=>$this->OrgNo, //机构号
        ];
        $date = $this->ArrFilter($date);
        $data = $this->ArrFilter($data);
        $date['signValue'] = Sign::set($data,$this->aKeys);
        $date['signType'] = 'MD5';
        $json = json_encode($date);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-实名注册状态查询
    public function MerchGetReal($param){
        $data=[
            'serviceId'=>'6060116',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店号
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'orgNo'=>$this->OrgNo, //机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-实名注册修改
    public function MerchEditReal($param){
        $date=[
            'serviceId'=>'6060117',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店号
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'orgNo'=>$this->OrgNo, //机构号
            'stoeCntNm'=>isset($param['stoeCntNm']) ? $param['stoeCntNm'] : null, //联系人名称
            'stoeCntTel'=>isset($param['stoeCntTel']) ? $param['stoeCntTel'] : null, //联系人手机号
            'stoeCntCardid'=>isset($param['stoeCntCardid']) ? $param['stoeCntCardid'] : null, //联系人身份证号码
            'busLicNo'=>isset($param['busLicNo']) ? $param['busLicNo'] : null, //营业执照号 小微填写法人身份证
            'busExpDt'=>isset($param['busExpDt']) ? $param['busExpDt'] : null, //营业执照有效期 永久 9999-12-31 其他填写身份证有效期
            'busEffDt'=>isset($param['busEffDt']) ? $param['busEffDt'] : null, //营业执照起始日期 小微填写身份证有效期
            'bseLiceNm'=>isset($param['bseLiceNm']) ? $param['bseLiceNm'] : null, //商户注册名1-36 企业小微必须
            'crpNm'=>isset($param['crpNm']) ? $param['crpNm'] : null, //法人姓名 企业小微必须
            'mercAdds'=>isset($param['mercAdds']) ? $param['mercAdds'] : null, //营业执照地址
            'certType'=>isset($param['certType']) ? $param['certType'] : null, //证书类型
            //2388-事业单位法人证书
            //2389-统一社会信用码证书
            //2390-有偿服务证书(军队医院适用)
            //2391-医疗机构执业许可证(军队医院适用)
            //2392-企业营业执照(挂靠企业的党组织适用)
            //2393-组织机构代码证(政府机关适用)
            //2394-社会团体法人登记证书
            //2395-民办非企业单位等级证书
            //2396-基金会法人等级证书
            //2397-慈善组织公开募捐资格证书
            //2398-农民专业合作法人营业执照
            //2399-宗教活动场所登记证
            //2340-其他证书/批文/证明
            'certNumber'=>isset($param['certNumber']) ? $param['certNumber'] : null, //证书编号
            'certValidStart'=>isset($param['certValidStart']) ? $param['certValidStart'] : null, //证书有效起始日期
            'certValidEnds'=>isset($param['certValidEnds']) ? $param['certValidEnds'] : null, //证书有效日期
            'stoeNm'=>isset($param['stoeNm']) ? $param['stoeNm'] : null, //签购单=市+门店名称
            'stoeAdds'=>isset($param['stoeAdds']) ? $param['stoeAdds'] : null, //详细地址
            'microBizType'=>isset($param['microBizType']) ? $param['microBizType'] : null, //小微经营类型 小微必传
            //MICRO_TYPE_STORE -门店场所
            //MICRO_TYPE_MOBILE -流动经营/便民服务
            //MICRO_TYPE_ONLINE -线上商品/服务交易
            'crpExpDt'=>isset($param['crpExpDt']) ? $param['crpExpDt'] : null, //法人身份证有效期
            'crpEffDt'=>isset($param['crpEffDt']) ? $param['crpEffDt'] : null, //法人身份证起始日期
        ];
        $data=[
            'serviceId'=>'6060117',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店号
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'orgNo'=>$this->OrgNo, //机构号
            'stoeCntNm'=>isset($param['stoeCntNm']) ? $param['stoeCntNm'] : null, //联系人名称
            'stoeCntTel'=>isset($param['stoeCntTel']) ? $param['stoeCntTel'] : null, //联系人手机号
            'stoeCntCardid'=>isset($param['stoeCntCardid']) ? $param['stoeCntCardid'] : null, //联系人身份证号码
            'crpExpDt'=>isset($param['crpExpDt']) ? $param['crpExpDt'] : null, //法人身份证有效期
            'crpEffDt'=>isset($param['crpEffDt']) ? $param['crpEffDt'] : null, //法人身份证起始日期
        ];
        $date = $this->ArrFilter($date);
        $data = $this->ArrFilter($data);
        $date['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($date);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-实名注册修改图片
    public function MerchEditRealImg($param){
        $data=[
            'serviceId'=>'6060118',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'orgNo'=>$this->OrgNo, //机构号
            'imgTyp'=>isset($param['imgTyp']) ? $param['imgTyp'] : null, //图片类型
            // 1-营业执照照片 2-单位证明函照片 3-门店门头照片 4-店内环境照片 5-证件正面照片 6-证件反面照片
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $data['imgFile'] = isset($param['imgFile']) ? $param['imgFile'] : null; //不参与验签,图片转换16进制,小于或等于500KB
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-实名注册修改提交
    public function MerchEditRealSubmit($param){
        $data=[
            'serviceId'=>'6060119',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //门店ID
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //商户识别号
            'orgNo'=>$this->OrgNo, //机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-商户合并入账
    public function MerchMergeInFunds($param){
        $data=[
            'serviceId'=>'6060821',
            'version'=>'V2.0.0',
            'stoeId'=>isset($param['stoeId']) ? $param['stoeId'] : null, //主商户门店号
            'mercId'=>isset($param['mercId']) ? $param['mercId'] : null, //主商户识别号
            'orgNo'=>$this->OrgNo, //机构号
            'stoeNo'=>isset($param['stoeNo']) ? $param['stoeNo'] : null, //被合并商户门店号
            'mercNo'=>isset($param['mercNo']) ? $param['mercNo'] : null, //被合并商户识别号
            'mergeSts'=>isset($param['mergeSts']) ? $param['mergeSts'] : null, //合并类型 1合并 2取消合并
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }

    //商户进件-商户分级信息查询
    public function MerchGradingInfo($param){
        $data=[
            'serviceId'=>'6060825',
            'version'=>'V2.0.0',
            'mercNo'=>isset($param['mercNo']) ? $param['mercNo'] : null, //商户号
            'smId'=>isset($param['smId']) ? $param['smId'] : null, //smId
            'orgNo'=>$this->OrgNo, //机构号
        ];
        $data = $this->ArrFilter($data);
        $data['signValue'] = Sign::set($data,$this->aKeys);
        $json = json_encode($data);
        $res = Respone::http_post($this->Url,$json,$this->heads);
        return $this->strToUtf8($res);
    }






    //商户进件排序与数组过滤
    protected function ArrFilter($data){
        $data = array_filter($data,function ($val){
            return ($val === ''|| $val === null) ? false : true;
        });
        ksort($data);
        return $data;
    }

    /**
     * gbk转utf-8
     **/
    protected function strToUtf8($str){
        $encode = mb_detect_encoding($str, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        if($encode == 'UTF-8'){
            $res = $str;
        }else{
            $res = mb_convert_encoding($str, 'UTF-8', $encode);
        }
        return json_decode(urldecode($res),true);
    }
}