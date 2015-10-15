<?php

function edup_activation(){
	echo 'Função de ativiação iniciada';
}

function edup_deactivation(){
	echo 'Função de desativação iniciada';
}

//retorna todas as variávies da url
function get_url($return_array=FALSE){
	$return = '?';
	foreach ($_GET as $key => $value):
		$return .= $key . '=' . $value . '&';
	endforeach;
	return $return;
}

function current_page_link($pos=NULL){
	return '?page=' . $_GET['page'] . '&' . $pos;
}



function _attributes_to_string($attributes){
	if (empty($attributes)) return '';

	if (is_object($attributes)) $attributes = (array) $attributes;

	if (is_array($attributes)):
		$atts = '';
		foreach ($attributes as $key => $val):
			$atts .= ' '.$key.'="'.$val.'"';
		endforeach;
		return $atts;
	endif;

	if (is_string($attributes)) return ' '.$attributes;

	return FALSE;
}