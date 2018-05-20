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

use ArrayAccess;
use GuzzleHttp\Psr7\Response as GuzzleHttpResponse;
use Iterator;

class Response implements Iterator, ArrayAccess
{
    /**
     * body.
     *
     * @var mixed
     */
    public $body;
    /**
     * headers.
     *
     * @var array
     */
    public $headers = [];
    /**
     * json.
     *
     * @var string
     */
    protected $json = '';
    /**
     * code.
     *
     * @var float
     */
    public $statusCode = 200;

    /**
     * __construct.
     *
     * @param GuzzleHttpResponse $response
     *
     * @return mixed
     */
    public function __construct(GuzzleHttpResponse $response)
    {
        foreach ($response->getHeaders() as $name => $values) {
            if (!array_filter($values)) {
                continue;
            }
            $this->headers[$name] = $values;
        }
        $this->statusCode = $response->getStatusCode(); // 200
        $this->body = (string) $response->getBody();

        if ($this->statusCode != 200) {
            $reason = $response->getReasonPhrase(); // OK
            throw new Exception($reason, $this->statusCode);
        }
        $this->json = $this->json(true);
        if (!isset($this->json['code']) || $this->json['code'] != 200) {
            throw new Exception($this->json['message'], $this->json['code']);
        }
    }

    /**
     * toArray.
     *
     *
     * @return mixed
     */
    public function toArray()
    {
        return $this->json['body'];
    }

    /**
     * first.
     *
     *
     * @return mixed
     */
    public function first()
    {
        return isset($this->json['body']) && is_array($this->json['body']) ?
                 current($this->json['body']) : null;
    }

    /**
     * firstValue.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function firstValue($key)
    {
        $first = $this->first();

        return isset($first[$key]) ? $first[$key] : null;
    }

    /**
     * body.
     *
     *
     * @return mixed
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * json.
     *
     * @param mixed $assoc
     *
     * @return mixed
     */
    public function json($assoc = true)
    {
        $json = json_decode($this->body, $assoc);
        if (!$json) {
            throw new \Liugj\Csb\Exception\JsonDecode(json_last_error_msg());
        }

        return $json;
    }

    /**
     * status.
     *
     *
     * @return mixed
     */
    public function status()
    {
        return $this->header['Status-Code'];
    }

    /**
     * header.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function header($key, $default = null)
    {
        return isset($this->header[$key]) ? $this->header[$key] : $default;
    }

    /**
     * rewind.
     *
     *
     *
     * @return mixed
     */
    public function rewind()
    {
        return reset($this->json['body']);
    }

    /**
     * current.
     *
     *
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->json['body']);
    }

    /**
     * key.
     *
     *
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->json['body']);
    }

    /**
     * next.
     *
     *
     *
     * @return mixed
     */
    public function next()
    {
        return next($this->json['body']);
    }

    /**
     * valid.
     *
     *
     *
     * @return mixed
     */
    public function valid()
    {
        return is_array($this->json['body'])
            && (key($this->json['body']) !== null);
    }

    /**
     * offsetExists.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetExists($key)
    {
        return is_array($this->json['body']) ?
            isset($this->json['body'][$key]) : false;
    }

    /**
     * offsetGet.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        if (!$this->offsetExists($key)) {
            return;
        }

        return is_array($this->json['body']) ?
            $this->json['body'][$key] : null;
    }

    /**
     * offsetSet.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function offsetSet($key, $value)
    {
        throw new \Liugj\Csb\Exception\ArrayAccess('Decoded response data is immutable.');
    }

    /**
     * offsetUnset.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetUnset($key)
    {
        throw new \Liugj\Csb\Exception\ArrayAccess('Decoded response data is immutable.');
    }

    /**
     * __toString.
     *
     *
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->body;
    }
}
