<?php

namespace Kaankilic\LaravelPlay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class LaravelPlayController extends Controller
{
	/**
	* Display a listing of the resource.
	* @return Response
	*/
	public function index()
	{
		$checkRequired = new \Kaankilic\LaravelPlay\Services\RequirementService();
		$requirements = $checkRequired->check(config("laravelplay.requirements"));
		$minVersion = $checkRequired->checkPHPversion(config("laravelplay.minPhpVersion"));
		$checkPermission = new \Kaankilic\LaravelPlay\Services\PermissionService();
		$permissions = $checkPermission->check(
			config('laravelplay.permissions')
		);
		$isReady = !isset($requirements["errors"]) && $minVersion['supported'] && !isset($permissions["errors"]);
		return view('laravelplay::index',compact('requirements','minVersion','permissions','isReady'));
	}

}
