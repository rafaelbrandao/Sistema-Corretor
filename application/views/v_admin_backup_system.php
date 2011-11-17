<ul id="browse">
	<li>Administrador</li>
	<li>Arquivamento</li>
</ul>

<pre>
<h1>Arquivamente do Sistema</h1>
Ao requisitar o arquivamento do Sistema, será enviado para o usuário um arquivo .sql com todas as informações que estão no banco de dados do sistema. Esses dados poderão ser usados para restaurar a versão do sistema ao rodar o script no banco de dados.
Cuidado! Ao requisitar e confirmar o reset do sistema, as informações que estão armazenadas serão perdidas. Lembre-se de ter feito um arquivamento antes de utilizar o reset. Esta funcionalidade tem como objetivo limpar o sistema para o novo semestre.
<?=form_open(base_url('/index.php/monitor/generate_backup/'))?>

Digite sua senha para confirmar mudanças:
<input name='confirm_pwd' type="password" style="width: 120px;" />

<input type="submit" value="Criar Arquivamento" /></form>

</pre>
