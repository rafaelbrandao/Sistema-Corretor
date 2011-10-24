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
?>
<ul id="browse">
	<li>Administrador</li>
	<li>Listas</li>
	<li>Editar Questão</li>
	<li>Exemplos IN/OUT</li>
	<li>Corretor IN/OUT</li>
</ul>
<pre>
<h1><strong><?=$listprefix.'Q'.$problem_num?></strong> - Editar questão (enunciado)</h1>
<?=form_open(base_url('/index.php/monitor/edit_problem/'.$problem_id.'/specs'))?>
Título: <input name="title" value="<?=$title?>" type="text" style="width: 200px;" />

Especificação:
<textarea name="specs" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$specs?></textarea>

Formato de entrada:
<textarea name="in_format" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$in_format?></textarea>

Formato de saída:
<textarea name="out_format" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$out_format?></textarea>

<input type="submit" value="Salvar alterações" /></form>

<?=form_open(base_url('/index.php/monitor/edit_problem/'.$problem_id.'/samples'))?>
<h1><strong><?=$listprefix.'Q'.$problem_num?></strong> - Exemplos de entrada e de saída</h1>
Exemplo de entrada:
<textarea name="in_sample" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$in_sample?></textarea>

Exemplo de saída:
<textarea name="out_sample" rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$out_sample?></textarea>

<!--Entrada para download (opcional): <input type="file" name="in_sample_file" style="width: 200px;" text="selecionar" />

Saída para download (opcional): <input type="file" name="out_sample_file" style="width: 200px;" text="selecionar" />
-->
<input type="submit" value="Salvar alterações" /></form>

<?=form_open_multipart(base_url('/index.php/monitor/edit_problem/'.$problem_id.'/add_answer'))?>
<h1><strong><?=$listprefix.'Q'.$problem_num?></strong> - Entradas e saídas para o corretor</h1>Nesta seção, você vê a lista de entradas e saídas já criadas.
<!--
	<?=$listprefix.'Q'.$problem_num?>E<strong>1</strong> [ <a href="oi">excluir</a> ]:
	
		Peso: <strong>1</strong>
		Tempo: <strong>4</strong> segundo(s)
		Entrada: <a href="oi">download</a>
		Saida: <a href="oi">download</a>
-->
		
<h2>Enviar nova entrada e saída para o corretor</h2>Entrada #: <input type="text" style="width: 20px;" />
Peso (para média): <input type="text" style="width: 30px;" value="1" />
Tempo (em segundos): <input type="text" style="width: 30px;" value="1" />
Arquivo de entrada: <input type="file" name="solucao" style="width: 200px;" text="selecionar" />
Arquivo de saída: <input type="file" name="solucao" style="width: 200px;" text="selecionar" />
<input type="submit" value="Adicionar" /></form>


</pre>
