<?php

class ED_Courses{
	public function __construct(){

	}

	public static function courses(){
		$ED =& instance();
		$ED->load_class(array('class'=>'lists', 'name'=>'list'));
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
				//$lines = 'conteúdo da tabela';
				$ED->list->tbody($lines);
				$ED->list->tfoot($cols);
			$ED->list->table_close();
			$ED->list->paged(array('num_pages'=>15, 'num_results'=>1, 'num_results_per_page'=>10, 'num_results_this_page'=>1));
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