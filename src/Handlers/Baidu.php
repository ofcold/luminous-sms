<?php

namespace AnomalyLab\LuminousSMS\Handlers;

use AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
use AnomalyLab\LuminousSMS\Contracts\MessagerInterface;
use AnomalyLab\LuminousSMS\Support\Arrays;

/**
 *	Class Baidu
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Handlers\Baidu
 */
class Baidu extends Handler
{
	/**
	 *	The handler name.
	 *
	 *	@var		string
	 */
	protected $name = 'baidu';

	protected const REQUEST_HOST = 'sms.bj.baidubce.com';

	protected const REQUEST_URI = '/bce/v2/message';

	protected const BCE_AUTH_VERSION = 'bce-auth-v1';

	protected const DEFAULT_EXPIRATION_IN_SECONDS = 1800; //签名有效期默认1800秒
	
	protected const SUCCESS_CODE = 1000;

	/**
	 *	Seed message.
	 *
	 *	The current drive service providers to implement push information content.
	 *
	 *	@param		\AnomalyLab\LuminousSMS\Contracts\MessagerInterface		$messager
	 *
	 *	@return		array
	 *
	 *	@throws		\AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send(MessagerInterface $messager) : array
	{
		$params = [
			'invokeId'		=> Arrays::get($this->config, 'invoke_id'),
			'phoneNumber'	=> $messager->getMobilePhone(),
			'templateCode'	=> $messager->getTemplate(),
			'contentVar'	=> $messager->getData(),
		];

		$datetime = date('Y-m-d\TH:i:s\Z');
		$headers = [
			'host'					=> static::REQUEST_HOST,
			'content-type'			=> 'application/json',
			'x-bce-date'			=> $datetime,
			'x-bce-content-sha256'	=> hash('sha256', json_encode($params)),
		];

		//	Get the data you need to sign.
		$headers['Authorization'] = $this->generateSign(
			$this->getHeadersToSign($headers, ['host', 'x-bce-content-sha256']),
			$datetime
		);


		$result = $this->request('post', $this->buildRequest(), ['headers' => $headers, 'json' => $params]);

		if ( static::SUCCESS_CODE != $result['code'] )
		{
			throw new HandlerBadException($result['message'], $result['code'], $result);
		}

		return $result;
	}

	/**
	 *	Build endpoint url.
	 *
	 *	@return		string
	 */
	protected function buildRequest() : string
	{
		return 'http://' . Arrays::get('domain', static::REQUEST_HOST).static::REQUEST_URI;
	}

	/**
	 *	Generate Authorization header.
	 *
	 *	@param		array			$headers
	 *	@param		int				$datetime
	 *
	 *	@return		string
	 */
	protected function generateSign(array $headers, int $datetime) : string
	{
		$auth = static::BCE_AUTH_VERSION . '/' . Arrays::get($this->config, 'ak') . '/' . $datetime . '/' .static::DEFAULT_EXPIRATION_IN_SECONDS;

		return sprintf(
			'%s/%s/%s',
			$auth,
			empty($headers) ? '' : strtolower(trim(implode(';', array_keys($headers)))),
			hash_hmac(
				'sha256',
				"POST\n{str_replace('%2F', '/', rawurlencode(static::REQUEST_URI))}\n''\n{$this->getCanonicalHeaders($headers)}",
				hash_hmac('sha256', $auth, Arrays::get($this->config, 'sk'))
			)
		);
	}

	/**
	 *	Generate a standardized http request header string.
	 *
	 *	@param		array		$headers
	 *
	 *	@return		string
	 */
	protected function getCanonicalHeaders(array $headers) : string
	{
		$headerStrings = [];

		foreach ( $headers as $name => $value )
		{
			$headerStrings[] = rawurlencode(strtolower(trim($name))) . ':' . rawurlencode(trim($value));
		}

		return implode("\n", sort($headerStrings));
	}

	/**
	 *	According to the specified keys filter signature should be involved in the header.
	 *
	 *	@param		array		$headers
	 *	@param		array		$keys
	 *
	 *	@return		array
	 */
	protected function getHeadersToSign(array $headers, array $keys) : array
	{
		return array_intersect_key($headers, array_flip($keys));
	}
}