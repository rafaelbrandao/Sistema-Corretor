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
Para os campos <strong>Inicio</strong> e <strong>Término</strong>, coloque a data no formato "<strong>DD/MM HH:mm</strong>", por exemplo: <strong>13/09 13:50</strong>. Da mesma forma para os campos <strong>Revisão (início)</strong> e <strong>Revisão (término)</strong>. Se não quiser modificá-los agora, basta manter os valores atuais inalterados.

Uma lista só estará disponível para o público quando das datas de inicio e de término estiverem bem definidas, o horário atual estiver neste intervalo e estiver no estado "<strong>Andamento</strong>" ou adiante. Da mesma forma para as revisões dessa lista: só estará disponível para os alunos quando as duas datas forem definidas e estiver no estado "<strong>Revisão</strong>".

<div id="register_block"><?=form_open(base_url('/index.php/monitor/edit_list/'.$list_id))?>
Lista (prefixo): <input name='listprefix' value="<?=$listprefix?>" type="text" style="position: absolute; right: 0px; width: 150px;" />
Estado: <select name="liststate" style="position: absolute; right: 0px; width: 150px;">
<option value="preparacao" <?=($liststate == 'preparacao' ? 'selected' : '')?>>Preparação</option>
<option value="andamento" <?=($liststate == 'andamento' ? 'selected' : '')?>>Andamento</option>
<option value="correcao" <?=($liststate == 'correcao' ? 'selected' : '')?>>Correção</option>
<option value="revisao" <?=($liststate == 'revisao' ? 'selected' : '')?>>Revisão</option>
<option value="finalizada" <?=($liststate == 'finalizada' ? 'selected' : '')?>>Finalizada</option>
</select>

Inicio: <input name='timebegin' value="<?=$timebegin?>" type="text" style="position: absolute; right: 0px; width: 150px;" />
Término: <input name='timeend' value="<?=$timeend?>" type="text" style="position: absolute; right: 0px; width: 150px;" />
Revisão (inicio): <input name='rev_timebegin' value="<?=$rev_timebegin?>" type="text" style="position: absolute; right: 0px; width: 150px;" />
Revisão (término): <input name='rev_timeend' value="<?=$rev_timeend?>" type="text" style="position: absolute; right: 0px; width: 150px;" />

<input type="submit" value="Salvar alterações" style="position: absolute; right: 0px; width: 150px;"/></form></div>

</pre>
