<?php

namespace Modules\LaravelPlay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class VerificationController extends Controller
{
	/**
	* Display a listing of the resource.
	* @return Response
	*/
	public function index(){
		$checkRequired = new \Modules\LaravelPlay\Services\RequirementService();
		$requirements = $checkRequired->check(config("laravelplay.requirements"));
		$minVersion = $checkRequired->checkPHPversion(config("laravelplay.minPhpVersion"));
		$checkPermission = new \Modules\LaravelPlay\Services\PermissionService();
		$permissions = $checkPermission->check(
			config('laravelplay.permissions')
		);
		$isReady = !isset($requirements["errors"]) && $minVersion['supported'] && !isset($permissions["errors"]);
		if(!$isReady){
			return redirect()->to("/laravelplay");
		}
		$applicationService = \Modules\LaravelPlay\Services\ApplicationService::get();
		$inputs = $applicationService->keys(["license_key","license_client"]);
		if(!$applicationService->hasKey(["license_key","license_client"])){
			$inputs = array(
				"license_key" => null,
				"license_client" => null
			);
		}
		return view('laravelplay::verification',compact('inputs'));
	}

	/**
	* Show the form for creating a new resource.
	* @return Response
	*/
	public function check(Request $request){
		$inputs = $request->only(["license_key","client"]);
		$checkRequired = new \Modules\LaravelPlay\Services\RequirementService();
		$requirements = $checkRequired->check(config("laravelplay.requirements"));
		$minVersion = $checkRequired->checkPHPversion(config("laravelplay.minPhpVersion"));
		$checkPermission = new \Modules\LaravelPlay\Services\PermissionService();
		$permissions = $checkPermission->check(
			config('laravelplay.permissions')
		);
		$isReady = !isset($requirements["errors"]) && $minVersion['supported'] && !isset($permissions["errors"]);
		if(!$isReady){
			return redirect()->to("/laravelplay");
		}
		$hasValidLicense = \Modules\LaravelPlay\Services\LicenseService::setLicenseKey($inputs["license_key"])->setClient($inputs["client"])->hasValidLicense();
		if(!$hasValidLicense){
			return redirect()->back()->with("error-message","License key and client is not verified by the license server. If you sure that you have a correct keys, contact with product owner.");
		}
		\Modules\LaravelPlay\Services\ApplicationService::get()->build([
			'license_key'		=> $inputs["license_key"],
			'license_client'	=> $inputs["client"]
		]);
		return redirect()->route("laravelplay::database");
	}
}
