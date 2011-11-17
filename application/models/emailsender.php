<?php

class EmailSender extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }


	
	public function send_email_request_received($to = '', $nome=''){
		$subject='Solicitação de Cadastro';
 		$message='Olá '. $nome . ',<br/>O seu pedido de cadastro no site da disciplina de algoritmos foi '.
 			'recebido com êxito, e em breve será analisado por um dos monitores.<br/>Quando o cadastro ' .
			'for confirmado, você irá receber um email informando que o seu login já está liberado.<br/>' .
			'Para mais informações, visite www.cin.ufpe.br/~if672cc ou entre em contato com um dos monitores.';
		$this->send_email($to, $nome, $subject, $message);
	}
	
	public function send_email_request_accepted($to = '', $nome='', $login=''){
		$subject='Cadastro feito com Sucesso';
 		$message= 'Olá '. $nome.',<br/>O seu cadastro no site da disciplina de algoritmos foi confirmado.<br/>' .
			'<br/>Para submeter questões das listas, será necessário logar-se com seu login ('. $login .') através da página '.
			'www.cin.ufpe.br/~if672cc/.<br/>Mantenha este email para referências futuras caso venha a esquecer sua senha.';
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
	
	private function send_email($to = '', $nome='', $subject='', $message=''){
		// multiple recipients
		//$to  = 'aca3@cin.ufpe.br' . ', '; // note the comma
		//$to .= 'alfl@cin.ufpe.br';

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		//$headers .= 'To: Arthur Alem <aca3@cin.ufpe.br>, Adriana Liborio <alfl@cin.ufpe.br>' . "\r\n";
		$headers .= 'To: '. $nome .' <'. $to .'>' . "\r\n";
		$headers .= 'From: Monitoria Algoritmos if672 <if672@googlegroups.com>' . "\r\n";

		// Mail it
		mail($to, $subject, $message, $headers);
	}
}

