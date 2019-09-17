<?php

namespace Kaankilic\LaravelPlay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
	/**
	* Display a listing of the resource.
	* @return Response
	*/
	public function index()
	{
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
		$hasKey = \Kaankilic\LaravelPlay\Services\ApplicationService::get()->hasKey(["db_host","db_database","db_username","db_password","app_name","app_url"]);
		if(!$hasKey){
			return redirect()->route("laravelplay::home");
		}
		$inputs = $request->only(["name","email","password"]);
		\App\Models\Users::create([
			'name' => $inputs['name'],
			'email' => $inputs['email'],
			'password' => bcrypt($inputs['password'])
		]);
		\Kaankilic\LaravelPlay\Services\ApplicationService::get()->delete();
		return redirect()->to("/");
	}
}
