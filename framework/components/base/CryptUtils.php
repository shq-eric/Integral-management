<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 17/1/13
 * Time: 下午7:41
 */
namespace BaseComponents\base;

class CryptUtils
{
    private $iv = '00000000000000000000000000000000'; # converted JAVA byte code in to HEX and placed it here
    private $key = 'U1MjU1M0FDOUZ.Qz'; #Same as in JAVA

    function __construct() {
        $this->key = hash('sha256', $this->key, true);
        //echo $this->key.'<br/>';
    }

    public function encrypt($input, $crypt = MCRYPT_DES)
    {
        $size = mcrypt_get_block_size($crypt, MCRYPT_MODE_CBC); //3DES加密将MCRYPT_DES改为MCRYPT_3DES
        $input = $this->pkcs5_pad($input, $size); //如果采用PaddingPKCS7，请更换成PaddingPKCS7方法。
        $key = str_pad($this->key, 8, '0'); //3DES加密将8改为24
        $td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, '');
        if ($this->iv == '') {
            $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        } else {
            $iv = $this->iv;
        }
        @mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);//如需转换二进制可改成  bin2hex 转换
        return $data;
    }

    public function decrypt($encrypted, $crypt = MCRYPT_DES)
    {
        $encrypted = base64_decode($encrypted); //如需转换二进制可改成  bin2hex 转换
        $key = str_pad($this->key, 8, '0'); //3DES加密将8改为24
        $td = mcrypt_module_open($crypt, '', MCRYPT_MODE_CBC, '');//3DES加密将MCRYPT_DES改为MCRYPT_3DES
        if ($this->iv == '') {
            $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        } else {
            $iv = $this->iv;
        }
        $ks = mcrypt_enc_get_key_size($td);
        @mcrypt_generic_init($td, $key, $iv);
        $decrypted = mdecrypt_generic($td, $encrypted);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $y = $this->pkcs5_unpad($decrypted);
        return $y;
    }

    public function pkcs5_pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }

    public function PaddingPKCS7($data)
    {
        $block_size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);//3DES加密将MCRYPT_DES改为MCRYPT_3DES
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char), $padding_char);
        return $data;
    }
}

