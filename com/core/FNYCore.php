<?php

/**
*
*/
class FNYCore
{
	public static function install()
	{
		global $wpdb;

		$fnytablestruct = "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix."fny_sharebuttons (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`type` varchar(255) NOT NULL,
			`title` varchar(255) NOT NULL,
			`options` text NOT NULL,
			PRIMARY KEY (id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8; ";

		$wpdb->query($fnytablestruct);
	}

	public static function uninstall()
	{
		global $wpdb;

		$fnydroptable = "DROP TABLE IF EXISTS ".$wpdb->prefix."fny_sharebuttons";
	}

}
