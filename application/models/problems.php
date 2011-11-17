<?php

class Problems extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function get_problems_from_list($list_id=0)
    {
    	if (!$list_id) return array();
    	$query = $this->db->query("SELECT id_questao, numero, nome FROM Questao WHERE id_lista='$list_id' ORDER BY numero");
    	return $query->result_array();
    }
    
    function get_problems_name_from_list($list_id=0)
    {
    	if (!$list_id) return array();
    	$query = $this->db->query("SELECT id_questao, numero, nome FROM Questao WHERE id_lista='$list_id' ORDER BY numero");
    	return $query->result_array();
    }
    
    function has_problem_num($list_id=0, $num=0)
    {
    	if (!$list_id || !$num) return TRUE;
    	$query = $this->db->query("SELECT id_questao FROM Questao WHERE id_lista='$list_id' and numero='$num'");
    	return $query->num_rows() > 0;
    }
    
    function get_list_id_for_problem($id=0)
    {
    	if (!$id) return 0;
    	$query = $this->db->query("SELECT id_lista FROM Questao WHERE id_questao='$id'");
    	return $query->num_rows() > 0 ? $query->row()->id_lista : 0;
    }
    
    function get_data_for_problem($id=0)
    {
    	if (!$id) return array();
    	$query = $this->db->query("SELECT enunciado, entrada_exemplo, saida_exemplo, descricao_saida, descricao_entrada, nome, numero FROM Questao WHERE id_questao='$id'");
    	return $query->num_rows() > 0 ? $query->row_array() : array();
    }
    
    function get_num_for_problem($id=0)
    {
    	if (!$id) return 0;
    	$query = $this->db->query("SELECT numero FROM Questao WHERE id_questao='$id'");
    	return $query->num_rows() > 0 ? $query->row()->numero : 0;
    }
    
    function create_problem_num($list_id=0, $num=0)
    {
    	if (!$list_id || !$num) return FALSE;
    	$data['id_lista'] = $list_id;
    	$data['numero'] = $num;
    	$this->db->insert('Questao', $data);
    	return TRUE;
    }
    
    function update_problem_specs($id=0, $title='', $specs='', $in_format='', $out_format='') {
    	if (!$id) return FALSE;
    	$data['nome'] = $title != '' ? $title : NULL;
    	$data['enunciado'] = $specs != '' ? $specs : NULL;
    	$data['descricao_entrada'] = $in_format != '' ? $in_format : NULL;
    	$data['descricao_saida'] = $out_format != '' ? $out_format : NULL;
    	$this->db->where('id_questao', $id);
    	$this->db->update('Questao', $data);
    	return TRUE;
    }
    
    function update_problem_samples($id=0, $in_sample='', $out_sample='') {
    	if (!$id) return FALSE;
    	$data['entrada_exemplo'] = $in_sample != '' ? $in_sample : NULL;
    	$data['saida_exemplo'] = $out_sample != '' ? $out_sample : NULL;
    	$this->db->where('id_questao', $id);
    	$this->db->update('Questao', $data);
    	return TRUE;
    }

	function get_problem_sample($id_problem=0, $column_name=''){
		if(!$id_problem || !$column_name) return array();
		$query = $this->db->query("SELECT q.".$column_name." as ".$column_name.", l.nome_lista as nome_lista, q.numero as questao_numero FROM Questao q, Lista_Exercicios l WHERE q.id_questao='$id_problem' AND q.id_lista = l.id_lista");
		return $query->result_array();
	}
	
	function get_problem_repr($id_problem=0)
	{
		if (!$id_problem)
			return "";
		$query = $this->db->query("SELECT l.nome_lista as nome_lista, q.numero as numero FROM Questao q, Lista_Exercicios l WHERE q.id_questao='$id_problem' AND q.id_lista = l.id_lista");
		if ($query->num_rows() == 0)
			return "";
		$row = $query->row_array();
		return $query->row()->nome_lista . 'Q' . $query->row()->numero;
	}
	
    function rem_problem($problem_id = 0)
    {
    	if (!$problem_id)
    		return;
    	$this->db->delete('Questao', array('id_questao' => $problem_id));
    }
    
}
