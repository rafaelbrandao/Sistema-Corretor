<?
if (!isset($lists_data)) $lists_data = array();
?>

<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/lists')?>'">Listas</li>
</ul>

<pre>
<h1>Listas</h1>
A seguir será listado todas as listas de exercícios que já foram terminadas, estão em andamento ou que ainda estão em desenvolvimento, e suas respectivas questões. Para criar uma nova lista, <a href="<?=base_url('/index.php/monitor/add_list')?>">clique aqui</a>.

<? foreach ($lists_data as $list) {
	$id = $list['id_lista'];
	$problems = $this->problems->get_problems_from_list($id);
?>
<h2><a id="scroll_point_list_<?=$id?>"></a>Lista '<strong><?=$list['nome_lista']?></strong>'</h2>[ <a href="<?=base_url('/index.php/monitor/edit_list/'.$id)?>">editar</a> / <a href="<?=base_url('/index.php/monitor/add_problem/'.$id)?>">adicionar questão</a> / <a href="<?=base_url('/index.php/monitor/rem_list/'.$id)?>">excluir</a> ]

	Status: <strong><?=$list['estado_lista']?></strong>
<? if ($list['data_finalizacao']) { ?>	Prazo: <strong><?=$this->datahandler->translate_date_format($list['data_finalizacao'])?></strong><br/><? } ?>
<? if ($list['data_lancamento']) { ?>	Inicio: <strong><?=$this->datahandler->translate_date_format($list['data_lancamento'])?></strong><br/><? } ?>
<? if ($list['data_fim_revisao']) { ?>	Revisão (prazo): <strong><?=$this->datahandler->translate_date_format($list['data_fim_revisao'])?></strong><br/><? } ?>
<? if ($list['data_inicio_revisao']) { ?>	Revisão (início): <strong><?=$this->datahandler->translate_date_format($list['data_inicio_revisao'])?></strong><br/><? } ?>
	
	Questões:
<? if (count($problems) == 0) { ?>
		(nenhuma)
<? } else {
		foreach($problems as $pro) {
?>
		#<strong><?=$pro['numero']?></strong> [ <a href="<?=base_url('/index.php/monitor/edit_problem/'.$pro['id_questao'])?>">editar</a> / <a href="<?=base_url('/index.php/monitor/list_submissions/'.$pro['id_questao'])?>">submissões</a> / <a href="<?=base_url('/index.php/monitor/rem_problem/'.$pro['id_questao'])?>">excluir</a> ]
<? 		}
   }
}
?>

</pre>
