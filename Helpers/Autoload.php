<?php

namespace Helpers;

class Autoload{
	
	public static function run() {
		
		spl_autoload_register(function($class_name) {
						
			$class_name_arr = explode('\\', $class_name);
			$folder = $class_name_arr[0];
			$file = $class_name_arr[1].'.php';
			
			require_once($folder.'/'.$file);		
			
		});
	}	
}