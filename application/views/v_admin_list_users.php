<?
if (!isset($students)) $students = array();
if (!isset($admins)) $admins = array();
?>
<ul id="browse">
	<li>Administrador</li>
	<li>Listar Usuários</li>
	<li>Alunos</li>
	<li>Monitores</li>
</ul>
<pre>
<h1>Lista de Usuários Cadastrados</h1>
Nesta seção você terá a lista de usuários que já estão com cadastro confirmado (clique em "<strong>editar</strong>" para ver mais informações de um usuário).
<? if (count($students) > 0) { ?>
<h2>Alunos</h2><? foreach($students as $user) { ?>
<strong><?=$user['login']?></strong> [ <a href="<?=base_url('/index.php/monitor/edit_user/'.$user['login'])?>">editar</a> / <a href="<?=base_url('/index.php/monitor/delete_user/'.$user['login'])?>">excluir</a> ]

<? }

   }
   if (count($admins) > 0) {
?>
<h2>Monitores</h2><? foreach($admins as $user) { ?>
<strong><?=$user['login']?></strong> [ <a href="<?=base_url('/index.php/monitor/edit_user/'.$user['login'])?>">editar</a> / <a href="<?=base_url('/index.php/monitor/delete_user/'.$user['login'])?>">excluir</a> ]

<? }

   } ?>


</pre>
