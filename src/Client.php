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

use GuzzleHttp\Client as GuzzleHttpClient;

class Client
{
    /**
     * options.
     *
     * @var mixed
     */
    public $options = [];
    /**
     * baseUri.
     *
     * @var string
     */
    public $baseUri = '';

    /**
     * __construct.
     *
     * @param string $baseUri
     * @param array  $options
     *
     * @return mixed
     */
    public function __construct(string $baseUri, array $options = [])
    {
        $this->baseUri = $baseUri;
        $this->options = $options;
    }

    /**
     * __call 发送http 请求.
     *
     * @param mixed $method
     * @param mixed $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        $url = $args[0];
        $vars = isset($args[1]) ? $args[1] : [];
        $headers = (isset($args[2]) ? $args[2] : []) + ['User-Agent' => 'ishumei-php-sdk'];

        if (strtolower($method) == 'post') {
            $params = ['form_params' => $vars, 'headers' => $headers];
        } else {
            $params = ['query' => $vars, 'headers' => $headers];
        }

        if (isset($this->options['http_errors'])) {
            $params['http_errors'] = $this->options['http_errors'];
        }

        $start = microtime(true);
        $response = (new GuzzleHttpClient(
            ['base_uri' => $this->baseUri, 'timeout' => $this->options['timeout'] ?? 1.0]
        ))->request($method, $url, $params);

        $end = microtime(true);
        if (function_exists('info')) {
            info(sprintf('req(url:%s,cost:%.3fs)', $this->baseUri.$url, $end - $start));
        }

        return new Response($response);
    }
}
