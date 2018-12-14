<?php

// You can find the keys here : https://apps.twitter.com/

return [
	'debug'               => function_exists('env') ? env('APP_DEBUG', false) : false,

	'API_URL'             => 'api.twitter.com',
	'UPLOAD_URL'          => 'upload.twitter.com',
	'API_VERSION'         => '1.1',
	'AUTHENTICATE_URL'    => 'https://api.twitter.com/oauth/authenticate',
	'AUTHORIZE_URL'       => 'https://api.twitter.com/oauth/authorize',
	'ACCESS_TOKEN_URL'    => 'https://api.twitter.com/oauth/access_token',
	'REQUEST_TOKEN_URL'   => 'https://api.twitter.com/oauth/request_token',
	'USE_SSL'             => true,

	'CONSUMER_KEY'        => function_exists('env') ? env('TWITTER_CONSUMER_KEY', 'P8b1DT5BATWcFJq7mSqFSN70f ') : '',
	'CONSUMER_SECRET'     => function_exists('env') ? env('TWITTER_CONSUMER_SECRET', 'FC0vYzrajYwbv1a9PaIACQQ4z6tX42uzv4hsawTbdtbgrNTrnh ') : '',
	'ACCESS_TOKEN'        => function_exists('env') ? env('TWITTER_ACCESS_TOKEN', 'TV423EMrt16sRVj7HKvs6U3Yd3p1JGQ5SBScRiLr ') : '',
	'ACCESS_TOKEN_SECRET' => function_exists('env') ? env('TWITTER_ACCESS_TOKEN_SECRET', 'YsScuiiPA6BPnpScmpGkBJOd1jeJsfJlDWKbUOyzjj0u7 ') : '',
];
