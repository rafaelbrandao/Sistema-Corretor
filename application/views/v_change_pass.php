<?
if (!isset($current_pass)) $current_pass = '';
if (!isset($new_pass)) $new_pass = '';
if (!isset($confirm_pass)) $confirm_pass = '';
if (!isset($is_admin)) $is_admin = FALSE;
?>
<ul id="browse">
	<? if ($is_admin) { ?> <li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li> <? }
	   else { ?> <li onclick="document.location = '<?=base_url('/index.php/home/perfil')?>'">Perfil</li> <? } ?>
	<li>Mudar senha</li>
</ul>
<pre>
<h1>Mudança de senha</h1>
É necessário que sua senha contenha no mínimo 4 caracteres. Digite no campo de confirmação a nova senha também, e memorize-a. No momento não é possível recuperar sua senha sem a ajuda de um monitor. Caso necessite, entre em contato com a monitoria.
<?=form_open(base_url('/index.php/home/change_pass'))?><div id="register_block">
Senha atual: <input name='current_pass' type="password" value="" type="text" style="position: absolute; right: 0px; width: 200px;" />
Nova senha: <input name='new_pass' value="" type="password" style="position: absolute; right: 0px; width: 200px;" onchange="document.getElementById('email_form').value = (this.value)+'@cin.ufpe.br'"/>
Confirme: <input name='confirm_pass' value="" type="password" style="position: absolute; right: 0px; width: 200px;" />
<input type="submit" value="Alterar" style="position: absolute; right: 0px;"/></form></div>

</pre>
