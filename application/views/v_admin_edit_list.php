<?
if (!isset($list_id)) $list_id='';
if (!isset($listprefix)) $listprefix='';
if (!isset($liststate)) $liststate='';
if (!isset($timebegin)) $timebegin='';
if (!isset($timeend)) $timeend='';
if (!isset($rev_timebegin)) $rev_timebegin='';
if (!isset($rev_timeend)) $rev_timeend='';
?>
<ul id="browse">
	<li>Administrador</li>
	<li>Listas</li>
	<li>Editar Lista</li>
</ul>
<pre>
<h1><strong>Lista '<?=$listprefix?>'</strong> - Editar Lista</h1>
Para os campos <strong>Inicio</strong> e <strong>Prazo</strong>, coloque a data no formato "<strong>DD/MM HH:mm</strong>", por exemplo: <strong>13/09 13:50</strong>. Da mesma forma para os campos <strong>Revisão (início)</strong> e <strong>Revisão (prazo)</strong>. Se não quiser modificá-los agora, basta manter os valores atuais inalterados.

Uma lista só estará disponível para o público quando das datas de inicio e prazo estiverem bem definidas (e depois da data de lançamento da lista). Da mesma forma para as revisões dessa lista, que só estará disponível para os alunos quando as duas datas forem definidas.

<?=form_open(base_url('/index.php/monitor/edit_list/'.$list_id))?>
Lista (prefixo): <input name='listprefix' value="<?=$listprefix?>" type="text" style="width: 100px;" />
Estado: <select name="liststate" style="width: 100px;">
<option value="preparacao" <?=($liststate == 'preparacao' ? 'selected' : '')?>>Preparação</option>
<option value="andamento" <?=($liststate == 'andamento' ? 'selected' : '')?>>Andamento</option>
<option value="correcao" <?=($liststate == 'correcao' ? 'selected' : '')?>>Correção</option>
<option value="revisao" <?=($liststate == 'revisao' ? 'selected' : '')?>>Revisão</option>
<option value="finalizada" <?=($liststate == 'finalizada' ? 'selected' : '')?>>Finalizada</option>
</select>
Inicio: <input name='timebegin' value="<?=$timebegin?>" type="text" style="width: 100px;" />
Prazo: <input name='timeend' value="<?=$timeend?>" type="text" style="width: 100px;" />
Revisão (inicio): <input name='rev_timebegin' value="<?=$rev_timebegin?>" type="text" style="width: 100px;" />
Revisão (prazo): <input name='rev_timeend' value="<?=$rev_timeend?>" type="text" style="width: 100px;" />

<input type="submit" value="Salvar alterações" /></form>

</pre>
