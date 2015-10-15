<?php

class ED_Database{
	private $db;
	public function __construct(){
		global $wpdb;
		$this->db = $wpdb;
	}

	public function results($table=NULL, $orderby=NULL, $order=NULL, $limit=100, $offset=0){
		$ED =& instance();
		$ED->load_class('options');
		$orderby = ( $_GET['orderby'] ) ? $_GET['orderby'] : $orderby;
		$order = ( $_GET['order'] ) ? strtoupper($_GET['order']) : strtoupper($order);
		$offset = ( $_GET['paged'] ) ? ($_GET['paged'] * $limit)-$limit : $offset;
		return $this->db->get_results( "SELECT * FROM " . $table . " ORDER BY " .  $orderby . " " . $order . " LIMIT " . $limit . " OFFSET " . $offset);
	}

}