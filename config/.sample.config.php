<?php 

namespace Configuration;
class DBConfig
{
    public static function getConfig(){
	$conf = array(
		'host' => "<yourhost>",
		'dbname' => "readdiet",
		'username' => "<sampleusername>",
		'password' => "<samplepassword>"
		);
	return $conf;
	}
}
