<?php
// рекурсивная функция формирования json-последовательности.
function php2json($obj){
	if(count($obj) == 0) return '[]';
	$is_obj = isset($obj[count($obj) - 1]) ? false : true;
	$str = $is_obj ? '{' : '[';
	foreach ($obj AS $key  => $value) {
	   $str .= $is_obj ? "\"" . addcslashes($key, "\n\r\t'\\/") . "\"" . ':' : '';
	   if (is_array($value))   $str .= php2json($value);
	   elseif (is_null($value))    $str .= 'null';
	   elseif (is_bool($value))    $str .= $value ? 'true' : 'false';
	   elseif (is_numeric($value)) $str .= "\"" .$value. "\"";
	   else                        $str .= "\"" . addcslashes($value, "\n\r\t'\\/") . "\"";
	   $str .= ',';
	   }
	return substr_replace($str, $is_obj ? '}' : ']', -1);
}

?>