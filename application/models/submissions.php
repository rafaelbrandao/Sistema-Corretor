<?php

class Submissions extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function create($problem_id=0, $login='', $language='', $src='', $compile='')
    {
    	if (!$problem_id || !$login || !$language || !$src)
    		return FALSE;
    	$data = array(
    		'data_submissao' => date("Y-m-d H:i:s"),
    		'id_questao' => $problem_id,
    		'login' => $login,
    		'codigo_fonte' => $src,
    		'linguagem' => $language,
    		'compilacao_erro' => $compile,
    		'submissao_zerada' => 0
    		);
    	$this->db->insert('Submissao', $data);
    	return TRUE;
    }
    
    function last_submission($problem_id=0, $login='')
    {
    	$query = $this->db->query("SELECT * FROM Submissao WHERE login='$login' AND id_questao='$problem_id' ORDER BY data_submissao DESC LIMIT 1");
    	return $query->num_rows() > 0 ? $query->row_array() : array();
    }
    
    function last_submission_basic_data($problem_id=0, $login='')
    {
    	$query = $this->db->query("SELECT data_submissao, linguagem FROM Submissao WHERE login='$login' AND id_questao='$problem_id' ORDER BY data_submissao DESC LIMIT 1");
    	return $query->num_rows() > 0 ? $query->row_array() : array();
    }
    
    function get($problem_id = 0, $login = '', $time = 0)
    {
    	if (!$problem_id || !$login || !$time)
    		return array();
    	
    	$where = array(
    		'login' => $login,
    		'id_questao' => $problem_id,
    		'data_submissao' => date("Y-m-d H:i:s", $time)
    	);
    	$this->db->where($where);
    	$query = $this->db->get('Submissao');
    	return $query->num_rows() > 0 ? $query->row_array() : array();
    }
    
    function logins_for_problem($problem_id=0)
    {
    	if (!$problem_id)
    		return array();
    	$query = $this->db->query("SELECT login FROM Submissao WHERE id_questao='$problem_id' GROUP BY login");
    	$query_result = $query->result_array();
    	$ret = array();
    	foreach ($query_result as $row)
    		$ret[] = $row['login'];
    	return $ret;
    }
    
    function flag_submission($problem_id = 0, $login = '', $time = 0, $flag = 0)
    {
    	if (!$problem_id || !$login || !$time)
    		return array();
    	
    	$where = array(
    		'login' => $login,
    		'id_questao' => $problem_id,
    		'data_submissao' => date("Y-m-d H:i:s", $time)
    	);
    	
    	$data = array(
    		'submissao_zerada' => $flag
    	);
    	
    	$this->db->where($where);
    	$this->db->update('Submissao', $data);
    }
    

    
}
