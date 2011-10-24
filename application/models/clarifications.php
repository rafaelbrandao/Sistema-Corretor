<?php

class Clarifications extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function get_confirmed_for_problem($problem_id=0) {
    	if (!$problem_id)
    		return array();
    	$query = $this->db->query("SELECT data_pedido, login_usuario, descricao_pedido, resposta FROM Pedido_Clarification WHERE estado_pedido='respondido' ORDER BY data_pedido");
    	return $query->result_array();
    }
    
    function get_pending_for_problem($problem_id=0) {
    	if (!$problem_id)
    		return array();
    	$query = $this->db->query("SELECT data_pedido, login_usuario, descricao_pedido FROM Pedido_Clarification WHERE estado_pedido='pendente' AND id_questao='$problem_id'");
    	return $query->result_array();
    }
    
    function get_pending() {
    	$query = $this->db->query("SELECT data_pedido, login_usuario, descricao_pedido, id_questao FROM Pedido_Clarification WHERE estado_pedido='pendente' ORDER BY data_pedido");
    	return $query->result_array();
    }
    
    function get_data($problem_id=0, $login='', $time=0)
    {
    	if (!$problem_id || !$login || !$time)
    		return array();
    	$time_request = date("Y-m-d H:i:s", $time);
    	$query = $this->db->query("SELECT descricao_pedido, estado_pedido, data_pedido, id_questao, login_usuario FROM Pedido_Clarification WHERE data_pedido='$time_request' AND id_questao='$problem_id' AND login_usuario='$login'");
    	return $query->row_array();
    }
    
    function update_data($problem_id=0, $login='', $time=0, $answer='', $state='')
    {
    	if (!$problem_id || !$login || !$time || !$state)
    		return FALSE;
    	
    	$where = array(
    		'login_usuario' => $login,
    		'id_questao' => $problem_id,
    		'data_pedido' => date("Y-m-d H:i:s", $time)
    		);
    	
    	$data = array(
    		'estado_pedido' => $state,
    		'resposta' => $answer
    		);
    	
    	$this->db->where($where);
    	$this->db->update('Pedido_Clarification', $data);
    	return TRUE;
    }
    
    function create($problem_id=0, $login='', $question='') {
    	if (!$problem_id || !$login)
    		return FALSE;
    	$data = array(
    		'data_pedido' => date("Y-m-d H:i:s"),
    		'login_usuario' => $login,
    		'id_questao' => $problem_id,
    		'descricao_pedido' => $question,
    		'estado_pedido' => 'pendente'
    		);
    	$this->db->insert('Pedido_Clarification', $data);
    	return TRUE;
    }
    
    function answer($problem_id=0, $login='', $time='', $answer='', $state='') {
    	if (!$problem_id || !$login || !$time || !$answer || !$state)
    		return FALSE;

    	$data = array(
    		'resposta' => $answer,
    		'estado_pedido' => $state
    		);
    		
    	$where = array(
    		'data_pedido' => $time,
    		'login_usuario' => $login,
    		'id_questao' => $problem_id
    	);
    	
    	$this->db->where($where);
    	$this->db->update('Pedido_Clarification', $data);
    }
    
    
}
