<?php

class Score extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->library('datahandler');
    }
    
    function sum_weights_problem($problem=0)
    {
    	$query = $this->db->query("SELECT SUM(peso_correcao) AS soma FROM Material_Correcao as correcao WHERE id_Questao = '$problem'");
    	return $query->num_rows() > 0 ? $query->row()->soma : -1;
    }
    
    function partial_score_for_problem($problem=0, $user="")
    {
    	$query = $this->db->query("SELECT
    		SUM(nota.valor_nota * mat.peso_correcao) AS somaNotas,
    		SUM(mat.peso_correcao) AS somaPesos
    		FROM Nota_Lista as nota, Material_Correcao as mat
    		WHERE nota.id_questao = '$problem'
    		AND mat.id_Questao = nota.id_questao
    		AND nota.id_Correcao = mat.id_Correcao
    		AND nota.login = '$user'");
    	
    	if (!$query->num_rows())
    		return -1;
    		
    	if (!$query->row()->somaPesos)
    		return 0.0;
    	
    	return ($query->row()->somaNotas / $query->row()->somaPesos) / 10.0;
    }
    
    function get_bonus_modifier($problem, $user, $list_id)
    {
    	if (!$problem || !$user || !$list_id)
    		return 1.0;

		$ci =& get_instance();
    	$ci->load->model('submissions','', TRUE);
    	$days = $ci->submissions->get_days_bonus($problem, $user, $list_id);
		$days = max(0, min($days, 5));
		return 1.0 + ($days * 0.03);
    }
    
    function final_score_for_problem($problem = 0, $user = "", $list_id = -1)
    {
    	$score = $this->partial_score_for_problem($problem, $user);
    	if ($score == -1)
    		return -1;
    	
    	$ci =& get_instance();
    	$ci->load->model('submissions','', TRUE);
    	if ($list_id == -1) {
    		$ci->load->model('problems','', TRUE);
    		$list_id = $ci->problems->get_list_id_for_problem($problem);
    	}
    	$bonus_rate = $this->get_bonus_modifier($problem, $user, $list_id);
		return min($score * $bonus_rate, 100.0);
    }
    
    function final_scores_for_lists($lists = array(), $students = array())
    {
    
    	$ci =& get_instance();
    	$ci->load->model('problems','', TRUE);
    	
    	if (!$lists) {
    		$ci->load->model('lists','', TRUE);
    		$lists = $this->lists->get_all_available_lists_asc();
    	}
    	
    	if (!$students) {
    		$ci->load->model('user','', TRUE);
    		$students = $this->user->retrieve_list_students_order();
    	}
    	
    	foreach ($lists as &$list) {
    		$list['problems'] = $this->problems->get_problems_from_list($list['id_lista']);
    		$list['num_problems'] = sizeof($list['problems']);
    	}
    	
    	foreach ($students as &$user) {
    		$user['final_results'] = array();
    		foreach ($lists as &$list) {
    			$sum_scores = 0.0;
    			$filled_list = $list['problems'];
    			foreach($filled_list as $problem)
    				$sum_scores += $this->final_score_for_problem($problem['id_questao'], $user['login'], $list['id_lista']);

    			$user['final_results'][ $list['id_lista'] ] = $list['num_problems'] == 0 ? 0.0 : ($sum_scores / $list['num_problems']);
    		}
    	}
    	
    	return $students;
    }
    
    function get_css_type($value)
    {
    	$ret = 'nota';
    	if($value < 50)
    		$ret .= ' bad';
    	
    	elseif($value < 70)
    		$ret .= ' avg';
    	elseif($value < 100)
    		$ret .= ' good';
    	elseif($value == 100)
    		$ret .= ' acc';
    		
    	return $ret;
    	
    	
    }
    
    function get_peso_tempo($problem=0)
    {
    	$query = $this->db->query("SELECT id_Correcao as id, peso_correcao as peso, max_tempo_execucao as tempo FROM Material_Correcao WHERE id_Questao = '$problem' ORDER BY id_correcao");
    	return $query->result_array();
    	
    }
    
    function get_nota_user($problem=0, $user="", $id)
    {
    	$ci =& get_instance();
    	$ci->load->model('submissions','', TRUE);
    	
    	$query = $this->db->query("SELECT valor_nota as nota FROM Nota_Lista WHERE id_questao = '$problem' AND login = '$user' AND id_correcao = '$id' ORDER BY id_correcao");
    	$result = $query->result_array();
    	if ($ci->submissions->is_last_submission_invalid($problem, $user))
    		$result['nota'] = -1;
    	
    	return $result;
    }
}

