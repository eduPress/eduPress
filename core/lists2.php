<?php

class ED_Lists extends ED_Template{

	public function __construct(){
		parent::__construct();
	}


	public function filters($filters=array(), $varget=NULL){
		echo '<ul class="subsubsub">';
		$i = 1;
		foreach ( $filters as $array ):
			$title = $slug = $count = NULL;
			$show = TRUE;
			foreach ( $array as $k => $v) eval("\$".$k." = \"".$v."\";" );
			if ( $show ):
				if ( $count > 0 || $count == NULL ):
					echo '<li class="' . $slug .'">';
						$is_current = ( $_GET[$varget] == $slug ) ? ' class="current"' : '';
						echo '<a href="admin.php?page=' . $_GET['page']. '&' . $varget . '=' . $slug . '"'. $is_current . '>';
							echo $title;
							if ( $count != NULL ) echo ' <span class="count">(' . $count . ')</span>';
						echo '</a>';
						if ( count( $filters ) > $i ) echo ' |';
					echo '</li>';
					$i++;
				endif;
			endif;
		endforeach;
		echo '</ul>';
	}

	public function search($search_slug='Pesquisar'){
		echo '<form id="filters" method="get">';
			foreach ($_GET as $key => $value) echo '<input name="' . $key . '" value="' . $value . '" type="hidden">';
			echo '<p class="search-box">';
				echo '<label class="screen-reader-text" for="search-input">' . $search_slug . ':</label>';
				echo '<input id="search-input" name="s" value="" type="search">';
				echo '<input id="search-submit" class="button" value="' . $search_slug . '" type="submit">';
			echo '</p>';
		echo '</form>';
	}

	public function paged($paged_args=array()){
		$ED =& instance();
		$num_pages = 15;
		$num_results = 1;
		$num_results_per_page = 10;
		$num_results_this_page = 1;
		$paged = ($_GET['paged'] == 0 || $_GET['paged'] == NULL) ? 1 : $_GET['paged'];
		$paged = ($paged > $num_pages) ? $num_pages : $paged;
		foreach ( $paged_args as $k => $v) eval("\$".$k." = \"".$v."\";" );
		echo '<form id="paged-filter" method="get">';
			foreach ($_GET as $key => $value) echo '<input name="' . $key . '" value="' . $value . '" type="hidden">';
			echo '<div class="tablenav bottom">';
				echo '<div class="tablenav-pages">';
					echo '<span class="displaying-num">' . $num_results_this_page . ' itens</span>';
					echo '<span class="pagination-links">';
						$disabled = ($paged == 1) ? ' disabled' : '';
						echo '<a class="first-page' . $disabled . '" title="Ir para a primeira página" href="' . get_url() . 'paged=1">«</a>';
						$prev = $paged - 1;
						$prev = ($prev < 1) ? 1 : $prev;
						$disabled = ($paged == 1) ? ' disabled' : '';
						echo '<a class="prev-page' . $disabled . '" title="Ir para a página anterior" href="' . get_url() . 'paged=' . $prev . '">‹</a>';
						echo '<span class="paging-input">';
							echo '<label for="current-page-selector" class="screen-reader-text">Selecionar Página</label>';
							echo '<input class="current-page" id="current-page-selector" title="Página atual" name="paged" value="' . $paged . '" size="1" type="text"> de ';
							echo '<span class="total-pages">' . $num_pages . '</span>';
						echo '</span>';
						$next = $paged + 1;
						$next = ($next < $num_pages) ? $next : $num_pages;
						$disabled = ($paged == $num_pages) ? ' disabled' : '';
						echo '<a class="next-page' . $disabled . '" title="Ir para a próxima página" href="' . get_url() . 'paged=' . $next . '">›</a>';
						$last = $num_pages;
						$disabled = ($paged >= $last) ? ' disabled' : '';
						echo '<a class="last-page' . $disabled . '" title="Ir para a última página" href="' . get_url() . 'paged=' . $last . '">»</a>';
					echo '</span>';
				echo '</div>';
				echo '<input name="mode" value="list" type="hidden">';
				echo '<div class="view-switch">';
					$_GET['mode'] = ( $_GET['mode'] == NULL ) ? 'list' : $_GET['mode'];
					$list_current = ($_GET['mode'] == 'list') ? ' current' : '';
					$excerpt_current = ($_GET['mode'] == 'excerpt') ? ' current' : '';
					echo '<a href="' . get_url() . 'mode=list" class="view-list' . $list_current . '" id="view-switch-list"><span class="screen-reader-text">Visualização em lista</span></a>';
					echo '<a href="' . get_url() . 'mode=excerpt" class="view-excerpt' . $excerpt_current . '" id="view-switch-excerpt"><span class="screen-reader-text">Visualização do resumo</span></a>';
				echo '</div>';
				echo '<br class="clear">';
			echo '</div>';
		echo '</form>';
	}

	public function table(){
		echo '<table class="wp-list-table widefat fixed striped">';
	}

	public function table_close(){
		echo '</table>';
	}

	public function thead($cols=array()){
		$this->trtype = ( $this->trtype != 'tfoot' ) ? 'thead' : $this->trtype;
		echo '<' . $this->trtype . '>';
			echo '<tr>';
				echo '<th scope="col" id="cb" class="manage-column column-cb check-column" disabled="disabled">';
					echo '<label class="screen-reader-text" for="cb-select-all-1">Selecionar todos</label>';
					echo '<input id="cb-select-all-1" type="checkbox">';
				echo '</th>';
				foreach ($cols as $col):
					$title = $slug = $order = NULL;
					foreach ( $col as $k => $v) eval("\$".$k." = \"".$v."\";" );
					if ( $order == TRUE ):
						$order = ( ! $_GET['order'] ) ? 'desc' : $_GET['order'];
						$order = ( $order == 'asc' ) ? 'desc' : 'asc';
						echo '<th scope="col" id="' . $slug . '" class="manage-column column-' . $slug . ' sortable ' . $order . '">';
							echo '<a href="' . get_url() . 'orderby=' . $slug . '&order=' . $order . '"><span>' . $title . '</span><span class="sorting-indicator"></span></a>';
						echo '</th>';
					else:
						echo '<th scope="col" id="' . $slug . '" class="manage-column column-' . $slug . '">' . $title . '</th>';
					endif;
				endforeach;
			echo '</tr>';
		echo '</' . $this->trtype . '>';
	}

	public function tfoot($cols=array()){
		$this->trtype = 'tfoot';
		$this->thead($cols);
	}

	public function tbody($lines=NULL){
		echo '<tbody id="the-list">';
			if ( $lines != NULL):
				echo $lines;
			else:
				echo '<tr class="no-items"><td class="colspanchange" colspan="7">Nenhum resultado encontrado.</td></tr>';
			endif;
		echo '</tbody>';
	}


	public function footer(){
		echo '<div id="ajax-response"></div>';
		echo '<br class="clear">';
		echo '</div>';
	}

	public function col($type=NULL, $text=NULL, $slug=NULL, $id=NULL, $url=NULL, $title=NULL, $strong=FALSE, $links=array()){
		echo $type['type'];
		if ( is_array($type) ):
			foreach ( $type as $k => $v):
				if (is_array($v)):
					$a = NULL;
				//print_r($v);
					foreach ($v as $k2 => $v2):
						$a .= '"'.$k2.'"=>"'.$v2.'",';
						//print_r($v);
					endforeach;
					//echo $a;
					if(is_array($v2)):
						//print_r($v2);
						$b = NULL;
						foreach ($v2 as $k3 => $v3) $b .= '"'.$k3.'"=>"'.$v3.'",';
						eval("\$".$k." = array(array(".$a."));" );
					else:
						eval("\$".$k." = array(".$a.");" );
					endif;
				else:
					eval("\$".$k." = \"".$v."\";" );
				endif;
			endforeach;
		endif;

		$return = NULL;

		if ( $type == 'open' ):
			$return = '<tr id="" class="iedit format-standard hentry">';
				$return .= '<th scope="row" class="check-column">';
					$return .= '<label class="screen-reader-text" for="cb-select">Selecionar</label>';
					$return .= '<input id="cb-select" name="" value="" disabled="disabled" type="checkbox">';
					$return .= '<div class="locked-indicator"></div>';
				$return .= '</th>';
		endif;

		if ( $type == 'close' ):
			$return = '</tr>';
		endif;

		if ( $type == 'simple' ):
			$return = '<td class="' . $slug . '">' . $text . '</td>';
		endif;

		if ( $type == 'link' ):
			$return = '<td class="' . $slug . '">';
				$return .= ( $strong == TRUE ) ? '<strong>' : NULL;
					$return .= '<a href="' . $url . '" title="' .$title. '">' . $text . '</a>';
				$return .= ( $strong == TRUE ) ? '</strong>' : NULL;
				//if (is_array($type)) print_r($type['text']);
				if ( $links ):
					$return .= '<div class="row-actions">';
					foreach ( $links as $key ):
						//args: type text title url end
						//types: view edit trash
						$return .= '<span class="' . $key['type'] . '"><a href="' . $key['url'] . '" title="' . $key['title'] . '">' . $key['text'] . '</a>';
						$return .= ( ! $key['end'] ) ? ' | ' : NULL;
						$return .= '</span>';
					endforeach;
					$return .= '</div>';
				endif;

			$return .= '</td>';
		endif;
		
		return $return;
	}

	public function results($args){


global $wpdb;

$table = $args['table'];
$orderby = $args['orderby'];
$order = $args['order'];
$num_itens_per_page = $args['num_itens_per_page'];
$limit = $num_itens_per_page;
$offset = $args['offset'];
if ( ! $args['cols_table'] ):
	$cols_table = '*';
else:
	$cols_table = NULL;
	foreach ( $args['cols_table'] as $col ):
		$cols_table .= $col . ',';
	endforeach;
	$cols_table = substr($cols_table, 0, -1);
endif;

$orderby = ( $_GET['orderby'] ) ? $_GET['orderby'] : $orderby;
$order = ( $_GET['order'] ) ? strtoupper($_GET['order']) : strtoupper($order);
$offset = ( $_GET['paged'] ) ? ($_GET['paged'] * $limit)-$limit : $offset;
$consult = $wpdb->get_results( "SELECT " . $cols_table . " FROM " . $table . " ORDER BY " .  $orderby . " " . $order . " LIMIT " . $limit . " OFFSET " . $offset);
$consult_all = $wpdb->get_results( "SELECT " . $cols_table . " FROM " . $table);
$num_results = count($consult_all);
$num_pages = count($consult_all) / $num_itens_per_page;
$num_pages =  intval($num_pages+0.5);
$num_results_this_page = count($consult);

return $consult;

	}

}
