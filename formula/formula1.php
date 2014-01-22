<?php

return [
	[
		function ($code) {
			return ($code[1] + $code[2]) . '+' . ($code[3] + 11) . '-' . $code[4];
		},
		function ($code) {
			return ($code[1] + $code[2]) + ($code[3] + 11) - $code[4];
		}
	],
	[
		function ($code) {
			return ($code[1] * $code[2]) . '+' . ($code[3] + 11) . '-' . $code[4];
		},
		function ($code) {
			return ($code[1] * $code[2]) + ($code[3] + 11) - $code[4];
		}
	],
	[
		function ($code) {
			return ($code[1] + $code[2]) . '+23-' . ($code[3] + $code[4]);
		},
		function ($code) {
			return ($code[1] + $code[2]) + 23 - ($code[3] + $code[4]);
		}
	],
	[
		function ($code) {
			return ($code[1] * $code[2]) . '+23-' . ($code[3] + $code[4]);
		},
		function ($code) {
			return ($code[1] * $code[2]) + 23 - ($code[3] + $code[4]);
		}
	],
	[
		function ($code) {
			return '2*' . ($code[1] + $code[2]) . '+' . ($code[3] + 11) . '-' . $code[4];
		},
		function ($code) {
			return 2 * ($code[1] + $code[2]) + ($code[3] + 11) - $code[4];
		}
	],
];