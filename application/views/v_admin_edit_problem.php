<?
if (!isset($problem_id)) $problem_id = 0;
if (!isset($problem_num)) $problem_num = 0;
if (!isset($listprefix)) $listprefix = '';
if (!isset($specs)) $specs = '';
if (!isset($title)) $title = '';
if (!isset($in_format)) $in_format = '';
if (!isset($out_format)) $out_format = '';
if (!isset($in_sample)) $in_sample = '';
if (!isset($out_sample)) $out_sample = '';
if (!isset($new_input)) $new_input = '';
if (!isset($new_output)) $new_output = '';
if (!isset($weight)) $weight = 1;
if (!isset($timelimit)) $timelimit = 1;
?>
<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/lists')?>'">Listas</li>
	<li onclick="scrolls_to('specs');">Editar Questão</li>
	<li onclick="scrolls_to('judge');">Corretor IN/OUT</li>
</ul>
<pre>
<h1><a id="scroll_point_specs"></a><strong><?=$listprefix.'Q'.$problem_num?></strong> - Editar questão (enunciado)</h1><strong>Atenção</strong>: Ao confirmar as alterações aqui, você também estará ignorando mudanças nas entradas e saídas do corretor (no fim desta página).

<?=form_open(base_url('/index.php/monitor/edit_problem/'.$problem_id.'/specs'))?>
Título: <input name="title" value="<?=$title?>" type="text" style="width: 200px;" />

Especificação:
<textarea name="specs" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$specs?></textarea>

Formato de entrada:
<textarea name="in_format" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$in_format?></textarea>

Formato de saída:
<textarea name="out_format" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$out_format?></textarea>

Exemplo de entrada:
<textarea name="in_sample" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$in_sample?></textarea>

Exemplo de saída:
<textarea name="out_sample" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$out_sample?></textarea>

<input type="submit" value="Salvar alterações" /></form>

<?=form_open(base_url('/index.php/monitor/edit_problem/'.$problem_id.'/add_answer'))?>
<h1><strong><?=$listprefix.'Q'.$problem_num?></strong> - Entradas e saídas para o corretor</h1>Nesta seção, você vê a lista de entradas e saídas já criadas.

<?
$inputs = $this->judge->get_inputs_for_problem($problem_id);
$it = 0;
foreach ($inputs as $input) { ++$it;
$input_name=$listprefix.'Q'.$problem_num.'E'.$it;
?>
	<?=$listprefix.'Q'.$problem_num?>E<strong><?=$it?></strong> [ <a href="<?=base_url('/index.php/monitor/rem_answer/'.$input['id_correcao'])?>">excluir</a> ]:
		Peso: <strong><?=$input["peso_correcao"]?></strong>
		Tempo: <strong><?=$input["max_tempo_execucao"]?></strong> segundo(s)
		Entrada: <a href="<?=base_url('/index.php/monitor/download_input/'.$input['id_correcao'].'/'.$input_name)?>">download</a>
		Saida: <a href="<?=base_url('/index.php/monitor/download_output/'.$input['id_correcao'].'/'.$input_name)?>">download</a>
		
<? } ?>
<h2><a id="scroll_point_judge"></a>Enviar nova entrada e saída para o corretor</h2><strong>Atenção</strong>: Ao enviar uma nova entrada, as alterações feitas em outros campos serão perdidas. Sugestão: deixe para adicionar/remover entradas quando o resto da lista não for modificado.

Peso (para média): <input name="weight" value="<?=$weight?>" type="text" style="width: 30px;" />
Tempo (em segundos): <input name="timelimit" value="<?=$timelimit?>" type="text" style="width: 30px;" />
Entrada:
<textarea name="new_input" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$new_input?></textarea>
Saída:
<textarea name="new_output" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$new_output?></textarea>

<input type="submit" value="Adicionar" /></form>


</pre>
