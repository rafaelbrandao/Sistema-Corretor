<?php

class Compilador extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
	
	var $compilingDir = 'submissionsTest/';
	function compilarCodigo($src = '', $lang = '', $formato = ''){
		$pasta =  $this->compilingDir . rand();
		mkdir($pasta);
		$filedir = $pasta . '/' . $formato;
		
		if($lang == 'java') {
			$handle = fopen($filedir . '.java' ,'w+');
			fwrite($handle, $src);
			fclose($handle);
			$returnText = system('javac ' . $filedir . '.java', $retval);
		} else if($lang == 'c++') {
			$handle = fopen($filedir . '.cpp' ,'w+');
			fwrite($handle, $src);
			fclose($handle);
			$returnText = system('g++ ' . $filedir . '.cpp -o ' . $filedir . '.a', $retval);
		} else if ($lang == 'c') {
			$handle = fopen($filedir . '.c' ,'w+');
			fwrite($handle, $src);
			fclose($handle);
			$returnText = system('gcc '. $filedir . '.c -o ' . $filedir . '.a' , $retval);
		}
		system('rm -r ' . $pasta);
		return $retval;
	}

}