<?php

namespace Kaankilic\LaravelPlay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Artisan;
use Symfony\Component\Console\Output\BufferedOutput;
class SettingsController extends Controller
{
	/**
	* Display a listing of the resource.
	* @return Response
	*/
	public function index(){
		$applicationService = \Kaankilic\LaravelPlay\Services\ApplicationService::get();
		if(!$applicationService->hasKey(["db_host","db_database","db_username","db_password"])){
			return redirect()->route("laravelplay::home");
		}
		$inputs = $applicationService->keys(["app_name","app_url"]);
		if(!$applicationService->hasKey(["app_name","app_url"])){
			$inputs = array(
				"app_name" => null,
				"app_url" => request()->getSchemeAndHttpHost()
			);
		}
		return view('laravelplay::settings',compact('inputs'));
	}

	/**
	* Show the form for creating a new resource.
	* @return Response
	*/
	public function check(Request $request){
		$hasKey = \Kaankilic\LaravelPlay\Services\ApplicationService::get()->hasKey(["db_host","db_database","db_username","db_password"]);
		if(!$hasKey){
			return redirect()->route("laravelplay::home");
		}
		$inputs = $request->only(["app_name","app_url"]);
		$application = \Kaankilic\LaravelPlay\Services\ApplicationService::get()->build([
			'app_env'		=> 'local',
			'app_name'		=> $inputs["app_name"],
			'app_url'		=> $inputs["app_url"]
		]);
		\Kaankilic\LaravelPlay\Services\EnviromentService::build(\Kaankilic\LaravelPlay\Services\ApplicationService::get()->toArray());
		$output = new BufferedOutput();
		Artisan::call('migrate:fresh',[
			'--force' => true
		],$output);
		\Log::info($output->fetch());
		return redirect()->route('laravelplay::user');
	}
}
