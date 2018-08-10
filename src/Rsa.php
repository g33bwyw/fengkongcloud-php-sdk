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

class Rsa
{
    protected $privateKey = '';

    public function __construct(string $key = '')
    {
        $pem = "-----BEGIN PRIVATE KEY-----\n".chunk_split($key, 64, "\n").'-----END PRIVATE KEY-----';

        $this->privateKey = openssl_pkey_get_private($pem);
    }

    /**
     * encrypt  加密.
     *
     * @param string $text 明文
     * @param string $key  私钥
     *
     * @return string
     */
    public function encrypt(string $text = '') :string
    {
        $encrypted = '';
        openssl_private_encrypt($text, $encrypted, $this->privateKey);

        return base64_encode($encrypted);
    }
}
