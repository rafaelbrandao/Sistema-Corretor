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
    
    function score_user_problem($problem=0, $user="")
    {
    	$query = $this->db->query("SELECT SUM(nota.valor_nota*mat.peso_correcao) AS soma FROM Nota_Lista as nota, Material_Correcao as mat WHERE nota.id_questao = '$problem' AND mat.id_Questao = nota.id_questao AND nota.id_Correcao = mat.id_Correcao AND nota.login = '$user'");
    	return $query->num_rows() > 0 ? $query->row()->soma : -1;
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
}

