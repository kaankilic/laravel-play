<?php

namespace Modules\LaravelPlay\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AppInstall extends Command
{
	/**
	* The console command name.
	*
	* @var string
	*/
	protected $name = 'app:install';

	/**
	* The console command description.
	*
	* @var string
	*/
	protected $description = 'Artisan installation for the application.';

	/**
	* Create a new command instance.
	*
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
	}
	protected $applicationService;
	/**
	* Execute the console command.
	*
	* @return mixed
	*/
	public function handle(){
		$this->applicationService = \Modules\LaravelPlay\Services\ApplicationService::get();
		$this->line("Welcome to CLI installation of the ".config('app.name').".");
		$this->line("Lets start to check your miniumum requirements.");
		$this->isAppReady();
		do{
			$isValid = $this->licenseVerification();
		}while(!$isValid);
		$this->setupDatabase();
		$this->setupSettings();
		$this->setupUser();
	}

	public function isAppReady(){
		$checkRequired = new \Modules\LaravelPlay\Services\RequirementService();
		$requirements = $checkRequired->check(config("laravelplay.requirements"));
		$minVersion = $checkRequired->checkPHPversion(config("laravelplay.minPhpVersion"));
		$checkPermission = new \Modules\LaravelPlay\Services\PermissionService();
		$permissions = $checkPermission->check(
			config('laravelplay.permissions')
		);
		$this->line("\nRequirements\n");
		$headers = config("laravelplay.requirements.php");
		$row[] = $requirements["requirements"]["php"];
		$this->table($headers,$row);
		$isReady = !isset($requirements["errors"]) && $minVersion['supported'] && !isset($permissions["errors"]);
		if(!$isReady){
			$this->error("Your app is not ready to install. Please see the requirements above.");
			return;
		}
		return $isReady;
	}
	public function licenseVerification(){
		do {
			$licenseKey = $this->ask("License Key");
		}while(is_null($licenseKey));
		do {
			$licenseClient = $this->ask("License Client");
		}while(is_null($licenseClient));
		$this->line("Please hold on due to license verification process completed.");
		$headers = ["License Key","License Client"];
		$row[] = [$licenseKey,$licenseClient];
		$this->table($headers,$row);
		if(!$this->confirm("Please confirm that the information above is totally correct.",true)){
			return ;
		}
		$hasValidLicense = \Modules\LaravelPlay\Services\LicenseService::setServer("https://verify.kaankilic.com")->setLicenseKey($licenseKey)->setClient($licenseClient)->hasValidLicense();
		if(!$hasValidLicense){
			$this->error("Invalid license key. Please check your license key.");
			return false;
		}
		$this->applicationService->build([
			'license_key'		=> $licenseKey,
			'license_client'	=> $licenseClient
		]);
		$this->info("License code verified succesfully.");
		return $hasValidLicense;
	}

	public function setupDatabase(){
		do {
			$host = $this->ask("MySQL Host");
		}while(is_null($host));
		do {
			$dbUsername = $this->ask("MySQL Username");
		}while(is_null($dbUsername));
		do {
			$dbPassword = $this->ask("MySQL Password");
		}while(is_null($dbPassword));
		do {
			$dbName = $this->ask("Database Name");
		}while(is_null($dbName));
		try{
			config([
				"database.connections.mysql.host" => $host,
				"database.connections.mysql.username" => $dbUsername,
				"database.connections.mysql.password" => $dbPassword,
				"database.connections.mysql.database" => $dbName
			]);
			$database = \DB::reconnect()->getPdo();
			$this->info("You've connected database succesfully.");
			$headers = ["Host","MySQL Username","MySQL Password","Database"];
			$rows[] = [$host,$dbUsername,$dbPassword,$dbName];
			$this->table($headers,$rows);
			if(!$this->confirm("Please confirm that the information above is totally correct.",true)){
				return ;
			}
			$this->applicationService->build([
				'db_host'		=> $host,
				'db_username'	=> $dbUsername,
				'db_password'	=> $dbPassword,
				'db_database'	=> $dbName
			]);
			return true;
		} catch (\Exception $e) {
			$this->error("Please check your database credentials might be wrong.");
			return ;
		}
	}

	public function setupSettings(){
		do{
			$appName = $this->ask("Application Name");
		}while(is_null($appName));
		do{
			$appUrl = $this->ask("Application URL");
		}while(is_null($appUrl));
		$headers = ["Application Name","Application URL"];
		$rows[] = [$appName,$appUrl];
		$this->table($headers,$rows);
		if(!$this->confirm("Please confirm that the information above is totally correct.",true)){
			return ;
		}
		$this->applicationService->build([
			'app_env'		=> 'local',
			'app_name'		=> $appName,
			'app_url'		=> $appUrl
		]);
		return true;
	}

	public function setupUser(){
		do{
			$username = $this->ask("Username");
		}while(is_null($username));
		do{
			$email = $this->ask("E-Mail");
		}while(is_null($email));
		do{
			$password = $this->ask("Password");
		}while(is_null($password));
		$headers = ["Username","E-Mail","Password"];
		$rows[] = [$username,$email,$password];
		$this->table($headers,$rows);
		if(!$this->confirm("Please confirm that the information above is totally correct.",true)){
			return ;
		}
		\Modules\LaravelPlay\Services\EnviromentService::build($this->applicationService->toArray());
		$output = new BufferedOutput();
		Artisan::call('migrate:fresh',[
			'--force' => true
		],$output);
		\Log::info($output->fetch());
	}
	/**
	* Get the console command arguments.
	*
	* @return array
	*/
	protected function getArguments()
	{
		return [
			//['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	* Get the console command options.
	*
	* @return array
	*/
	protected function getOptions()
	{
		return [
			//['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}
}
