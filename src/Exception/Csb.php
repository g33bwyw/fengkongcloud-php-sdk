<?php

/*
 * This file is part of the sh single purpose prepaid card sdk package.
 *
 * (c) liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liugj\Csb\Exception;

use Exception;

class Csb extends Exception
{
    /**
     * errCode 错误码
     *
     * @var string
     */
    protected $errCode = '';

    /**
     * __construct.
     *
     * @param string $errCode
     *
     * @return mixed
     */
    public function __construct(string $errCode)
    {
        $errMsg = $this->getErrMsg($errCode);
        parent :: __construct($errMsg, 3024);
    }

    /**
     * getErrMsg 获取错误描述.
     *
     * @param string $errCode
     *
     * @return mixed
     */
    protected function getErrMsg(string $errCode)
    {
        $messages = [
            'ORSS0001' => '请确认上送的随机密钥是否正确',
            'ORSS0002' => '请确认上送的企业联网发行密钥是否正确',
            'ORSS0003' => '对称密钥密文不能为空',
            'ORSS0004' => '联网发行唯一标识不能为空',
            'ORSS0005' => '上送报文不能为空',
            'ORSS0006' => '报送卡面额不能为空',
            'ORSS0007' => '卡号不能为空',
            'ORSS0008' => '卡号ID不能为空',
            'ORSS0009' => '唯一报送流水号不能为空',
            'ORSS0010' => '报送卡号有误',
            'ORSS0012' => '联网发行唯一标识不存在',
            'ORSS0014' => 'JSON报文不正确',
            'ORSS0015' => '卡面额格式不对',
            'ORSS0016' => '是否记名卡标识格式不对',
            'ORFK0001' => '领卡时间不能为空',
            'ORFK0002' => '卡本金不能为空',
            'ORFK0003' => '卡有效期起不能为空',
            'ORFK0004' => '卡有效期止不能为空',
            'ORFK0005' => '是否记名不能为空',
            'ORFK0007' => '报送重复',
            'ORFK0008' => '卡本金格式不对',
            'ORCZ0001' => '充值时间不能为空',
            'ORCZ0002' => '是否联机开户不能为空',
            'ORCZ0003' => '充值方式不能为空',
            'ORCZ0004' => '请检查报送卡是否存在',
            'ORCZ0005' => '是否联机开户标识格式不对',
            'ORCZ0006' => '充值后累计本金格式不对',
            'ORCZ0007' => '充值本金格式不对',
            'ORCZ0008' => '充值面额格式不对',
            'ORCZ0009' => '充值方式格式不对',
            'ORXF0001' => '交易时间不能为空',
            'ORXF0002' => '交易类型标识不能为空',
            'ORXF0003' => '交易后剩余本金格式不对',
            'ORXF0004' => '交易本金格式不对',
            'ORXF0005' => '交易面额格式不对',
            'ORXF0006' => '交易类型格式标识不对',
            'ORXF0007' => '是否退卡标识格式不对',
            'ORSC0001' => '上传文件大小不符合要求',
            'ORSC0002' => '文件已经上传成功，不能再次上传',
            'ORSC0003' => '写入的文件大小和发送的报文中的文件大小不一致',
            'ORSC0004' => '后续上传未带流水号',
            'ORSC0005' => '上送的流水号 和联网发行唯一标识有误，没找到对应的文件',
            'ORSC0006' => '上传文件偏转量不能为空',
            'ORSC0007' => '上传文件大小超出',
            'ORYZ0001' => '上传文件不存在',
            'ORSY0001' => '单用途预付卡系统异常',
            '0RVA0001' => '私钥不存在',
        ];

        return $messages[$errCode] ?? '单用途预付卡系统未知错误';
    }
}
