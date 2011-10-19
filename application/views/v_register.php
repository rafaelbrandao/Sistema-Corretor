<?
	if (!isset($nome)) $nome = '';
	if (!isset($login)) $login = '';
?>

<ul id="browse">
	<li>Login</li>
	<li>Cadastro</li>
</ul>
<pre>
<div id="register_div"><h1>Cadastro</h1>Preencha com seu nome completo, seu <strong>login do CIn</strong> e, finalmente, crie uma senha para usar neste sistema. Seu email será no formato <strong>login@cin.ufpe.br</strong>.

<?=form_open(base_url('/index.php/home/register'))?><div id="register_block">Nome: <input name='nome' value="<?=$nome?>" type="text" style="position: absolute; right: 0px; width: 200px;"/>
Login: <input name='login' value="<?=$login?>" type="text" style="position: absolute; right: 0px; width: 200px;" onchange="document.getElementById('email_form').value = (this.value)+'@cin.ufpe.br'"/>
Senha: <input name='pwd' type="password" style="position: absolute; right: 0px; width: 200px;"/>
Email: <input id="email_form" name='email' value="<?=$login.'@cin.ufpe.br'?>" type="text" style="position: absolute; right: 0px; width: 200px;" disabled="disabled"/>
<input type="submit" value="Enviar" style="position: absolute; right: 0px;"/>
</div></form>
</div>

</pre>
