<?
if (!isset($nome)) $nome='';
if (!isset($login)) $login='';
if (!isset($pwd)) $pwd='';
if (!isset($email)) $email='';
if (!isset($grant_access)) $grant_access=FALSE;
?>
<ul id="browse">
	<li>Administrador</li>
	<li>Cadastro</li>
	<li>Aluno/Monitor</li>
</ul>
<pre>
<h1>Cadastro de <strong>Aluno</strong> (ou <strong>Monitor</strong>)</h1>
É recomendado que os alunos solicitem seus próprios cadastros ao invés de serem cadastrados por monitores. O email do aluno será preenchido automaticamente, após inserido o login, com o email do CIn, mas você poderá alterá-lo se necessário.
<?=form_open(base_url('/index.php/monitor/register_user'))?><div id="register_block">
Nome: <input name='nome' value="<?=$nome?>" type="text" style="position: absolute; right: 0px; width: 200px;" />
Login: <input name='login' value="<?=$login?>" type="text" style="position: absolute; right: 0px; width: 200px;" onchange="document.getElementById('email_form').value = (this.value)+'@cin.ufpe.br'"/>
Senha: <input name='pwd' value="<?=$pwd?>" type="password" style="position: absolute; right: 0px; width: 200px;" />

Email: <input id="email_form" name='email' value="<?=$email?>" type="text" style="position: absolute; right: 0px; width: 200px;" />

<input type="checkbox" name="grant_access" value="1" <?=($grant_access == '1' ? 'checked' : '')?>> Cadastrar como <strong>Monitor</strong>.

<input type="submit" value="Cadastrar" style="position: absolute; right: 0px;"/></form></div>

</pre>
