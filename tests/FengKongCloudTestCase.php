<?php

/*
 * This file is part of the sh single purpose prepaid card sdk package.
 *
 * (c) liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Bqrd\IShuMei\FengKongCloud;
use PHPUnit\Framework\TestCase;

class PrepaidTestCase extends TestCase
{
    public $fengKongCloud = null;

    public function setUp()
    {
        $config = [
            'version' => '2.0',
            'requestUrl' => 'http://api.fengkongcloud.com/',
            'accessKey' => 'O7MFGXPJhIJ9Yd2tUPlB',
            'appId' => 'rQ4s5hnrh9LiRtfkPA4k',
            'appId' => 'default',
            'options' => [
                'timeout' => 1.0,
            ],
        ];

        $this->fengKongCloud = new FengKongCloud($config);
    }

    public function testRegister()
    {
        $param = [
          'tokenId' => '23432',
          'eventName' => '注册',
          'deviceId' => 'dfafasfdas',
          'ip' => '172.16.76.251',
          'signupPlatform' => 'phone',
          'phone' => '18611615170',
          'getCoupon' => 0,

        ];
        $response = $this->fengKongCloud->register($param)->json(false);
        var_dump($response);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('SUCCESS', $response->message);
    }

    public function testAddRechargeService()
    {
        $param = [
            'cardID' => '123114444',
            'cardNo' => '123114444',
            'cardMon' => '100ii',
            'serialNo' => '111ee',
            'cardBalance' => '1000',
            'chargeTime' => '20180404000000',
            'isOpenAcc' => 0,
        ];
        $response = $this->fengKongCloud->sendCard($param)->json(false);
        var_dump($response);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('SUCCESS', $response->message);
    }
}
