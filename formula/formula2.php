<?php

return [
	[
		function ($code) {
			$a = $code[0]*(11+$code[2]);
			$b = $code[1]*(11+$code[2]) - $code[1]*$code[3];
			$c = $code[1]*$code[3];
			$d = 11 + $code[2];
			return "\\frac{{$a}+{$b}-{$c}}{{$d}-{$code[3]}}";
			return "($a+$b-$c)/(".(11+$code[2])."-{$code[3]})";
		},
		function ($code) {
			return $code[0]+$code[1];
			
		},
	],
];