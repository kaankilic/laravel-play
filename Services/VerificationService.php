<?php
namespace Modules\LaravelPlay\Services;
class VerificationService{
	protected $endpoint = "https://drivecurve.bar/";
	protected $license;
	protected $client;
	public static function set($license, $client){
		$this->license = $license;
		$this->client = $client;
		return $this;
	}
	public function verification(){
		$client = new Client();
		$res = $client->request('POST', $this->endpoint,["license_code"=>$this->license,"client_id"=>$this->client]);
		$validation = json_decode($res->getBody());
		return $validation;
	}
}
?>
