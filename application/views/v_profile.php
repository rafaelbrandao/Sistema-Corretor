<?
if (!isset($login)) $login = '???';
if (!isset($email)) $email = '???';
if (!isset($nome)) $nome = '???';
?>
<ul id="browse">
	<li>Perfil</li>
	<li>Submissões</li>
	<li>Clarifications</li>
	<li>Revisões</li>
</ul>

<pre>
<h1>Perfil</h1>Olá, <strong><?=$nome?></strong>, seu login é <strong><?=$login?></strong> e seu email, <strong><?=$email?></strong>.

<h1>Submissões</h1>Nesta seção você tem acesso à lista das suas submissões mais recentes efetuadas. Para ver o conteúdo da sua última submissão ou o erro que ela obteve, vá na questão da lista e clique em <strong>Submissão</strong>.
<!--
<strong>[13/09/2011 13:37]</strong> Submissão da solução <strong>L2Q1.cpp</strong> foi efetuada com sucesso!
<strong>[13/09/2011 13:14]</strong> Submissão da solução <strong>L2Q1.cpp</strong> obteve erros de compilação!
-->
<h1>Clarifications</h1>Nesta seção você pode acompanhar o resultado dos seus pedidos de clarification nas listas.
<!--
<strong>[13/09/2011 13:32]</strong> Clarification <a>#137</a> para <strong>L2Q2</strong> foi rejeitado!
<strong>[13/09/2011 11:45]</strong> Clarification <a>#132</a> para <strong>L2Q2</strong> foi aceito!
-->
<h1>Revisões</h1>Nesta seção você pode acompanhar o resultado dos seus pedidos de revisão nas listas.
<!--
<strong>[11/09/2011 10:20]</strong> Revisão de <strong>L1Q1.cpp</strong> foi rejeitada!
-->
</pre>
