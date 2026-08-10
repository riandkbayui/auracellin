<?php

if (!function_exists('doubleRound')) {
	function doubleRound($val, $len=8) {
		if (is_numeric($val)) {
			$val = doubleval($val);
			return round($val, $len);
		} else {
			return 0;
		}
	}
}

if (!function_exists('idr')) {
	function idr($num, $prefix="") {
		$format = number_format($num, 0, ",", ".");
		if($prefix) $format = "{$prefix}. {$format}";
		return $format;
	}
}

if (!function_exists('dlr')) {
	function dlr($num, $prefix="", $len=0) {
		$format = floatval($num);
		if($len>0) {
			$format = number_format($num, $len, '.', ',');
		}
		if($prefix) $format = "{$prefix}.{$format}";
		return $format;
	}
}