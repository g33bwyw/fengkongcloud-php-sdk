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

class Aes
{
    protected $key = '';

    /**
     * __construct.
     *
     * @param string $key 加密秘钥
     *
     * @return mixed
     */
    public function __construct(string $key = '')
    {
        $this->key = $key;
    }

    /**
     * pkcs5Pad.
     *
     * @param string $text
     * @param int    $blockSize
     *
     * @return string
     */
    private function pkcs5Pad(string $text, int $blockSize) :string
    {
        $pad = $blockSize - (strlen($text) % $blockSize);

        return $text.str_repeat(chr($pad), $pad);
    }

    /**
     * pkcs5Unpad.
     *
     * @param string $text
     *
     * @return mixed
     */
    private function pkcs5Unpad(string $text)
    {
        $end = substr($text, -1);
        $last = ord($end);
        $len = strlen($text) - $last;
        if (substr($text, $len) == str_repeat($end, $last)) {
            return substr($text, 0, $len);
        }

        return false;
    }

    /**
     * encrypt 加密.
     *
     * @param mixed $encrypt
     *
     * @return mixed
     */
    public function encrypt($encrypt)
    {
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $paddedData = $this->pkcs5Pad($encrypt, $blockSize);
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);

        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $key = substr(openssl_digest(openssl_digest($this->key, 'sha1', true), 'sha1', true), 0, 16);
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $paddedData, MCRYPT_MODE_ECB, $iv);

        return base64_encode($encrypted);
    }
}
