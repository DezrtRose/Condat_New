<?php

return array(
	# Account credentials from developer portal
	'Account' => array(
		'ClientId' => 'AVK7FeFkmcTBqpuoTpnZGn_8Xnpo_U2BTm_lo-JHUGwXUECVmxqNs2-y40U6oMOxeIOWgKQIYgFQe7GU',
		'ClientSecret' => 'EPwdN-9XSul1oTRGy8YTp-q0G8x1d9ZiOnW5bpof40TZ6cEQRLx5OvPpZ-ZZsaktieAxikZafh5LP4sH',
	),

	# Connection Information
	'Http' => array(
		'ConnectionTimeOut' => 30,
		//'Retry' => 1,
		//'Proxy' => 'http://[username:password]@hostname[:port][/path]',
	),

	# Service Configuration
	'Service' => array(
		# For integrating with the live endpoint,
		# change the URL to https://api.paypal.com!
		'EndPoint' => 'https://api.sandbox.paypal.com',
	),


	# Logging Information
	'Log' => array(
		'LogEnabled' => true,

		# When using a relative path, the log file is created
		# relative to the .php file that is the entry point
		# for this request. You can also provide an absolute
		# path here
		'FileName' => '../PayPal.log',

		# Logging level can be one of FINE, INFO, WARN or ERROR
		# Logging is most verbose in the 'FINE' level and
		# decreases as you proceed towards ERROR
		'LogLevel' => 'FINE',
	),
);
