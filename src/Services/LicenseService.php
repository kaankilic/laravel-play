<?php
namespace Kaankilic\LaravelPlay\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
class LicenseService{
	protected static $serverEndpoint = null;
	protected static $licenseKey = null;
	protected static $licenseClient = null;
	protected $response;
	protected static $instance = null;

	public static function setServer($url){
		if (static::$instance === null){
			static::$instance = new LicenseService();
		}
		static::$serverEndpoint = $url;
		return static::$instance;
	}
	public static function setLicenseKey($key){
		if (static::$instance === null){
			static::$instance = new LicenseService();
		}
		static::$licenseKey = $key;
		return static::$instance;
	}
	public static function setClient($client){
		static::$licenseClient = $client;
		return static::$instance;
	}
	public function hasValidLicense($key=null,$client=null){
		if(!is_null($key)){
			static::setLicenseKey($key);
		}
		if(!is_null($client)){
			static::setClient($client);
		}
		static::$serverEndpoint = config("auth.license.server");
		//$this->response = json_decode(file_get_contents(static::$serverEndpoint."/check/".static::$licenseKey));
		$client = new Client();
		$res = $client->request('POST', static::$serverEndpoint."/api/verify",[
			"headers" => [
				"Content-Type"  => "application/json",
				"Authorization" => "Bearer ".config('auth.license.token'),
				"X-DCKEY" => config('auth.license.dckey'),
				"Content-Type" => "application/json",
			],
			"body" => json_encode([
				"license_code" => static::$licenseKey,
				"client" => static::$licenseClient
			])
		]);
		$this->response = json_decode($res->getBody()->getContents());
		if($res->getStatusCode()!="200"){
			\Log::error("verification connectivity issue.");
			return false;
		}
		if(!isset($this->response->data->is)){
			\Log::error("verification response error.");
			return false;
		}
		if($this->response->data->is=="valid"){
			return true;
		}
		\Log::error("invalid license error");
		return false;
	}
}
?>
