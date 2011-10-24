	<ul id="browse">
		<li>Listas</li>
	</ul>

<h1>Considerações Gerais</h1>
<pre>As listas são <strong>individuais</strong>. É responsabilidade de cada aluno fazer os programas sozinho e preservar a sua solução em sigilo.

Se estiver usando <strong>Java</strong> para as soluções das listas, leia este <a href="ok">link</a> com considerações sobre implementação. Faça também o download da classe Arquivo: <a href="ok">Arquivo.java</a>.

</pre>

<?
$lists = $this->lists->get_all_available_lists();
foreach ($lists as $list) {
	$running = $this->datahandler->is_now_between_time($list['data_lancamento'], $list['data_finalizacao']);
?>
<h1>Lista <strong><?=$list['nome_lista']?></strong></h1>
<ul class="lista_menu">
	<li>Prazo: <strong><?=($running ? $this->datahandler->translate_date_format($list['data_finalizacao']) : 'encerrado')?></strong></li>
	<? if ($running) { ?><li>Horário atual: <strong><?=$this->datahandler->translate_date_format(date("Y-m-d H:i:s"))?></strong></li><li>Clarifications</li><? } ?>
</ul>
<?
	$problems = $this->problems->get_problems_from_list($list['id_lista']);
	foreach($problems as $pro) {
?>
<div class="lista_questao_block" onclick="window.location='<?=base_url('/index.php/home/problem/'.$pro['id_questao'])?>'">
	<div class="lista_questao_filename"><?=$list['nome_lista'].'Q'.$pro['numero']?></div>
	<div class="lista_questao_name"><?=$pro['nome']?></div>
</div>
<? } ?>

<? } ?>

<h1>Lista 1</h1>
<ul class="lista_menu">
	<li>Prazo: <strong>encerrado</strong></li>
	<li>Clarifications</li>
	<li>Notas</li>
</ul>
<div class="lista_questao_block">
	<div class="lista_questao_filename">L1Q1</div>
	<div class="lista_questao_name">Pilha ou Fila?</div>
</div>
<div class="lista_questao_block">
	<div class="lista_questao_filename">L1Q2</div>
	<div class="lista_questao_name">Jogo de Cartas.</div>
</div>
<div class="lista_questao_block">
	<div class="lista_questao_filename">L1Q3</div>
	<div class="lista_questao_name">Validando Sentenças.</div>
</div>
<div class="lista_questao_block">
	<div class="lista_questao_filename">L1Q4</div>
	<div class="lista_questao_name">Braço robótico.</div>
</div>
