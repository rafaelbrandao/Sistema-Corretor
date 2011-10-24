<?php

class Problems extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function get_problems_from_list($list_id=0)
    {
    	if (!$list_id) return array();
    	$query = $this->db->query("SELECT id_questao, numero FROM Questao WHERE id_lista='$list_id' ORDER BY numero");
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
    	$data['nome'] = $title ? $title : NULL;
    	$data['enunciado'] = $specs ? $specs : NULL;
    	$data['descricao_entrada'] = $in_format ? $in_format : NULL;
    	$data['descricao_saida'] = $out_format ? $out_format : NULL;
    	$this->db->where('id_questao', $id);
    	$this->db->update('Questao', $data);
    	return TRUE;
    }
    
    function update_problem_samples($id=0, $in_sample='', $out_sample='') {
    	if (!$id) return FALSE;
    	$data['entrada_exemplo'] = $in_sample ? $in_sample : NULL;
    	$data['saida_exemplo'] = $out_sample ? $out_sample : NULL;
    	$this->db->where('id_questao', $id);
    	$this->db->update('Questao', $data);
    	return TRUE;
    }
    
}
