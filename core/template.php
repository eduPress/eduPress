<?php

class ED_Template{

	public function __construct(){

	}

	public function header($h2=NULL, $a=NULL, $page=NULL){
		echo '<div class="wrap">';
		echo '<h2>';
		echo $h2;
		if ( $a != NULL ) echo ' <a href="?page=' . $page . '" class="add-new-h2">' . $a .'</a>';
		echo '</h2>';
	}

}