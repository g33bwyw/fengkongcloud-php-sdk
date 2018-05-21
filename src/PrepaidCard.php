<?php

/*
 * This file is part of the sh single purpose prepaid card sdk package.
 *
 * (c) liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liugj\Csb;

use Liugj\Csb\Client as CsbClient;

class PrepaidCard
{
    /**
     * version  版本.
     *
     * @var string
     */
    protected $version = '1.0.0';
    /**
     * requestUrl 请求Url.
     *
     * @var string
     */
    protected $requestUrl = 'http://101.132.39.129:8086/CSB';
    /**
     * ak Access Key.
     *
     * @var string
     */
    protected $ak = 'e7ec2742cad4432d9700ecb8d56d28a0';
    /**
     * sk Access Key Secret.
     *
     * @var string
     */
    protected $sk = 'y8ONI4Ifx4iWreeOJGRBkK+Im2o=';
    /**
     * uniqueNo  企业联网发行唯一标识.
     *
     * @var string
     */
    protected $uniqueNo = '310104F5201889100033';
    /**
     * submissionPass 私钥.
     *
     * @var string
     */
    protected $submissionPass = '';
    /**
     * csbClient.
     *
     * @var mixed
     */
    protected $csbClient = null;

    /**
     * __construct.
     *
     * @param array $options
     *
     * @return mixed
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            if (isset($this->$key)) {
                $this->$key = $value;
            }
        }

        $this->csbClient = (new CsbClient($this->requestUrl, $config['options'] ?? []));
    }

    /**
     * sendCard. 发卡
     *
     * @param array $card 预付卡信息
     *
     * @return mixed
     */
    public function sendCard(array $card = [])
    {
        return $this->request('sendCardsService', ['dataMap' => $card]);
    }

    /**
     * addRecharge. 充值
     *
     * @param array $recharge 充值信息
     *
     * @return mixed
     */
    public function addRecharge(array $recharge = [])
    {
        return $this->request('addRechargeService', ['dataMap' => $recharge]);
    }

    /**
     * addConsumption. 消费.
     *
     * @param array $consumption 消费信息
     *
     * @return mixed
     */
    public function addConsumption(array $consumption = [])
    {
        return $this->request('addConsumptionService', ['dataMap' => $consumption]);
    }

    /**
     * getRandomKey. 生成随机Key.
     *
     * @param int $length 随机字符串长度
     *
     * @return mixed
     */
    protected function getRandomKey(int $length = 10)
    {
        $str = null;
        $strPol = '0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];
        }

        return $str;
    }

    /**
     * request. 报送
     *
     * @param array $params  请求params
     * @param array $headers 请求header
     *
     * @return mixed
     */
    protected function request(string $api = '', array $params = [])
    {
        $aesKey = $this->getRandomKey();
        $symmetricKeyEncrpt = (new Rsa($this->submissionPass))->encrypt($aesKey);
        $jsonDataEncrypt = (new Aes($aesKey))->encrypt(json_encode($params));
        $dataMap = [
            'dataMap' => [
                  'uniqueNo' => $this->uniqueNo,
                  'symmetricKeyEncrpt' => $symmetricKeyEncrpt,
                  'jsonDataEncrypt' => $jsonDataEncrypt,
              ],
        ];
        $requestBody = ['dataMap' => json_encode($dataMap)];

        $headers = [];
        $headers['_api_name'] = $api;
        $headers['_api_version'] = $this->version;
        $headers['_api_access_key'] = $this->ak;
        $headers['_api_timestamp'] = $this->getMillisTime();
        $headers['_api_signature'] = $this->sign($requestBody, $headers);

        $response = $this->csbClient->post('/CSB', $requestBody, $headers);
        $responseBody = $response->json(false)->body;
        if ($responseBody->dataMap->state != 0) {
            throw  new Exception\Csb($responseBody->dataMap->errorCode);
        }

        return $response;
    }

    /**
     * getMillisTime 获取微秒.
     *
     *
     *
     * @return mixed
     */
    protected function getMillisTime()
    {
        $microtime = microtime();
        $comps = explode(' ', $microtime);

        return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
    }

    /**
     * 计算签名.
     *
     * @param array $body    调用body
     * @param array $headers 请求headers
     *
     * @return mixed
     */
    protected function sign(array $body = [], array $headers = [])
    {
        $params = array();

        foreach ($body as $k => $v) {
            $params[$k] = $v;
        }

        foreach ($headers as $k => $v) {
            if (strncmp($k, '_api_', 5) !== 0) {
                continue;
            }
            $params[$k] = $v;
        }

        ksort($params);

        $signStr = '';
        foreach ($params as $k => $v) {
            if ($k == '_api_signature') {
                continue;
            }
            if ($signStr != '') {
                $signStr = $signStr.'&';
            }
            $signStr = $signStr.$k.'='.$v;
        }

        return base64_encode(hash_hmac('sha1', $signStr, $this->sk, true));
    }
}
