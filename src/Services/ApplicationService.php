<?php
namespace Kaankilic\LaravelPlay\Services;
use Illuminate\Filesystem\Filesystem;
class ApplicationService{
	protected const APPLICATION_FILE = "app.json";
	protected static $file = null;
	protected static $instance = null;

	public static function get(){
		if (static::$instance === null){
			static::$instance = new ApplicationService();
		}
		$finder = new Filesystem();
		$env = base_path(self::APPLICATION_FILE);
		if(!$finder->exists($env)){
			$finder->put($env,json_encode([]));
		}
		static::$file = json_decode($finder->get($env),true);
		return static::$instance;
	}
	public function toArray(){
		return static::$file;
	}
	public static function build($data){
		$finder = new Filesystem();
		if (!empty($data)) {
			static::$file = array_merge(static::$file,$data);
		}
		$contents = json_encode(static::$file);
		$finder->put(base_path(self::APPLICATION_FILE), $contents);
		return static::$instance;
	}
	public static function keys(array $keys){
		return array_filter(static::$file,function($key) use ($keys) {
			return in_array($key, $keys);
		},ARRAY_FILTER_USE_KEY);
	}
	public static function hasKey($key){
		if(is_string($key)){
			return array_key_exists($key, static::$file);
		}
		if(is_array($key)){
			foreach($key as $value){
				if(!array_key_exists($value, static::$file)){
					return false;
				}
			}
			return true;
		}
	}
	public static function delete(){
		$finder = new Filesystem();
		$finder->delete(base_path(self::APPLICATION_FILE));
		return static::$instance;
	}
}
?>
