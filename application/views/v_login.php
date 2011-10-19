<?
	if (!isset($login)) $login = '';
?>

<ul id="browse">
	<li onclick="window.location = '<?=base_url('/index.php/home/login')?>';">Login</li>
	<li onclick="window.location = '<?=base_url('/index.php/home/register')?>';">Cadastro</li>
</ul>

<pre>
<div id="login_div"><h1>Login</h1>Caso você ainda não esteja cadastrado, <strong onclick="window.location = '<?=base_url('/index.php/home/register')?>';" style="cursor:pointer;">clique aqui</strong>. Digite o login que você escolheu ao se cadastrar e sua respectiva senha para logar no sistema.

<?=form_open(base_url('/index.php/home/login'))?><div id="login_block">Login: <input name='login' value="<?=$login?>" type="text" style="position: absolute; right: 0px; width: 200px;"/>
Senha: <input name='pwd' type="password" style="position: absolute; right: 0px; width: 200px;"/>
<input type="submit" value="Enviar" style="position: absolute; right: 0px;"/>
</div></div></form>

</pre>
