<?php

namespace Kaankilic\LaravelPlay\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class LaravelPlayed
{
	use Dispatchable, InteractsWithSockets, SerializesModels;
	protected $user;
	protected $app;
	/**
	* Create a new event instance.
	*
	* @return void
	*/
	public function __construct($app, $user){
		$this->app = $app;
		$this->user = $user;
	}
}
