<?php

namespace BaseComponents\base;

/**
 * des加密解密
 * 
 * @author bigticket
 * @date   2014-03-12
 *
 */
class DesEncode {
	const VKEY = 'vip_weixin_purchase_!@#$';
	
	/**
	 * 加密
	 *
	 * @param
	 *        	$input
	 * @return string
	 */
	public static function encrypt($input) {
		if (empty ( $input )) {
			return '';
		}
		$size = mcrypt_get_block_size ( 'des', 'ecb' );
		$input = self::pkcs5_pad ( $input, $size );
		$td = mcrypt_module_open ( 'des', '', 'ecb', '' );
		$iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );
		@mcrypt_generic_init ( $td, self::VKEY, $iv );
		$data = mcrypt_generic ( $td, $input );
		mcrypt_generic_deinit ( $td );
		mcrypt_module_close ( $td );
		return base64_encode ( $data );
	}
	
	/**
	 * 解密
	 *
	 * @param
	 *        	$input
	 * @return string
	 */
	public static function decrypt($encrypted) {
		if (empty ( $encrypted )) {
			return '';
		}
		$encrypted = base64_decode ( $encrypted );
		if (empty ( $encrypted )) {
			return '';
		}
		$td = mcrypt_module_open ( 'des', '', 'ecb', '' );
		// 使用MCRYPT_DES算法,cbc模式
		$iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );
		$ks = mcrypt_enc_get_key_size ( $td );
		@mcrypt_generic_init ( $td, self::VKEY, $iv );
		// 初始处理
		$decrypted = mdecrypt_generic ( $td, $encrypted );
		// 解密
		mcrypt_generic_deinit ( $td );
		// 结束
		mcrypt_module_close ( $td );
		return self::pkcs5_unpad ( $decrypted );
	}
	
	/**
	 *
	 * @return string
	 */
	public static function pkcs5_pad($text, $blocksize) {
		$pad = $blocksize - (strlen ( $text ) % $blocksize);
		return $text . str_repeat ( chr ( $pad ), $pad );
	}
	
	/**
	 *
	 * @param
	 *        	$text
	 * @return string
	 */
	public static function pkcs5_unpad($text) {
		$pad = ord ( $text {strlen ( $text ) - 1} );
		if ($pad > strlen ( $text )) {
			return false;
		}
		if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad) {
			return false;
		}
		return substr ( $text, 0, - 1 * $pad );
	}
} 
