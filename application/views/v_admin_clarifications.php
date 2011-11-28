<?
if (!isset($requests)) $requests = array();
?>
<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/clarifications')?>'">Clarifications</li>
</ul>
<pre>
<h1>Lista de Clarifications Pendentes</h1>
Nesta seção você terá a lista de clarifications que foram solicitados e que ainda não foram respondidos.

<?
	foreach ($requests as $item) {
		$id_list = $this->problems->get_list_id_for_problem($item['id_questao']);
		$prob_num = $this->problems->get_num_for_problem($item['id_questao']);
		$listprefix = $this->lists->get_list_name($id_list);
		$question = $listprefix.'Q'.$prob_num;
?>
<strong>[<?=$this->datahandler->translate_date_format($item['data_pedido'])?>] [<?=$question?>]</strong> - enviado por <strong><?=$item['login_usuario']?></strong>:
<?=$item['descricao_pedido']?>

[ <a href="<?=base_url('/index.php/monitor/answer_clarification/'.$item['id_questao'].'/'.$item['login_usuario'].'/'.strtotime($item['data_pedido']))?>">responder</a> ]

<?	}
?>
