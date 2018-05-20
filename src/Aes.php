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

    public function __construct(string $key = '')
    {
        $this->key = $key;
    }

    /**
     * This was AES-128 / CBC / PKCS5Padding
     * return base64_encode string.
     *
     * @author Terry
     *
     * @param string $plaintext
     *
     * @return string
     */
    public function encrypt(string $plaintext = '')
    {
        $plaintext = trim($plaintext);
        if ($plaintext == '') {
            return '';
        }
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);

        //PKCS5Padding
        $padding = $size - strlen($plaintext) % $size;
        // 添加Padding
        $plaintext .= str_repeat(chr($padding), $padding);

        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $key = mb_substr($this->key, 0, mcrypt_enc_get_key_size($module), 'utf-8');

        $iv = str_repeat("\0", $size);    
        /* Intialize encryption */
        mcrypt_generic_init($module, $key, $iv);

        /* Encrypt data */
        $encrypted = mcrypt_generic($module, $plaintext);

        /* Terminate encryption handler */
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);

        return base64_encode($encrypted);
    }
}
