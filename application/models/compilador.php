<?php

class Compilador extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
	
	var $compilingDir = 'submissionsTest/';
	function compilarCodigo($src = '', $lang = '', $formato = '', &$returnText){
		error_reporting(0);
		$pasta =  $this->compilingDir . rand();
		mkdir($pasta);
		$filedir = $pasta . '/' . $formato;
		
		if($lang == 'java') {
			$handle = fopen($filedir . '.java' ,'w+');
			fwrite($handle, $src);
			fclose($handle);
		 	exec('javac ' . $filedir . '.java 1>&1', $output, $retval);
		} else if($lang == 'c++') {
			$handle = fopen($filedir . '.cpp' ,'w+');
			fwrite($handle, $src);
			fclose($handle);
			exec('g++ ' . $filedir . '.cpp -o ' . $filedir . '.a 2>&1', $output, $retval);
		} else if ($lang == 'c') {
			$handle = fopen($filedir . '.c' ,'w+');
			fwrite($handle, $src);
			fclose($handle);
			exec('gcc '. $filedir . '.c -o ' . $filedir . '.a 2>&1', $output, $retval);
		}
		system('rm -r ' . $pasta);
		$returnText = '';
		foreach( $output as $outputline){
			$returnText .= $outputline . "\n";
		}
		return $retval;
	}

}