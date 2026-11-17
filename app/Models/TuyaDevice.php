<?php

namespace App\Models;

use Illuminate\Support\Arr;

/**
 * This is the model class for Generic Tuya Device api
 *
 * @property string $apiVersion
 * @property string $deviceId
 * @property array $units
 */

class TuyaDevice
{
	protected $apiVersion;
	protected $deviceId;
	protected $units;

	public function __construct($params =[])
	{
		foreach($params as $k => $v) {
			$this->setProperty($k, $v);
		}
	}

	public function setProperty($property, $value)
	{
		if(property_exists(static::class, $property)) {
			$this->$property = $value;
		}
	}

	/**
	 * Метод для выполнения подписанных запросов к Tuya API v2.0
	 */
	protected static function tuyaRequest(
		$method, 
		$path, 
		$clientId, 
		$clientSecret, 
		$baseUrl, $accessToken = ''
	)
	{
	    $t = round(microtime(true) * 1000); // Текущее время в миллисекундах
	    $nonce = '';
	    $body = ''; // Для GET-запросов тело пустое
	    
	    // Хэш тела запроса (SHA256 от пустой строки)
	    $contentHash = hash('sha256', $body);
	    
	    // Формируем строку для подписи
	    $stringToSign = $method . "\n" . $contentHash . "\n" . "" . "\n" . $path;
	    
	    // Собираем финальную строку (с токеном или без, если запрашиваем сам токен)
	    $str = $clientId . $accessToken . $t . $nonce . $stringToSign;
	    
	    // Генерируем подпись HMAC-SHA256 в верхнем регистре
	    $sign = strtoupper(hash_hmac('sha256', $str, $clientSecret));

	    $headers = [
	        'client_id: ' . $clientId,
	        'sign: ' . $sign,
	        't: ' . $t,
	        'sign_method: HMAC-SHA256',
	        'Content-Type: application/json'
	    ];

	    if (!empty($accessToken)) {
	        $headers[] = 'access_token: ' . $accessToken;
	    }

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $baseUrl . $path);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	    
	    $response = curl_exec($ch);
	    if (curl_errno($ch)) {
	        die('Ошибка cURL: ' . curl_error($ch));
	    }
	    curl_close($ch);

	    return json_decode($response, true);
	}

	/** Makes new instance of Tuya device 
	 * 
	 * @param string $apiVersion
	 * @param string $deviceId
	 * @return mixed
	 * */
	public static function make($apiVersion, $deviceId) 
	{
		$className = static::class;
		$clientId = config('custom.tuya.client_id');
		$clientSecret = config('custom.tuya.client_secret');
		$baseUrl = config('custom.tuya.api_url');

		if (!$clientId || !$clientSecret || !$baseUrl) {
			return null;
		}

		$tokenData = self::tuyaRequest('GET', '/v1.0/token?grant_type=1', $clientId, $clientSecret, $baseUrl);

		if (!isset($tokenData['success']) || !$tokenData['success']) {
		    return null;
		}

		$accessToken = Arr::get($tokenData, 'result.access_token');

		// Запрашиваем свойства устройства через новый API v2.0 (Shadow Properties)

		$statusData = self::tuyaRequest('GET', "/v2.0/cloud/thing/{$deviceId}/shadow/properties", $clientId, $clientSecret, $baseUrl, $accessToken);

		if (!isset($statusData['success']) || !$statusData['success']) {
		    return null;
		}


		$items = Arr::get($statusData, 'result.properties');

		if(is_array($items) && !empty($items)) {
			$params = compact('apiVersion', 'deviceId');
			foreach ($items as $item) {
			    $propertyName = Arr::get($item, 'code');
			    $value = Arr::get($item, 'value');
			    $time = Arr::get($item, 'time');
			    $params[$propertyName] = $value;
			    if (!!$time) {
			    	$params[$propertyName . '_time'] = $time;
			    }
			}
			return new $className($params);
		} 
		return null;
	}

	/** Gives measurement unit for param name 
	 * 
	 * @param string $paramName
	 * @return mixed
	 * */
	public function unit(string $paramName)
	{
		return Arr::get($this->units, $paramName);
	}
}