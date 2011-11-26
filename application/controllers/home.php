<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	var $logged = '';
	var $is_admin = FALSE;

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->library(array('datahandler','session','input'));
		$this->load->model('user','', TRUE);
		$this->load->model('lists','', TRUE);
		$this->load->model('problems','', TRUE);
		$this->load->model('judge','', TRUE);
		$this->load->model('clarifications','', TRUE);
		$this->load->model('submissions','', TRUE);
		$this->load->model('reviews','', TRUE);
		$this->load->model('score', '', TRUE);
		$this->load->model('emailsender', '', TRUE);
		
		$this->load->model('compilador', '', TRUE);
		
		$this->logged = $this->session->userdata('logged');
		if ($this->logged) 
			$this->is_admin = $this->user->is_user_admin($this->logged);
	}
	
	function logout() {
		$this->session->sess_destroy();
		redirect(base_url('/'), 'location');
	}
	
	function teste() {
		$this->session->set_userdata('logged', 'admin');
	}

	function index()
	{
		$notice = $this->session->flashdata('notice');
		$this->load->view('v_header', array('tab'=>'home', 'logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
		$this->load->view('v_index');
		$this->load->view('v_footer');
	}
	
	function login() {
		if ($this->logged) {
			redirect(base_url('/'), 'location');
			return;
		}
		
		$login = $this->input->post('login');
		$pwd = $this->input->post('pwd');
		
		if (!$login && !$pwd) {
			$this->load->view('v_header');
			$this->load->view('v_login');
			$this->load->view('v_footer');
			return;
		}
		
		$error='';
		if (!$login) $error='Você precisa especificar seu login no sistema.';
		else if (!$pwd) $error='Você precisa especificar sua senha no sistema.';
		else if (!$this->user->is_user_registered($login)) $error='Login especificado não está cadastrado no sistema.';
		else if (!$this->user->is_user_confirmed($login)) $error='Login especificado ainda está aguardando confirmação de cadastro.';
		else if (!$this->user->is_pwd_correct($login,$pwd)) $error='Login e/ou senha incorretos.';
		
		if ($error) {
			$this->load->view('v_header',array('error'=>$error));
			$this->load->view('v_login',array('login'=>$login));
			$this->load->view('v_footer');
			return;
		}
		
		$this->session->set_userdata('logged', $login);
		redirect(base_url('/'), 'location');
		
	}
	
	function register() {
		if ($this->logged) {
			redirect(base_url('/'), 'location');
			return;
		}
		
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);
		
		$nome = $this->input->post('nome');
		$login = $this->input->post('login');
		$pwd = $this->input->post('pwd');
		
		if (!$nome && !$login && !$pwd) {
			$this->load->view('v_header');
			$this->load->view('v_register');
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		
		if (!$nome) $error = 'Você precisa especificar seu nome completo no sistema.';
		else if (!$login) $error = 'Você precisa especificar seu login no sistema.';
		else if (!$pwd) $error = 'Você precisa especificar sua senha no sistema.';
		else if (count(explode(" ",$nome)) < 2) $error = 'Você precisa especificar seu nome completo no sistema.';
		else if ($this->user->is_user_registered($login)) $error = 'Login especificado já está cadastrado. Por favor, use seu login do CIn.';
		else if (!$this->user->add_user($login,$pwd,$nome,"$login@cin.ufpe.br")) $error = 'Erro desconhecido. Por favor, comunique aos monitores.';
		
		if ($error) {
			$this->load->view('v_header',array('error'=>$error));
			$this->load->view('v_register', array('login'=>$login, 'nome'=>$nome));
			$this->load->view('v_footer');
			return;			
		}
		
		$this->session->set_flashdata('notice','Cadastro solicitado com sucesso. Seu pedido será analisado pelos monitores. Por favor, aguarde confirmação por email.');
		$this->emailsender->send_email_request_received($login.'@cin.ufpe.br', $nome);

		redirect(base_url('/'), 'location');
	}

	function lists()
	{
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_lists');
		$this->load->view('v_footer');
	}	

	function problem($problem_id=0) {
		$list_id = $this->problems->get_list_id_for_problem($problem_id);
		if (!$list_id)  {
			redirect(base_url('/'), 'location');
			return;
		}
		$list = $this->lists->get_list_data($list_id);
		if ($list['estado_lista'] == 'preparacao') {
			redirect(base_url('/'), 'location');
			return;			
		}
		$problem = $this->problems->get_data_for_problem($problem_id);
		$error = $this->session->flashdata('error');
		
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
		$this->load->view('v_problem', array('list'=>$list, 'problem'=>$problem, 'problem_id'=>$problem_id, 'list_id'=>$list_id));
		$this->load->view('v_footer');
	}
	
	function perfil() {
		if ($this->is_admin) {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		
		if (!$this->logged) {
			redirect(base_url('/'), 'location');
			return;			
		}
		
		$user = $this->user->retrieve_info($this->logged);
		
		$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_profile', array('login'=>$this->logged, 'nome'=>$user['nome'], 'email'=>$user['email']));
		$this->load->view('v_footer');
	}
	
	function clarifications($problem_id=0, $task='') {
		$list_id = $this->problems->get_list_id_for_problem($problem_id);
		if (!$list_id)  {
			redirect(base_url('/'), 'location');
			return;
		}
		$list = $this->lists->get_list_data($list_id);
		if ($list['estado_lista'] == 'preparacao') {
			redirect(base_url('/'), 'location');
			return;			
		}
		$running = $this->datahandler->is_now_between_time($list['data_lancamento'], $list['data_finalizacao']);
		$problem = $this->problems->get_data_for_problem($problem_id);
		
		$confirmed = $this->clarifications->get_confirmed_for_problem($problem_id);
		$ask = $this->input->post('ask');
		$notice = $this->session->flashdata('notice');
		
		if (!$task || !$ask || !$this->logged || !$running) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
			$this->load->view('v_clarifications', array('logged'=>$this->logged, 'confirmed'=>$confirmed, 'problem'=>$problem, 'list'=>$list, 'problem_id'=>$problem_id, 'running' => $running) );
			$this->load->view('v_footer');
			return;
		}
		
		$this->clarifications->create($problem_id, $this->logged, $ask);
		$this->session->set_flashdata('notice', "Pedido de clarification enviado com sucesso.");
		redirect(base_url('/index.php/home/clarifications/'.$problem_id), 'location');
		return;		
	}
	
	function list_clarifications($list_id=0) {
		$list = $this->lists->get_list_data($list_id);
		if (!$list || $list['estado_lista'] == 'preparacao')  {
			redirect(base_url('/'), 'location');
			return;
		}
		$problems = $this->problems->get_problems_from_list($list_id);
		$notice = $this->session->flashdata('notice');
		$confirmed = array();
		$problem_num = 0;
		$ask_problem = $this->input->post('question');
		if ($ask_problem)
			$ask_problem = intval($ask_problem);
			
		foreach ($problems as $problem) {
			$num = $problem['numero'];
			$id = $problem['id_questao'];
			$confirmed[$num] = $this->clarifications->get_confirmed_for_problem($id);
			if ($id == $ask_problem)
				$problem_num = $num;
		}
		
		$ask = $this->input->post('ask');
		$running = $this->datahandler->is_now_between_time($list['data_lancamento'], $list['data_finalizacao']);
		
		if (!$ask_problem || ($ask_problem && !$ask) || !$problem_num || !$running) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
			$this->load->view('v_list_clarifications', array('logged'=>$this->logged, 'confirmed'=>$confirmed, 'list'=>$list, 'problems'=>$problems, 'running' => $running) );
			$this->load->view('v_footer');
			return;
		}
		
		$this->clarifications->create($ask_problem, $this->logged, $ask);
		$this->session->set_flashdata('notice', "Pedido de clarification enviado com sucesso.");
		redirect(base_url('/index.php/home/list_clarifications/'.$list_id), 'location');
		return;		
	}
	
	function submit($problem_id=0)
	{
		if (!$problem_id || !$this->logged) {
			redirect(base_url('/'), 'location');
			return;
		}
		$data['logged'] = $this->logged;
		$data['problem_id'] = $problem_id;
		$data['src'] = $this->input->post('src');
		$data['lang'] = $this->input->post('lang');
		$confirm_pwd = $this->input->post('pwd');
		$notice = $this->session->flashdata('notice');
		
		if (!$data['src'] || !$data['lang']) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
			$this->load->view('v_submit', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		if (!$this->user->is_pwd_correct($this->logged,$confirm_pwd))
			$error = 'Senha incorreta.';
		
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_submit', $data);
			$this->load->view('v_footer');
			return;
		}
	//	ini_set('display_errors', 'On');
	//	error_reporting(E_ALL);
		$this->submissions->create($problem_id, $this->logged, $data['lang'], $data['src'], '');
		$formato = $this->input->post('formatoQuestao');
	//	$resultadoCompilacao = $this->compilador->compilarCodigo($data['src'], $data['lang'], $formato);
		$resultadoCompilacao = 0;
		if( $resultadoCompilacao != 0){
			$error = 'Submissão realizada com erro compilação.';
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_submit', $data);
			$this->load->view('v_footer');
			return;
		} else {
			$this->session->set_flashdata('notice', "Submissão realizada com sucesso.");
		}
		redirect(base_url('/index.php/home/submit/'.$problem_id), 'location');
	}
	
	
	
	function review($problem_id=0)
	{
		if (!$problem_id || !$this->logged) {
			redirect(base_url('/'), 'location');
			return;
		}
		
		$data['last'] = $this->submissions->last_submission($problem_id, $this->logged);
		if (!$data['last']) {
			$this->session->set_flashdata('error','Você não pode pedir revisão porque não efetuou submissão para essa questão.');
			redirect(base_url('/index.php/home/problem/'.$problem_id), 'location');
			return;
		}
		
		$notice = $this->session->flashdata('notice');
		$data['request'] = $this->input->post('request');
		$data['problem_id'] = $problem_id;
		$data['logged'] = $this->logged;
		$confirm_pwd = $this->input->post('confirm_pwd');
		
		if (!$data['request'] && !$confirm_pwd) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
			$this->load->view('v_review', $data);
			$this->load->view('v_footer');
			return;			
		}
		
		$error = '';
		if (!$this->user->is_pwd_correct($this->logged, $confirm_pwd))
			$error = 'Senha incorreta.';
		else if (!$data['request'])
			$error = 'Pedido não especificado. Verifique o formato e mande uma nova solicitação com o seu pedido preenchido.';
		else if ($this->reviews->request_state($problem_id, $this->logged) != NULL)
			$error = 'Você já solicitou um pedido de revisão para essa questão. Não é possível submeter um novo pedido.';
		
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_review', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$this->reviews->create_request($problem_id, $this->logged, $data['request']);
		$this->session->set_flashdata('notice', "Pedido de revisão realizado com sucesso.");
		redirect(base_url('/index.php/home/review/'.$problem_id), 'location');
	}
	
	public function download_input($problem_id){
		$this->download_example($problem_id, 'in', 'entrada_exemplo');
	}
	
	public function download_output($problem_id){
		$this->download_example($problem_id, 'out', 'saida_exemplo');
	}
	
	private function download_example($problem_id, $extension, $column_name){
		if(!$problem_id) {
			redirect(base_url('/index.php'), 'location');
			return;
		}
		$infos = $this->problems->get_problem_sample($problem_id, $column_name);
		if (!$infos) {
			redirect(base_url('/index.php'), 'location');
			return;
		}
		$file_name = $infos[0]["nome_lista"]."Q".$infos[0]["questao_numero"];
		header('Content-type: application/text');
		header('Content-Disposition: attachment; filename="' .$file_name. '.' .$extension.'"');
		echo($infos[0][$column_name]);
	}
	
	function download_inputs($material_id=0, $input_name=''){
		$this->download($material_id, $input_name, 'in');
	}
	
	function download_outputs($material_id=0, $input_name=''){
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
	
	public function cadastro() {
		$this->load->view('view_cadastro');
	}

	public function listas() {
		$this->load->view('view_listas');	
	}
	
	public function questao() {
		$this->load->view('view_questao');	
	}
	
	public function questao_clarifications() {
		$this->load->view('view_questao_clarifications');
	}
	
	public function _clarifications() {
		$this->load->view('view_clarifications');
	}
	
	public function submissao() {
		$this->load->view('view_submissao');
	}
	
	public function notas_lista() {
		$this->load->view('view_notas_lista');
	}
	
	public function notas_questao() {
		$this->load->view('view_notas_questao');
	}
	
	public function questao_revisao() {
		$this->load->view('view_questao_revisao');
	}
	
	public function pedir_revisao() {
		$this->load->view('view_pedir_revisao');
	}
	
	public function score($list_id = 0)
	{
		$list = $this->lists->get_list_data($list_id);
		if(!$this->is_admin){
			if (!$list || ($list['estado_lista'] != 'revisao' && $list['estado_lista'] != 'finalizada')) {
				redirect(base_url('/index.php/home/lists'), 'location');
				return;
			}
		}
		
		$data['list'] = $list;
		$data['problems'] = $this->problems->get_problems_from_list($list_id);
		$data['students'] = $this->user->retrieve_list_students_order();
		$data['list_id'] = $list_id;
		
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_score_list', $data);
		$this->load->view('v_footer');
	}
	
	public function score_detail()
	{
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_score_detail');
		$this->load->view('v_footer');
	}
	
	
 	public function pages($pagina='' ){

//		if( !file_exists(base_url('/pages/'.$pagina))){
//			redirect(base_url('/index.php'), 'location');
//			return;
//		}
		
		$saida = file_get_contents(base_url('/pages/'.$pagina));
		
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));	
		echo('<div id="content">');
		echo($saida);
		echo('</div>');
		$this->load->view('v_footer');
	}
	
}
