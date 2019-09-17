<?php

namespace Kaankilic\LaravelPlay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class DatabaseController extends Controller
{
	/**
	* Display a listing of the resource.
	* @return Response
	*/
	public function index()
	{
		$hasKey = \Kaankilic\LaravelPlay\Services\ApplicationService::get()->hasKey(["license_key","license_client"]);
		if(!$hasKey){
			return redirect()->route("laravelplay::home");
		}
		$applicationService = \Kaankilic\LaravelPlay\Services\ApplicationService::get();
		$inputs = $applicationService->keys(["db_host","db_username","db_password","db_database"]);
		if(!$applicationService->hasKey(["db_host","db_username","db_password","db_database"])){
			$inputs = array(
				"db_host"=>"127.0.0.1",
				"db_username"=>null,
				"db_password"=>null,
				"db_database"=>null
			);
		}
		return view('laravelplay::database',compact('inputs'));
	}

	/**
	* Show the form for creating a new resource.
	* @return Response
	*/
	public function check(Request $request){
		$hasKey = \Kaankilic\LaravelPlay\Services\ApplicationService::get()->hasKey(["license_key","license_client"]);
		if(!$hasKey){
			return redirect()->route("laravelplay::home");
		}
		try{
			$inputs = $request->only(["host","db_username","db_password","db_name"]);
			config([
				"database.connections.mysql.host" => $inputs["host"],
				"database.connections.mysql.username" => $inputs["db_username"],
				"database.connections.mysql.password" => $inputs["db_password"],
				"database.connections.mysql.database" => $inputs["db_name"]
			]);
			$database = \DB::reconnect()->getPdo();
			\Kaankilic\LaravelPlay\Services\ApplicationService::get()->build([
				'db_host'		=> $inputs["host"],
				'db_username'	=> $inputs["db_username"],
				'db_password'	=> $inputs["db_password"],
				'db_database'	=> $inputs["db_name"],
			]);
		} catch (\Exception $e) {
			return redirect()->route('laravelplay::database')->with('error-message','DB Connection settings are not correct. Please verify that you have correct database credentials.');
		}
		return redirect()->route("laravelplay::settings");
	}
}
