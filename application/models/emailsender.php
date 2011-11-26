<?php

class EmailSender extends CI_Model {

	function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
    }
	
	public function send_email_register_requested($to = '', $nome=''){
		$subject='Solicitação de Cadastro';
 		$message='Olá '. $nome . ',<br/>O seu pedido de cadastro no site '.base_url('/').' foi '.
 			'recebido com êxito, e em breve será analisado por um dos monitores.<br/>Quando o cadastro ' .
			'for confirmado, você irá receber um email informando que o seu login já está liberado.<br/>' .
			'Para mais informações, visite '.base_url('/').' ou entre em contato com um dos monitores.';
		$this->send_email($to, $nome, $subject, $message);
	}
	
	public function send_email_register_accepted($to = '', $nome='', $login=''){
		$subject='Cadastro feito com Sucesso';
 		$message= 'Olá '. $nome.',<br/>O seu cadastro no site '.base_url('/').' foi confirmado.<br/>' .
			'<br/>Para submeter questões das listas, será necessário logar-se com seu login ('. $login .') através da página '.
			base_url('/').'.<br/>Mantenha este email para referências futuras caso venha a esquecer sua senha.';
		$this->send_email($to, $nome, $subject, $message);
	}
	
	public function send_email_register_rejected($to = '', $nome='', $login=''){
		$subject='Cadastro recusado';
 		$message= 'Olá '. $nome.',<br/>O seu cadastro no site '.base_url('/').' foi recusado.<br/>' .
			'<br/>Se estiver em dúvida sobre o que possa ter acontecido, entre em contato com a monitoria.<br/><br/>'.
			'Se você não solicitou este cadastro, então por favor desconsidere esta mensagem.';
		$this->send_email($to, $nome, $subject, $message);
	}
	
	public function send_email_clarification_accepted($to = '', $name = '', $filename = '') {
		$subject = 'Clarification aceito para questão '.$filename;
		$message = 'Olá '. $name . ',<br/> Seu pedido de clarification foi analisado e confirmado.<br/>' .
			'Confira na página os clarifications confirmados dessa questão e fique a vontade para fazer um novo pedido, caso necessário.';
		$this->send_email($to, $name, $subject, $message);
	}
	
	public function send_email_clarification_rejected($to = '', $name = '', $filename = '', $reason = '') {
		$subject = 'Clarification rejeitado para questão '.$filename;
		$message = 'Olá '. $name . ',<br/> Seu pedido de clarification foi analisado e rejeitado.<br/>' .
			($reason ? 'A justificativa para a recusa deste pedido foi: "'. $reason .'"<br/>' : '') .
			'Confira na página os clarifications confirmados dessa questão e fique a vontade para fazer um novo pedido, caso necessário.';
		$this->send_email($to, $name, $subject, $message);
	}
	
	public function send_email_review_accepted($to = '', $name = '', $filename = '') {
		$subject = 'Revisão aceita para questão '.$filename;
		$message = 'Olá '. $name . ',<br/> Seu pedido de revisão foi analisado e confirmado.<br/>' .
			'Confira depois na página de notas o resultado após sua revisão ter sido aplicada.';
		$this->send_email($to, $name, $subject, $message);
	}
	
	public function send_email_review_rejected($to = '', $name = '', $filename = '', $reason = '') {
		$subject = 'Revisão rejeitada para questão '.$filename;
		$message = 'Olá '. $name . ',<br/> Seu pedido de revisão foi analisado e rejeitado.<br/>' .
			($reason ? 'A justificativa para a recusa deste pedido foi: "'. $reason .'"<br/>' : '') .
			'Confira depois na página de notas o resultado após sua revisão ter sido aplicada.';
		$this->send_email($to, $name, $subject, $message);
	}
	
	private function send_email($to = '', $nome='', $subject='', $message=''){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'To: '. $nome .' <'. $to .'>' . "\r\n";
		$headers .= 'From: Monitoria Algoritmos if672 <if672@googlegroups.com>' . "\r\n";

		mail($to, $subject, $message, $headers);
	}
}

