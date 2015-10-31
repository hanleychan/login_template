<?php
define("LOG_FILE", "../logs/log.txt");

class Logger {
	public static function log($message="") {
		if(!empty($message)) {
			if($handle = fopen(LOG_FILE, 'a')) {
				$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
				$content = "{$timestamp} | {$message}\n";
				fwrite($handle, $content);
				fclose($handle);	
			}
			else { 
				echo "Could not open log file for writing";
			}
		}
	}
}
?>
