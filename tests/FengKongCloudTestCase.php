<?php

/*
 * This file is part of the sh single purpose prepaid card sdk package.
 *
 * (c) liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Bqrd\IShuMei\Aes;
use Bqrd\IShuMei\PrepaidCard;
use Bqrd\IShuMei\Rsa;
use PHPUnit\Framework\TestCase;

class PrepaidTestCase extends TestCase
{
    public $prepaidCard = null;

    public function setUp()
    {
        $config = [
            'version'        => '1.0.0',
            'requestUrl'     => 'http://101.132.39.129:8086/CSB',
            'ak'             => 'e7ec2742cad4432d9700ecb8d56d28a0',
            'sk'             => 'y8ONI4Ifx4iWreeOJGRBkK+Im2o=',
            'uniqueNo'       => '310104F5201889100033',
            'submissionPass' => 'MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBALI6G+lzFj1aGym4iq9JY53dyAFBRrRlvo8VnDhcIyMXrIko20lZIAL95Hvbk6Bs1suoURU0Y8+jAd/YH/jGHww6AXYljFC5PSf3lPd3YXoGrxk+iDZz60Q1K7xqsrtbHVQzySiXyMBjQ4tZbsIqD5c4UXkccp/JSwd4HNxZXiEFAgMBAAECgYEAgGzO4BFF3T+ogw+vH0/KsF63V/ApeqQ2A/SWdSYvS4IrmUoPeXL3VjCNC5LVdav3uxi2FImDwoK7PwkFQMXCaF97ZvAZ3S6x+D+aubkizc4b3TXQ84hwV6LGOMZjvnKXjNhUHd6gLc0OYGzziwkoLa1KcoxyZrZC5IbehlRoHwECQQDtPU7x/LajoC0yydjSzw9bBjIUI8t30pSHsgYq0YxR/WzDc+TVL2afzKeHPu8KQoaLXRhMBQGSCkBqJUSJGJ3ZAkEAwFIl1ohfy4uueeyt3Z6QvhUAORqZQCmvngxRsrFo2poS+w+2aOG1HG61AljOrNvnOs9XzLcQ4GwLIeZZC2PlDQJBAI5VBQMrwgvDMrrQ3NQFREoxGmR44T6/STtsNEUGOXCLYfCVnInGiYSADVaYDGQUa5I7RTN+oWWT3veP6mFyMmkCQQCLd4clCoSdsU/37yEuxBynG8eroZRdKV3HuZtNgMZPMMhu9LgNWxDh646sgwZt6JLI3TAIrwE4HmH8VXVhgzHJAkBlHu3Xm4ffPPEoO0ByBUEkS8VreRo6Eqt4WtRIPbXbQoL5W192XeR+CqFeeb8K+s3fzdjWt1q1b71vl20XGb/H',
            'options'        => [],
        ];

        $this->prepaidCard = new PrepaidCard($config);
    }

    public function testRsaEncrypt()
    {
        $submissionPass = 'MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBALI6G+lzFj1aGym4iq9JY53dyAFBRrRlvo8VnDhcIyMXrIko20lZIAL95Hvbk6Bs1suoURU0Y8+jAd/YH/jGHww6AXYljFC5PSf3lPd3YXoGrxk+iDZz60Q1K7xqsrtbHVQzySiXyMBjQ4tZbsIqD5c4UXkccp/JSwd4HNxZXiEFAgMBAAECgYEAgGzO4BFF3T+ogw+vH0/KsF63V/ApeqQ2A/SWdSYvS4IrmUoPeXL3VjCNC5LVdav3uxi2FImDwoK7PwkFQMXCaF97ZvAZ3S6x+D+aubkizc4b3TXQ84hwV6LGOMZjvnKXjNhUHd6gLc0OYGzziwkoLa1KcoxyZrZC5IbehlRoHwECQQDtPU7x/LajoC0yydjSzw9bBjIUI8t30pSHsgYq0YxR/WzDc+TVL2afzKeHPu8KQoaLXRhMBQGSCkBqJUSJGJ3ZAkEAwFIl1ohfy4uueeyt3Z6QvhUAORqZQCmvngxRsrFo2poS+w+2aOG1HG61AljOrNvnOs9XzLcQ4GwLIeZZC2PlDQJBAI5VBQMrwgvDMrrQ3NQFREoxGmR44T6/STtsNEUGOXCLYfCVnInGiYSADVaYDGQUa5I7RTN+oWWT3veP6mFyMmkCQQCLd4clCoSdsU/37yEuxBynG8eroZRdKV3HuZtNgMZPMMhu9LgNWxDh646sgwZt6JLI3TAIrwE4HmH8VXVhgzHJAkBlHu3Xm4ffPPEoO0ByBUEkS8VreRo6Eqt4WtRIPbXbQoL5W192XeR+CqFeeb8K+s3fzdjWt1q1b71vl20XGb/H';
        $text = '7579366565318556864';
        $aesKey = (new Rsa($submissionPass))->encrypt($text);
        $this->assertEquals($aesKey, 'Ae2TQeRrc5bHcc6y5/P04ATB64Nm0NGJvocPiMZxiZliSjAyS7BUjN1bF2bgH/Q5Dnhy50Wj23lAF6LrbPfnmdbeiIBwJFJvqDBolsG+6m0LC0yk5miebOeJY5/88uwZWwIwsu4Ugt+AbzU0eMQBg8qS/KRNqcwskmwn6Q2ksVo=');

        $text2 = '{"dataMap":{"expiryDate":"20991231","beginDate":"20181212","rev":"","cardID":"123","cardBalance":"1000","cardMon":"100","applyTime":"20180404000000","cardNo":"123","isRegister":"0","serialNo":"111"}}';
        $text2Encypt = (new Aes($text))->encrypt($text2);
        $text2EncyptCmp = 'TsPQ7/fQuHef9jpeh9h/jTnZEW47USr6iXDr9H4i00kYb09pdbNMTtXPuDVwCMgIHwfBOx1exwKrk2dsVCZQT6uY2Fb3QQjAiql9OuvOHwXYo4RJxMKsgQZW/3RgkDaRYO47fORPDVRtVjgyOk01i5gl2xJ6+Ts79t+BoIqs5dYE23eIOWxYYH0FZHmiASPodFixxQp4Y61/VuawBv4/M7qgkUaD4MnodJh0yhcKDv95nrK4pxlJT3XzWMzWfhM+uIO+KCXUexa+uIWyB/kiPg==';
        $this->assertEquals($text2Encypt, $text2EncyptCmp);
    }

    public function testSendCardsService()
    {
        $param = [
            'cardID'      => '123',
            'cardNo'      => '123',
            'cardMon'     => '100',
            'serialNo'    => '111',
            'cardBalance' => '1000',
            'applyTime'   => '20180404000000',
            'beginDate'   => '20181212',
            'expiryDate'  => '20991231',
            'isRegister'  => '0',
            'rev'         => '',
        ];
        $response = $this->prepaidCard->sendCard($param)->json(false);
        var_dump($response);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('SUCCESS', $response->message);
    }

    public function testAddRechargeService()
    {
        $param = [
            'cardID'      => '123114444',
            'cardNo'      => '123114444',
            'cardMon'     => '100ii',
            'serialNo'    => '111ee',
            'cardBalance' => '1000',
            'chargeTime'  => '20180404000000',
            'isOpenAcc'   => 0,
        ];
        $response = $this->prepaidCard->sendCard($param)->json(false);
        var_dump($response);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('SUCCESS', $response->message);
    }
}
