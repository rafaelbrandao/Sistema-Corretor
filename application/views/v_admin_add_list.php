<?
if (!isset($listprefix)) $listprefix = '';
if (!isset($timebegin)) $timebegin = '';
if (!isset($timeend)) $timeend = '';
?>
<ul id="browse">
	<li>Administrador</li>
	<li>Listas</li>
	<li>Criar Lista</li>
</ul>
<pre>
<h1>Criar Lista</h1>
Para o campo <strong>Lista (prefixo)</strong>, sugerimos que use no formato <strong>LX</strong> onde X é o número da lista. Esse prefixo será depois usado para o nome dos arquivos de entrada e de saída, por exemplo: <strong>LXQY</strong>, caso o prefixo seja no formato sugerido anteriormente. Cada lista diferente terá um prefixo diferente.

Para os campos <strong>Inicio</strong> e <strong>Prazo</strong>, coloque a data no formato "<strong>DD/MM HH:mm</strong>", por exemplo: <strong>13/09 13:50</strong>. Se não quiser especificá-las agora, deixe-as em branco. Uma lista só estará disponível para o público quando essas duas datas estiverem bem definidas (e depois da data de lançamento da lista).

<?=form_open(base_url('/index.php/monitor/add_list'))?>
Lista (prefixo): <input name="listprefix" value="<?=$listprefix?>" type="text" style="width: 50px;" />
Inicio: <input name="timebegin" value="<?=$timebegin?>" type="text" style="width: 100px;" />
Prazo: <input name="timeend" value="<?=$timeend?>" type="text" style="width: 100px;" />
<input type="submit" value="Criar" />
</form>

</pre>