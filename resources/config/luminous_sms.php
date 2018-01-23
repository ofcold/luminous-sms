<?php

return [
	/**
	 *	The default send SMS handler
	 *
	 *	Use multiple third party service providers. We need to use a main selection of services. It is used by default to
	 *	push SMS messages.
	 *
	 *	@var		string
	 */
	'default_handler'		=> 'qclod',

	'supported'		=> [

		/**
		 *	Tencent qclod handler.
		 *
		 *	@var		array
		 */
		'qclod'		=> [

			//	The app key
			'app_key'			=> '0ab93dee585584abc5fff6e194a7cf81',

			//	The app id
			'app_id'			=> '1400030784',
		],

		'yunpian'	=> [
			'app_key'
		]
	]
];