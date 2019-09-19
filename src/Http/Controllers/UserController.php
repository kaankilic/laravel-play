<?php

namespace Kaankilic\LaravelPlay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Artisan;
use Symfony\Component\Console\Output\BufferedOutput;
class UserController extends Controller
{
	/**
	* Display a listing of the resource.
	* @return Response
	*/
	public function index()
	{
		$output = new BufferedOutput();
		Artisan::call('migrate:fresh',[
			'--force' => true
		],$output);
		\Log::info($output->fetch());
		$hasKey = \Kaankilic\LaravelPlay\Services\ApplicationService::get()->hasKey(["db_host","db_database","db_username","db_password","app_name","app_url"]);
		if(!$hasKey){
			return redirect()->route("laravelplay::home");
		}
		return view('laravelplay::user');
	}

	/**
	* Show the form for creating a new resource.
	* @return Response
	*/
	public function create(Request $request){
		$applicationContainer = \Kaankilic\LaravelPlay\Services\ApplicationService::get();
		$hasKey = $applicationContainer->hasKey(["db_host","db_database","db_username","db_password","app_name","app_url"]);
		if(!$hasKey){
			return redirect()->route("laravelplay::home");
		}
		$inputs = $request->only(["name","email","password"]);
		$inputs["password"] = bcrypt($inputs['password']);
		$inputs = array_merge(config("laravelplay.defaults.user"),$inputs);
		$userProvider = config("auth.guards.web.provider");
		$userModel = config("auth.providers.".$userProvider.".model");
		$user = $userModel::create($inputs);
		event(new \Kaankilic\LaravelPlay\Events\LaravelPlayed($applicationContainer->toArray(),$user));
		\Kaankilic\LaravelPlay\Services\EnviromentService::build($applicationContainer->build(["app_env"=>"production"])->toArray());
		$applicationContainer->delete();
		return redirect()->to("/");
	}
}
