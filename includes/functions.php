<?php

/*
 * Funkcja sprawdza poprawnośc numeru NIP
 */
function bpmj_edd_invoice_data_check_nip($str)
{
	$str = preg_replace("/[^0-9]+/","",$str);
	if (strlen($str) != 10)
	{
		return false;
	}
 
	$arrSteps = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
	$intSum=0;
	for ($i = 0; $i < 9; $i++)
	{
		$intSum += $arrSteps[$i] * $str[$i];
	}
	$int = $intSum % 11;
 
	$intControlNr=($int == 10)?0:$int;
	if ($intControlNr == $str[9])
	{
		return true;
	}
	return false;
}

function bpmj_edd_invoice_data_get_cb_setting( $option ) {

    global $edd_options;

    if( isset( $edd_options[ $option ]) && $edd_options[ $option ] == '1')
        return true;

    return false;
}
?>
