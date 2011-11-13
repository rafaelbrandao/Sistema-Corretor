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
    	return $query->num_rows() > 0 ? $query->row()->soma : "erro";
    }
    
    function score_user_problem($problem=0, $user="")
    {
    	$query = $this->db->query("SELECT SUM(valor_nota) AS soma FROM Nota_Lista WHERE id_questao = '$problem' AND login = '$user' ");
    	return $query->num_rows() > 0 ? $query->row()->soma : "Não Entregou";
    }
    
    function get_css_type($value)
    {
    	$ret = 'nota';
    	if($value < 50)
    	{
    		$ret .= ' bad';
    	}
    	elseif($value < 70)
    	{
    		$ret .= ' avg';
    	}
    	elseif($value < 100)
    	{
    		$ret .= ' good';
    	}
    	elseif($value == 100)
    	{
    		$ret .= ' acc';
    	}
    	
    	return $ret;
    	
    	
    } 
}

