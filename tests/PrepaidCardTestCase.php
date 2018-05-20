<?php

/*
 * This file is part of the sh single purpose prepaid card sdk package.
 *
 * (c) liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Liugj\Csb\PrepaidCard;
use PHPUnit\Framework\TestCase;

class PrepaidTestCase extends TestCase
{
    public $prepaidCard = null;

    public function setUp()
    {
        $config = [
            'version' => '1.0.0',
            'requestUr' => 'http://101.132.39.129:8086/CSB',
            'ak' => 'e7ec2742cad4432d9700ecb8d56d28a0',
            'sk' => 'y8ONI4Ifx4iWreeOJGRBkK+Im2o=',
            'uniqueNo' => '310104F5201889100033',
            'submissionPass' => 'MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBALI6G+lzFj1aGym4iq9JY53dyAFBRrRlvo8VnDhcIyMXrIko20lZIAL95Hvbk6Bs1suoURU0Y8+jAd/YH/jGHww6AXYljFC5PSf3lPd3YXoGrxk+iDZz60Q1K7xqsrtbHVQzySiXyMBjQ4tZbsIqD5c4UXkccp/JSwd4HNxZXiEFAgMBAAECgYEAgGzO4BFF3T+ogw+vH0/KsF63V/ApeqQ2A/SWdSYvS4IrmUoPeXL3VjCNC5LVdav3uxi2FImDwoK7PwkFQMXCaF97ZvAZ3S6x+D+aubkizc4b3TXQ84hwV6LGOMZjvnKXjNhUHd6gLc0OYGzziwkoLa1KcoxyZrZC5IbehlRoHwECQQDtPU7x/LajoC0yydjSzw9bBjIUI8t30pSHsgYq0YxR/WzDc+TVL2afzKeHPu8KQoaLXRhMBQGSCkBqJUSJGJ3ZAkEAwFIl1ohfy4uueeyt3Z6QvhUAORqZQCmvngxRsrFo2poS+w+2aOG1HG61AljOrNvnOs9XzLcQ4GwLIeZZC2PlDQJBAI5VBQMrwgvDMrrQ3NQFREoxGmR44T6/STtsNEUGOXCLYfCVnInGiYSADVaYDGQUa5I7RTN+oWWT3veP6mFyMmkCQQCLd4clCoSdsU/37yEuxBynG8eroZRdKV3HuZtNgMZPMMhu9LgNWxDh646sgwZt6JLI3TAIrwE4HmH8VXVhgzHJAkBlHu3Xm4ffPPEoO0ByBUEkS8VreRo6Eqt4WtRIPbXbQoL5W192XeR+CqFeeb8K+s3fzdjWt1q1b71vl20XGb/H',
            'options' => [],
        ];

        $this->prepaidCard = new PrepaidCard($config);
    }

    public function testSendCardsService()
    {
        $param = [
            'cardID' => '123',
            'cardNo' => '123',
            'cardMon' => '100',
            'serialNo' => '111',
            'cardBalance' => '1000',
            'applyTime' => '20180404000000',
            'beginDate' => '20181212',
            'expiryDate' => '20991231',
            'isRegister' => 0,
        ];
        $response = $this->prepaidCard->sendCard($param)->json(false);
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
        $response = $this->prepaidCard->sendCard($param)->json(false);
        var_dump($response);
        $this->assertEquals(200, $response->code); 
        $this->assertEquals('SUCCESS', $response->message); 
    }
}
