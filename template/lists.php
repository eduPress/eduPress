<?php

class ED_Lists{

	public $type = '<h1>listas listas listas TIPO TIOP</h1>';

	private $pagination = TRUE;

	public function __construct(){
		echo '<h1>oBJETO LIST INSTANCIADO</h1>';
	}


	public function header(){
		echo 'Exibe o cabecalho da pagina com titulo e opção de um botão';
	}

	public function search(){
		echo 'Exibe caixa de buscas da lista';
	}

	public function table(){
		echo 'Exibe a tabela com os resultados da query';
	}

	public function pagination(){
		echo 'Exibe a paginação de resultados';
	}
}

echo '<h1>listas listas listas</h1>';