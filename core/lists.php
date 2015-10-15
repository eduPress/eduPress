<?php

class ED_Lists extends ED_Template{

	public function __construct(){
		parent::__construct();
	}


	public function filters($filters=array(), $varget=NULL){
		$return = '<ul class="subsubsub">';
		$i = 1;
		foreach ( $filters as $array ):
			$title = $slug = $count = NULL;
			$show = TRUE;
			foreach ( $array as $k => $v) eval("\$".$k." = \"".$v."\";" );
			if ( $show ):
				if ( $count > 0 || $count == NULL ):
					$return .= '<li class="' . $slug .'">';
						$is_current = ( $_GET[$varget] == $slug ) ? ' class="current"' : '';
						$return .= '<a href="admin.php?page=' . $_GET['page']. '&' . $varget . '=' . $slug . '"'. $is_current . '>';
							$return .= $title;
							if ( $count != NULL ) $return .= ' <span class="count">(' . $count . ')</span>';
						$return .= '</a>';
						if ( count( $filters ) > $i ) $return .= ' |';
					$return .= '</li>';
					$i++;
				endif;
			endif;
		endforeach;
		$return .= '</ul>';
		echo $return;
	}

	public function search($search_slug='Pesquisar'){
		$return = '<form id="filters" method="get">';
			foreach ($_GET as $key => $value) $return .= '<input name="' . $key . '" value="' . $value . '" type="hidden">';
			$return .= '<p class="search-box">';
				$return .= '<label class="screen-reader-text" for="search-input">' . $search_slug . ':</label>';
				$return .= '<input id="search-input" name="s" value="" type="search">';
				$return .= '<input id="search-submit" class="button" value="' . $search_slug . '" type="submit">';
			$return .= '</p>';
		$return .= '</form>';
		echo $return;
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
		$return = '<form id="paged-filter" method="get">';
			foreach ($_GET as $key => $value) $return .= '<input name="' . $key . '" value="' . $value . '" type="hidden">';
			$return .= '<div class="tablenav bottom">';
				$return .= '<div class="tablenav-pages">';
					$return .= '<span class="displaying-num">' . $num_results_this_page . ' itens</span>';
					$return .= '<span class="pagination-links">';
						$disabled = ($paged == 1) ? ' disabled' : '';
						$return .= '<a class="first-page' . $disabled . '" title="Ir para a primeira página" href="' . get_url() . 'paged=1">«</a>';
						$prev = $paged - 1;
						$prev = ($prev < 1) ? 1 : $prev;
						$disabled = ($paged == 1) ? ' disabled' : '';
						$return .= '<a class="prev-page' . $disabled . '" title="Ir para a página anterior" href="' . get_url() . 'paged=' . $prev . '">‹</a>';
						$return .= '<span class="paging-input">';
							$return .= '<label for="current-page-selector" class="screen-reader-text">Selecionar Página</label>';
							$return .= '<input class="current-page" id="current-page-selector" title="Página atual" name="paged" value="' . $paged . '" size="1" type="text"> de ';
							$return .= '<span class="total-pages">' . $num_pages . '</span>';
						$return .= '</span>';
						$next = $paged + 1;
						$next = ($next < $num_pages) ? $next : $num_pages;
						$disabled = ($paged == $num_pages) ? ' disabled' : '';
						$return .= '<a class="next-page' . $disabled . '" title="Ir para a próxima página" href="' . get_url() . 'paged=' . $next . '">›</a>';
						$last = $num_pages;
						$disabled = ($paged >= $last) ? ' disabled' : '';
						$return .= '<a class="last-page' . $disabled . '" title="Ir para a última página" href="' . get_url() . 'paged=' . $last . '">»</a>';
					$return .= '</span>';
				$return .= '</div>';
				$return .= '<input name="mode" value="list" type="hidden">';
				$return .= '<div class="view-switch">';
					$_GET['mode'] = ( $_GET['mode'] == NULL ) ? 'list' : $_GET['mode'];
					$list_current = ($_GET['mode'] == 'list') ? ' current' : '';
					$excerpt_current = ($_GET['mode'] == 'excerpt') ? ' current' : '';
					$return .= '<a href="' . get_url() . 'mode=list" class="view-list' . $list_current . '" id="view-switch-list"><span class="screen-reader-text">Visualização em lista</span></a>';
					$return .= '<a href="' . get_url() . 'mode=excerpt" class="view-excerpt' . $excerpt_current . '" id="view-switch-excerpt"><span class="screen-reader-text">Visualização do resumo</span></a>';
				$return .= '</div>';
				$return .= '<br class="clear">';
			$return .= '</div>';
		$return .= '</form>';
		echo $return;
	}

	public function table(){
		echo '<table class="wp-list-table widefat fixed striped">';
	}

	public function table_close(){
		echo '</table>';
	}

	public function thead($cols=array()){
		$this->trtype = ( $this->trtype != 'tfoot' ) ? 'thead' : $this->trtype;
		$return = '<' . $this->trtype . '>';
			$return .= '<tr>';
				$return .= '<th scope="col" id="cb" class="manage-column column-cb check-column" disabled="disabled">';
					$return .= '<label class="screen-reader-text" for="cb-select-all-1">Selecionar todos</label>';
					$return .= '<input id="cb-select-all-1" type="checkbox">';
				$return .= '</th>';
				foreach ($cols as $col):
					$title = $slug = $order = NULL;
					foreach ( $col as $k => $v) eval("\$".$k." = \"".$v."\";" );
					if ( $order == TRUE ):
						$order = ( ! $_GET['order'] ) ? 'desc' : $_GET['order'];
						$order = ( $order == 'asc' ) ? 'desc' : 'asc';
						$return .= '<th scope="col" id="' . $slug . '" class="manage-column column-' . $slug . ' sortable ' . $order . '">';
							$return .= '<a href="' . get_url() . 'orderby=' . $slug . '&order=' . $order . '"><span>' . $title . '</span><span class="sorting-indicator"></span></a>';
						$return .= '</th>';
					else:
						$return .= '<th scope="col" id="' . $slug . '" class="manage-column column-' . $slug . '">' . $title . '</th>';
					endif;
				endforeach;
			$return .= '</tr>';
		$return .= '</' . $this->trtype . '>';
		echo $return;
	}

	public function tfoot($cols=array()){
		$this->trtype = 'tfoot';
		$this->thead($cols);
	}

	public function tbody($lines=NULL){
		$return = '<tbody id="the-list">';
			if ( $lines != NULL):
				$return .= $lines;
			else:
				$return .= '<tr class="no-items"><td class="colspanchange" colspan="7">Nenhum resultado encontrado.</td></tr>';
			endif;
		$return .= '</tbody>';
		echo $return;
	}


	public function footer(){
		$return = '<div id="ajax-response"></div>';
		$return .= '<br class="clear">';
		$return .= '</div>';
		echo $return;
	}

	public function cols($data=array()){
		$return = NULL;
		$z = count($data);
		for ($i = 0; $i <= $z; $i++):
			$args = $data[$i];
			if ( $i == 0 ):
				$return = '<tr id="" class="iedit format-standard hentry" ' . $args['extras_tr'] . '>';
					$return .= '<th scope="row" class="check-column" ' . $args['extras_th'] . '>';
						$return .= '<label class="screen-reader-text" for="cb-select">Selecionar</label>';
						$return .= '<input id="cb-select" name="" value="" disabled="disabled" type="checkbox">';
						$return .= '<div class="locked-indicator"></div>';
					$return .= '</th>';
			endif;

			if ( $args['type'] == 'simple' ):
				$return .= '<td class="' . $args['slug'] . '" ' . $args['extras_td'] . '>' . $args['text'] . '</td>';
			endif;

			if ( $args['type'] == 'link' ):
				$return .= '<td class="' . $args['slug'] . ' post-title page-title column-title username column-username" ' . $args['extras_td'] . '>';
					$return .= ( $args['image'] ) ? '<img src="' .$args['image']. '" class="avatar user-1-avatar avatar-32 photo" height="32" width="32">' : NULL;
					$return .= ( $args['strong'] == TRUE ) ? '<strong>' : NULL;
						$return .= '<a href="' . $args['url'] . '" title="' .$args['title']. '" ' . $args['extras_a'] . '>' . $args['text'] . '</a>';
					$return .= ( $args['strong'] == TRUE ) ? '</strong>' : NULL;
					$return .= ( $_GET['mode'] == 'excerpt' && $args['excerpt'] ) ? '<p>' . $args['excerpt'] . '</p>' : NULL;
					if ( $args['links'] ):
						$return .= '<div class="row-actions">';
						foreach ( $args['links'] as $key ):
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

			if ( $i == $z ):
				$return .= '</tr>';
			endif;
		endfor;
		return $return;
	}

	public function results($args, $parameters=FALSE){
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
		if ( ! $parameters ):
			return $consult;
		else:
			return array('num_pages'=>$num_pages, 'num_results'=>$num_results, 'num_results_per_page'=>$num_itens_per_page, 'num_results_this_page'=>$num_results_this_page);
		endif;
	}

}
