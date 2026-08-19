<?php
	
	if (!function_exists('get_config')) {
		function get_config($key)
		{
			return service('Configs')->getConfig($key);
		}
	}
	
	if (!function_exists('get_config_group')) {
		function get_config_group($group)
		{
			return service('Configs')->getConfigByGroup($group);
		}
	}
