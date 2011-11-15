<?
if (!isset($logged)) $logged = '';
if (!isset($problems)) $problems = array();
if (!isset($confirmed)) $confirmed = array();
if (!isset($list)) {
	$list = array();
	$list_name = '';
} else {
	$list_name = $list['nome_lista'];
}
?>
<ul id="browse">
	<li>Listas</li>
	<li><?=$list_name?></li>
	<li>Clarifications</li>
</ul>

<h1><strong><?=$list_name?></strong> - Clarifications Confirmados</h1>
<pre>Nesta seção, todos os clarifications já confirmados serão listados aqui.

<? foreach ($confirmed as $num => $clarifications) {
	if (!$clarifications) continue;
?>
<h2><?=$list_name.'Q'.$num?></h2><? foreach ($clarifications as $item) { ?>
<strong>[<?=$this->datahandler->translate_date_format($item['data_pedido'])?>]</strong> <?=$item['descricao_pedido']?> <strong>R:</strong> <?=$item['resposta']?>

<? } ?>

<? } ?>
</pre>

<? if ($logged) { ?>
<?=form_open(base_url('/index.php/home/list_clarifications/'.$list['id_lista']))?>
<h1><strong><?=$list_name?></strong> - Solicitar Clarification</h1>
<pre>Antes de solicitar um novo clarification, faça a releitura da questão e verifique se alguém já solicitou algum clarification relacionado e que foi confirmado, para evitar repetição de perguntas que já foram respondidas.

Questão: <select name="question">
<? foreach ($problems as $problem) { ?>
	<option value="<?=$problem['id_questao']?>"><?=$list_name.'Q'.$problem['numero']?></option>
<? } ?>
</select>
<textarea name='ask' rows="3" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>
<input type="submit" value="Enviar" style="position: relative; left: 548px; width: 60px;" /></form>
</pre>
<? } ?>
