<?
$question = $list['nome_lista'].'Q'.$problem['numero'];
?>

<ul id="browse">
	<li>Listas</li>
	<li><?=$question?></li>
</ul>
	
<h1><strong><?=$question?></strong> - <?=$problem['nome']?></h1>
<ul class="lista_menu">
	<!--<li>Código fonte: <strong><?=$question?>.c</strong>, <strong><?=$question?>.cpp</strong> ou <strong><?=$question?>.java</strong></li>-->
	<li>Entrada: <strong><?=$question?>.in</strong></li>
	<li>Saída: <strong><?=$question?>.out</strong></li>
	<? if ($list['estado_lista'] == 'andamento' && $this->datahandler->is_now_between_time($list['data_lancamento'], $list['data_finalizacao'])) { ?>
	<li style="background: #A22; top: -28px; float: right;"
	onclick="window.location='<?=base_url('/index.php/home/submit/'.$problem_id)?>'"><strong>Submissão</strong></li>
	<? } else if ($list['estado_lista'] == 'revisao' && $this->datahandler->is_now_between_time($list['data_inicio_revisao'], $list['data_fim_revisao'])) { ?>
	<li style="background: #2A2; top: -28px; float: right;"
	onclick="window.location='<?=base_url('/index.php/home/review/'.$problem_id)?>'"><strong>Revisão</strong></li>	
	<? } ?>
	<li style="background: #A22; top: -28px; float: right;"
	onclick="window.location='<?=base_url('/index.php/home/clarifications/'.$problem_id)?>'"><strong>Clarifications</strong></li>
</ul>
<pre><?=$problem['enunciado']?>
</pre>

<h2>Formato de Entrada</h2>
<pre><?=$problem['descricao_entrada']?>
</pre>

<h2>Formato de Saída</h2>
<pre><?=$problem['descricao_saida']?>
</pre>

<h2>Exemplos</h2>
<div class="questao_ex_in_out">
<div class="questao_input">
<pre>Entrada (<strong>download</strong>):

<?=$problem['entrada_exemplo']?></pre>
</div>
<div class="questao_output">
<pre>Saída (<strong>download</strong>):

<?=$problem['saida_exemplo']?>
</pre>
</div>
</div>
