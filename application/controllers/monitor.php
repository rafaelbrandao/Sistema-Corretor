<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor extends CI_Controller {

	var $logged = '';
	var $is_admin = FALSE;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->library(array('datahandler','session','input'));
		$this->load->model('user','', TRUE);
		$this->load->model('lists','', TRUE);
		$this->load->model('problems','', TRUE);
		$this->load->model('judge','', TRUE);
		$this->load->model('clarifications','', TRUE);
		$this->load->model('reviews','', TRUE);
		$this->load->model('submissions','', TRUE);
		$this->load->model('emailsender','', TRUE);
		$this->load->model('score','', TRUE);
		
		$this->load->model('backup','', TRUE);
		
		
		$this->logged = $this->session->userdata('logged');
		if ($this->logged) 
			$this->is_admin = $this->user->is_user_admin($this->logged);
		
		if (!$this->logged || !$this->is_admin)
			redirect(base_url('/'), 'location');
	}

	function index()
	{
		$notice = $this->session->flashdata('notice');
		
		$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
		$this->load->view('v_admin_profile', $this->user->retrieve_info($this->logged));
		$this->load->view('v_footer');
	}
	
	function register_user()
	{
		$nome = $this->input->post('nome');
		$email = $this->input->post('email');
		$pwd = $this->input->post('pwd');
		$login = $this->input->post('login');
		$grant_access = $this->input->post('grant_access');
		
		if (!$nome && !$email && !$pwd && !$login) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_register_user');
			$this->load->view('v_footer');
			return;
		}
		
		$error='';
		
		if (!$nome) $error = 'É preciso especificar nome completo no sistema.';
		else if (!$login) $error = 'É preciso especificar login no sistema.';
		else if (!$pwd) $error = 'É preciso especificar uma senha no sistema.';
		else if (!$email) $error = 'É preciso especificar um email no sistema.';
		else if (count(explode(" ",$nome)) < 2) $error = 'É preciso especificar nome completo no sistema.';
		else if ($this->user->is_user_registered($login)) $error = 'Login especificado já está cadastrado.';
		else if (!$this->user->add_user($login,$pwd,$nome,$email,($grant_access == '1'),TRUE)) $error = 'Erro desconhecido.';
		
		if ($error) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_register_user', array('nome'=>$nome, 'email'=>$email, 'pwd'=>$pwd, 'login'=>$login, 'grant_access'=>$grant_access));
			$this->load->view('v_footer');
			return;
		}
		
		$this->session->set_flashdata('notice','Usuário (login: '.$login.') foi cadastrado com sucesso!');
		redirect(base_url('/index.php/monitor'), 'location');
		
		
	}
	
	function pending_registers()
	{
		$notice = $this->session->flashdata('notice');
		$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
		$this->load->view('v_admin_pending_registers', array('pending_list'=>$this->user->retrieve_pending_registers()));
		$this->load->view('v_footer');
	}
	
	function register_confirm($login='')
	{
		$user = $this->user->retrieve_info($login);
		$this->user->register_confirm($login);
		$this->emailsender->send_email_register_accepted($user['email'], $user['nome'], $login);
		$this->session->set_flashdata('notice','Cadastro do login '.$login.' foi aceito com sucesso.');
		redirect(base_url('/index.php/monitor/pending_registers'), 'location');
	}
	
	function register_reject($login='')
	{
		$user = $this->user->retrieve_info($login);
		$this->user->register_reject($login);
		$this->emailsender->send_email_register_rejected($user['email'], $user['nome'], $login);
		$this->session->set_flashdata('notice','Cadastro do login '.$login.' foi rejeitado com sucesso.');
		redirect(base_url('/index.php/monitor/pending_registers'), 'location');
	}
	
	function list_users()
	{
		$students = $this->user->retrieve_list_students();
		$admins = $this->user->retrieve_list_admins();
		
		$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_admin_list_users', array('students'=>$students, 'admins'=>$admins));
		$this->load->view('v_footer');
	}
	
	function edit_user($login='')
	{	
		if ($login=='admin') {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		$pwd = $this->input->post('pwd');
		$nome = $this->input->post('nome');
		$email = $this->input->post('email');
		$grant_access = $this->input->post('grant_access');
		$confirm_pwd = $this->input->post('confirm_pwd');
		
		if (!$pwd && !$nome && !$email) {
			if (!$login) {
				redirect(base_url('/index.php/monitor'), 'location');
				return;
			}
			$user = $this->user->retrieve_info($login,TRUE);
			$pwd = '';
			$nome = $user['nome'];
			$email = $user['email'];
			$grant_access = $user['tipo_permissao'] == 'aluno' ? FALSE : '1';
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_edit_user', array('pwd'=>$pwd,'nome'=>$nome,'email'=>$email,'grant_access'=>$grant_access,'login'=>$login));
			$this->load->view('v_footer');			
			return;
		}
		
		$error = '';
		if (!$nome) $error = 'Usuários precisam ter seu nome completo especificado.';
		else if (!$email) $error = 'Usuários precisam ter seu email especificado.';
		else if (count(explode(" ",$nome)) < 2) $error = 'Usuários precisam ter seu nome completo especificado.';
		else if (!$confirm_pwd) $error='Você precisa confirmar as mudanças digitando sua senha.';
		else if (!$this->user->is_pwd_correct($this->logged, $confirm_pwd)) $error='Sua senha está incorreta. Mudanças não foram efetuadas.';
		
		if ($error) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_edit_user', array('pwd'=>$pwd,'nome'=>$nome,'email'=>$email,'grant_access'=>$grant_access,'login'=>$login));
			$this->load->view('v_footer');			
			return;
		}
		
		
		$this->user->update_user($login, $pwd, $nome, $email, $grant_access);
		$this->session->set_flashdata('notice',"Usuário (login: $login) teve seus dados atualizados com sucesso!");
		redirect(base_url('/index.php/monitor'), 'location');
	}	
	
	function delete_user($login='', $confirm=FALSE)
	{
		if (!$login || $login=='admin') {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		
		if (!$confirm) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_rem_user', array('login'=>$login));
			$this->load->view('v_footer');
			return;
		}
		
		$confirm_pwd = $this->input->post('confirm_pwd');
		if (!$this->user->is_pwd_correct($this->logged, $confirm_pwd)) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>'Sua senha está incorreta. Usuário não foi excluido.'));
			$this->load->view('v_admin_rem_user', array('login'=>$login));
			$this->load->view('v_footer');
			return;			
		}
		
		$this->user->delete_user($login);
		$this->session->set_flashdata('notice',"Usuário (login: $login) foi excluido com sucesso!");
		redirect(base_url('/index.php/monitor'), 'location');
	}
	
	function lists()
	{
		$notice = $this->session->flashdata('notice');
		$error = $this->session->flashdata('error');
		$lists_data = $this->lists->get_all_lists_data();
	
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice, 'error'=>$error));
		$this->load->view('v_admin_lists', array('lists_data'=>$lists_data));
		$this->load->view('v_footer');
	}
	
	function add_list()
	{
		$listprefix = $this->input->post('listprefix');
		$timebegin = $this->input->post('timebegin');
		$timeend = $this->input->post('timeend');
		
		if (!$listprefix && !$timebegin && !$timeend) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_add_list');
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		if (!$listprefix)
			$error = 'Você precisa especificar o prefixo da lista.';
		else if ($timebegin && $timebegin != '' && !$this->datahandler->validate_date_format($timebegin))
			$error = 'O formato da data de inicio deve ser DD/MM HH:mm. Veja o exemplo para esclarecimento.';
		else if ($timeend && $timeend != '' && !$this->datahandler->validate_date_format($timeend))
			$error = 'O formato da data de término deve ser DD/MM HH:mm. Veja o exemplo para esclarecimento.';
		
		if ($error == '') {
			$_timebegin = $this->datahandler->convert_date_format($timebegin);
			$_timeend = $this->datahandler->convert_date_format($timeend);
			
			if ($_timebegin != '' && $_timeend != '' && strtotime($_timebegin) > strtotime($_timeend))
				$error = 'O inicio da lista deve acontecer antes do fim da mesma.';
			else if ($this->lists->create_list($listprefix, $_timebegin, $_timeend) == 0)
				$error = 'O prefixo escolhido para a lista já existe. Escolha outro.';
		}
		
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_add_list', array('listprefix' => $listprefix, 'timebegin'=>$timebegin, 'timeend'=>$timeend));
			$this->load->view('v_footer');
			return;
		}
		
		$this->session->set_flashdata('notice',"Lista '$listprefix' adicionada com sucesso.");
		redirect(base_url('/index.php/monitor/lists'), 'location');
	}
	
	function edit_list($list_id=0)
	{
		if (!$list_id || !$this->lists->has_list_id($list_id)) {
			redirect(base_url('/index.php/monitor/lists'), 'location');
			return;
		}
		
		$form['list_id'] = $list_id;
		$form['listprefix'] = $this->input->post('listprefix');
		$form['liststate'] = $this->input->post('liststate');
		$form['timebegin'] = $this->input->post('timebegin');
		$form['timeend'] = $this->input->post('timeend');
		$form['rev_timebegin'] = $this->input->post('rev_timebegin');
		$form['rev_timeend'] = $this->input->post('rev_timeend');
		if (!$form['listprefix'] & !$form['liststate'] && !$form['timebegin']
			&& !$form['timeend'] && !$form['rev_timebegin'] && !$form['rev_timeend']) {
			$data = $this->lists->get_list_data($list_id);
			$form['listprefix'] = $data['nome_lista'];
			$form['liststate'] = $data['estado_lista'];
			$form['timebegin'] = $this->datahandler->translate_date_format($data['data_lancamento']);
			$form['timeend'] = $this->datahandler->translate_date_format($data['data_finalizacao']);
			$form['rev_timebegin'] = $this->datahandler->translate_date_format($data['data_inicio_revisao']);
			$form['rev_timeend'] = $this->datahandler->translate_date_format($data['data_fim_revisao']);
			
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_edit_list', $form);
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		$other_id = $this->lists->get_list_id($form['listprefix']);
		$timebegin = '';
		$timeend = '';
		$rev_timebegin = '';
		$rev_timeend = '';
		
		if ($other_id && $other_id != $list_id) $error = 'Você escolheu um prefixo que já está sendo usado em outra lista.';
		else if (!$form['liststate']) $error = 'Você deveria selecionar um estado válido da lista.';
		if (!$error) {
			$timebegin = $this->datahandler->convert_date_format($form['timebegin']);
			$timeend = $this->datahandler->convert_date_format($form['timeend']);
			$rev_timebegin = $this->datahandler->convert_date_format($form['rev_timebegin']);
			$rev_timeend = $this->datahandler->convert_date_format($form['rev_timeend']);
			if ($timebegin != '' && $timeend != '' && strtotime($timebegin) > strtotime($timeend))
				$error = 'A data de inicio da lista deveria ser antes da data de término da mesma.';
			else if ($rev_timebegin != '' && $rev_timeend != '' && strtotime($rev_timebegin) > strtotime($rev_timeend))
				$error = 'A data de inicio da revisão deveria ser antes da data de término da mesma.';
			else if (!$this->lists->edit_list($list_id, $form['listprefix'], $form['liststate'], $timebegin, $timeend, $rev_timebegin, $rev_timeend))
				$error = 'Erro desconhecido.';
		}
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_edit_list', $form);
			$this->load->view('v_footer');
			return;
		}
		$this->session->set_flashdata('notice',"Lista '".$form['listprefix']."' modificada com sucesso.");
		redirect(base_url('/index.php/monitor/lists'), 'location');
	}
	
	function rem_list($list_id=0, $confirm='')
	{
		if (!$list_id || !$this->lists->has_list_id($list_id)) {
			redirect(base_url('/index.php/monitor/lists'), 'location');
			return;
		}
		
		$listprefix = $this->lists->get_list_name($list_id);
		
		if ($confirm == '') {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_rem_list', array('listprefix'=>$listprefix, 'list_id'=>$list_id));
			$this->load->view('v_footer');
			return;
		}
		
		$confirm_pwd = $this->input->post('confirm_pwd');
		if (!$this->user->is_pwd_correct($this->logged, $confirm_pwd)) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>'Senha incorreta. Lista não foi removida.'));
			$this->load->view('v_admin_rem_list', array('listprefix'=>$listprefix, 'list_id'=>$list_id));
			$this->load->view('v_footer');
			return;
		}
		$this->lists->delete_list($list_id);
		$this->session->set_flashdata('notice', "Lista '$listprefix' foi removida com sucesso.");
		redirect(base_url('/index.php/monitor/lists'), 'location');
	}
	
	function add_problem($list_id=0)
	{
		if (!$list_id || !$this->lists->has_list_id($list_id)) {
			redirect(base_url('/index.php/monitor/lists'), 'location');
			return;
		}
		$data['listprefix'] = $this->lists->get_list_name($list_id);
		$data['list_id'] = $list_id;
		$data['problem_num'] = $this->input->post('problem_num');
		
		if (!$data['problem_num']) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_add_problem', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		$problem_num = 0;
		if (!is_numeric($data['problem_num']))
			$error = 'Você deve passar um número inteiro positivo.';
		else if (($problem_num = intval($data['problem_num'])) <= 0)
			$error = 'Você deve passar um número inteiro positivo. Zero ou números negativos são inválidos.';
		else if ($this->problems->has_problem_num($list_id, $problem_num))
			$error = "Uma questão com número $problem_num já existe. Escolha outro.";
		
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_add_problem', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$this->problems->create_problem_num($list_id, $problem_num);
		$this->session->set_flashdata('notice', "Questão #$problem_num criada com sucesso!");
		redirect(base_url('/index.php/monitor/lists'), 'location');
	}
	
	function edit_problem($problem_id=0, $step='')
	{
		$list_id = 0;
		if (!$problem_id || !($list_id = $this->problems->get_list_id_for_problem($problem_id))) {
			redirect(base_url('/index.php/monitor/lists'), 'location');
			return;
		}
		$scroll = $this->session->flashdata('scroll');
		$notice = $this->session->flashdata('notice');
		$data['list_id'] = $list_id;
		$data['listprefix'] = $this->lists->get_list_name($list_id);
		$data['problem_id'] = $problem_id;
		$pro = $this->problems->get_data_for_problem($problem_id);
		
		$data['problem_num'] = $pro['numero'];
		$data['specs'] = $step == 'specs' ? $this->input->post('specs') : $pro['enunciado'];
		$data['title'] = $step == 'specs' ? $this->input->post('title') : $pro['nome'];
		$data['in_format'] = $step == 'specs' ? $this->input->post('in_format') : $pro['descricao_entrada'];
		$data['out_format'] = $step == 'specs' ? $this->input->post('out_format') : $pro['descricao_saida'];
		$data['in_sample'] = $step == 'specs' ? $this->input->post('in_sample') : $pro['entrada_exemplo'];
		$data['out_sample'] = $step == 'specs' ? $this->input->post('out_sample') : $pro['saida_exemplo'];
		
		if (!$step) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice, 'scroll'=>$scroll));
			$this->load->view('v_admin_edit_problem', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		$question = $data['listprefix'].'Q'.$data['problem_num'];
		
		if ($step == 'add_answer') {
			$data['new_input'] = $this->input->post('new_input');
			$data['new_output'] = $this->input->post('new_output');
			$data['timelimit'] = $this->input->post('timelimit');
			$data['weight'] = $this->input->post('weight');
			$timelimit = 0;
			$weight = 0;
			if (!$data['new_input'])
				$error = 'Você precisa especificar alguma entrada para o corretor.';
			else if (!$data['timelimit'])
				$error = 'Você precisa especificar tempo limite para o corretor.';
			else if (!$data['weight'])
				$error = 'Você precisa especificar o peso para uma nova entrada.';
			else if (!is_numeric($data['timelimit']))
				$error = 'Você deve passar um número inteiro positivo como tempo limite.';
			else if (($timelimit = intval($data['timelimit'])) <= 0)
				$error = 'Você deve passar um número inteiro positivo como tempo limite. Zero ou números negativos são inválidos.';
			else if (!is_numeric($data['weight']))
				$error = 'Você deve passar um número inteiro positivo como peso.';
			else if (($weight = intval($data['weight'])) <= 0)
				$error = 'Você deve passar um número inteiro positivo como peso. Zero ou números negativos são inválidos.';
			
			if ($error) {
				$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error, 'notice'=>$notice, 'scroll'=>'judge'));
				$this->load->view('v_admin_edit_problem', $data);
				$this->load->view('v_footer');
				return;
			}
			$this->judge->add_input_for_problem($problem_id, $data['new_input'], $data['new_output'], $timelimit, $weight);
			$this->session->set_flashdata('scroll','judge');
		}
		else if ($step == 'specs') {
			$this->problems->update_problem_specs($problem_id, $data['title'], $data['specs'], $data['in_format'], $data['out_format']);
			$this->problems->update_problem_samples($problem_id, $data['in_sample'], $data['out_sample']);
		}
		
		$this->session->set_flashdata('notice', "Questão $question foi atualizada com sucesso.");
		redirect(base_url('/index.php/monitor/edit_problem/'.$problem_id), 'location');
	}
	
	function rem_answer($input_id = 0, $opt='')
	{
		$judge_input = $this->judge->get_input_basic_data($input_id);
		if (!$judge_input) {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		
		$problem_id = $judge_input['id_questao'];
		$input_num = 0;
		$inputs = $this->judge->get_inputs_for_problem($problem_id);
		$at = 0;
		foreach ($inputs as $input) {
			++$at;
			if ($input['id_correcao'] == $input_id) {
				$input_num = $at;
				break;
			}
		}
		
		$list_id = $this->problems->get_list_id_for_problem($problem_id);
		$data['list'] = $this->lists->get_list_data($list_id);
		$data['judge_input'] = $judge_input;
		$data['input_num'] = $input_num;
		$data['filename'] = $this->problems->get_problem_repr($problem_id);
		
		if (!$opt) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_rem_answer', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		$pwd = $this->input->post('pwd');
		if (!$pwd)
			$error = 'Você precisa especificar sua senha para remover.';
		else if (!$this->user->is_pwd_correct($this->logged, $pwd))
			$error = 'Senha incorreta.';
		
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error' => $error));
			$this->load->view('v_admin_rem_answer', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$this->judge->rem_input($input_id);
		$this->session->set_flashdata('notice', 'Entrada do corretor removida com sucesso.');
		redirect(base_url('/index.php/monitor/edit_problem/'.$problem_id), 'location');
	}
	
	function rem_problem($problem_id = 0, $opt = '')
	{
		$list_id = 0;
		if (!$problem_id || !($list_id = $this->problems->get_list_id_for_problem($problem_id))) {
			redirect(base_url('/index.php/monitor/lists'), 'location');
			return;		
		}
		
		$data['list'] = $this->lists->get_list_data($list_id);
		$data['filename'] = $this->problems->get_problem_repr($problem_id);
		$data['problem_id'] = $problem_id;
		if ($opt != 'confirm') {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_rem_problem', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		$pwd = $this->input->post('pwd');
		if (!$pwd)
			$error = 'Você precisa especificar sua senha para remover.';
		else if (!$this->user->is_pwd_correct($this->logged, $pwd))
			$error = 'Senha incorreta.';
		
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error' => $error));
			$this->load->view('v_admin_rem_problem', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$this->problems->rem_problem($problem_id);
		$this->session->set_flashdata('notice', "Questão ".$data['filename']." apagada com sucesso.");
		redirect(base_url('/index.php/monitor/lists'), 'location');
	}
	
	function clarifications()
	{
		$notice = $this->session->flashdata('notice');
		$data['requests'] = $this->clarifications->get_pending();
		
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
		$this->load->view('v_admin_clarifications', $data);
		$this->load->view('v_footer');
	}
	
	function answer_clarification($problem_id=0, $login_request='', $time_request=0, $handle='')
	{
		if (!$problem_id || !$login_request || !$time_request) {
			redirect(base_url('/index.php/monitor/clarifications'), 'location');
			return;
		}
		
		$data['problem_id'] = $problem_id;
		$data['login_request'] = $login_request;
		$data['time_request'] = $time_request;
		$data['request'] = $this->clarifications->get_data($problem_id, $login_request, $time_request);
		if (!$data['request']) {
			redirect(base_url('/index.php/monitor/clarifications'), 'location');
			return;		
		}
		if ($handle != '')
			$data['answer'] = $this->input->post('answer');
		
		if ($handle == '') {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_answer_clarification', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$user = $this->user->retrieve_info($login_request);
		$filename = $this->problems->get_problem_repr($problem_id);
		if ($handle == 'confirm') {
			$this->clarifications->update_data($problem_id, $login_request, $time_request, $data['answer'], 'respondido');
			$this->session->set_flashdata('notice', 'Clarification respondido com sucesso.');
			$this->emailsender->send_email_clarification_accepted($user['email'], $user['nome'], $filename);
		} else if ($handle == 'reject') {
			$this->clarifications->update_data($problem_id, $login_request, $time_request, $data['answer'], 'desconsiderado');
			$this->session->set_flashdata('notice', 'Clarification respondido com sucesso.');
			$this->emailsender->send_email_clarification_rejected($user['email'], $user['nome'], $filename, $data['answer']);
		}
		redirect(base_url('/index.php/monitor/clarifications'), 'location');
	}
	
	function download_input($material_id=0, $input_name=''){
		$this->download($material_id, $input_name, 'in');
	}
	
	function download_output($material_id=0, $input_name=''){
		$this->download($material_id, $input_name, 'out');
	}

	private function download($material_id=0, $file_name='', $extension=''){
		if (!$material_id) {
			redirect(base_url('/index.php'), 'location');
			return;
		}
		if (!$file_name) {
			$file_name = $material_id;
		}
		$column_name = '';
		if($extension == 'out') $column_name = 'saida';
		else $column_name = 'entrada';
		
		header('Content-type: application/text');
		header('Content-Disposition: attachment; filename="' .$file_name. '.' .$extension.'"');
		echo( $this->judge->get_file_for_inputs($material_id, $column_name) );
		
	}
	
	function reviews()
	{
		$notice = $this->session->flashdata('notice');
		$reviews = $this->reviews->get_pending_reviews();
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
		$this->load->view('v_admin_pending_reviews', array('reviews'=>$reviews));
		$this->load->view('v_footer');
	}
	
	function download_src($problem_id=0, $login='', $time=0)
	{
		$submit = $this->submissions->get($problem_id, $login, $time);
		if (!$submit) {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		
		$filename = $this->problems->get_problem_repr($problem_id);
		$ext = $this->datahandler->file_extension_for_language($submit['linguagem']);
		
		header('Content-type: application/text');
		header('Content-Disposition: attachment; filename="'.$filename.'.'.$ext.'"');
		echo $submit['codigo_fonte'];
	}
	
	function download_review($login_request='', $problem_id=0, $time_request=0, $judge='')
	{
		$request_content = '';
		if (!$problem_id || !$login_request || !$time_request
			|| !($request_content = $this->reviews->get_request($problem_id,$login_request,$time_request))) {
			redirect(base_url('/index.php/monitor/reviews'), 'location');
			return;
		}
		header('Content-type: application/text');
		header('Content-Disposition: attachment; filename="'.$this->problems->get_problem_repr($problem_id).'.revisao"');
		echo $request_content;
	}
	
	function review($login_request='', $problem_id=0, $time_request=0, $judge='')
	{
		$last_submission = array();
		if (!$problem_id || !$login_request || !$time_request
			|| !$this->reviews->has_request($problem_id,$login_request,$time_request)
			|| !($last_submission = $this->submissions->last_submission($problem_id, $login_request))) {
			redirect(base_url('/index.php/monitor/reviews'), 'location');
			return;
		}
		$data = array(
			'review_date' => $this->datahandler->translate_date_format(date("Y-m-d H:i:s", $time_request)),
			'problem_id' => $problem_id,
			'login' => $login_request,
			'review_time' => $time_request,
			'submit_time' => strtotime($last_submission['data_submissao'])
		);
		$lang = $last_submission['linguagem'];
		$data['submit_extension'] = $this->datahandler->file_extension_for_language($lang);
		
		
		$error = '';
		
		if ($judge == 'accept') {
			$src = $this->input->post('sourcecode');
			$rejudge = $this->input->post('rejudge');
			if (!$src) 
				$error = 'Você precisa colocar as alterações do código antes de confirmar o pedido.';
			else {
				$this->reviews->accept_request($problem_id, $login_request, $time_request);
				$this->submissions->create($problem_id, $login_request, $lang, $src);
				if ($rejudge) {
				/*	$dataForCorrector = array();
					$dataForCorrector['id_revisao'] = $this->reviews->get_review_id($problem_id, $login_request, $time_request);
					$dataForCorrector['estado'] = 'Revisao';
					$dataForCorrector['data_pedido'] = date("Y-m-d h:i:s", time());
					$this->judge->add_corrector_request($dataForCorrector);
					*/
					// FIXME: ask only one rejudge, by now the user is going to need to ask list rejudge
					// FIXME: rejudge the new submission as requested, or mark it
					// to be analised as soon as possible. For now, this is ignored.
				}
				$filename = $this->problems->get_problem_repr($problem_id);
				$user = $this->user->retrieve_info($login_request);
				$this->emailsender->send_email_review_accepted($user['email'], $user['nome'], $filename);
				
				$this->session->set_flashdata('notice', 'Pedido de revisão de '.$login_request.' foi aceito com sucesso.');
				redirect(base_url('/index.php/monitor/reviews'), 'location');
				return;
			}
			
		} else if ($judge == 'reject') {
			$reason = $this->input->post('reason');
			if ($reason) {		
				$this->reviews->reject_request($problem_id, $login_request, $time_request);

				$filename = $this->problems->get_problem_repr($problem_id);
				$user = $this->user->retrieve_info($login_request);
				$this->emailsender->send_email_review_rejected($user['email'], $user['nome'], $filename, $reason);
				
				$this->session->set_flashdata('notice', 'Pedido de revisão de '.$login_request.' foi recusado com sucesso.');
				redirect(base_url('/index.php/monitor/reviews'), 'location');
				return;
			}
			else
				$error = 'Preencha o motivo da recusa do pedido de revisão.';
		}
		
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
		$this->load->view('v_admin_review', $data);
		$this->load->view('v_footer');
		
	}
	
	public function list_submissions($problem_id = 0)
	{
		if (!$problem_id || !($list_id = $this->problems->get_list_id_for_problem($problem_id))) {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		
		$notice = $this->session->flashdata('notice');
		
		$this->load->view('v_header', array('logged' => $this->logged, 'is_admin' => $this->is_admin, 'notice' => $notice));
		$this->load->view('v_admin_list_submissions', array('problem_id' => $problem_id));
		$this->load->view('v_footer');
	}
	
	public function edit_submission($problem_id = 0, $login_submit = '', $time_submit = 0, $opt = '')
	{
		$submit = $this->submissions->get($problem_id, $login_submit, $time_submit);
		if (!$submit) {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		$data = array(
			'problem_id' => $problem_id,
			'login_submit' => $login_submit,
			'time_submit' => $time_submit,
			'date_submit' => $submit['data_submissao'],
			'lang_submit' => $submit['linguagem'],
			'banned_submit' => $submit['submissao_zerada'] ? 1 : 0,
			'compile_submit' => $submit['compilacao_erro']
		);
		
		if ($opt == 'edit') {
			$banned = $this->input->post("banned") ? 1 : 0;
			$this->submissions->flag_submission($problem_id, $login_submit, $time_submit, $banned);
			$this->session->set_flashdata('notice', 'Submissão de '.$login_submit.' foi editada com sucesso.');
			redirect(base_url('/index.php/monitor/list_submissions/'.$problem_id), 'location');
			return;
		}
		
		$this->load->view('v_header', array('logged' => $this->logged, 'is_admin' => $this->is_admin));
		$this->load->view('v_admin_edit_submission', $data);
		$this->load->view('v_footer');
	}
	
	
	public function corrector()
	{
		$correcoes = $this->judge->get_corrector_submissions();
		$listas = $this->lists->get_all_lists_idnames();
		$this->load->view('v_header', array('logged' => $this->logged, 'is_admin' => $this->is_admin,
		 					'correcoes' => $correcoes, 'listas' => $listas));
		$this->load->view('v_admin_corrector');
		$this->load->view('v_footer');
	}
	
	public function submit_correct_request()
	{
		$data = array();
		$data['id_lista'] = $this->input->post('corrigirLista');
		$data['estado'] = 'Correcao';
		$this->judge->add_corrector_request($data);
		redirect(base_url('/index.php/monitor/corrector'), 'location');
	}
	
	public function get_copycatch_report($id_corretor)
	{
		if(!$id_corretor) return;
		$arquivo = $this->judge->get_copy_report($id_corretor);
		if(!$arquivo->relatorio || !$arquivo->nome_lista){
			redirect(base_url('/index.php'), 'location');
			return;
		}
		header('Content-type: application/text');
		header('Content-Disposition: attachment; filename="relatorio_' . $arquivo->nome_lista . '.txt"');
		echo( $arquivo->relatorio );
	}
	
	public function semester_filing($error = '')
	{			
		$this->load->view('v_header', array('logged' => $this->logged, 'is_admin' => $this->is_admin, 'error' => $error));
		$this->load->view('v_admin_backup_system');
		$this->load->view('v_footer');
	}
	
	public function generate_backup()
	{
		$confirm_pwd = $this->input->post('confirm_pwd');
		$error = '';
		if (!$this->user->is_pwd_correct($this->logged,$confirm_pwd)){
			$error = 'Senha incorreta.';
			$this->semester_filing($error);
			return;
		}
		
		
		header('Content-type: application/text');
		header('Content-Disposition: attachment; filename="backup-monitoria' . date('Y-m-d h-i-s', time()) . '.sql"');
		echo( $this->backup->make_backup() );
	}
	
	public function notas_semestre()
	{
		$this->load->view('v_header', array('logged' => $this->logged, 'is_admin' => $this->is_admin));
		$this->load->view('v_admin_notas');
		$this->load->view('v_footer');
	}
	
	//FIXME Essa funcao esta duplicada na view v_admin_notas
	public function download_notas($file="notas")
	{
		ini_set('display_errors', 'Off');
		error_reporting(0);
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$file.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "<table><tr><td>Nome</td><td>Login</td>";
		$students = $this->user->retrieve_list_students_order();
		$lists = $this->lists->get_all_available_lists_asc();
		foreach($lists as $lista)
			echo "<td>".$lista['nome_lista']."</td>";


		echo "</tr></table>";
		foreach($students as $user)
		{
			echo "<table><tr><td>".$user['nome']."</td><td>".$user['login']."</td>";
			foreach($lists as $lista)
			{
				$score_final=0;
				$list_name = $lista['nome_lista'];
				$problems = $this->problems->get_problems_from_list($lista['id_lista']);
				foreach($problems as $problem)
				{
					$user_score = $this->score->score_user_problem($problem['id_questao'], $user['login']);
					$problem_weight = $this->score->sum_weights_problem($problem['id_questao']);
					$days_bonus = $this->submissions->get_days_bonus($lista['id_lista'], $problem['id_questao'], $user['login']);
					$days_bonus = max(0, $days_bonus);
					$days_bonus = min(5, $days_bonus);
					$bonus = $days_bonus*0.03;
					$score_pro = $problem_weight != 0 ? ($user_score/$problem_weight)/10*($bonus + 1) : 0;
					$score_final += $score_pro;
				}
				if(sizeof($problems) == 0) $score_final = 0;
				else $score_final = $score_final/sizeof($problems);
				
				echo "<td>".sprintf("%.2f", $score_final/10)."</td>";


    			}
    			echo "</tr></table>";
    		}



	}
}
