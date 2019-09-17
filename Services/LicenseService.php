<?php
namespace Modules\LaravelPlay\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
class LicenseService{
	protected static $serverEndpoint = 'http://drivecurve.bar';
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
		//$this->response = json_decode(file_get_contents(static::$serverEndpoint."/check/".static::$licenseKey));
		$client = new Client();
		$res = $client->request('POST', static::$serverEndpoint."/api/verify",[
			"headers" => [
				"Content-Type"  => "application/json",
				"Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk0MTVkYjk2NDhhOTdmYTdiNWY0ZDIzYWZkMGNkOTk3NWE2ZWRmZGJiNThjMDJmNWRkM2JmMzIyZmY1MTViN2M1YmQ4OTllZmQ1MjdlYWFhIn0.eyJhdWQiOiIxIiwianRpIjoiOTQxNWRiOTY0OGE5N2ZhN2I1ZjRkMjNhZmQwY2Q5OTc1YTZlZGZkYmI1OGMwMmY1ZGQzYmYzMjJmZjUxNWI3YzViZDg5OWVmZDUyN2VhYWEiLCJpYXQiOjE1Njg3Mzg0MzUsIm5iZiI6MTU2ODczODQzNSwiZXhwIjoxNjAwMzYwODM1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.f2NUBhNl5zGqg2EFnjYdJNSfCO5oBupgwZaN7fsnF99Up16XQU5vQvx4ofsIypzJh_3Id0qWtjg201fxaHFLEHNaOW9rTwi_UWQS6ntePrxVVPeximtb_InG4AMdZPLJ2ZJ_ceAGo4P2HSGmuNV5W-VNgsciSOSqedXBcWZfCAVcidlJpAhyYNoDP2q34EG9d_KcaiLuHNKmjWqGRMKiNg05k3QU6hEocG_bNbvHEz-fyGrz0dMrOlusAFfzRU-ZJ3nsLxgsHQu1EgIhUOVyhuocuGniUakBjNA877_OQ1S1dG0opmDRMB27pDT68-fa3ps17fzSvkuSVYS77RA2S2dWd3R8WcBG13nuEAsPk56EyGQFfPR2UO2eoAM-l08-YyDSHsyg0ZTgT1OL8CcHWbGQL03AScO9Ep5WDAsnBDNEdlVy8jqLqatZNc5wiXLFyqYNHO7vmDO8Zcn_VDLaKOTe3h7AWrdDP4RGzestHZY4NMrHhF5cCLVdBaRHzvifu1vTtcFfXMCnHKxcLKRV5Kkl1QPRwZ2QKg9yh1AoN9f8ueuhEDeZI56rjqhWxierusMuA6wBSk2SogxXDLojNU9_YKr9xyvbm0Y_XqsqvzBfXWlZmKjEXM73nIQZTQ9vRgZeX_ubHRW2srS_tGEgJlMQ-HZicaYSQXYSra0_DPY",
				"X-DCKEY" => "6H078R",
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
