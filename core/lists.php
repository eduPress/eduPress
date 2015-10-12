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

}

/*




<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
		<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><label class="screen-reader-text" for="cb-select-all-1">Selecionar todos</label><input id="cb-select-all-1" type="checkbox"></th><th scope="col" id="title" class="manage-column column-title sortable desc" style=""><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=title&amp;order=asc"><span>Título</span><span class="sorting-indicator"></span></a></th><th scope="col" id="author" class="manage-column column-author" style="">Autor</th><th scope="col" id="categories" class="manage-column column-categories" style="">Categorias</th><th scope="col" id="tags" class="manage-column column-tags" style="">Tags</th><th scope="col" id="comments" class="manage-column column-comments num sortable desc" style=""><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=comment_count&amp;order=asc"><span><span class="vers comment-grey-bubble" title="Comentários"><span class="screen-reader-text">Comentários</span></span></span><span class="sorting-indicator"></span></a></th><th scope="col" id="date" class="manage-column column-date sortable asc" style=""><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=date&amp;order=desc"><span>Data</span><span class="sorting-indicator"></span></a></th>	</tr>
	</thead>

	<tbody id="the-list">
				<tr id="post-4" class="iedit author-self level-0 post-4 type-post status-publish format-standard hentry category-sem-categoria">
				<th scope="row" class="check-column">
								<label class="screen-reader-text" for="cb-select-4">Selecionar post de teste</label>
				<input id="cb-select-4" name="post[]" value="4" type="checkbox">
				<div class="locked-indicator"></div>
							</th>
			<td class="post-title page-title column-title"><strong><a class="row-title" href="http://localhost/wordpress/wp-admin/post.php?post=4&amp;action=edit" title="Editar “post de teste”">post de teste</a></strong>
<div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
<div class="row-actions"><span class="edit"><a href="http://localhost/wordpress/wp-admin/post.php?post=4&amp;action=edit" title="Editar este item">Editar</a> | </span><span class="inline hide-if-no-js"><a href="#" class="editinline" title="Editar este item diretamente">Edição rápida</a> | </span><span class="trash"><a class="submitdelete" title="Mover este item para a Lixeira" href="http://localhost/wordpress/wp-admin/post.php?post=4&amp;action=trash&amp;_wpnonce=7a5eda7bbf">Lixeira</a> | </span><span class="view"><a href="http://localhost/wordpress/2015/08/23/post-de-teste/" title="Ver “post de teste”" rel="permalink">Ver</a></span></div>
<div class="hidden" id="inline_4">
	<div class="post_title">post de teste</div>
	<div class="post_name">post-de-teste</div>
	<div class="post_author">1</div>
	<div class="comment_status">open</div>
	<div class="ping_status">open</div>
	<div class="_status">publish</div>
	<div class="jj">23</div>
	<div class="mm">08</div>
	<div class="aa">2015</div>
	<div class="hh">01</div>
	<div class="mn">43</div>
	<div class="ss">46</div>
	<div class="post_password"></div><div class="post_category" id="category_4">1</div><div class="tags_input" id="post_tag_4"></div><div class="sticky"></div><div class="post_format"></div></div></td>			<td class="author column-author"><a href="edit.php?post_type=post&amp;author=1">Sr. Rodrigo Sousa</a></td>
			<td class="categories column-categories"><a href="edit.php?category_name=sem-categoria">Sem categoria</a></td><td class="tags column-tags">—</td>			<td class="comments column-comments"><div class="post-com-count-wrapper">
			<a href="http://localhost/wordpress/wp-admin/edit-comments.php?p=4" title="0 pendente(s)" class="post-com-count"><span class="comment-count">0</span></a>			</div></td>
			<td class="date column-date"><abbr title="23/08/2015 1:43:46">23/08/2015</abbr><br>Publicado</td>		</tr>
		</tbody>

	<tfoot>
	<tr>
		<th scope="col" class="manage-column column-cb check-column" style=""><label class="screen-reader-text" for="cb-select-all-2">Selecionar todos</label><input id="cb-select-all-2" type="checkbox"></th><th scope="col" class="manage-column column-title sortable desc" style=""><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=title&amp;order=asc"><span>Título</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-author" style="">Autor</th><th scope="col" class="manage-column column-categories" style="">Categorias</th><th scope="col" class="manage-column column-tags" style="">Tags</th><th scope="col" class="manage-column column-comments num sortable desc" style=""><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=comment_count&amp;order=asc"><span><span class="vers comment-grey-bubble" title="Comentários"><span class="screen-reader-text">Comentários</span></span></span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-date sortable asc" style=""><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=date&amp;order=desc"><span>Data</span><span class="sorting-indicator"></span></a></th>	</tr>
	</tfoot>

</table>
	<div class="tablenav bottom">

		<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-bottom" class="screen-reader-text">Selecionar ação em massa</label><select name="action2" id="bulk-action-selector-bottom">
<option value="-1" selected="selected">Ações em massa</option>
	<option value="edit" class="hide-if-no-js">Editar</option>
	<option value="trash">Mover para a lixeira</option>
</select>
<input id="doaction2" class="button action" value="Aplicar" type="submit">
		</div>
		<div class="alignleft actions">
		</div>
<div class="tablenav-pages"><span class="displaying-num">2 itens</span>
<span class="pagination-links"><a class="first-page disabled" title="Ir para a primeira página" href="http://localhost/wordpress/wp-admin/edit.php">«</a>
<a class="prev-page disabled" title="Ir para a página anterior" href="http://localhost/wordpress/wp-admin/edit.php?paged=1">‹</a>
<span class="paging-input">1 de <span class="total-pages">2</span></span>
<a class="next-page" title="Ir para a próxima página" href="http://localhost/wordpress/wp-admin/edit.php?paged=2">›</a>
<a class="last-page" title="Ir para a última página" href="http://localhost/wordpress/wp-admin/edit.php?paged=2">»</a></span></div>
		<br class="clear">
	</div>

</form>


	<form method="get"><table style="display: none"><tbody id="inlineedit">
		
		<tr id="inline-edit" class="inline-edit-row inline-edit-row-post inline-edit-post quick-edit-row quick-edit-row-post inline-edit-post" style="display: none"><td colspan="7" class="colspanchange">

		<fieldset class="inline-edit-col-left"><div class="inline-edit-col">
			<h4>Edição rápida</h4>
	
			<label>
				<span class="title">Título</span>
				<span class="input-text-wrap"><input name="post_title" class="ptitle" value="" type="text"></span>
			</label>

			<label>
				<span class="title">Slug</span>
				<span class="input-text-wrap"><input name="post_name" value="" type="text"></span>
			</label>

	
				<label><span class="title">Data</span></label>
			<div class="inline-edit-date">
				<div class="timestamp-wrap"><label for="mm" class="screen-reader-text">Mês</label><select name="mm">
			<option value="01">01-jan</option>
			<option value="02">02-fev</option>
			<option value="03">03-mar</option>
			<option value="04">04-abr</option>
			<option value="05">05-mai</option>
			<option value="06">06-jun</option>
			<option value="07">07-jul</option>
			<option value="08" selected="selected">08-ago</option>
			<option value="09">09-set</option>
			<option value="10">10-out</option>
			<option value="11">11-nov</option>
			<option value="12">12-dez</option>
</select> <label for="jj" class="screen-reader-text">Dia</label><input name="jj" value="23" size="2" maxlength="2" autocomplete="off" type="text">, <label for="aa" class="screen-reader-text">Ano</label><input name="aa" value="2015" size="4" maxlength="4" autocomplete="off" type="text"> às <label for="hh" class="screen-reader-text">Hora</label><input name="hh" value="01" size="2" maxlength="2" autocomplete="off" type="text">: <label for="mn" class="screen-reader-text">Minuto</label><input name="mn" value="43" size="2" maxlength="2" autocomplete="off" type="text"></div><input id="ss" name="ss" value="46" type="hidden">			</div>
			<br class="clear">
	
	<label class="inline-edit-author"><span class="title">Autor</span><select name="post_author" class="authors">
	<option value="1">Sr. Rodrigo Sousa</option>
</select></label>
			<div class="inline-edit-group">
				<label class="alignleft">
					<span class="title">Senha</span>
					<span class="input-text-wrap"><input name="post_password" class="inline-edit-password-input" value="" type="text"></span>
				</label>

				<em class="alignleft inline-edit-or">
					–OU–				</em>
				<label class="alignleft inline-edit-private">
					<input name="keep_private" value="private" type="checkbox">
					<span class="checkbox-title">Privado</span>
				</label>
			</div>

	
		</div></fieldset>

	
		<fieldset class="inline-edit-col-center inline-edit-categories"><div class="inline-edit-col">

	
			<span class="title inline-edit-categories-label">Categorias</span>
			<input name="post_category[]" value="0" type="hidden">
			<ul class="cat-checklist category-checklist">
				
<li id="category-1" class="popular-category"><label class="selectit"><input value="1" name="post_category[]" id="in-category-1" type="checkbox"> Sem categoria</label></li>
			</ul>

	
		</div></fieldset>

	
		<fieldset class="inline-edit-col-right"><div class="inline-edit-col">

	
	
						<label class="inline-edit-tags">
				<span class="title">Tags</span>
				<textarea cols="22" rows="1" name="tax_input[post_tag]" class="tax_input_post_tag"></textarea>
			</label>
		
	
	
	
			<div class="inline-edit-group">
							<label class="alignleft">
					<input name="comment_status" value="open" type="checkbox">
					<span class="checkbox-title">Permitir comentários</span>
				</label>
							<label class="alignleft">
					<input name="ping_status" value="open" type="checkbox">
					<span class="checkbox-title">Permitir pings</span>
				</label>
						</div>

	
			<div class="inline-edit-group">
				<label class="inline-edit-status alignleft">
					<span class="title">Status</span>
					<select name="_status">
												<option value="publish">Publicado</option>
						<option value="future">Agendado</option>
												<option value="pending">Revisão pendente</option>
						<option value="draft">Rascunho</option>
					</select>
				</label>

	
	
				<label class="alignleft">
					<input name="sticky" value="sticky" type="checkbox">
					<span class="checkbox-title">Fixar este post</span>
				</label>

	
	
			</div>

	
		</div></fieldset>

			<p class="submit inline-edit-save">
			<a href="#inline-edit" class="button-secondary cancel alignleft">Cancelar</a>
			<input id="_inline_edit" name="_inline_edit" value="7c5e1f3075" type="hidden">				<a href="#inline-edit" class="button-primary save alignright">Atualizar</a>
				<span class="spinner"></span>
						<input name="post_view" value="list" type="hidden">
			<input name="screen" value="edit-post" type="hidden">
						<span class="error" style="display:none"></span>
			<br class="clear">
		</p>
		</td></tr>
	
		<tr id="bulk-edit" class="inline-edit-row inline-edit-row-post inline-edit-post bulk-edit-row bulk-edit-row-post bulk-edit-post" style="display: none"><td colspan="7" class="colspanchange">

		<fieldset class="inline-edit-col-left"><div class="inline-edit-col">
			<h4>Edição em massa</h4>
				<div id="bulk-title-div">
				<div id="bulk-titles"></div>
			</div>

	
	
	
		</div></fieldset><fieldset class="inline-edit-col-center inline-edit-categories"><div class="inline-edit-col">

	
			<span class="title inline-edit-categories-label">Categorias</span>
			<input name="post_category[]" value="0" type="hidden">
			<ul class="cat-checklist category-checklist">
				
<li id="category-1" class="popular-category"><label class="selectit"><input value="1" name="post_category[]" id="in-category-1" type="checkbox"> Sem categoria</label></li>
			</ul>

	
		</div></fieldset>

	
		<fieldset class="inline-edit-col-right"><label class="inline-edit-tags">
				<span class="title">Tags</span>
				<textarea cols="22" rows="1" name="tax_input[post_tag]" class="tax_input_post_tag"></textarea>
			</label><div class="inline-edit-col">

	<label class="inline-edit-author"><span class="title">Autor</span><select name="post_author" class="authors">
	<option value="-1">— Nenhuma mudança —</option>
	<option value="1">Sr. Rodrigo Sousa</option>
</select></label>
	
	
			<div class="inline-edit-group">
					<label class="alignleft">
				<span class="title">Comentários</span>
				<select name="comment_status">
					<option value="">— Nenhuma mudança —</option>
					<option value="open">Permitir</option>
					<option value="closed">Não permitir</option>
				</select>
			</label>
					<label class="alignright">
				<span class="title">Pings</span>
				<select name="ping_status">
					<option value="">— Nenhuma mudança —</option>
					<option value="open">Permitir</option>
					<option value="closed">Não permitir</option>
				</select>
			</label>
					</div>

	
			<div class="inline-edit-group">
				<label class="inline-edit-status alignleft">
					<span class="title">Status</span>
					<select name="_status">
							<option value="-1">— Nenhuma mudança —</option>
												<option value="publish">Publicado</option>
						
							<option value="private">Privado</option>
												<option value="pending">Revisão pendente</option>
						<option value="draft">Rascunho</option>
					</select>
				</label>

	
	
				<label class="alignright">
					<span class="title">Fixo</span>
					<select name="sticky">
						<option value="-1">— Nenhuma mudança —</option>
						<option value="sticky">Fixo</option>
						<option value="unsticky">Não fixo</option>
					</select>
				</label>

	
	
			</div>

			<label class="alignleft" for="post_format">
		<span class="title">Formato</span>
		<select name="post_format">
			<option value="-1">— Nenhuma mudança —</option>
			<option value="0">Padrão</option>
							<option value="aside">Nota</option>
								<option value="image">Imagem</option>
								<option value="link">Link</option>
								<option value="quote">Citação</option>
								<option value="status">Status</option>
						</select></label>
	
		</div></fieldset>

			<p class="submit inline-edit-save">
			<a href="#inline-edit" class="button-secondary cancel alignleft">Cancelar</a>
			<input name="bulk_edit" id="bulk_edit" class="button button-primary alignright" value="Atualizar" type="submit">			<input name="post_view" value="list" type="hidden">
			<input name="screen" value="edit-post" type="hidden">
						<span class="error" style="display:none"></span>
			<br class="clear">
		</p>
		</td></tr>
			</tbody></table></form>


*/
