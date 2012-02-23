<?
if (!isset($login)) $login = '???';
if (!isset($email)) $email = '???';
if (!isset($nome)) $nome = '???';
?>
<ul id="browse">
	<li>Perfil</li>
</ul>

<pre>
<h1>Perfil</h1>Olá, <strong><?=$nome?></strong>, seu login é <strong><?=$login?></strong> e seu email, <strong><?=$email?></strong>.

<h1>Usuário</h1>
<a href="<?=base_url('/index.php/home/change_pass')?>">Mudar senha</a> - clique aqui para alterar sua senha no sistema.
</pre>
