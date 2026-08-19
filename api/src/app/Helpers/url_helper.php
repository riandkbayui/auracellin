<?php
    
    if (!function_exists('this_url')) {
        function this_url()
        {
            $currentUrl = (isset($_SERVER[ 'HTTPS' ]) && $_SERVER[ 'HTTPS' ] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            return $currentUrl;
        }
    }
    
    if (!function_exists('valid_url')) {
        function valid_url($url)
        {
            return filter_var($url, FILTER_VALIDATE_URL);
        }
    }
    
    if (!function_exists('asset_url')) {
        function asset_url($url)
        {
			if (empty($url)){
				return '';
			}
            $isUrlValid = filter_var($url, FILTER_VALIDATE_URL);
            if ($isUrlValid) {
                return $url;
            }
            return base_url($url);
        }
    }

    if (!function_exists('isMobile')) {
        function isMobile() {
            return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        }
    }
