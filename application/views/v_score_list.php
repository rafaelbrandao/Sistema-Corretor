<?
if (!isset($list_id)) $list_id = 0;
if (!isset($list)) $list = array();
if (!isset($students)) $students = array();
if (!isset($problems)) $problems = array();
?>

<ul id="browse">
	<li>Listas</li>
	<li>Notas</li>
	<li>Respostas</li>
</ul>

<h1><strong><?=$list['nome_lista']?></strong> - Notas</h1>
<pre>
Clique em uma nota para ver mais detalhes da mesma, exceto a nota final que é apenas a média das notas das questões.
<? if ($this->datahandler->is_now_between_time($list['data_inicio_revisao'], $list['data_fim_revisao'])) { ?>

O prazo de submissão de um pedido de <strong>revisão</strong> vai até <strong><?=$this->datahandler->translate_date_format($list['data_fim_revisao'])?></strong>. Nesse momento, o horário do servidor é <strong><?=$this->datahandler->translate_date_format(date("Y-m-d H:i:s"))?></strong>.
Para fazer seu pedido de revisão, abra a página que contém o formato de entrada e saída da questão e clique em <strong>Revisão</strong>.
<? } ?>

</pre>

<table class='campos'><tr><td class='login'></td>

<? foreach($problems as $problem){ ?>
	<td class='campo'><?=$list['nome_lista']."Q".$problem['numero']?></td>
<? } ?>

<td class='campo'>FINAL</td></tr></table>

<? foreach($students as $user) { $score_final = 0; ?>
<table class='score'><tr><td class='login'><?=$user['login']?></td>
<?
	foreach($problems as $problem){
		$user_score = $this->score->score_user_problem($problem['id_questao'], $user['login']);
		$problem_weight = $this->score->sum_weights_problem($problem['id_questao']);
		$score_pro = $problem_weight != 0 ? ($user_score/$problem_weight)/10 : 0;
		$score_final += $score_pro;
?>
<td class="<?=$this->score->get_css_type($score_pro)?>" onclick="window.location='<?=base_url('/index.php/home/score_detail/'.$list_id.'/'.$problem['id_questao'].'/'.$user['login'])?>'"> <?=sprintf("%.2f", $score_pro)?>% </td>
<?
	}
	if(sizeof($problems) == 0)
		$score_final = 0;
	else
		$score_final = $score_final/sizeof($problems);
?>	
<td class=' <?=$this->score->get_css_type($score_final)?>'><?=sprintf("%.2f", $score_final)?>%</td></tr></table>
<? } ?>

<h2>Respostas (entradas e saídas usadas na correção)</h2>
<pre>
Clique no nome do arquivo de entrada e de saída para fazer seu download. A sua nota da questão é calculada a partir da média ponderada das notas em cada entrada, e cada uma tem um peso associado. Tempo é o limite de execução.

</pre>

<table class='campos'><tr><td class='login'></td><td class='campo'>entrada</td><td class='campo'>saida</td><td class='campo'>peso</td><td class='campo'>tempo</td></tr></table>
<?
	foreach($problems as $problem){
		$solutions = $this->score->get_peso_tempo($problem['id_questao']);
		$i = 0;
?>
<table class='score'><tr>
<?
		foreach($solutions as $solution)
		{
			$name = $list['nome_lista'].'Q'.$problem['numero'].'E'.(++$i)
?>
<td class='login'><?=($i == 1 ? $list['nome_lista'].'Q'.$problem['numero'] : '')?></td><td class='nota'><a href="<?=base_url('/index.php/home/download_inputs/'.$solution['id'].'/'.$name)?>"><?='E'.$i.'.in'?></a></td><td class='nota'><a href="<?=base_url('/index.php/home/download_outputs/'.$solution['id'].'/'.$name)?>"><?='E'.$i.'.out'?></a></td><td class='nota avg'><?=$solution['peso']?></td><td class='nota acc'><?=$solution['tempo'].' sec'?></td></tr><tr>

<? } ?>
</table>
<? } ?>
