<?
if (!isset($login)) $login = '';
if (!isset($problem_id)) $problem_id=0;
if (!isset($review_date)) $review_time='';
if (!isset($review_time)) $review_time=0;
if (!isset($submit_time)) $submit_time=0;
if (!isset($submit_extension)) $submit_extension='';
$question = $this->problems->get_problem_repr($problem_id);
?>
<ul id="browse">
	<li>Administrador</li>
	<li>Revisões</li>
	<li>Analisar</li>
	<li>Confirmar</li>
	<li>Rejeitar</li>
</ul>
<pre>
<h1>Analisar Revisão</h1>
O processo de revisão é feito manualmente. Você faz o download da solicitação de revisão que deve estar no formato proposto na disciplina, faz o download do código fonte do aluno na questão, aplica as alterações no código, e depois submete o novo código ao confirmar. Ao rejeitar o pedido você pode opcionalmente colocar uma mensagem que será recebida pelo aluno por email. 

<h2><strong><?=$question?></strong> - Enviado por <strong><?=$login?></strong> em <strong><?=$review_date?></strong></h2>Download [ <a href="<?=base_url('/index.php/monitor/download_src/'.$problem_id.'/'.$login.'/'.$submit_time)?>"><?=$question?>.<?=$submit_extension?></a> / <a href="<?=base_url('/index.php/monitor/download_review/'.$login.'/'.$problem_id.'/'.$review_time)?>"><?=$question?>.revisao</a> ]

<h2>Confirmar Pedido</h2>Cole o novo código fonte, após aplicada as alterações solicitadas neste pedido revisão.

<?=form_open(base_url('/index.php/monitor/review/'.$login.'/'.$problem_id.'/'.$review_time.'/accept'))?>
<textarea name="sourcecode" rows="10" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>
<input name="rejudge" type="checkbox" value="1"> Recorrigir esta questão após as alterações.

<input type="submit" value="Confirmar" />
</form>

<h2>Rejeitar Pedido</h2>Digite a sua justificativa por recusar este pedido de revisão (será enviado por email ao aluno).
<?=form_open(base_url('/index.php/monitor/review/'.$login.'/'.$problem_id.'/'.$review_time.'/reject'))?>
<textarea name="reason" rows="3" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>
<input type="submit" value="Rejeitar" />
</form>

</pre>
