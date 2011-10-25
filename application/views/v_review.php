<?
if (!isset($problem_id)) $problem_id = 0;
if (!isset($request)) $request = '';
if (!isset($logged)) $logged = '';
if (!isset($last)) $last = '';
$num = $this->problems->get_num_for_problem($problem_id);
$list_id = $this->problems->get_list_id_for_problem($problem_id);
$listprefix = $this->lists->get_list_name($list_id);
$question = $listprefix.'Q'.$num;
?>

<ul id="browse">
	<li>Listas</li>
	<li><?=$question?></li>
	<li>Revisão</li>
</ul>

<h1><strong><?=$question?></strong> - Revisão</h1>
<ul class="lista_menu">
	<!--<li>Nome do arquivo: <strong>L2Q2.revisao</strong></li>-->
</ul>
<pre>Escreva, no formato adequado, o seu <strong>pedido de revisão</strong>. Ele deve seguir o formato especificado em <strong>Informações</strong>. Pedidos fora do formato serão desconsiderados.

<?=form_open(base_url('/index.php/home/review/'.$problem_id))?>
Pedido:
<textarea name='request' rows="3" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"><?=$request?></textarea>
Senha:   <input name='confirm_pwd' type="password" name="senha" style="width: 200px;" />
		 <input type="submit" value="Enviar" style="margin-left: 132px; width: 60px;"/></form>
</pre>

<?
if ($last) {
?>

<h2>Solução enviada por você</h2>
<ul class="lista_menu">
	<!--<li>Código fonte: <strong>L2Q2.c</strong>, <strong>L2Q2.cpp</strong> ou <strong>L2Q2.java</strong></li>-->
	<li>Entrada: <strong><?=$question?>.in</strong></li>
	<li>Saída: <strong><?=$question?>.out</strong></li>
</ul>
<pre>A seguir, o código fonte da sua solução (em <strong><?=$last['linguagem']?></strong>), enviado por você em <strong><?=$this->datahandler->translate_date_format($last['data_submissao'])?></strong>:

<div style="border-left: solid 2px #ddd; padding-left: 10px;"><?=htmlspecialchars($last['codigo_fonte'])?>
</div>
<? } ?>
</pre>
