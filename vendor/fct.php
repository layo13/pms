<?php

/**
 * 
 * @param mixed $val
 * @param mixed $_
 * @return boolean
 */
function in($val, $_ = NULL) {
	if (!is_array($_)) {
		$_ = func_get_args();
		array_shift($_);
	}
	return in_array($val, $_);
}

function str_replace_first($from, $to, $subject) {
	$from = '/' . preg_quote($from, '/') . '/';

	return preg_replace($from, $to, $subject, 1);
}
