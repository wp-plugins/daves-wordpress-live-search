<?php

/**
 * Special wrapper around the WP transients API
 */
class DWLSTransients {
	static function clear() {
		$a = 255;
		while($a > -1) {
			$prefix = dechex($a);
			$index = get_transient("dwls_index_{$prefix}");
			foreach($index as $hash=>$value) {
				delete_transient("dwls_result_{$hash}");
			}
			delete_transient("dwls_index_{$prefix}");
			$a -= 1;
		}
	}
	
	static function set($key, $value, $expiration) {
		$hash = md5($key);
		$prefix = substr($hash, 0, 2);
		$index = get_transient("dwls_index_{$prefix}");
		if(!$index) {
			$index = array();
		}
		if(!array_key_exists($hash, $index)) {
			$index[$hash] = $hash;
			set_transient("dwls_index_{$prefix}", $index);
		}
		set_transient("dwls_result_{$hash}", $value);
	}
	
	static function get($key) {
		$hash = md5($key);
		$prefix = substr($hash, 0, 2);
		$index = get_transient("dwls_index_{$prefix}");
		if(!$index) {
			$index = array();
		}		
		if(array_key_exists($hash, $index)) {
			return get_transient("dwls_result_{$hash}");	
		}
		
		return FALSE;
	}
}
