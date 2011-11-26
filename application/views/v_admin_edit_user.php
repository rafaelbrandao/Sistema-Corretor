<?
if (!isset($nome)) $nome='';
if (!isset($login)) $login='';
if (!isset($pwd)) $pwd='';
if (!isset($email)) $email='';
if (!isset($grant_access)) $grant_access=FALSE;
?>
<ul id="browse">
	<li>Administrador</li>
	<li>Editar Dados</li>
	<li>Aluno/Monitor</li>
</ul>

<pre>
<h1>Edição de Dados de <strong>Aluno</strong> (ou <strong>Monitor</strong>)</h1>
Os alunos não possuem essa interface, então qualquer alteração nas informações deles deve ser feitas por intermédio de um monitor. Além de fornecer os novos dados do usuário, você deverá fornecer sua senha, para confirmar as alterações dessas informações. Para <strong>não mudar a senha</strong> desse usuário, basta deixar o campo <strong>Senha</strong> em branco.
<?=form_open(base_url('/index.php/monitor/edit_user/'.$login))?><div id="register_block">
Nome: <input name='nome' value="<?=$nome?>" type="text" style="position: absolute; right: 0px; width: 200px;" />
Login: <input name='login' value="<?=$login?>" type="text" style="position: absolute; right: 0px; width: 200px;" disabled="disabled"/>
Senha: <input name='pwd' value="<?=$pwd?>" type="password" style="position: absolute; right: 0px; width: 200px;" />

Email: <input id="email_form" name='email' value="<?=$email?>" type="text" style="position: absolute; right: 0px; width: 200px;" />

<input type="checkbox" name="grant_access" value="1" <?=($grant_access == '1' ? 'checked' : '')?> > Marque se este usuário é <strong>Monitor</strong>.

<div style="text-align: right;">Confirme as mudanças com <strong>sua senha</strong>:</div><input name='confirm_pwd' type="password" style="position: absolute; right: 0px; width: 200px;" />

<input type="submit" value="Salvar" style="position: absolute; right: 0px; width: 100px;" /></form></div>

</pre>
