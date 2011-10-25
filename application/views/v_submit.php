<?
if (!isset($problem_id)) $problem_id = 0;
if (!isset($src)) $src = '';
if (!isset($lang)) $lang = 'java';
if (!isset($logged)) $logged = '';

$num = $this->problems->get_num_for_problem($problem_id);
$list_id = $this->problems->get_list_id_for_problem($problem_id);
$listprefix = $this->lists->get_list_name($list_id);
$question = $listprefix.'Q'.$num;
?>
<ul id="browse">
	<li>Listas</li>
	<li><?=$question?></li>
	<li>Submissão</li>
</ul>
	
<h1><strong><?=$question?></strong> - Submissão</h1>
<ul class="lista_menu">
	<li>Entrada: <strong><?=$question?>.in</strong></li>
	<li>Saída: <strong><?=$question?>.out</strong></li>
</ul>
<pre>Cole no campo '<strong>Código fonte</strong>' sua solução e digite sua senha. Antes de enviar, verifique os nomes dos arquivos de <strong>entrada</strong> e de <strong>saída</strong>. Lembre-se também de escolher a linguagem de programação correta.

<?=form_open(base_url('/index.php/home/submit/'.$problem_id))?>
Linguagem: <select name='lang'>
<option value="c" <?=($lang == 'c' ? 'selected' : '')?>>c</option>
<option value="c++" <?=($lang == 'c++' ? 'selected' : '')?>>c++</option>
<option value="java" <?=($lang == 'java' ? 'selected' : '')?>>java</option>
</select>
Código fonte:
<textarea name='src' rows="3" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$src?></textarea>
Senha:   <input name='pwd' type="password" name="senha" style="width: 200px;" />
		 <input type="submit" value="Enviar" style="margin-left: 132px; width: 60px;"/></form>
</pre>

<?
$last = $this->submissions->last_submission($problem_id, $logged);
if ($last) {
?>
<h2>Última Submissão</h2><pre>
<? if ($last['compilacao_erro']) { ?>
Houve um <strong>erro de compilação</strong> no seu último código enviado:

<div style="border-left: solid 2px #ddd; padding-left: 10px; font-weight: bold;"><?=$last['compilacao_erro']?>
</div>


<? } ?>
A seguir, o código fonte (em <strong><?=$last['linguagem']?></strong>) da sua última submissão, enviada por você em <strong><?=$this->datahandler->translate_date_format($last['data_submissao'])?></strong>:

<div style="border-left: solid 2px #ddd; padding-left: 10px;"><?=htmlspecialchars($last['codigo_fonte'])?>
</div>
<? } ?>
</pre>
