<?php
// source:https://github.com/erelsgl/tnk/blob/master/script/hebrew.php

/**
 * @file hebrew.php handle Hebrew-specific actions like "gimatriya" - ?????????? ????????????
 * 
 */

### Hebrew letters ###
$otiot_txiliot = "????????????????????????????????????????????";
$otiot_ivriot = "??????????????????????????????????????????????????????";

$letters1 = array('??','??','??','??','??','??','??','??','??','??');
$letters2 = array(
		array('??','??','??','??','??','??','??','??','??','??'),
		array('??','??','??','??','??','??','??','??','??','??'));
$letters3 = array('??','??','??','??');

$hebrew2number = array(
		'??' => 1,
		'??' => 2,
		'??' => 3,
		'??' => 4,
		'??' => 5,
		'??' => 6,
		'??' => 7,
		'??' => 8,
		'??' => 9,
		'??' => 10,
		'??' => 20,
		'??' => 20,
		'??' => 30,
		'??' => 40,
		'??' => 40,
		'??' => 50,
		'??' => 50,
		'??' => 60,
		'??' => 70,
		'??' => 80,
		'??' => 80,
		'??' => 90,
		'??' => 90,
		'??' => 100,
		'??' => 200,
		'??' => 300,
		'??' => 400
);

### regular expressions for Hebrew numbers ###
$hebchar1 = "[??-??]";
$hebchar2 = "[??-??]";
$hebchar3 = "[??-??]";
$hebchar="[??-??]";

$hebnum1 = $hebchar1;
$hebnum2 = "(?:????|????|$hebchar2|$hebchar2$hebnum1)";
$hebnum12 = "(?:????|????|$hebchar2|(?:$hebchar2$hebnum1)|$hebnum1)";
$hebnum3 = "$hebchar3$hebnum12?";
$hebnum = "(?:$hebnum12|$hebnum3)";


$values = array (1,2,3,4,5,6,7,8,9,10,20,20,30,40,40,50,50,60,70,80,80,90,90,100,200,300,400);

function number2hebrew($num, $sofiot=false) {
	global $letters1, $letters2, $letters3;
	$heb = "";
	while ($num > 400) {
		$heb .= "??";
		$num -= 400;
	}
	if ($num >= 100) {
		$heb .= $letters3[ floor($num / 100) - 1 ];
		$num %= 100;
	}
	if ($num >= 10) {
		if ($num == 15) {
			$heb .= "????";
			$num = 0;
		} elseif ($num == 16) {
			$heb .= "????";
			$num = 0;
		} else {
			$heb .= $letters2[$sofiot][ floor($num / 10) - 1 ];
			$num %= 10;
		}
	}
	if ($num >= 1) {
		$heb .= $letters1[ $num - 1 ];
	}
	
	return $heb;
}



