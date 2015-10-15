<?php

class ED_Courses{
	public function __construct(){

	}

	public static function courses(){
		$ED =& instance();

		$ED->load_class('database');

		$ED->load_class(array('class'=>'lists', 'name'=>'list'));

		$args = array(
			'table'					=>	'wp_edupress_courses',
			'orderby'				=>	'course_registered',
			'order'					=>	'desc',
			'num_itens_per_page'	=>	2,
			'offset'				=> 	0,
			'cols_table'			=> array('course_id', 'course_name', 'course_url', 'course_slug', 'course_description'),	
		);
		$results = $ED->list->results($args);

		$lines = NULL;
		$id = 1;
		foreach ( $results as $key ):
			$lines .= $ED->list->cols(array(
										array(
											'type'		=>	'link',
											'text'		=>	$key->course_name,
											'slug'		=>	'column-name',
											'id'		=>	$key->course_id,
											'url'		=>	current_page_link('id='.$key->course_id),
											'title'		=>	'Acessar o curso ' . $key->course_name,
											'extras_a'	=>	'',
											'extras_tr'	=>	'',
											'extras_th'	=>	'',
											'extras_td'	=>	'',
											'strong'	=>	TRUE,
											'excerpt'	=>	$key->course_description,
											//'image'		=>	'//www.gravatar.com/avatar/8a52ee2ea6d683865df9741181f31e60?d=mm&s=32&r=G',
											'links'		=>	array( 
																array(	'type'	=>	'view', 
																		'text'	=>	'Acessar', 
																		'title'	=>	'Acessar o curso '. $key->course_name, 
																		'url'	=>	current_page_link('action=view&id=' . $key->course_id), 
																		'end'	=>	FALSE
																),
																array(	'type'	=>	'edit', 
																		'text'	=>	'Editar', 
																		'title'	=>	'Editar o curso '. $key->course_name, 
																		'url'	=>	current_page_link('action=edit&id=' . $key->course_id), 
																		'end'	=>	FALSE
																),
																array(	'type'	=>	'trash', 
																		'text'	=>	'Excluir', 
																		'title'	=>	'Excluir o curso '. $key->course_name, 
																		'url'	=>	current_page_link('action=trash&id=' . $key->course_id), 
																		'end'	=>	TRUE
																),
															)

										),
										array(
											'type'	=> 'link',
											'text'	=>	$key->course_url,
											'slug'	=>	'column-name',
											'id'	=>	$key->course_id,
											'url'	=>	current_page_link('id='.$key->course_id),
											'title'	=>	'Acessar o curso ' . $key->course_name
										),
										array( 
											'type'=>'simple', 
											'text' => $key->course_name, 
											'slug' => 'column-name', 
											'id' => $key->course_id
										),

									)
								);
			$id++;
		endforeach;
	
		$ED->list->header('Cursos', 'Adiconar novo', 'edupress-courses-new');
			$filters = array(
							array('title'=>'Todos', 'slug'=>'all', 'count'=>'3', 'show'=>TRUE),
							array('title'=>'Ativos', 'slug'=>'active', 'count'=>'5'),
							array('title'=>'Ministrando', 'slug'=>'teaching'),
							array('title'=>'Cursando', 'slug'=>'coursing', 'count'=>'1'),
						);
			$ED->list->filters($filters, 'type');
			$ED->list->search('Pesquisar cursos');
			$ED->list->table();
				$cols = array(
							array('title'=>'Nome completo', 'slug'=>'name', 'order'=>TRUE),
							array('title'=>'Endereço', 'slug'=>'adress', 'order'=>TRUE),
							array('title'=>'Telefone', 'slug'=>'tel', 'order'=>FALSE),
							array('title'=>'E-mail', 'slug'=>'email', 'order'=>FALSE),
						);
				$ED->list->thead($cols);
				$ED->list->tbody($lines);
				$ED->list->tfoot($cols);
			$ED->list->table_close();
			$ED->list->paged($ED->list->results($args, TRUE));
		$ED->list->footer();
	}

	public static function new_course(){
		$ED =& instance();
		$ED->load_class(array('class'=>'forms', 'name'=>'form'));
		$ED->form->header('Adicionar novo curso');
		$ED->form->open('post', array('class'=>'classe do form', 'id'=>'id-do-form'));
			$ED->form->hidden(array('casa'=>'janela'));
			$ED->form->text('Nome do curso:', 'name', NULL, 'id="coursename" class="regular-text" ');
			$ED->form->text(array('label'=>'Slug:', 'name'=>'slug', 'value'=>'curso-qgis-teste', 'class'=>'regular-text'));
			$ED->form->url('URL:', 'url', NULL, 'class="regular-text code" ');
			$ED->form->email('EMAIL:', 'url', NULL, 'class="regular-text ltr" ');
			$ED->form->password('Senha:', 'password', NULL);
			$ED->form->number('Tamanho:', 'number', NULL);
			$ED->form->textarea('Descrição:', 'textarea', NULL);
			$ED->form->checkbox('Aceitar:', 'textarea', NULL, NULL, NULL, 'Aceitar termos');
			$ED->form->radio('Selecione uma opção:', 'sleciona', array('opcao1'=>'Primeira opçaõ', 'opcao2'=>'Segunda opção'));
			$ED->form->select('Selecione uma segunda opção:', 'sleciona2', array('opcao1'=>'Primeira opçaõ', 'opcao2'=>'Segunda opção', 'opcao3'=>'Terceira opção'), 'opcao3');
			$ED->form->file('Arquivo:', 'file', NULL);
		$ED->form->close('submit', 'Enviar');
	}
}