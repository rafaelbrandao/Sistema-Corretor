<?
if (!isset($problem_id)) $problem_id = 0;
if (!isset($login_submit)) $login_submit = '';
if (!isset($date_submit)) $date_submit = '';
if (!isset($time_submit)) $time_submit = 0;
if (!isset($lang_submit)) $lang_submit = '';
if (!isset($compile_submit)) $compile_submit = '';
if (!isset($banned_submit)) $banned_submit = FALSE;
$filename = $this->problems->get_problem_repr($problem_id);
$ext = $this->datahandler->file_extension_for_language($lang_submit);

?>
<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/list_submissions/'.$problem_id)?>'">Submissões</li>
	<li>Editar</li>
</ul>
	
	
<h1>Editar Submissão</h1>
<pre>Nesta seção você pode analisar uma submissão de algum aluno, mas não pode alterá-la. O que pode fazer é sinalizar que esta submissão deve ser penalizada (em caso de detecção de cópias, por exemplo).

<a href="<?=base_url('/index.php/monitor/download_src/'.$problem_id.'/'.$login_submit.'/'.$time_submit)?>"><?=$filename?>.<?=$ext?></a> enviado por <strong><?=$login_submit?></strong> em <strong><?=$this->datahandler->translate_date_format($date_submit)?></strong>

<? if ($compile_submit) { ?>
Houve um <strong>erro de compilação</strong>:

<div style="border-left: solid 2px #ddd; padding-left: 10px; font-weight: bold;"><? echo $compile_submit; ?>
</div>
<? } ?>
</pre>

<h2>Penalizar Submissão</h2>
<?=form_open(base_url('/index.php/monitor/edit_submission/'.$problem_id.'/'.$login_submit.'/'.$time_submit.'/edit'))?>
<pre><input type="checkbox" name="banned" value="1" <?=($banned_submit ? 'checked' : '')?>> Marque esta opção para sinalizar que sua nota deverá ser <strong>zerada</strong>, independentemente da correção.

<input type="submit" value="Salvar alterações" />
</form>


</pre>
