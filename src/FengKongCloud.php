<?php

/*
 * This file is part of the sh single purpose prepaid card sdk package.
 *
 * (c) liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bqrd\IShuMei;

use Bqrd\IShuMei\Client as FengKongCloudClient;

class FengKongCloud
{
    /**
     * version  版本.
     *
     * @var string
     */
    protected $version = '2.0';
    /**
     * requestUrl 请求Url.
     *
     * @var string
     */
    protected $requestUrl = 'http://api.fengkongcloud.com/';
    /**
     * Access Key.
     *
     * @var string
     */
    protected $accessKey = 'e7ec2742cad4432d9700ecb8d56d28a0';
    /**
     * AppId.
     *
     * @var string
     */
    protected $appId = 'y8ONI4Ifx4iWreeOJGRBkK+Im2o=';
    /**
     * client.
     *
     * @var mixed
     */
    protected $client = null;

    /**
     * __construct.
     *
     * @param array $config
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

        $this->client = new FengKongCloudClient($this->requestUrl, $config['options'] ?? []);
    }

    /**
     * register 注册.
     *
     * @param array $post 注册数据
     *
     * @return mixed
     */
    public function register(array $post = [])
    {
        return $this->request('/v2/event', $post, 'register');
    }

    /**
     * login.
     *
     * @param array $post
     */
    public function login(array $post = [])
    {
        return $this->request('/v2/event', $post, 'login');
    }

    /**
     * invite.
     *
     * @param array $post
     */
    public function invite(array $post = [])
    {
        return $this->request('/v2/event', $post, 'fission');
    }

    /**
     * order.
     *
     * @param array $post
     */
    public function order(array $post = [])
    {
        return $this->request('/v2/event', $post, 'order');
    }

    /**
     * task.
     *
     * @param array $post
     */
    public function task(array $post = [])
    {
        return $this->request('/v2/event', $post, 'task');
    }

    /**
     * coupon.
     *
     * @param array $post
     */
    public function coupon(array $post = [])
    {
        return $this->request('/v2/event', $post, 'coupon');
    }

    /**
     * batchQuery.
     *
     * @param array $data
     * @param array $criteria
     */
    public function batchQuery(array $data = [], array $criteria = [])
    {
        $json = json_encode(array_merge($criteria, [
            'accessKey' => $this->accessKey,
            'appId' => $this->appId,
            'data' => $params,
        ]));

        $response = $this->client->post('/v2/account/risk_accounts', $json);
        $responseBody = $response->json(false)->body;
        if ($responseBody->dataMap->state != 0) {
            throw  new Exception\FengKongCloud($responseBody->dataMap->errorCode);
        }

        return $response;
    }

    /**
     * request 上报.
     *
     * @param string $uri
     * @param array  $params
     * @param string $eventId
     */
    protected function request(string $uri = '', array $params = [], string $eventId = 'register')
    {
        $json = json_encode([
            'accessKey' => $this->accessKey,
            'appId' => $this->appId,
            'eventId' => $eventId,
            'data' => $params,
        ]);

        $response = $this->client->post($uri, $json);
        $responseBody = $response->json(false)->body;
        if ($responseBody->dataMap->state != 0) {
            throw  new Exception\FengKongCloud($responseBody->dataMap->errorCode);
        }

        return $response;
    }
}
