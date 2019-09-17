<?php

return [
	'name' => 'LaravelPlay',
	'product_key' => 'XXXX',
	'minPhpVersion' => "7.0.0",
	'requirements' => [
		'php' => [
			'openssl',
			'pdo',
			'mbstring',
			'tokenizer',
			'JSON',
			'cURL',
		],
		'apache' => [
			'mod_rewrite',
		],
	],
	'permissions' => [
		'storage/framework/'     => '775',
		'storage/logs/'          => '775',
		'bootstrap/cache/'       => '775',
	],
];
