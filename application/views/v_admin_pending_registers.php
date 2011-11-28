<?
	if (!isset($pending_list)) $pending_list = array();
?>
<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li>Solicitações</li>
</ul>
<pre>
<h1>Lista de Cadastros Pendentes</h1>
Nesta seção você terá a lista de usuários que solicitaram cadastro no sistema e que estão aguardando aprovação. Ao aceitar ou rejeitar um pedido de cadastro, o usuário que solicitou será informado da decisão através de seu email (informado no cadastro). Fique atento porque a operação de rejeitar um cadastro não pedirá confirmação para conclui-la.

<? 	foreach ($pending_list as $entry) {
		$login = $entry['login'];
?>
<strong><?=$login?></strong> [ <a href="<?=base_url('/index.php/monitor/register_confirm/'.$login)?>">aceitar</a> / <a href="<?=base_url('/index.php/monitor/register_reject/'.$login)?>">rejeitar</a> ]
	Nome: <strong><?=$entry['nome']?></strong>
	Email: <strong><?=$entry['email']?></strong>
	
<? 	} ?>

</pre>
