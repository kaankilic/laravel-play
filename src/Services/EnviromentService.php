<?php
namespace Kaankilic\LaravelPlay\Services;
use Illuminate\Filesystem\Filesystem;
use Artisan;
use Symfony\Component\Console\Output\BufferedOutput;
class EnviromentService{
	protected const ENVIROMENT_FILE = ".env";
	protected const EXAMPLE_FILE = ".env.example";
	protected static $file = null;
	public static function build($data){
		$finder = new Filesystem();
		$env = base_path(self::ENVIROMENT_FILE);
		if(!is_file($env)){
			$env = base_path(self::EXAMPLE_FILE);
		}
		static::$file = $finder->get($env);
		if (!empty($data)) {
			$contents = "";
			foreach ($data as $key => $value) {
				if (str_contains($value, [' ', '$', '\n'])) {
					$value = '"' . trim($value, '"') . '"';
				}
				if ($key) {
					$contents .= strtoupper($key) . '=' . $value . PHP_EOL;
				} else {
					$contents .= $value . PHP_EOL;
				}
			}
			$contents .= "APP_KEY=".env("APP_KEY")."\n";
			$contents .= "JWT_SECRET=".env("JWT_SECRET")."\n";
			$finder->put(base_path(self::ENVIROMENT_FILE), $contents);
		}
		$output = new BufferedOutput();
		Artisan::call('key:generate',[],$output);
		\Log::info($output->fetch());
		Artisan::call('optimize:clear',[],$output);
		\Log::info($output->fetch());
		return $finder->get(base_path(self::ENVIROMENT_FILE));
	}
}
?>
