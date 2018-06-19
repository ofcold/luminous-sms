<?php

return [
	/**
	 * The default send SMS handler
	 *
	 * Use multiple third party service providers. We need to use a main selection of services. It is used by default to
	 * push SMS messages.
	 *
	 * @var string
	 */
	'default_handler' => 'qcloud',

	'supported' => [

		/**
		 * Tencent qcloud handler.
		 *
		 * @var		array
		 */
		'qcloud' => [

			//	The app key
			'app_key' => 'app key',

			//	The app id
			'app_id' => 'app id',
		],

		'yunpian' => [
			'app_key'
		]
	]
];