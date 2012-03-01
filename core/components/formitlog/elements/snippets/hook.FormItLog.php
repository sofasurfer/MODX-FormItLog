<?php
/**
 * FormItLog 
 *
 * Hook to store formit data to jSon file
 *
 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
 * @package formitlog
 */
	  
	/* path to data file */
	$logFile = $modx->getOption('logfile',$scriptProperties,$modx->getOption('formitlog.logfile'));

	/* Load Lexicon entry */
	$modx->lexicon->load('formitlog:default');

	/* get form from file */
	$formText = file_get_contents($logFile);

	/* create array list from form */
	$formList = json_decode($formText,true);


	/* get form data */
	$formValues = $hook->getValues();
	$formValues['email_to'] = $scriptProperties['emailTo'];
	$formValues['clientip'] = $_SERVER['REMOTE_ADDR'];
	$formValues['context'] = $modx->context->key;
	$formValues['logtime'] = time(); 	
		 	

	/* add form data to array with micro time as key */
	$key =  $modx->context->key . "_" . microtime(true);
	$formList['formdata'][$key] = $formValues;

	/* convert form to string */
	$formText = json_encode($formList);

	/* save comment to file */
	if( file_put_contents($logFile, $formText) == false ){

		/* return error */
		$hook->addError("error_message",$modx->lexicon('formitlog.error_logfile',array('logfile'=>$logFile)) );
		return false;	

	}

	return true;
