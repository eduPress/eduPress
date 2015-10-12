<?php

//Dá suporte para insersão de separadores no menu admin
add_action( 'admin_init', 'add_menu_separator' );

//
add_action( 'admin_menu', 'register_menu_first_separator' );

add_action( 'admin_menu', 'register_menu_courses' );

add_action( 'admin_menu', 'register_menu_last_separator' );





function add_menu_separator( $position ) {
	global $menu;
	$menu[ $position ] = array(
		0	=>	'',
		1	=>	'read',
		2	=>	'separator' . $position,
		3	=>	'',
		4	=>	'wp-menu-separator'
	);
}



function register_menu_first_separator() {
	do_action( 'admin_init', 26 );
}


function register_menu_courses() {
	$ED =& instance();
	$ED->load_class(array('class'=>'courses', 'name'=>'courses'));
	add_menu_page( 'Cursos', 'Cursos', 'manage_options', 'edupress-courses', array('ED_Courses', 'courses'), plugins_url( '\edupress/admin/images/icons.png' ), 27 );
	add_submenu_page( 'edupress-courses', 'Meus cursos', 'Meus cursos', 'manage_options', 'edupress-courses' );
	add_submenu_page( 'edupress-courses', 'Adicionar novo curso', 'Adicionar novo curso', 'manage_options', 'edupress-courses-new', array('ED_Courses', 'new_course'), 'new_course' );
}


function register_menu_last_separator() {
	do_action( 'admin_init', 35 );
}






function funcao_menu() {
	
	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
		echo '<h2>My Custom Submenu Page</h2>';
	echo '</div>';

}



