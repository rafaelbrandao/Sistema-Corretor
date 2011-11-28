<?
if (!isset($logged)) $logged = '';
if (!isset($running)) $running = FALSE;
$question = $list['nome_lista'].'Q'.$problem['numero'];
?>
<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/home/lists')?>'">Listas</li>
	<li onclick="document.location = '<?=base_url('/index.php/home/problem/'.$problem_id)?>'"><?=$question?></li>
	<li>Clarifications</li>
</ul>

<h1><strong><?=$question?></strong> - Clarifications Confirmados</h1>
<pre>Nesta seção, todos os clarifications já confirmados serão listados aqui.

<? foreach ($confirmed as $item) { ?>
<strong>[<?=$this->datahandler->translate_date_format($item['data_pedido'])?>]</strong> <?=$item['descricao_pedido']?> <strong>R:</strong> <?=$item['resposta']?>

<? } ?>
</pre>

<? if ($logged && $running) { ?>
<?=form_open(base_url('/index.php/home/clarifications/'.$problem_id.'/submit'))?>
<h1><strong><?=$question?></strong> - Solicitar Clarification</h1>
<pre>Antes de solicitar um novo clarification, faça a releitura da questão e verifique se alguém já solicitou algum clarification relacionado e que foi confirmado, para evitar repetição de perguntas que já foram respondidas.

<textarea name='ask' rows="3" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>
<input type="submit" value="Enviar" style="position: relative; left: 548px; width: 60px;" /></form>
</pre>
<? } ?>
