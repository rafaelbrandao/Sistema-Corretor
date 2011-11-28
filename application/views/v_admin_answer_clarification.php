<?
if (!isset($problem_id)) $problem_id=0;
if (!isset($login_request)) $login_request='';
if (!isset($time_request)) $time_request=0;
if (!isset($request)) $request=array();

$list_id = $this->problems->get_list_id_for_problem($request['id_questao']);
$listprefix = $this->lists->get_list_name($list_id);
$num = $this->problems->get_num_for_problem($problem_id);
$questao = $listprefix.'Q'.$num;
?>

<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/clarifications')?>'">Clarifications</li>
	<li>Responder</li>
</ul>
<pre>
<h1><strong><?=$questao?></strong> - Responder Clarification</h1>
Aqui você pode <strong>confirmar</strong> que o problema descrito no clarification é real e assim criar um clarification que esclarece esse problema, ou você pode <strong>rejeitar</strong> o pedido, caso o problema não exista ou já tenha sido respondido. Só no primeiro caso que a resposta é publicada oficialmente no site e fica visível para todos verem. No segundo, o motivo da recusa será enviado somente por email para o usuário que solicitou.

<h2>Enviado por <strong><?=$request['login_usuario']?></strong> em <strong><?=$this->datahandler->translate_date_format($request['data_pedido'])?></strong></h2><?=$request['descricao_pedido']?>

<?=form_open(base_url('/index.php/monitor/answer_clarification/'.$problem_id.'/'.$login_request.'/'.$time_request.'/confirm'))?>
<h2>Confirmar</h2>Digite o conteúdo do clarification que esclarece o problema descrito.
<textarea name='answer' rows="4" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>
<input type="submit" value="Confirmar" /></form>

<?=form_open(base_url('/index.php/monitor/answer_clarification/'.$problem_id.'/'.$login_request.'/'.$time_request.'/reject'))?>
<h2>Rejeitar</h2>Digite a sua justificativa para recusar este pedido de clarification (será enviado por email ao aluno).
<textarea name='answer' rows="4" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>
<input type="submit" value="Rejeitar" /></form>

</pre>
