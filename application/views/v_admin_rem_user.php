<?
if (!isset($login)) $login='';
?>
<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/list_users')?>'">Cadastrados</li>
	<li>Remover</li>
</ul>

<pre>
<h1>Remover Cadastro</h1>
Você está tentando remover o cadastro do usuário com login <strong><?=$login?></strong>. Deseja realmente removê-lo? Se não quiser, basta voltar para a página anterior. Entretanto, se deseja prosseguir, digite sua senha para confirmar a remoção.

<?=form_open(base_url('/index.php/monitor/delete_user/'.$login.'/confirm'))?>
Senha: <input name='confirm_pwd' type="password" style="width: 120px;" />
<input type="submit" value="Remover" /></form>

</pre>
