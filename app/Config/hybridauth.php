<?php
/**
 * HybridAuth Plugin example config
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 */

$config['HybridAuth'] = array(
	'providers' => array(
		'OpenID' => array(
			'enabled' => true
		),
		"Facebook" => array(
        	"enabled" => true,
        	 "keys" => array("id" => "971460122889609", "secret" => "187a5733ba27326b507f272009597d1a"),
    	),
	),
	'debug_mode' => (boolean)Configure::read('debug'),
	'debug_file' => LOGS . 'hybridauth.log',
);
