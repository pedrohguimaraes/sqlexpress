<?php
/**
 *  PHP SQL EXPRESS :: Helpers
 *
 *  Biblioteca com funções básicas para auxiliamento
 *  Esta biblitoca é distribuida na expectativa de ser útil, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPÓSITO EM           
 *  PARTICULAR.
 *
 *  Desenvolvida por: Pedro Guimarães
 *
 */
function errors($val){
	ini_set('display_errors',$val);
	ini_set('display_startup_erros',$val);

	if($val == 0) error_reporting($val);
	else error_reporting(E_ALL);	
} 

// default
errors(1);
